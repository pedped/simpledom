<?php

namespace Simpledom\Admin\Controllers;

use AppEmailRequest;
use AppEmailRequestForm;
use AtaPaginator;
use Simpledom\Admin\BaseControllers\ControllerBase;

class AppEmailRequestController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('AppEmailRequest');
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

        $fr = new AppEmailRequestForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $appemailrequest = new \AppEmailRequest();

                $appemailrequest->phone = $this->request->getPost('phone', 'string');
                $appemailrequest->email = $this->request->getPost('email', 'string');
                $appemailrequest->date = $this->request->getPost('date', 'string');
                $appemailrequest->ip = $this->request->getPost('ip', 'string');
                if (!$appemailrequest->create()) {
                    $appemailrequest->showErrorMessages($this);
                } else {
                    $appemailrequest->showSuccessMessages($this, 'New AppEmailRequest added Successfully');

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
        $appemailrequests = AppEmailRequest::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $appemailrequests,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'phone', 'email', 'date', 'ip'
                ))->
                setFields(array(
                    'id', 'phone', 'email', 'getDate()', 'ip'
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
        $item = AppEmailRequest::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'appemailrequest',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = AppEmailRequest::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this AppEmailRequest item');
            } else {
                $this->flash->success('AppEmailRequest item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'appemailrequest',
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
        $this->setTitle('Edit AppEmailRequest');

        $appemailrequestItem = AppEmailRequest::findFirst($id);

        // create form
        $fr = new AppEmailRequestForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $appemailrequest = AppEmailRequest::findFirst($id);
                $appemailrequest->phone = $this->request->getPost('phone', 'string');

                $appemailrequest->email = $this->request->getPost('email', 'string');

                $appemailrequest->date = $this->request->getPost('date', 'string');

                $appemailrequest->ip = $this->request->getPost('ip', 'string');
                if (!$appemailrequest->save()) {
                    $appemailrequest->showErrorMessages($this);
                } else {
                    $appemailrequest->showSuccessMessages($this, 'AppEmailRequest Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('phone')->setDefault($appemailrequestItem->phone);
            $fr->get('email')->setDefault($appemailrequestItem->email);
            $fr->get('date')->setDefault($appemailrequestItem->date);
            $fr->get('ip')->setDefault($appemailrequestItem->ip);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = AppEmailRequest::findFirst($id);
        $this->view->item = $item;

        $form = new AppEmailRequestForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('phone')->setDefault($item->phone);
        $form->get('email')->setDefault($item->email);
        $form->get('date')->setDefault($item->date);
        $form->get('ip')->setDefault($item->ip);
        $this->view->form = $form;
    }

}
