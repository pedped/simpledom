<?php

namespace Simpledom\Frontend\Controllers;

use AtaPaginator;
use Simpledom\Frontend\BaseControllers\ControllerBase;
use UserPost;
use UserPostForm;

class UserPostController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setPageTitle('UserPost');
    }

    /**
     * this function will validate request access
     * @param type $id
     * @return boolean
     */
    protected function ValidateAccess($id) {
        return true;
    }

    public function addAction() {

        $fr = new UserPostForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $userpost = new \UserPost();

                $userpost->userid = $this->request->getPost('userid', 'string');
                $userpost->postid = $this->request->getPost('postid', 'string');
                $userpost->code = $this->request->getPost('code', 'string');
                $userpost->phonenumber = $this->request->getPost('phonenumber', 'string');
                if (!$userpost->create()) {
                    $userpost->showErrorMessages($this);
                } else {
                    $userpost->showSuccessMessages($this, 'New UserPost added Successfully');

                    // clear the title and message so the user can add better info
                    $fr->clear();
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }
        $this->view->form = $fr;
    }

    public function listAction($page = 1) {

        // load the users
        $userposts = UserPost::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $userposts,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Organ', 'User Name', 'Post Name', 'User ID', 'Post ID', 'User Phone', 'Code'
                ))->
                setFields(array(
                    'id', 'getOrganName()', 'getUserName()', 'getPostTitle()', 'userid', 'postid', 'phonenumber', 'code'
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

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = UserPost::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'userpost',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = UserPost::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this UserPost item');
            } else {
                $this->flash->success('UserPost item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'userpost',
                            'action' => 'list'
                ));
            }
        }
    }

    public function editAction($id) {


        if (!$this->ValidateAccess($id)) {
            // user do not have permission to edut this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // set title
        $this->setPageTitle('Edit UserPost');

        $userpostItem = UserPost::findFirst($id);

        // create form
        $fr = new UserPostForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $userpost = UserPost::findFirst($id);
                $userpost->userid = $this->request->getPost('userid', 'string');
                $userpost->phonenumber = $this->request->getPost('phonenumber', 'string');
                $userpost->postid = $this->request->getPost('postid', 'string');
                $userpost->code = $this->request->getPost('code', 'string');
                if (!$userpost->save()) {
                    $userpost->showErrorMessages($this);
                } else {
                    $userpost->showSuccessMessages($this, 'UserPost Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('phonenumber')->setDefault($userpostItem->phonenumber);
            $fr->get('userid')->setDefault($userpostItem->userid);
            $fr->get('postid')->setDefault($userpostItem->postid);
            $fr->get('code')->setDefault($userpostItem->code);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = UserPost::findFirst($id);
        $this->view->item = $item;

        $form = new UserPostForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('phonenumber')->setDefault($item->phonenumber);
        $form->get('userid')->setDefault($item->userid);
        $form->get('postid')->setDefault($item->postid);
        $form->get('code')->setDefault($item->code);
        $this->view->form = $form;
    }

}
