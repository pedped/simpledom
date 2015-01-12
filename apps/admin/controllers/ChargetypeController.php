<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use ChargeType;
use ChargeTypeForm;
use Simpledom\Admin\BaseControllers\ControllerBase;

class ChargeTypeController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('ChargeType');
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

        $fr = new ChargeTypeForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $chargetype = new \ChargeType();

                $chargetype->name = $this->request->getPost('name', 'string');
                $chargetype->persianname = $this->request->getPost('persianname', 'string');
                $chargetype->status = $this->request->getPost('status', 'string');
                $chargetype->statusmessage = $this->request->getPost('statusmessage', 'string');
                if (!$chargetype->create()) {
                    $chargetype->showErrorMessages($this);
                } else {
                    $chargetype->showSuccessMessages($this, 'New ChargeType added Successfully');

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
        $chargetypes = ChargeType::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $chargetypes,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Name', 'Persian Name', 'Status', 'Status Message'
                ))->
                setFields(array(
                    'id', 'name', 'persianname', 'status', 'statusmessage'
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
        $item = ChargeType::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'chargetype',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = ChargeType::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this ChargeType item');
            } else {
                $this->flash->success('ChargeType item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'chargetype',
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
        $this->setTitle('Edit ChargeType');

        $chargetypeItem = ChargeType::findFirst($id);

        // create form
        $fr = new ChargeTypeForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $chargetype = ChargeType::findFirst($id);
                $chargetype->name = $this->request->getPost('name', 'string');

                $chargetype->persianname = $this->request->getPost('persianname', 'string');

                $chargetype->status = $this->request->getPost('status', 'string');

                $chargetype->statusmessage = $this->request->getPost('statusmessage', 'string');
                if (!$chargetype->save()) {
                    $chargetype->showErrorMessages($this);
                } else {
                    $chargetype->showSuccessMessages($this, 'ChargeType Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('name')->setDefault($chargetypeItem->name);
            $fr->get('persianname')->setDefault($chargetypeItem->persianname);
            $fr->get('status')->setDefault($chargetypeItem->status);
            $fr->get('statusmessage')->setDefault($chargetypeItem->statusmessage);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = ChargeType::findFirst($id);
        $this->view->item = $item;

        $form = new ChargeTypeForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('name')->setDefault($item->name);
        $form->get('persianname')->setDefault($item->persianname);
        $form->get('status')->setDefault($item->status);
        $form->get('statusmessage')->setDefault($item->statusmessage);
        $this->view->form = $form;
    }

}
