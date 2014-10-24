<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use SMSCreditChange;
use Simpledom\Core\SMSCreditChangeForm;

class SMSCreditChangeControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('SMSCreditChange');
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

        $fr = new SMSCreditChangeForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $smscreditchange = new \SMSCreditChange();

                $smscreditchange->userid = $this->request->getPost('userid', 'string');
                $smscreditchange->smsid = $this->request->getPost('smsid', 'string');
                $smscreditchange->value = $this->request->getPost('value', 'string');
                $smscreditchange->date = $this->request->getPost('date', 'string');
                if (!$smscreditchange->create()) {
                    $smscreditchange->showErrorMessages($this);
                } else {
                    $smscreditchange->showSuccessMessages($this, 'New SMSCreditChange added Successfully');

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
        $smscreditchanges = SMSCreditChange::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $smscreditchanges,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'User ID', 'SMS ID', 'Value', 'Date'
                ))->
                setFields(array(
                    'id', 'userid', 'smsid', 'value', 'date'
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
        $item = SMSCreditChange::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'smscreditchange',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = SMSCreditChange::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this SMSCreditChange item');
            } else {
                $this->flash->success('SMSCreditChange item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'smscreditchange',
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
        $this->setTitle('Edit SMSCreditChange');

        $smscreditchangeItem = SMSCreditChange::findFirst($id);

        // create form
        $fr = new SMSCreditChangeForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $smscreditchange = SMSCreditChange::findFirst($id);
                $smscreditchange->userid = $this->request->getPost('userid', 'string');

                $smscreditchange->smsid = $this->request->getPost('smsid', 'string');

                $smscreditchange->value = $this->request->getPost('value', 'string');

                $smscreditchange->date = $this->request->getPost('date', 'string');
                if (!$smscreditchange->save()) {
                    $smscreditchange->showErrorMessages($this);
                } else {
                    $smscreditchange->showSuccessMessages($this, 'SMSCreditChange Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('userid')->setDefault($smscreditchangeItem->userid);
            $fr->get('smsid')->setDefault($smscreditchangeItem->smsid);
            $fr->get('value')->setDefault($smscreditchangeItem->value);
            $fr->get('date')->setDefault($smscreditchangeItem->date);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = SMSCreditChange::findFirst($id);
        $this->view->item = $item;

        $form = new SMSCreditChangeForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userid')->setDefault($item->userid);
        $form->get('smsid')->setDefault($item->smsid);
        $form->get('value')->setDefault($item->value);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
