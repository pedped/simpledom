<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use BaseUser;
use BaseUserLog;
use Opinion;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Text;
use Simpledom\Core\AdminChangeLoginDetailsUserForm;
use Simpledom\Core\AdminUserProfileImageForm;
use Simpledom\Core\Classes\FileManager;
use Simpledom\Core\ViewUserForm;
use UserOrder;

class UserControllerBase extends ControllerBase {

    public function viewTabOpinions($id, $page) {

        // load the users
        $userorders = Opinion::find(array("userid = :userid:", "bind" => array("userid" => $id), 'order' => 'id DESC'));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $userorders,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Message', 'Rate', 'Date',
                ))->
                setFields(array(
                    'id', 'message', 'rate', 'getDate()',
                ))->
                setEditUrl(
                        'view'
                )->setListPath(
                'user/view/' . $id . "/opinions/{pn}");

        $this->view->list = $paginator->getPaginate();
    }

    public function viewTabOrder($id, $page) {

        // load the users
        $userorders = UserOrder::find(
                        array(
                            "userid = '$id'",
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
                    'ID', 'Type', 'Title', 'Item ID', 'Handler', 'Payment ID', 'price', 'Currency', 'date', 'done'
                ))->
                setFields(array(
                    'id', 'getTypeName()', 'getItemTitle()', 'itemid', 'getPaymentTypeName()', 'paymentitemid', 'price', 'pricecurrency', 'getDate()', 'getDoneTag()'
                ))->
                setEditUrl(
                        'view'
                )->setListPath(
                'user/view/' . $id . "/orders/{pn}");

        $this->view->list = $paginator->getPaginate();
    }

    public function viewTabUserLogs($id, $page) {

        // load the users
        $userLogs = BaseUserLog::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $userLogs,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Action', 'Info', 'Date'
                ))->
                setFields(array(
                    'id', 'action', 'info', 'getDate()'
                ))->
                setEditUrl(
                        'view'
                )->setListPath(
                'user/view/' . $id . "/userlogs/{pn}");

        $this->view->list = $paginator->getPaginate();
    }

    public function viewTabProfileImage($id) {

        // create new login form
        $rf = new AdminUserProfileImageForm();
        $user = BaseUser::findFirst($id);
        if ($this->request->isPost()) {
            // user want to submit the post, validae the request
            if (!$rf->isValid($_POST)) {
                // invalid post
            } else {
                // valid post, we have to create new user based on the request
                if ($this->request->hasFiles()) {
                    $image = FileManager::HandleImageUpload($this->errors, $this->request->getUploadedFiles()[0], $outputFileName, $realtiveloaction);
                    if (!$image) {
                        $this->flash->error("unable to handle file upload");
                    } else {
                        // check if we can save user
                        if (!$user->setImagelink($image->link)->save()) {
                            // unable to save user
                            $user->showErrorMessages($this);
                        } else {

                            // show the message
                            $user->showSuccessMessages($this, "Image Changed Successfully");
                        }
                    }
                }
            }
        }

        $rf->get("image")->setLink($user->imagelink);
        $this->view->viewForm = $rf;
    }

    public function viewTabUserInfo($id) {

        // create new login form
        $rf = new ViewUserForm();
        if ($this->request->isPost()) {
            // user want to submit the post, validae the request
            if (!$rf->isValid($_POST)) {
                // invalid post
            } else {
                // valid post, we have to create new user based on the request
                $user = BaseUser::findFirst($id);
                $user->fname = $this->request->getPost("firstname");
                $user->lname = $this->request->getPost("lastname");
                $user->gender = $this->request->getPost("gender");
                $user->verified = $this->request->getPost("verify");
                $user->active = $this->request->getPost("active");
                $user->disablemessage = $this->request->getPost("disablemessage");

                if (intval($user->active) == 0 && $user->level == USERLEVEL_SUPERADMIN) {
                    // we are not allowed to disable Super Admin Account
                    $this->flash->error("You should not disable Super Admin Account");
                } else {
                    // check if we can save user
                    if (!$user->save()) {
                        // unable to save user
                        $user->showErrorMessages($this);
                    } else {
                        $user->showSuccessMessages($this, "User saved successfully");
                    }
                }
            }
        }
        $user = BaseUser::findFirst($id);
        $rf->get("firstname")->setDefault($user->fname);
        $rf->get("lastname")->setDefault($user->lname);
        $rf->get("gender")->setDefault($user->gender);
        $rf->get("verify")->setDefault($user->verified);
        $rf->get("disablemessage")->setDefault($user->disablemessage);
        $rf->get("active")->setDefault($user->active);
        $this->view->viewForm = $rf;
    }

    public function viewTabLoginDetails($id) {

        // create new login form
        $rf = new AdminChangeLoginDetailsUserForm();
        if ($this->request->isPost()) {
            // user want to submit the post, validae the request
            if (!$rf->isValid($_POST)) {
                // invalid post
            } else {
                // valid post, we have to create new user based on the request
                $user = BaseUser::findFirst($id);
                $user->email = $this->request->getPost("email", "email");

                if (strlen($this->request->getPost("password")) > 0) {
                    $user->password = md5($this->request->getPost("password"));
                }

                // check if we can save user
                if (!$user->save()) {
                    // unable to save user
                    $user->showErrorMessages($this);
                } else {
                    $user->showSuccessMessages($this, "User saved successfully");
                    $this->flash->success("Password Changed To : " . $this->request->getPost("password"));
                }
            }
        }
        $user = BaseUser::findFirst($id);
        $rf->get("email")->setDefault($user->email);
        $this->view->viewForm = $rf;
    }

    public function viewAction($id, $tab = "userinfo", $page = 1) {

        switch ($tab) {
            case "userinfo" :
                $this->viewTabUserInfo($id);
                break;
            case "logindetails" :
                $this->viewTabLoginDetails($id);
                break;
            case "profileimage" :
                $this->viewTabProfileImage($id);
                break;
            case "userlogs" :
                $this->viewTabUserLogs($id, $page);
                break;
            case "orders" :
                $this->viewTabOrder($id, $page);
                break;
            case "opinions" :
                $this->viewTabOpinions($id, $page);
                break;

            default :
                var_dump("invalid tab");
                die();
        }


        // Load Default Information
        $user = BaseUser::findFirst($id);
        $this->view->tab = $tab;
        $this->view->user = $user;
        $this->setTitle("User Information");


        // check if user is disabled
        if (intval($user->active) == 0) {
            $this->flash->error(Text::upper("<b>User Is Deactiveted</b>"));
        }


        // calc the more infos
        $this->view->totalOpinions = Opinion::count(array("userid = :userid:", "bind" => array("userid" => $id)));

        $this->view->totalOrdersCost = UserOrder::sum(
                        array(
                            "userid = :userid: AND done = '1' ",
                            "bind" => array("userid" => $id),
                            "column" => "price"));


        $this->view->totalOrders = UserOrder::find(array("userid = :userid: AND done = '1' ", "bind" => array("userid" => $id)))->count();
    }

    public function listAction($page = 1) {

        // set page title
        $this->setTitle("Users");

        // check if we have to search
        if ($this->request->isPost() && $this->request->hasPost("target")) {

            $parameters = array();
            $target = $this->request->getPost("target");
            $query = $this->request->getPost("searchquery");
            $parameters["conditions"] = "$target LIKE '%$query%' ";
            $parameters["order"] = "logintimes DESC";
            $this->persistent->parameters = $parameters;
        } else {
            //$parameters = array();
            //$this->persistent->parameters = $parameters;
        }


        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        } else {
            //var_dump($parameters);
            //die();
        }


        // load the users
        $users = BaseUser::find($parameters);

        $numberPage = $page;




        // create paginator
        $paginator = new AtaPaginator(array(
            "data" => $users,
            "limit" => 10,
            "page" => $numberPage
        ));

        $paginator->
                setTableHeaders(array(
                    'User ID', 'First Name', 'Last Name', 'Email', 'Gender', 'Active', 'Verified', 'Join Date'
                ))->
                setFields(array(
                    'userid', 'fname', 'lname', 'email', 'getGenderTitle()', 'getActiveButton()', 'getVerifiedButton()', 'getJoinDate()'
                ))->
                setEditUrl(
                        'view'
                )->setListPath(
                'user/list');

        $paginator->setSearchItemArrays(array(
            "userid" => "User ID",
            "email" => "Email"
        ));

        $this->view->users = $paginator->getPaginate();
    }

    public function mostAction($page = 1) {


        // check if we have to search
        if ($this->request->isPost() && $this->request->hasPost("target")) {

            $parameters = array();
            $target = $this->request->getPost("target");
            $query = $this->request->getPost("searchquery");
            $parameters["conditions"] = "$target LIKE '%$query%' ";
            $this->persistent->parameters = $parameters;
        } else {
            //$parameters = array();
            //$this->persistent->parameters = $parameters;
        }


        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        } else {
            //var_dump($parameters);
            //die();
        }


        // load the users
        $users = BaseUser::find($parameters);


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            "data" => $users,
            "limit" => 10,
            "page" => $numberPage
        ));


        $paginator->setSearchItemArrays(array(
            "userid" => "User ID",
            "email" => "Email"
        ));

        $this->view->users = $paginator->getPaginate();
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
     * Displayes the creation form
     */
    public function newAction() {
        
    }

    /**
     * Edits a user
     *
     * @param string $userid
     */
    public function editAction($userid) {

        if (!$this->request->isPost()) {

            $user = BaseUser::findFirstByuserid($userid);
            if (!$user) {
                $this->flash->error("user was not found");

                return $this->dispatcher->forward(array(
                            "controller" => "user",
                            "action" => "index"
                ));
            }

            $this->view->userid = $user->userid;

            $this->tag->setDefault("userid", $user->userid);
            $this->tag->setDefault("fname", $user->fname);
            $this->tag->setDefault("lname", $user->lname);
            $this->tag->setDefault("gender", $user->gender);
            $this->tag->setDefault("imagelink", $user->imagelink);
            $this->tag->setDefault("regdate", $user->regdate);
            $this->tag->setDefault("active", $user->active);
            $this->tag->setDefault("verified", $user->verified);
        }
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

    protected function ValidateAccess($id) {
        
    }

}
