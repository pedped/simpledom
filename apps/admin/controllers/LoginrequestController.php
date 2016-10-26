<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ControllerBase;
use AtaPaginator;
use LoginRequest;
use LoginRequestForm;

class LoginRequestController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('LoginRequest');
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

        $fr = new LoginRequestForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $loginrequest = new \LoginRequest();

                $loginrequest->devicemodel = $this->request->getPost('devicemodel', 'string');
                $loginrequest->deviceid = $this->request->getPost('deviceid', 'string');
                $loginrequest->androidversioncode = $this->request->getPost('androidversioncode', 'string');
                $loginrequest->phonenumber = $this->request->getPost('phonenumber', 'string');
                $loginrequest->androidversionname = $this->request->getPost('androidversionname', 'string');
                $loginrequest->ip = $this->request->getPost('ip', 'string');
                $loginrequest->token = $this->request->getPost('token', 'string');
                if (!$loginrequest->create()) {
                    $loginrequest->showErrorMessages($this);
                } else {
                    $loginrequest->showSuccessMessages($this, 'New LoginRequest added Successfully');

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
        $loginrequests = LoginRequest::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $loginrequests,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Device Model', 'Device ID', 'Android Version Code', 'Phone Number', 'Android Version Name', 'IP', 'Token', 'Date'
                ))->
                setFields(array(
                    'id', 'devicemodel', 'deviceid', 'androidversioncode', 'phonenumber', 'androidversionname', 'ip', 'token', 'getDate()'
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
        $item = LoginRequest::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'loginrequest',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = LoginRequest::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this LoginRequest item');
            } else {
                $this->flash->success('LoginRequest item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'loginrequest',
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
        $this->setTitle('Edit LoginRequest');

        $loginrequestItem = LoginRequest::findFirst($id);

        // create form
        $fr = new LoginRequestForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $loginrequest = LoginRequest::findFirst($id);
                $loginrequest->devicemodel = $this->request->getPost('devicemodel', 'string');

                $loginrequest->deviceid = $this->request->getPost('deviceid', 'string');

                $loginrequest->androidversioncode = $this->request->getPost('androidversioncode', 'string');

                $loginrequest->phonenumber = $this->request->getPost('phonenumber', 'string');

                $loginrequest->androidversionname = $this->request->getPost('androidversionname', 'string');

                $loginrequest->ip = $this->request->getPost('ip', 'string');

                $loginrequest->token = $this->request->getPost('token', 'string');

                $loginrequest->date = $this->request->getPost('date', 'string');
                if (!$loginrequest->save()) {
                    $loginrequest->showErrorMessages($this);
                } else {
                    $loginrequest->showSuccessMessages($this, 'LoginRequest Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('devicemodel')->setDefault($loginrequestItem->devicemodel);
            $fr->get('deviceid')->setDefault($loginrequestItem->deviceid);
            $fr->get('androidversioncode')->setDefault($loginrequestItem->androidversioncode);
            $fr->get('phonenumber')->setDefault($loginrequestItem->phonenumber);
            $fr->get('androidversionname')->setDefault($loginrequestItem->androidversionname);
            $fr->get('ip')->setDefault($loginrequestItem->ip);
            $fr->get('token')->setDefault($loginrequestItem->token);
            $fr->get('date')->setDefault($loginrequestItem->date);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = LoginRequest::findFirst($id);
        $this->view->item = $item;

        $form = new LoginRequestForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('devicemodel')->setDefault($item->devicemodel);
        $form->get('deviceid')->setDefault($item->deviceid);
        $form->get('androidversioncode')->setDefault($item->androidversioncode);
        $form->get('phonenumber')->setDefault($item->phonenumber);
        $form->get('androidversionname')->setDefault($item->androidversionname);
        $form->get('ip')->setDefault($item->ip);
        $form->get('token')->setDefault($item->token);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
