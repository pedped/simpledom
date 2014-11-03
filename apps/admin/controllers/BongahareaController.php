<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use BongahArea;
use BongahAreaForm;
use Simpledom\Admin\BaseControllers\ControllerBase;

class bongahareaController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('bongaharea');
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

        $fr = new BongahAreaForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $bongaharea = new \BongahArea();

                $bongaharea->bongahid = $this->request->getPost('bongahid', 'string');
                $bongaharea->areaid = $this->request->getPost('areaid', 'string');
                $bongaharea->enable = $this->request->getPost('enable', 'string');
                if (!$bongaharea->create()) {
                    $bongaharea->showErrorMessages($this);
                } else {
                    $bongaharea->showSuccessMessages($this, 'New bongaharea added Successfully');

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
        $bongahareas = BongahArea::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $bongahareas,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Bongah ID', 'Area ID', 'Enable'
                ))->
                setFields(array(
                    'id', 'bongahid', 'areaid', 'enable'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'bongaharea/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = BongahArea::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'bongaharea',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = BongahArea::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this bongaharea item');
            } else {
                $this->flash->success('bongaharea item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'bongaharea',
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
        $this->setTitle('Edit bongaharea');

        $bongahareaItem = BongahArea::findFirst($id);

        // create form
        $fr = new bongahareaForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $bongaharea = BongahArea::findFirst($id);
                $bongaharea->bongahid = $this->request->getPost('bongahid', 'string');

                $bongaharea->areaid = $this->request->getPost('areaid', 'string');

                $bongaharea->enable = $this->request->getPost('enable', 'string');
                if (!$bongaharea->save()) {
                    $bongaharea->showErrorMessages($this);
                } else {
                    $bongaharea->showSuccessMessages($this, 'bongaharea Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('bongahid')->setDefault($bongahareaItem->bongahid);
            $fr->get('areaid')->setDefault($bongahareaItem->areaid);
            $fr->get('enable')->setDefault($bongahareaItem->enable);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = BongahArea::findFirst($id);
        $this->view->item = $item;

        $form = new bongahareaForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('bongahid')->setDefault($item->bongahid);
        $form->get('areaid')->setDefault($item->areaid);
        $form->get('enable')->setDefault($item->enable);
        $this->view->form = $form;
    }

}
