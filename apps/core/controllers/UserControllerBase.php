<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Simpledom\Core\ViewUserForm;
use BaseUser;

class UserControllerBase extends ControllerBase {

    public function viewAction($id) {
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

                if ($this->request->hasPost("password")) {
                    $user->password = $this->request->getPost("password");
                }

                // check if we can save user
                if (!$user->save()) {
                    // unable to save user
                    $user->showErrorMessages($this);
                } else {
                    $user->showSuccessMessages($this, "User saved successfully");
                }
            }
        }

        // Load Default Information
        $user = BaseUser::findFirst($id);
        $rf->get("firstname")->setDefault($user->fname);
        $rf->get("lastname")->setDefault($user->lname);
        $rf->get("gender")->setDefault($user->gender);
        $rf->get("email")->setDefault($user->email);
        $this->view->viewForm = $rf;
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
