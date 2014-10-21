<?php

namespace Simpledom\Frontend\Controllers;

use AtaPaginator;
use BaseLogins;
use BaseSystemLog;
use BaseUser;
use BaseUserLog;
use EmailItems;
use LoginDetailsForm;
use Phalcon\Mvc\Model\Criteria;
use ProfileImageForm;
use Settings;
use Simpledom\Core\Classes\FileManager;
use Simpledom\Core\ForgetPasswordForm;
use Simpledom\Core\LoginForm;
use Simpledom\Core\ProfileEditForm;
use Simpledom\Core\RegisterForm;
use SMSManager;
use SmsNumber;
use UserOrder;
use UserPhone;

class UserController extends ControllerBase {

    public function LogoutAction() {
        // destroy session
        $this->session->destroy();

        return $this->dispatcher->forward(array(
                    "controller" => "index",
                    "action" => "index"
        ));
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
                'list');

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
                $user = BaseUser::findFirst("email = '" . $email . "'");
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

                $email = $this->request->getPost("email");
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
                                "controller" => "user",
                                "action" => "welcome"
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
            if (!$rf->isValid($_POST)) {
                // invalid post
            } else {


                // check if the login is enabled
                if (Settings::Get()->enabledisablesignup === false) {
                    $this->flash->notice(_("Sorry!<br/>But the register system is disabled by Super Adminstator at this time."));
                    return;
                }


                // valid post, we have to create new user based on the request
                $user = new BaseUser();
                $user->fname = $this->request->getPost("firstname");
                $user->lname = $this->request->getPost("lastname");
                $user->gender = $this->request->getPost("gender");
                $user->email = $this->request->getPost("email");
                $user->password = $this->request->getPost("password");
                $user->level = USERLEVEL_USER;

                // check if we can save user
                if (!$user->create()) {
                    // unable to save user
                    $user->showErrorMessages($this);
                } else {

                    // user created in database, we have to generate 
                    $email = new EmailItems();
                    $email->sendRegsiterNotification($user->userid, $user->getFullName(), $user->email, $user->verifycode);

                    // check if user has entered an not exist phone, add the phone
                    // to the user phones and send sms to user
                    $count = UserPhone::count(array(
                                "phone = :phone:",
                                "bind" => array(
                                    "phone" => $this->request->getPost("phone")
                                )
                    ));
                    if ($count == 0) {
                        // we have no user based on that phone, it is valid to add
                        // the phone to the UserPhone table and notify of the phone
                        // with verify code
                        $userphone = new UserPhone();
                        $userphone->phone = $this->request->getPost("phone");
                        $userphone->userid = $user->userid;
                        if (!$userphone->create()) {
                            // usre phone not created
                            BaseSystemLog::init($item)->setTitle("Unable to create User Phone Item")->setMessage("When we are going to create a new UserPhone item for new registered user, we were unable to insert new item")->setIP($_SERVER["REMOTE_ADDR"])->create();
                        } else {
                            // user phone created, we have to send the verify code to user
                            $smsMessage = sprintf(_('"Hi %s \nThank you for interseting in %s.\n Please use this code to verify your phone number address :\n %s'), $user->getFullName(), Settings::Get()->websitename, $userphone->verifycode);
                            //$smsMessage = "Hi " . $user->getFullName() . "\nThank you for interseting in " . Settings::Get()->websitename . ".\n Please use this code to verify your phone number address :\n" . $userphone->verifycode;
                            SMSManager::SendSMS($userphone->phone, $smsMessage, SmsNumber::findFirst("enable = '1'")->id);
                        }
                    } else {
                        // phone exist in database before
                        $this->flash->error(_("Your Entered Phone was exist in database, please add another phone"));
                    }

                    $user->showSuccessMessages($this, _("User creating was successfull"));
                }
            }
        }

        $this->setPageTitle("Signup");
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
                    'Date', 'IP', 'Agent'
                ))->
                setFields(array(
                    'getDate()', 'ip', 'agent'
                ))->setListPath(
                'list');

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
                'list');

        $this->view->list = $paginator->getPaginate();


        // set page title
        $this->setPageTitle(_("View Phones"));
    }

}
