<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ControllerBase;
use AtaPaginator;
use Deliveryman;
use DeliverymanForm;

class DeliverymanController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('پیک');
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

        $fr = new DeliverymanForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $deliveryman = new \Deliveryman();

                $deliveryman->workerid = $this->request->getPost('workerid', 'string');
                $deliveryman->warehouseid = $this->request->getPost('warehouseid', 'string');
                $deliveryman->status = $this->request->getPost('status', 'string');
                if (!$deliveryman->create()) {
                    $deliveryman->showErrorMessages($this);
                } else {
                    $deliveryman->showSuccessMessages($this, 'پیک جدید با موفقیت اضافه گردید');

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
        $deliverymans = Deliveryman::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $deliverymans,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'کارمند', 'کد انبار', 'وضعیت پیک'
                ))->
                setFields(array(
                    'id', 'workerid', 'warehouseid', 'status'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'deliveryman/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = Deliveryman::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'deliveryman',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Deliveryman::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('خطا در هنگام حذف پیک');
            } else {
                $this->flash->success('پیک با موفقیت حذف گردید');
                return $this->dispatcher->forward(array(
                            'controller' => 'deliveryman',
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


        $deliverymanItem = Deliveryman::findFirst($id);

        // create form
        $fr = new DeliverymanForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $deliveryman = Deliveryman::findFirst($id);
                $deliveryman->workerid = $this->request->getPost('workerid', 'string');

                $deliveryman->warehouseid = $this->request->getPost('warehouseid', 'string');

                $deliveryman->status = $this->request->getPost('status', 'string');
                if (!$deliveryman->save()) {
                    $deliveryman->showErrorMessages($this);
                } else {
                    $deliveryman->showSuccessMessages($this, 'Deliveryman Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('workerid')->setDefault($deliverymanItem->workerid);
            $fr->get('warehouseid')->setDefault($deliverymanItem->warehouseid);
            $fr->get('status')->setDefault($deliverymanItem->status);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Deliveryman::findFirst($id);
        $this->view->item = $item;

        $form = new DeliverymanForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('workerid')->setDefault($item->workerid);
        $form->get('warehouseid')->setDefault($item->warehouseid);
        $form->get('status')->setDefault($item->status);
        $this->view->form = $form;
    }

}
