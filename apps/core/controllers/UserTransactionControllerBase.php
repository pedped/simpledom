<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use Simpledom\Core\UserTransactionForm;
use UserTransaction;

class UserTransactionControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('UserTransaction');
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

        $fr = new UserTransactionForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $usertransaction = new UserTransaction();

                $usertransaction->userid = $this->request->getPost('userid', 'string');
                $usertransaction->amount = $this->request->getPost('amount', 'string');
                $usertransaction->cur = $this->request->getPost('cur', 'string');
                $usertransaction->type = $this->request->getPost('type', 'string');
                $usertransaction->typename = $this->request->getPost('typename', 'string');
                $usertransaction->itemid = $this->request->getPost('itemid', 'string');
                $usertransaction->date = $this->request->getPost('date', 'string');
                if (!$usertransaction->create()) {
                    $usertransaction->showErrorMessages($this);
                } else {
                    $usertransaction->showSuccessMessages($this, 'New UserTransaction added Successfully');

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
        $usertransactions = UserTransaction::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $usertransactions,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'User ID', 'Amount', 'Currency', 'Type', 'Type Name', 'Item ID', 'Date'
                ))->
                setFields(array(
                    'id', 'userid', 'amount', 'cur', 'type', 'typename', 'itemid', 'date'
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
        $item = UserTransaction::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'usertransaction',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = UserTransaction::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this UserTransaction item');
            } else {
                $this->flash->success('UserTransaction item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'usertransaction',
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
        $this->setTitle('Edit UserTransaction');

        $usertransactionItem = UserTransaction::findFirst($id);

        // create form
        $fr = new UserTransactionForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $usertransaction = UserTransaction::findFirst($id);
                $usertransaction->userid = $this->request->getPost('userid', 'string');

                $usertransaction->amount = $this->request->getPost('amount', 'string');

                $usertransaction->cur = $this->request->getPost('cur', 'string');

                $usertransaction->type = $this->request->getPost('type', 'string');

                $usertransaction->typename = $this->request->getPost('typename', 'string');

                $usertransaction->itemid = $this->request->getPost('itemid', 'string');

                $usertransaction->date = $this->request->getPost('date', 'string');
                if (!$usertransaction->save()) {
                    $usertransaction->showErrorMessages($this);
                } else {
                    $usertransaction->showSuccessMessages($this, 'UserTransaction Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('userid')->setDefault($usertransactionItem->userid);
            $fr->get('amount')->setDefault($usertransactionItem->amount);
            $fr->get('cur')->setDefault($usertransactionItem->cur);
            $fr->get('type')->setDefault($usertransactionItem->type);
            $fr->get('typename')->setDefault($usertransactionItem->typename);
            $fr->get('itemid')->setDefault($usertransactionItem->itemid);
            $fr->get('date')->setDefault($usertransactionItem->date);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = UserTransaction::findFirst($id);
        $this->view->item = $item;

        $form = new UserTransactionForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userid')->setDefault($item->userid);
        $form->get('amount')->setDefault($item->amount);
        $form->get('cur')->setDefault($item->cur);
        $form->get('type')->setDefault($item->type);
        $form->get('typename')->setDefault($item->typename);
        $form->get('itemid')->setDefault($item->itemid);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
