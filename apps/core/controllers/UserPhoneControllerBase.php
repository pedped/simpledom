<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use Simpledom\Core\UserPhoneForm;
use UserPhone;

class UserPhoneControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('UserPhone');
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

        $fr = new UserPhoneForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $userphone = new UserPhone();

                $userphone->userid = $this->request->getPost('userid', 'string');
                $userphone->phone = $this->request->getPost('phone', 'string');
                $userphone->verifycode = $this->request->getPost('verifycode', 'string');
                $userphone->verified = $this->request->getPost('verified', 'string');
                $userphone->lastsmsdate = $this->request->getPost('lastsmsdate', 'string');
                $userphone->date = $this->request->getPost('date', 'string');
                if (!$userphone->create()) {
                    $userphone->showErrorMessages($this);
                } else {
                    $userphone->showSuccessMessages($this, 'New UserPhone added Successfully');

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
        $userphones = UserPhone::find(
                        array(
                            'order' => 'id DESC'
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
                    'ID', 'User ID', 'Phone', 'Verify Code', 'Verified', 'Last SMS Sent Date', 'Date'
                ))->
                setFields(array(
                    'id', 'userid', 'phone', 'verifycode', 'verified', 'lastsmsdate', 'date'
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
        $item = UserPhone::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'userphone',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = UserPhone::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this UserPhone item');
            } else {
                $this->flash->success('UserPhone item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'userphone',
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
        $this->setTitle('Edit UserPhone');

        $userphoneItem = UserPhone::findFirst($id);

        // create form
        $fr = new UserPhoneForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $userphone = UserPhone::findFirst($id);
                $userphone->userid = $this->request->getPost('userid', 'string');

                $userphone->phone = $this->request->getPost('phone', 'string');

                $userphone->verifycode = $this->request->getPost('verifycode', 'string');

                $userphone->verified = $this->request->getPost('verified', 'string');

                $userphone->lastsmsdate = $this->request->getPost('lastsmsdate', 'string');

                $userphone->date = $this->request->getPost('date', 'string');
                if (!$userphone->save()) {
                    $userphone->showErrorMessages($this);
                } else {
                    $userphone->showSuccessMessages($this, 'UserPhone Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('userid')->setDefault($userphoneItem->userid);
            $fr->get('phone')->setDefault($userphoneItem->phone);
            $fr->get('verifycode')->setDefault($userphoneItem->verifycode);
            $fr->get('verified')->setDefault($userphoneItem->verified);
            $fr->get('lastsmsdate')->setDefault($userphoneItem->lastsmsdate);
            $fr->get('date')->setDefault($userphoneItem->date);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = UserPhone::findFirst($id);
        $this->view->item = $item;

        $form = new UserPhoneForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userid')->setDefault($item->userid);
        $form->get('phone')->setDefault($item->phone);
        $form->get('verifycode')->setDefault($item->verifycode);
        $form->get('verified')->setDefault($item->verified);
        $form->get('lastsmsdate')->setDefault($item->lastsmsdate);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
