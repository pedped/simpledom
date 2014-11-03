<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use SMSCredit;
use Simpledom\Core\SMSCreditForm;

class SMSCreditControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('SMSCredit');
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

        $fr = new SMSCreditForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $smscredit = new \SMSCredit();

                $smscredit->userid = $this->request->getPost('userid', 'string');
                $smscredit->value = $this->request->getPost('value', 'string');
                $smscredit->date = $this->request->getPost('date', 'string');
                if (!$smscredit->create()) {
                    $smscredit->showErrorMessages($this);
                } else {
                    $smscredit->showSuccessMessages($this, 'New SMSCredit added Successfully');

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
        $smscredits = SMSCredit::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $smscredits,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'User ID', 'Value', 'Date'
                ))->
                setFields(array(
                    'id', 'userid', 'value', 'date'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'smscredit/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = SMSCredit::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'smscredit',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = SMSCredit::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this SMSCredit item');
            } else {
                $this->flash->success('SMSCredit item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'smscredit',
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
        $this->setTitle('Edit SMSCredit');

        $smscreditItem = SMSCredit::findFirst($id);

        // create form
        $fr = new SMSCreditForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $smscredit = SMSCredit::findFirst($id);
                $smscredit->userid = $this->request->getPost('userid', 'string');

                $smscredit->value = $this->request->getPost('value', 'string');

                $smscredit->date = $this->request->getPost('date', 'string');
                if (!$smscredit->save()) {
                    $smscredit->showErrorMessages($this);
                } else {
                    $smscredit->showSuccessMessages($this, 'SMSCredit Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('userid')->setDefault($smscreditItem->userid);
            $fr->get('value')->setDefault($smscreditItem->value);
            $fr->get('date')->setDefault($smscreditItem->date);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = SMSCredit::findFirst($id);
        $this->view->item = $item;

        $form = new SMSCreditForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userid')->setDefault($item->userid);
        $form->get('value')->setDefault($item->value);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
