<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use MobileToken;
use Simpledom\Core\MobileTokenForm;

class MobileTokenControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('MobileToken');
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

        $fr = new MobileTokenForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $mobiletoken = new \MobileToken();

                $mobiletoken->userid = $this->request->getPost('userid', 'string');
                $mobiletoken->deviceid = $this->request->getPost('deviceid', 'string');
                $mobiletoken->devicetype = $this->request->getPost('devicetype', 'string');
                $mobiletoken->token = $this->request->getPost('token', 'string');
                $mobiletoken->date = $this->request->getPost('date', 'string');
                if (!$mobiletoken->create()) {
                    $mobiletoken->showErrorMessages($this);
                } else {
                    $mobiletoken->showSuccessMessages($this, 'New MobileToken added Successfully');

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
        $mobiletokens = MobileToken::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $mobiletokens,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'User ID', 'Device ID', 'Device Type', 'Token', 'Date'
                ))->
                setFields(array(
                    'id', 'userid', 'deviceid', 'devicetype', 'token', 'getDate()'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'mobiletoken/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = MobileToken::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'mobiletoken',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = MobileToken::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this MobileToken item');
            } else {
                $this->flash->success('MobileToken item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'mobiletoken',
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
        $this->setTitle('Edit MobileToken');

        $mobiletokenItem = MobileToken::findFirst($id);

        // create form
        $fr = new MobileTokenForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $mobiletoken = MobileToken::findFirst($id);
                $mobiletoken->userid = $this->request->getPost('userid', 'string');

                $mobiletoken->deviceid = $this->request->getPost('deviceid', 'string');

                $mobiletoken->devicetype = $this->request->getPost('devicetype', 'string');

                $mobiletoken->token = $this->request->getPost('token', 'string');

                $mobiletoken->date = $this->request->getPost('date', 'string');
                if (!$mobiletoken->save()) {
                    $mobiletoken->showErrorMessages($this);
                } else {
                    $mobiletoken->showSuccessMessages($this, 'MobileToken Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('userid')->setDefault($mobiletokenItem->userid);
            $fr->get('deviceid')->setDefault($mobiletokenItem->deviceid);
            $fr->get('devicetype')->setDefault($mobiletokenItem->devicetype);
            $fr->get('token')->setDefault($mobiletokenItem->token);
            $fr->get('date')->setDefault($mobiletokenItem->date);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = MobileToken::findFirst($id);
        $this->view->item = $item;

        $form = new MobileTokenForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userid')->setDefault($item->userid);
        $form->get('deviceid')->setDefault($item->deviceid);
        $form->get('devicetype')->setDefault($item->devicetype);
        $form->get('token')->setDefault($item->token);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
