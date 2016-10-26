<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ControllerBase;
use AtaPaginator;
use WarehouseSection;
use WarehouseSectionForm;

class WarehouseSectionController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('WarehouseSection');
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

        $fr = new WarehouseSectionForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $warehousesection = new \WarehouseSection();

                $warehousesection->warehouseid = $this->request->getPost('warehouseid', 'string');
                $warehousesection->status = $this->request->getPost('status', 'string');
                if (!$warehousesection->create()) {
                    $warehousesection->showErrorMessages($this);
                } else {
                    $warehousesection->showSuccessMessages($this, 'New WarehouseSection added Successfully');

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
        $warehousesections = WarehouseSection::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $warehousesections,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Date', 'Warehouse ID', 'Status'
                ))->
                setFields(array(
                    'id', 'getDate()', 'warehouseid', 'status'
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
        $item = WarehouseSection::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'warehousesection',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = WarehouseSection::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this WarehouseSection item');
            } else {
                $this->flash->success('WarehouseSection item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'warehousesection',
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
        $this->setTitle('Edit WarehouseSection');

        $warehousesectionItem = WarehouseSection::findFirst($id);

        // create form
        $fr = new WarehouseSectionForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $warehousesection = WarehouseSection::findFirst($id);
                $warehousesection->date = $this->request->getPost('date', 'string');

                $warehousesection->warehouseid = $this->request->getPost('warehouseid', 'string');

                $warehousesection->status = $this->request->getPost('status', 'string');
                if (!$warehousesection->save()) {
                    $warehousesection->showErrorMessages($this);
                } else {
                    $warehousesection->showSuccessMessages($this, 'WarehouseSection Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('date')->setDefault($warehousesectionItem->date);
            $fr->get('warehouseid')->setDefault($warehousesectionItem->warehouseid);
            $fr->get('status')->setDefault($warehousesectionItem->status);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = WarehouseSection::findFirst($id);
        $this->view->item = $item;

        $form = new WarehouseSectionForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('date')->setDefault($item->date);
        $form->get('warehouseid')->setDefault($item->warehouseid);
        $form->get('status')->setDefault($item->status);
        $this->view->form = $form;
    }

}
