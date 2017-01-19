<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ControllerBase;
use AtaPaginator;
use DeliveryModeOption;
use DeliveryModeOptionForm;

class DeliveryModeOptionController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle("گزینه های حالت ارسال");
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

        $fr = new DeliveryModeOptionForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $deliverymodeoption = new \DeliveryModeOption();

                $deliverymodeoption->title = $this->request->getPost('title', 'string');
                $deliverymodeoption->delivery_mode_id = $this->request->getPost('delivery_mode_id', 'string');
                $deliverymodeoption->description = $this->request->getPost('description', 'string');
                $deliverymodeoption->status = $this->request->getPost('status', 'string');
                $deliverymodeoption->time_start = $this->request->getPost('time_start', 'string');
                $deliverymodeoption->time_end = $this->request->getPost('time_end', 'string');
                if (!$deliverymodeoption->create()) {
                    $deliverymodeoption->showErrorMessages($this);
                } else {
                    $deliverymodeoption->showSuccessMessages($this, 'گزینه جدید با موفقیت اضافه گردید');

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
        $deliverymodeoptions = DeliveryModeOption::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $deliverymodeoptions,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'تیتر', 'نحوه ارسال مربوطه', 'توضیحات', 'وضعیت', 'ساعت شروع', 'ساعت پایان', 'تاریخ'
                ))->
                setFields(array(
                    'id', 'title', 'delivery_mode_id', 'description', 'status', 'time_start', 'time_end', 'getDate()'
                ))->
                setEditUrl(
                        'deliverymodeoption/edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'deliverymodeoption/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = DeliveryModeOption::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'deliverymodeoption',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = DeliveryModeOption::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this DeliveryModeOption item');
            } else {
                $this->flash->success('DeliveryModeOption item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'deliverymodeoption',
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

        $deliverymodeoptionItem = DeliveryModeOption::findFirst($id);

        // create form
        $fr = new DeliveryModeOptionForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $deliverymodeoption = DeliveryModeOption::findFirst($id);
                $deliverymodeoption->title = $this->request->getPost('title', 'string');

                $deliverymodeoption->delivery_mode_id = $this->request->getPost('delivery_mode_id', 'string');

                $deliverymodeoption->description = $this->request->getPost('description', 'string');

                $deliverymodeoption->status = $this->request->getPost('status', 'string');

                $deliverymodeoption->time_start = $this->request->getPost('time_start', 'string');

                $deliverymodeoption->time_end = $this->request->getPost('time_end', 'string');

                if (!$deliverymodeoption->save()) {
                    $deliverymodeoption->showErrorMessages($this);
                } else {
                    $deliverymodeoption->showSuccessMessages($this, 'تغییر کرد');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values
            $fr->get('title')->setDefault($deliverymodeoptionItem->title);
            $fr->get('delivery_mode_id')->setDefault($deliverymodeoptionItem->delivery_mode_id);
            $fr->get('description')->setDefault($deliverymodeoptionItem->description);
            $fr->get('status')->setDefault($deliverymodeoptionItem->status);
            $fr->get('time_start')->setDefault($deliverymodeoptionItem->time_start);
            $fr->get('time_end')->setDefault($deliverymodeoptionItem->time_end);

        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = DeliveryModeOption::findFirst($id);
        $this->view->item = $item;

        $form = new DeliveryModeOptionForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('title')->setDefault($item->title);
        $form->get('delivery_mode_id')->setDefault($item->delivery_mode_id);
        $form->get('description')->setDefault($item->description);
        $form->get('status')->setDefault($item->status);
        $form->get('time_start')->setDefault($item->time_start);
        $form->get('time_end')->setDefault($item->time_end);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
