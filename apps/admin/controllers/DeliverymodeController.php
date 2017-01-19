<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ControllerBase;
use AtaPaginator;
use DeliveryMode;
use DeliveryModeForm;

class DeliveryModeController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('نحوه ارسال');
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

        $fr = new DeliveryModeForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $deliverymode = new \DeliveryMode();

                $deliverymode->title = $this->request->getPost('title', 'string');
                $deliverymode->description = $this->request->getPost('description', 'string');
                $deliverymode->full_introduction = $this->request->getPost('full_introduction', 'string');
                $deliverymode->min_price = $this->request->getPost('min_price', 'string');
                $deliverymode->max_price = $this->request->getPost('max_price', 'string');
                $deliverymode->min_count = $this->request->getPost('min_count', 'string');
                $deliverymode->max_count = $this->request->getPost('max_count', 'string');
                $deliverymode->lastupdate = $this->request->getPost('lastupdate', 'string');
                $deliverymode->status = $this->request->getPost('status', 'string');
                $deliverymode->basecost = $this->request->getPost('basecost', 'string');
                if (!$deliverymode->create()) {
                    $deliverymode->showErrorMessages($this);
                } else {
                    $deliverymode->showSuccessMessages($this, 'حالت ارسال با موفقیت ذخیره گردید');

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
        $deliverymodes = DeliveryMode::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $deliverymodes,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'تیتر', 'وضعیت', 'تاریخ افزوده شدن'
                ))->
                setFields(array(
                    'id', 'title', 'status', 'getDate()'
                ))->
                setEditUrl(
                        'deliverymode/edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'deliverymode/list');

        $this->view->list = $paginator->getPaginate();
    }



    public function editAction($id) {


        if (!$this->ValidateAccess($id)) {
            // user do not have permission to edut this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }


        $deliverymodeItem = DeliveryMode::findFirst($id);

        // create form
        $fr = new DeliveryModeForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $deliverymode = DeliveryMode::findFirst($id);
                $deliverymode->title = $this->request->getPost('title', 'string');

                $deliverymode->description = $this->request->getPost('description', 'string');

                $deliverymode->full_introduction = $this->request->getPost('full_introduction', 'string');

                $deliverymode->min_price = $this->request->getPost('min_price', 'string');

                $deliverymode->max_price = $this->request->getPost('max_price', 'string');

                $deliverymode->min_count = $this->request->getPost('min_count', 'string');

                $deliverymode->max_count = $this->request->getPost('max_count', 'string');

                $deliverymode->lastupdate = $this->request->getPost('lastupdate', 'string');

                $deliverymode->status = $this->request->getPost('status', 'string');

                $deliverymode->basecost = $this->request->getPost('basecost', 'string');

                if (!$deliverymode->save()) {
                    $deliverymode->showErrorMessages($this);
                } else {
                    $deliverymode->showSuccessMessages($this, 'DeliveryMode Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('title')->setDefault($deliverymodeItem->title);
            $fr->get('description')->setDefault($deliverymodeItem->description);
            $fr->get('full_introduction')->setDefault($deliverymodeItem->full_introduction);
            $fr->get('min_price')->setDefault($deliverymodeItem->min_price);
            $fr->get('max_price')->setDefault($deliverymodeItem->max_price);
            $fr->get('min_count')->setDefault($deliverymodeItem->min_count);
            $fr->get('max_count')->setDefault($deliverymodeItem->max_count);
            $fr->get('lastupdate')->setDefault($deliverymodeItem->lastupdate);
            $fr->get('status')->setDefault($deliverymodeItem->status);
            $fr->get('basecost')->setDefault($deliverymodeItem->basecost);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = DeliveryMode::findFirst($id);
        $this->view->item = $item;

        $form = new DeliveryModeForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('title')->setDefault($item->title);
        $form->get('description')->setDefault($item->description);
        $form->get('full_introduction')->setDefault($item->full_introduction);
        $form->get('min_price')->setDefault($item->min_price);
        $form->get('max_price')->setDefault($item->max_price);
        $form->get('min_count')->setDefault($item->min_count);
        $form->get('max_count')->setDefault($item->max_count);
        $form->get('lastupdate')->setDefault($item->lastupdate);
        $form->get('status')->setDefault($item->status);
        $form->get('basecost')->setDefault($item->basecost);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
