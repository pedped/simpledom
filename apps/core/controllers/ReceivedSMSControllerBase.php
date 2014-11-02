<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use ReceivedSMS;
use ReceivedSMSForm;

class ReceivedSMSControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('ReceivedSMS');
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

        $fr = new ReceivedSMSForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $receivedsms = new \ReceivedSMS();

                $receivedsms->phone = $this->request->getPost('phone', 'string');
                $receivedsms->message = $this->request->getPost('message', 'string');
                $receivedsms->fromnumber = $this->request->getPost('fromnumber', 'string');
                $receivedsms->ip = $this->request->getPost('ip', 'string');
                $receivedsms->provider = $this->request->getPost('provider', 'string');
                $receivedsms->date = $this->request->getPost('date', 'string');
                if (!$receivedsms->create()) {
                    $receivedsms->showErrorMessages($this);
                } else {
                    $receivedsms->showSuccessMessages($this, 'New ReceivedSMS added Successfully');

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
        $receivedsmss = ReceivedSMS::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $receivedsmss,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Phone', 'Message', 'From Number', 'IP', 'Provider', 'Date'
                ))->
                setFields(array(
                    'id', 'phone', 'message', 'fromnumber', 'ip', 'provider', 'getDate()'
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
        $item = ReceivedSMS::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'receivedsms',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = ReceivedSMS::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this ReceivedSMS item');
            } else {
                $this->flash->success('ReceivedSMS item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'receivedsms',
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
        $this->setTitle('Edit ReceivedSMS');

        $receivedsmsItem = ReceivedSMS::findFirst($id);

        // create form
        $fr = new ReceivedSMSForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $receivedsms = ReceivedSMS::findFirst($id);
                $receivedsms->phone = $this->request->getPost('phone', 'string');

                $receivedsms->message = $this->request->getPost('message', 'string');

                $receivedsms->fromnumber = $this->request->getPost('fromnumber', 'string');

                $receivedsms->ip = $this->request->getPost('ip', 'string');

                $receivedsms->provider = $this->request->getPost('provider', 'string');

                $receivedsms->date = $this->request->getPost('date', 'string');
                if (!$receivedsms->save()) {
                    $receivedsms->showErrorMessages($this);
                } else {
                    $receivedsms->showSuccessMessages($this, 'ReceivedSMS Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('phone')->setDefault($receivedsmsItem->phone);
            $fr->get('message')->setDefault($receivedsmsItem->message);
            $fr->get('fromnumber')->setDefault($receivedsmsItem->fromnumber);
            $fr->get('ip')->setDefault($receivedsmsItem->ip);
            $fr->get('provider')->setDefault($receivedsmsItem->provider);
            $fr->get('date')->setDefault($receivedsmsItem->date);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = ReceivedSMS::findFirst($id);
        $this->view->item = $item;

        $form = new ReceivedSMSForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('phone')->setDefault($item->phone);
        $form->get('message')->setDefault($item->message);
        $form->get('fromnumber')->setDefault($item->fromnumber);
        $form->get('ip')->setDefault($item->ip);
        $form->get('provider')->setDefault($item->provider);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
