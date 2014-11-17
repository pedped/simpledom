<?php

namespace Simpledom\Frontend\BaseControllers;

use AtaPaginator;
use BaseLogins;
use BaseSystemLog;
use BaseUser;
use BaseUserLog;
use EmailItems;
use LoginDetailsForm;
use Phalcon\Filter;
use ProfileImageForm;
use Recaptcha;
use ResetVerficationCode;
use Settings;
use Simpledom\Core\Classes\Config;
use Simpledom\Core\Classes\FileManager;
use Simpledom\Core\Classes\Helper;
use Simpledom\Core\ForgetPasswordForm;
use Simpledom\Core\LoginForm;
use Simpledom\Core\ProfileEditForm;
use Simpledom\Core\RegisterForm;
use SMSManager;
use SmsNumber;
use UserOrder;
use UserPhone;

class UserControllerBase extends ControllerBase {

    public function resetverifyAction() {

        $this->setPageTitle(_("Resend Verification Link"));
        $fr = new ResetVerficationCode();
        $this->view->form = $fr;

        // check if user requested resending verification email
        if (!$this->request->isPost()) {
            // user did not requested resend verificaion email
            return;
        } else {
            if (!$fr->isValid($_POST)) {
                // invalid email received
                return;
            }
        }

        // user added his emai;
        $email = $this->request->getPost("email");

        $user = \BaseUser::findFirst(array("email = :email:", "bind" => array("email" => $email)));
        if (!$user) {
            $this->flash->error(_("We are not able to find user with requested email"));
            return;
        }

        // check if the user is verified before
        if (intval($user->verified) == 1) {
            $this->flash->error(_("This email has verified before"));
            return;
        }

        // Reset the verify code
        $user->verifycode = Helper::GenerateRandomString(256);
        if (!$user->save()) {
            $this->flash->error(_("Internal Error, Please Try Later"));
            return;
        } else {

            // Send email
            $emailItems = new \EmailItems();
            $emailItems->sendVerifyCode($user->userid, $user->getFullName(), $user->email, $user->verifycode);

            // Show message
            $this->flash->success(_("<h2>Success</h2>new verfication code has been sent to your email successfully"));
        }
    }

    public function verifyAction($email = null, $usercode = null) {


        $this->setPageTitle(_("Verify Email"));


        // check if user eneterd email and user code
        if (!isset($email) || !isset($usercode)) {
            $this->flash->error(_("Invalid email and verification code"));
            return;
        }

        // user want to verify his email, check if email exist in database
        $user = \BaseUser::findFirst(array("email = :email:", "bind" => array("email" => $email)));
        if (!$user) {
            $this->flash->error(_("We are not able to find user with requested email"));
            return;
        }

        // check if the user is verified before
        if (intval($user->verified) == 1) {
            $this->flash->error(_("This email has verified before"));
            return;
        }


        // check if code equal
        if (strval($user->verifycode) != strval($usercode)) {
            $this->flash->error(_("Oops! your verification code is invalid"));
            return;
        }


        // everything is ok, we can set the user code
        $user->verified = 1;
        if (!$user->save()) {
            $this->flash->error(_("Your verification code is valid, but we are not able to change your status, please try later"));
            return;
        } else {
            $this->flash->success(_("<h2>Success</h2>Your account has been changed verified successfully"));
        }
    }

    public function LogoutAction() {
        // destroy session
        $this->session->destroy();

        // show message
        $this->flash->success(_("You have successfully logged out from webiste"));

        return $this->response->redirect("");
    }

    public function ordersAction($page = 1) {

        $userid = (int) $this->user->userid;

        // load the users
        $userorders = UserOrder::find(
                        array(
                            "userid = '$userid'",
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $userorders,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    _('ID'), _('Title'), _('Handler'), _('Payment ID'), _('Price'), _('Currency'), _('Date'), _('Done')
                ))->
                setFields(array(
                    'id', 'getItemTitle()', 'getPaymentTypeName()', 'paymentitemid', 'price', 'pricecurrency', 'getDate()', 'getDoneTag()'
                ))->setListPath(
                "user/orders/{pn}");

        $this->view->list = $paginator->getPaginate();


        // set page title
        $this->setPageTitle(_("Orders"));
    }

