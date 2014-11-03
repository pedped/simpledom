<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use Sentsms;
use Simpledom\Core\SentsmsForm;

class SentsmsControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Sentsms');
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

        $fr = new SentsmsForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $sentsms = new Sentsms();
                $sentsms->phone = $this->request->getPost('phone', 'string');
                $sentsms->message = $this->request->getPost('message', 'string');
                $sentsms->fromnumber = $this->request->getPost('fromnumber', 'string');
                $sentsms->ip = $this->request->getPost('ip', 'string');
                $sentsms->provider = $this->request->getPost('provider', 'string');
                $sentsms->date = $this->request->getPost('date', 'string');
                $sentsms->result = $this->request->getPost('result', 'string');
                $sentsms->refcode = $this->request->getPost('refcode', 'string');
                if (!$sentsms->create()) {
                    $sentsms->showErrorMessages($this);
                } else {
                    $sentsms->showSuccessMessages($this, 'New Sentsms added Successfully');

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
        $sentsmss = Sentsms::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $sentsmss,
            'limit' => 10,
            'page' => $numberPage
        ));

        $paginator->setSearchItemArrays(array(
            "phone" => "Phone",
            "message" => "Message",
        ));

        $paginator->
                setTableHeaders(array(
                    'ID', 'Phone', 'Message', 'From Number', 'IP', 'Provider', 'Date', 'Result', 'Reference Code'
                ))->
                setFields(array(
                    'id', 'phone', 'message', 'fromnumber', 'ip', 'getProviderName()', 'getDate()', 'result', 'refcode'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'sentsms/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = Sentsms::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'sentsms',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Sentsms::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Sentsms item');
            } else {
                $this->flash->success('Sentsms item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'sentsms',
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
        $this->setTitle('Edit Sentsms');

        $sentsmsItem = Sentsms::findFirst($id);

        // create form
        $fr = new SentsmsForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $sentsms = Sentsms::findFirst($id);
                $sentsms->phone = $this->request->getPost('phone', 'string');

                $sentsms->message = $this->request->getPost('message', 'string');

                $sentsms->fromnumber = $this->request->getPost('fromnumber', 'string');

                $sentsms->ip = $this->request->getPost('ip', 'string');

                $sentsms->provider = $this->request->getPost('provider', 'string');

                $sentsms->date = $this->request->getPost('date', 'string');

                $sentsms->result = $this->request->getPost('result', 'string');

                $sentsms->refcode = $this->request->getPost('refcode', 'string');
                if (!$sentsms->save()) {
                    $sentsms->showErrorMessages($this);
                } else {
                    $sentsms->showSuccessMessages($this, 'Sentsms Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('phone')->setDefault($sentsmsItem->phone);
            $fr->get('message')->setDefault($sentsmsItem->message);
            $fr->get('fromnumber')->setDefault($sentsmsItem->fromnumber);
            $fr->get('ip')->setDefault($sentsmsItem->ip);
            $fr->get('provider')->setDefault($sentsmsItem->provider);
            $fr->get('date')->setDefault($sentsmsItem->date);
            $fr->get('result')->setDefault($sentsmsItem->result);
            $fr->get('refcode')->setDefault($sentsmsItem->refcode);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Sentsms::findFirst($id);
        $this->view->item = $item;

        $form = new SentsmsForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('phone')->setDefault($item->phone);
        $form->get('message')->setDefault($item->message);
        $form->get('fromnumber')->setDefault($item->fromnumber);
        $form->get('ip')->setDefault($item->ip);
        $form->get('provider')->setDefault($item->provider);
        $form->get('date')->setDefault($item->date);
        $form->get('result')->setDefault($item->result);
        $form->get('refcode')->setDefault($item->refcode);
        $this->view->form = $form;
    }

}
