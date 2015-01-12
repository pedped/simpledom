<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use CreditChange;
use CreditChangeForm;
use Simpledom\Admin\BaseControllers\ControllerBase;

class CreditChangeController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('CreditChange');
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

        $fr = new CreditChangeForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $creditchange = new \CreditChange();

                $creditchange->userid = $this->request->getPost('userid', 'string');
                $creditchange->status = $this->request->getPost('status', 'string');
                $creditchange->value = $this->request->getPost('value', 'string');
                $creditchange->chargeid = $this->request->getPost('chargeid', 'string');
                $creditchange->date = $this->request->getPost('date', 'string');
                $creditchange->message = $this->request->getPost('message', 'string');
                if (!$creditchange->create()) {
                    $creditchange->showErrorMessages($this);
                } else {
                    $creditchange->showSuccessMessages($this, 'New CreditChange added Successfully');

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
        $creditchanges = CreditChange::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $creditchanges,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'User ID', 'Status', 'Value', 'Charge ID', 'Date', 'Message'
                ))->
                setFields(array(
                    'id', 'userid', 'status', 'value', 'chargeid', 'getDate()', 'message'
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
        $item = CreditChange::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'creditchange',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = CreditChange::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this CreditChange item');
            } else {
                $this->flash->success('CreditChange item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'creditchange',
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
        $this->setTitle('Edit CreditChange');

        $creditchangeItem = CreditChange::findFirst($id);

        // create form
        $fr = new CreditChangeForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $creditchange = CreditChange::findFirst($id);
                $creditchange->userid = $this->request->getPost('userid', 'string');

                $creditchange->status = $this->request->getPost('status', 'string');

                $creditchange->value = $this->request->getPost('value', 'string');

                $creditchange->chargeid = $this->request->getPost('chargeid', 'string');

                $creditchange->date = $this->request->getPost('date', 'string');

                $creditchange->message = $this->request->getPost('message', 'string');
                if (!$creditchange->save()) {
                    $creditchange->showErrorMessages($this);
                } else {
                    $creditchange->showSuccessMessages($this, 'CreditChange Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('userid')->setDefault($creditchangeItem->userid);
            $fr->get('status')->setDefault($creditchangeItem->status);
            $fr->get('value')->setDefault($creditchangeItem->value);
            $fr->get('chargeid')->setDefault($creditchangeItem->chargeid);
            $fr->get('date')->setDefault($creditchangeItem->date);
            $fr->get('message')->setDefault($creditchangeItem->message);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = CreditChange::findFirst($id);
        $this->view->item = $item;

        $form = new CreditChangeForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userid')->setDefault($item->userid);
        $form->get('status')->setDefault($item->status);
        $form->get('value')->setDefault($item->value);
        $form->get('chargeid')->setDefault($item->chargeid);
        $form->get('date')->setDefault($item->date);
        $form->get('message')->setDefault($item->message);
        $this->view->form = $form;
    }

}
