<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use Simpledom\Core\UserCachChangeForm;
use UserCachChange;

class UserCachChangeControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('UserCachChange');
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

        $fr = new UserCachChangeForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $usercachchange = new UserCachChange();

                $usercachchange->userid = $this->request->getPost('userid', 'string');
                $usercachchange->amount = $this->request->getPost('amount', 'string');
                $usercachchange->date = $this->request->getPost('date', 'string');
                $usercachchange->reasonid = $this->request->getPost('reasonid', 'string');
                $usercachchange->more = $this->request->getPost('more', 'string');
                if (!$usercachchange->create()) {
                    $usercachchange->showErrorMessages($this);
                } else {
                    $usercachchange->showSuccessMessages($this, 'New UserCachChange added Successfully');

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
        $usercachchanges = UserCachChange::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $usercachchanges,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'User ID', 'Amount', 'Date', 'Reason', 'More Info'
                ))->
                setFields(array(
                    'id', 'userid', 'amount', 'date', 'reasonid', 'more'
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
        $item = UserCachChange::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'usercachchange',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = UserCachChange::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this UserCachChange item');
            } else {
                $this->flash->success('UserCachChange item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'usercachchange',
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
        $this->setTitle('Edit UserCachChange');

        $usercachchangeItem = UserCachChange::findFirst($id);

        // create form
        $fr = new UserCachChangeForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $usercachchange = UserCachChange::findFirst($id);
                $usercachchange->userid = $this->request->getPost('userid', 'string');

                $usercachchange->amount = $this->request->getPost('amount', 'string');

                $usercachchange->date = $this->request->getPost('date', 'string');

                $usercachchange->reasonid = $this->request->getPost('reasonid', 'string');

                $usercachchange->more = $this->request->getPost('more', 'string');
                if (!$usercachchange->save()) {
                    $usercachchange->showErrorMessages($this);
                } else {
                    $usercachchange->showSuccessMessages($this, 'UserCachChange Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('userid')->setDefault($usercachchangeItem->userid);
            $fr->get('amount')->setDefault($usercachchangeItem->amount);
            $fr->get('date')->setDefault($usercachchangeItem->date);
            $fr->get('reasonid')->setDefault($usercachchangeItem->reasonid);
            $fr->get('more')->setDefault($usercachchangeItem->more);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = UserCachChange::findFirst($id);
        $this->view->item = $item;

        $form = new UserCachChangeForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userid')->setDefault($item->userid);
        $form->get('amount')->setDefault($item->amount);
        $form->get('date')->setDefault($item->date);
        $form->get('reasonid')->setDefault($item->reasonid);
        $form->get('more')->setDefault($item->more);
        $this->view->form = $form;
    }

}
