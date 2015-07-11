<?php

namespace Simpledom\Admin\Controllers;

use Account;
use AccountForm;
use AtaPaginator;
use Simpledom\Admin\BaseControllers\ControllerBase;

class AccountController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Account');
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

        $fr = new AccountForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $account = new \Account();

                $account->title = $this->request->getPost('title', 'string');
                $account->price = $this->request->getPost('price', 'string');
                $account->credit = $this->request->getPost('credit', 'string');
                $account->date = $this->request->getPost('date', 'string');
                $account->enable = $this->request->getPost('enable', 'string');
                if (!$account->create()) {
                    $account->showErrorMessages($this);
                } else {
                    $account->showSuccessMessages($this, 'بسته با موفقیت ساخته شد');

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
        $accounts = Account::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $accounts,
            'limit' => 10,
            'page' => $numberPage
        ));
   

        $paginator->
                setTableHeaders(array(
                    'کد', 'عنوان', 'قیمت', 'اعتبار', 'تاریخ', 'فعال'
                ))->
                setFields(array(
                    'id', 'title', 'price', 'credit', 'getDate()', 'enable'
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
        $item = Account::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'account',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Account::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Account item');
            } else {
                $this->flash->success('Account item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'account',
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
        $this->setTitle('Edit Account');

        $accountItem = Account::findFirst($id);

        // create form
        $fr = new AccountForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $account = Account::findFirst($id);
                $account->title = $this->request->getPost('title', 'string');

                $account->price = $this->request->getPost('price', 'string');

                $account->credit = $this->request->getPost('credit', 'string');

                $account->date = $this->request->getPost('date', 'string');

                $account->enable = $this->request->getPost('enable', 'string');
                if (!$account->save()) {
                    $account->showErrorMessages($this);
                } else {
                    $account->showSuccessMessages($this, 'Account Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('title')->setDefault($accountItem->title);
            $fr->get('price')->setDefault($accountItem->price);
            $fr->get('credit')->setDefault($accountItem->credit);
            $fr->get('date')->setDefault($accountItem->date);
            $fr->get('enable')->setDefault($accountItem->enable);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Account::findFirst($id);
        $this->view->item = $item;

        $form = new AccountForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('title')->setDefault($item->title);
        $form->get('price')->setDefault($item->price);
        $form->get('credit')->setDefault($item->credit);
        $form->get('date')->setDefault($item->date);
        $form->get('enable')->setDefault($item->enable);
        $this->view->form = $form;
    }

}
