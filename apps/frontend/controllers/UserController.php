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
                    $this->flash->error("Unable to find such user with requested email");
                } else {
                    // user found, we have to request password request for user
                    if ($user->requestResetPassword()) {
                        $this->flash->success("Password Reset Link Sent To Your Email, Please Check Your Email");
                    } else {
                        $this->flash->error("Unable to send password reset link");
                    }
                }
            } else {
                // invalid request
            }
        }
        $this->view->form = $fr;
    }

    public function welcomeAction() {
        $this->view->firstName = $this->session->get("fname");
        $this->view->lastName = $this->session->get("lname");
    }

    public function listAction($page = 1) {


        // load the users
        $users = BaseUser::find();

        $numberPage = $page;

        // create paginator
        $paginator = new Paginator(array(
            "data" => $users,
            "limit" => 1,
            "page" => $numberPage
        ));
        $this->view->users = $paginator->getPaginate();
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
                        $this->flash->notice("Sorry!<br/>The login is disabled by adminstrator now");
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
                    $this->flash->error("Unable to find user");
                }
            }
        }
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
                    $this->flash->notice("Sorry!<br/>But the register system is disabled by Super Adminstator at this time.");
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
                            $smsMessage = "Hi " . $user->getFullName() . "\nThank you for interseting in " . Settings::Get()->websitename . ".\n Please use this code to verify your phone number address :\n" . $userphone->verifycode;
                            SMSManager::SendSMS($userphone->phone, $smsMessage, SmsNumber::findFirst("enable = '1'")->id);
                        }
                    } else {
                        // phone exist in database before
                        $this->flash->error("Your Entered Phone was exist in database, please add another phone");
                    }

                    $user->showSuccessMessages($this, "User creating was successfull");
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
     * Searches for user
     */
    public function searchAction() {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "User", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "userid";

        $user = BaseUser::find($parameters);
        if (count($user) == 0) {
            $this->flash->notice("The search did not find any user");

            return $this->dispatcher->forward(array(
                        "controller" => "user",
                        "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $user,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
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
                        $this->flash->error("unable to handle file upload");
                    } else {
                        // check if we can save user
                        if (!$this->user->setImagelink($image->link)->save()) {
                            // unable to save user
                            $this->user->showErrorMessages($this);
                        } else {

                            // reset the session
                            $this->user->setSession($this);

                            // show the message
                            $this->user->showSuccessMessages($this, "Image Changed Successfully");
                        }
                    }
                }
            }
        }

        $this->view->form = $pef;
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
                    $this->flash->error("Incorrect current password");
                } else {
                    // current password is cuuerct
                    if ($newpass !== $newpassconfirm) {
                        $this->flash->error("Your new passwords are not look the same");
                    } else {
                        // everything is OK
                        if ($this->user->changePassword($this->errors, $newpass)) {
                            $this->flash->success("Your password changed successfully");
                        }
                    }
                }
            }
        }

        $this->view->form = $form;
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
    }

    /**
     * Creates a new user
     */
    public function createAction() {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                        "controller" => "user",
                        "action" => "index"
            ));
        }

        $user = new BaseUser();

        $user->fname = $this->request->getPost("fname");
        $user->lname = $this->request->getPost("lname");
        $user->gender = $this->request->getPost("gender");
        $user->imagelink = $this->request->getPost("imagelink");
        $user->regdate = $this->request->getPost("regdate");
        $user->active = $this->request->getPost("active");
        $user->verified = $this->request->getPost("verified");


        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                        "controller" => "user",
                        "action" => "new"
            ));
        }

        $this->flash->success("user was created successfully");

        return $this->dispatcher->forward(array(
                    "controller" => "user",
                    "action" => "index"
        ));
    }

    /**
     * Saves a user edited
     *
     */
    public function saveAction() {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                        "controller" => "user",
                        "action" => "index"
            ));
        }

        $userid = $this->request->getPost("userid");

        $user = BaseUser::findFirstByuserid($userid);
        if (!$user) {
            $this->flash->error("user does not exist " . $userid);

            return $this->dispatcher->forward(array(
                        "controller" => "user",
                        "action" => "index"
            ));
        }

        $user->fname = $this->request->getPost("fname");
        $user->lname = $this->request->getPost("lname");
        $user->gender = $this->request->getPost("gender");
        $user->imagelink = $this->request->getPost("imagelink");
        $user->regdate = $this->request->getPost("regdate");
        $user->active = $this->request->getPost("active");
        $user->verified = $this->request->getPost("verified");


        if (!$user->save()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                        "controller" => "user",
                        "action" => "edit",
                        "params" => array($user->userid)
            ));
        }

        $this->flash->success("user was updated successfully");

        return $this->dispatcher->forward(array(
                    "controller" => "user",
                    "action" => "index"
        ));
    }

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
                    'Phone', 'Does Verified', 'Date', 'Verify Phone'
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
    }

    /**
     * Deletes a user
     *
     * @param string $userid
     */
    public function deleteAction($userid) {

        $user = BaseUser::findFirstByuserid($userid);
        if (!$user) {
            $this->flash->error("user was not found");

            return $this->dispatcher->forward(array(
                        "controller" => "user",
                        "action" => "index"
            ));
        }

        if (!$user->delete()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                        "controller" => "user",
                        "action" => "search"
            ));
        }

        $this->flash->success("user was deleted successfully");

        return $this->dispatcher->forward(array(
                    "controller" => "user",
                    "action" => "index"
        ));
    }

}
