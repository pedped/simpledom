<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use Simpledom\Core\SmsNumberForm;
use SmsNumber;


class SmsNumberControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('SmsNumber');
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

        $fr = new SmsNumberForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $smsnumber = new SmsNumber();

                $smsnumber->number = $this->request->getPost('number', 'string');
                $smsnumber->enable = $this->request->getPost('enable', 'string');
                $smsnumber->sentcount = $this->request->getPost('sentcount', 'string');
                $smsnumber->date = $this->request->getPost('date', 'string');
                $smsnumber->description = $this->request->getPost('description', 'string');
                $smsnumber->providerid = $this->request->getPost('providerid', 'string');
                if (!$smsnumber->create()) {
                    $smsnumber->showErrorMessages($this);
                } else {
                    $smsnumber->showSuccessMessages($this, 'New SmsNumber added Successfully');

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
        $smsnumbers = SmsNumber::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $smsnumbers,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Number', 'Enable', 'Sent Count', 'Date', 'Description', 'Provider Name'
                ))->
                setFields(array(
                    'id', 'number', 'enable', 'sentcount', 'date', 'description', 'providerid'
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
        $item = SmsNumber::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'smsnumber',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = SmsNumber::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this SmsNumber item');
            } else {
                $this->flash->success('SmsNumber item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'smsnumber',
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
        $this->setTitle('Edit SmsNumber');

        $smsnumberItem = SmsNumber::findFirst($id);

        // create form
        $fr = new SmsNumberForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $smsnumber = SmsNumber::findFirst($id);
                $smsnumber->number = $this->request->getPost('number', 'string');

                $smsnumber->enable = $this->request->getPost('enable', 'string');

                $smsnumber->sentcount = $this->request->getPost('sentcount', 'string');

                $smsnumber->date = $this->request->getPost('date', 'string');

                $smsnumber->description = $this->request->getPost('description', 'string');

                $smsnumber->providerid = $this->request->getPost('providerid', 'string');
                if (!$smsnumber->save()) {
                    $smsnumber->showErrorMessages($this);
                } else {
                    $smsnumber->showSuccessMessages($this, 'SmsNumber Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('number')->setDefault($smsnumberItem->number);
            $fr->get('enable')->setDefault($smsnumberItem->enable);
            $fr->get('sentcount')->setDefault($smsnumberItem->sentcount);
            $fr->get('date')->setDefault($smsnumberItem->date);
            $fr->get('description')->setDefault($smsnumberItem->description);
            $fr->get('providerid')->setDefault($smsnumberItem->providerid);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = SmsNumber::findFirst($id);
        $this->view->item = $item;

        $form = new SmsNumberForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('number')->setDefault($item->number);
        $form->get('enable')->setDefault($item->enable);
        $form->get('sentcount')->setDefault($item->sentcount);
        $form->get('date')->setDefault($item->date);
        $form->get('description')->setDefault($item->description);
        $form->get('providerid')->setDefault($item->providerid);
        $this->view->form = $form;
    }

}
