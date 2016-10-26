<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ControllerBase;
use AtaPaginator;
use Warehouse;
use WarehouseForm;

class WarehouseController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('انبار');
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

        $fr = new WarehouseForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $warehouse = new \Warehouse();

                $warehouse->longitude = $this->request->getPost('map_longitude', 'string');
                $warehouse->latitude = $this->request->getPost('map_latitude', 'string');
                $warehouse->address = $this->request->getPost('address', 'string');
                $warehouse->cityid = $this->request->getPost('cityid', 'string');
                $warehouse->status = $this->request->getPost('status', 'string');
                if (!$warehouse->create()) {
                    $warehouse->showErrorMessages($this);
                } else {
                    $warehouse->showSuccessMessages($this, 'انبار جدید با موفقیت افزوده گردید');

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
        $warehouses = Warehouse::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $warehouses,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد انبار', 'شهر', 'آدرس', 'وضعیت'
                ))->
                setFields(array(
                    'id', 'getCityName()', 'address', 'status'
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
        $item = Warehouse::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'warehouse',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Warehouse::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Warehouse item');
            } else {
                $this->flash->success('Warehouse item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'warehouse',
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
        $this->setTitle('Edit Warehouse');

        $warehouseItem = Warehouse::findFirst($id);

        // create form
        $fr = new WarehouseForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $warehouse = Warehouse::findFirst($id);
                $warehouse->longitude = $this->request->getPost('longitude', 'string');

                $warehouse->date = $this->request->getPost('date', 'string');

                $warehouse->latitude = $this->request->getPost('latitude', 'string');

                $warehouse->address = $this->request->getPost('address', 'string');

                $warehouse->cityid = $this->request->getPost('cityid', 'string');

                $warehouse->status = $this->request->getPost('status', 'string');
                if (!$warehouse->save()) {
                    $warehouse->showErrorMessages($this);
                } else {
                    $warehouse->showSuccessMessages($this, 'Warehouse Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('longitude')->setDefault($warehouseItem->longitude);
            $fr->get('date')->setDefault($warehouseItem->date);
            $fr->get('latitude')->setDefault($warehouseItem->latitude);
            $fr->get('address')->setDefault($warehouseItem->address);
            $fr->get('cityid')->setDefault($warehouseItem->cityid);
            $fr->get('status')->setDefault($warehouseItem->status);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Warehouse::findFirst($id);
        $this->view->item = $item;

        $form = new WarehouseForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('longitude')->setDefault($item->longitude);
        $form->get('date')->setDefault($item->date);
        $form->get('latitude')->setDefault($item->latitude);
        $form->get('address')->setDefault($item->address);
        $form->get('cityid')->setDefault($item->cityid);
        $form->get('status')->setDefault($item->status);
        $this->view->form = $form;
    }

}
