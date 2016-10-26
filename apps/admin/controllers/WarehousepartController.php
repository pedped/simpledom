<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ControllerBase;
use AtaPaginator;
use Warehousepart;
use WarehousepartForm;

class WarehousepartController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('بخش های انبار');
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

        $fr = new WarehousepartForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $warehousepart = new \Warehousepart();

                $warehousepart->warehousesectionid = $this->request->getPost('warehousesectionid', 'string');
                $warehousepart->status = $this->request->getPost('status', 'string');
                if (!$warehousepart->create()) {
                    $warehousepart->showErrorMessages($this);
                } else {
                    $warehousepart->showSuccessMessages($this, 'بخش جدید با موفقیت اضافه گردید');

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
        $warehouseparts = Warehousepart::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $warehouseparts,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'تاریخ افزوده شده', 'برش انبار', 'وضعیت'
                ))->
                setFields(array(
                    'id', 'getDate()', 'warehousesectionid', 'status'
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
        $item = Warehousepart::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'warehousepart',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Warehousepart::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('در هنگام حذف این پارت مشکلی پیش آمد');
            } else {
                $this->flash->success('این پارت از انبار با موفقیت حذف گردید');
                return $this->dispatcher->forward(array(
                            'controller' => 'warehousepart',
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

        $warehousepartItem = Warehousepart::findFirst($id);

        // create form
        $fr = new WarehousepartForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $warehousepart = Warehousepart::findFirst($id);
                $warehousepart->date = $this->request->getPost('date', 'string');

                $warehousepart->warehousesectionid = $this->request->getPost('warehousesectionid', 'string');

                $warehousepart->status = $this->request->getPost('status', 'string');
                if (!$warehousepart->save()) {
                    $warehousepart->showErrorMessages($this);
                } else {
                    $warehousepart->showSuccessMessages($this, 'Warehousepart Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('date')->setDefault($warehousepartItem->date);
            $fr->get('warehousesectionid')->setDefault($warehousepartItem->warehousesectionid);
            $fr->get('status')->setDefault($warehousepartItem->status);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Warehousepart::findFirst($id);
        $this->view->item = $item;

        $form = new WarehousepartForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('date')->setDefault($item->date);
        $form->get('warehousesectionid')->setDefault($item->warehousesectionid);
        $form->get('status')->setDefault($item->status);
        $this->view->form = $form;
    }

}