    public function ForgetpasswordAction() {
        $fr = new ForgetPasswordForm();
        if ($this->request->isPost()) {
            // we have to validate the request 
            if ($fr->isValid($_POST)) {
                // valid request, we have to reset user request
                $email = $this->request->getPost("email", "email");
                $user = BaseUser::findFirst(array("email = :email:", "bind" => array("email" => $email)));
                if (!$user) {
                    // user not found
                    $this->flash->error(_("Unable to find such user with requested email"));
                } else {
                    // user found, we have to request password request for user
                    if ($user->requestResetPassword()) {
                        $this->flash->success(_("Password Reset Link Sent To Your Email, Please Check Your Email"));
                    } else {
                        $this->flash->error(_("Unable to send password reset link"));
                    }
                }
            } else {
                // invalid request
            }
        }
        $this->view->form = $fr;


        // set page title
        $this->setPageTitle(_("Forget Password"));
    }

    public function welcomeAction() {
        $this->view->firstName = $this->session->get("fname");
        $this->view->lastName = $this->session->get("lname");
    }

    public function loginAction() {

        $lf = new LoginForm();
        $this->view->loginform = $lf;
        if ($this->request->isPost()) {

            if (!$lf->isValid($_POST)) {
                // invalid post
            } else {
                // check if the website signin is enabled
                $email = $this->request->getPost("email", "email");
                $password = $this->request->getPost("password");
                $user = BaseUser::Login($email, $password);
                if ($user) {

                    // check if the login is enabled
                    if (!$user->isSuperAdmin() && (bool) Settings::Get()->enabledisablesignin == false) {
                        $this->flash->notice(_("Sorry!<br/>The login is disabled by adminstrator now"));
                        return;
                    }

                    // set session
                    $user->setSession($this);

                    // set login for the user
                    $user->trackLogin($this->request->getUserAgent(), $_SERVER["REMOTE_ADDR"]);

                    // incrase loggin time
                    $user->logintimes = $user->logintimes + 1;
                    $user->save();

                    // we need to log this action for the user
                    BaseUserLog::byUserID($user->userid)->setAction("Login To System")->Create();

                    // go to welcome page
                    return $this->dispatcher->forward(array(
                                "controller" => "index",
                                "action" => "index"
                    ));
                } else {
                    // unabel to find the user
                    $this->flash->error(_("Unable to find user"));
                }
            }
        }



        // set page title
        $this->setPageTitle(_("Login"));
    }

    /**
     * Index action
     */
    public function registerAction() {

        // create new login form
        $rf = new RegisterForm();
        if ($this->request->isPost()) {
            // user want to submit the post, validae the request
            if (!$rf->isValid($_POST) || !Recaptcha::check(Settings::Get()->recaptchaprivate, $_SERVER['REMOTE_ADDR'], $this->request->getPost('recaptcha_challenge_field'), $this->request->getPost('recaptcha_response_field'))) {
                // invalid post or recaptcha
                if ($rf->isValid($_POST)) {
                    //captcha was invalid
                    $this->flash->error(_("Invalid Capctcha"));
                }
            } else {
                // valid post, we have to create new user based on the request
                $user = new BaseUser();
                $fname = $this->request->getPost("firstname");
                $lname = $this->request->getPost("lastname");
                $gender = $this->request->getPost("gender");
                $email = $this->request->getPost("email");
                $password = $this->request->getPost("password");
                $phone = $this->request->getPost("phone");
                $level = USERLEVEL_USER;
                $user->registerAccount($this, $this->errors, $fname, $lname, $gender, $email, $password, $level, $phone);
            }
        }

        $this->setPageTitle(_("Signup"));
        $this->view->registerform = $rf;
    }

    /**
     * Index action
     */
    public function indexAction() {
        $this->persistent->parameters = null;
    }

