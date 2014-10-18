<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use Simpledom\Core\SMSProviderForm;
use SMSProvider;

class SMSProviderControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('SMSProvider');
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

        $fr = new SMSProviderForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $smsprovider = new SMSProvider();
                $smsprovider->name = $this->request->getPost('name', 'string');
                $smsprovider->description = $this->request->getPost('description', 'string');
                $smsprovider->infos = $this->request->getPost('infos', 'string');
                $smsprovider->date = $this->request->getPost('date', 'string');
                $smsprovider->websitename = $this->request->getPost('websitename', 'striptags'); // TODO not validated
                $smsprovider->enable = $this->request->getPost('enable', 'string');
                if (!$smsprovider->create()) {
                    $smsprovider->showErrorMessages($this);
                } else {
                    $smsprovider->showSuccessMessages($this, 'New SMSProvider added Successfully');

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
        $smsproviders = SMSProvider::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $smsproviders,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Name', 'Description', 'Infos', 'Date', 'Website URL', 'Enable'
                ))->
                setFields(array(
                    'id', 'name', 'description', 'infos', 'date', 'websitename', 'enable'
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
        $item = SMSProvider::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'smsprovider',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = SMSProvider::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this SMSProvider item');
            } else {
                $this->flash->success('SMSProvider item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'smsprovider',
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
        $this->setTitle('Edit SMSProvider');

        $smsproviderItem = SMSProvider::findFirst($id);

        // create form
        $fr = new SMSProviderForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $smsprovider = SMSProvider::findFirst($id);
                $smsprovider->name = $this->request->getPost('name', 'string');

                $smsprovider->description = $this->request->getPost('description', 'string');

                $smsprovider->infos = $this->request->getPost('infos', 'string');

                $smsprovider->date = $this->request->getPost('date', 'string');

                $smsprovider->websitename = $this->request->getPost('websitename', 'string');

                $smsprovider->enable = $this->request->getPost('enable', 'string');
                if (!$smsprovider->save()) {
                    $smsprovider->showErrorMessages($this);
                } else {
                    $smsprovider->showSuccessMessages($this, 'SMSProvider Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('name')->setDefault($smsproviderItem->name);
            $fr->get('description')->setDefault($smsproviderItem->description);
            $fr->get('infos')->setDefault($smsproviderItem->infos);
            $fr->get('date')->setDefault($smsproviderItem->date);
            $fr->get('websitename')->setDefault($smsproviderItem->websitename);
            $fr->get('enable')->setDefault($smsproviderItem->enable);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = SMSProvider::findFirst($id);
        $this->view->item = $item;

        $form = new SMSProviderForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('name')->setDefault($item->name);
        $form->get('description')->setDefault($item->description);
        $form->get('infos')->setDefault($item->infos);
        $form->get('date')->setDefault($item->date);
        $form->get('websitename')->setDefault($item->websitename);
        $form->get('enable')->setDefault($item->enable);
        $this->view->form = $form;
    }

}
