<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use ValidProviderIP;
use ValidProviderIPForm;

class ValidProviderIPControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('ValidProviderIP');
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

        $fr = new ValidProviderIPForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $validproviderip = new \ValidProviderIP();

                $validproviderip->providerid = $this->request->getPost('providerid', 'string');
                $validproviderip->ip = $this->request->getPost('ip', 'string');
                $validproviderip->enable = $this->request->getPost('enable', 'string');
                if (!$validproviderip->create()) {
                    $validproviderip->showErrorMessages($this);
                } else {
                    $validproviderip->showSuccessMessages($this, 'New ValidProviderIP added Successfully');

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
        $validproviderips = ValidProviderIP::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $validproviderips,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Provider', 'IP', 'Enable'
                ))->
                setFields(array(
                    'id', 'providerid', 'ip', 'enable'
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
        $item = ValidProviderIP::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'validproviderip',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = ValidProviderIP::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this ValidProviderIP item');
            } else {
                $this->flash->success('ValidProviderIP item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'validproviderip',
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
        $this->setTitle('Edit ValidProviderIP');

        $validprovideripItem = ValidProviderIP::findFirst($id);

        // create form
        $fr = new ValidProviderIPForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $validproviderip = ValidProviderIP::findFirst($id);
                $validproviderip->providerid = $this->request->getPost('providerid', 'string');

                $validproviderip->ip = $this->request->getPost('ip', 'string');

                $validproviderip->enable = $this->request->getPost('enable', 'string');
                if (!$validproviderip->save()) {
                    $validproviderip->showErrorMessages($this);
                } else {
                    $validproviderip->showSuccessMessages($this, 'ValidProviderIP Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('providerid')->setDefault($validprovideripItem->providerid);
            $fr->get('ip')->setDefault($validprovideripItem->ip);
            $fr->get('enable')->setDefault($validprovideripItem->enable);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = ValidProviderIP::findFirst($id);
        $this->view->item = $item;

        $form = new ValidProviderIPForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('providerid')->setDefault($item->providerid);
        $form->get('ip')->setDefault($item->ip);
        $form->get('enable')->setDefault($item->enable);
        $this->view->form = $form;
    }

}