    /**
     * Edits a user
     *
     * @param string $userid
     */
    public function editAction() {
        // create new login form
        $pef = new ProfileEditForm();
        if ($this->request->isPost()) {
            // user want to submit the post, validae the request
            if (!$pef->isValid($_POST)) {
                // invalid post
            } else {
                // valid post, we have to create new user based on the request
                $user = BaseUser::findFirst($this->session->get("userid"));
                $user->fname = $this->request->getPost("firstname");
                $user->lname = $this->request->getPost("lastname");
                $user->gender = $this->request->getPost("gender");

                // check if we can save user
                if (!$user->save()) {
                    // unable to save user
                    $user->showErrorMessages($this);
                } else {

                    // reset the session
                    $user->setSession($this);

//                    return $this->dispatcher->forward(array(
//                                "controller" => "user",
//                                "action" => "edit",
//                                "params" => array(
//                                    "success" => "1"
//                                )
//                    ));
                }
            }
        }


        $this->view->form = $pef;


        // set page title
        $this->setPageTitle(_("Edit Profile Information"));
    }

    public function editprofileimageAction() {
        // create new login form
        $pef = new ProfileImageForm();
        $pef->get("image")->setHref($this->user->getProfileImageLink());

        if ($this->request->isPost()) {
            // user want to submit the post, validae the request
            if (!$pef->isValid($_POST)) {
                // invalid post
            } else {
                // valid post, we have to create new user based on the request
                if ($this->request->hasFiles()) {
                    $image = FileManager::HandleImageUpload($this->errors, $this->request->getUploadedFiles()[0], $outputFileName, $realtiveloaction);
                    if (!$image) {
                        $this->flash->error(_("unable to handle file upload"));
                    } else {
                        // check if we can save user
                        if (!$this->user->setImagelink($image->link)->save()) {
                            // unable to save user
                            $this->user->showErrorMessages($this);
                        } else {

                            // reset the session
                            $this->user->setSession($this);

                            // show the message
                            $this->user->showSuccessMessages($this, _("Image Changed Successfully"));
                        }
                    }
                }
            }
        }

        $this->view->form = $pef;


        // set page title
        $this->setPageTitle(_("Edit Profile Image"));
    }

    public function editloginAction() {
        // create new login form
        $form = new LoginDetailsForm();
        $form->get("email")->setDefault($this->user->email);

        if ($this->request->isPost()) {
            // user want to submit the post, validae the request
            if (!$form->isValid($_POST)) {
                // invalid post
            } else {

                // check if the password is true
                $currentpass = $this->request->getPost("password", "string");
                $newpass = $this->request->getPost("newpassword", "string");
                $newpassconfirm = $this->request->getPost("newpasswordconfirm", "string");

                if (!$this->user->verifyPassword($currentpass)) {
                    $this->flash->error(_("Incorrect current password"));
                } else {
                    // current password is cuuerct
                    if ($newpass !== $newpassconfirm) {
                        $this->flash->error(_("Your new passwords are not look the same"));
                    } else {
                        // everything is OK
                        if ($this->user->changePassword($this->errors, $newpass)) {
                            $this->flash->success(_("Your password changed successfully"));
                        }
                    }
                }
            }
        }

        $this->view->form = $form;


        // set page title
        $this->setPageTitle(_("Edit Login Details"));
    }

    public function viewloginsAction($page = 1) {

        $userid = (int) $this->user->userid;
        // load the logins
        $logins = BaseLogins::find(
                        array(
                            "userid = '$userid'",
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $logins,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    _('Date'), _('IP'), _('Agent')
                ))->
                setFields(array(
                    'getDate()', 'ip', 'agent'
                ))->setListPath(
                "user/viewlogins/{pn}");

        $this->view->list = $paginator->getPaginate();


        // set page title
        $this->setPageTitle(_("View Logins"));
    }

    /**
     * Saves a user edited
     *
     */
    public function phonesAction($page = 1) {
        // load the users
        $userphones = UserPhone::find(
                        array(
                            "userid = :userid:",
                            'order' => 'id DESC',
                            "bind" => array(
                                "userid" => $this->user->userid
                            )
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $userphones,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    _('Phone'), _('Does Verified'), _('Date'), _('Verify Phone')
                ))->
                setFields(array(
                    'phone', 'getVerifiedText()', 'getDate()', 'getVerifiedLink()'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                "user/phones/{pn}");

        $this->view->list = $paginator->getPaginate();


        // set page title
        $this->setPageTitle(_("View Phones"));
    }

    protected function ValidateAccess($id) {
        return true;
    }

}
