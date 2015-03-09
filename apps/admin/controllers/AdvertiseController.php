<?php

namespace Simpledom\Admin\Controllers;

use Advertise;
use AdvertiseForm;
use AtaPaginator;
use Simpledom\Admin\BaseControllers\ControllerBase;

class AdvertiseController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('آگهی ها');
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

        $fr = new AdvertiseForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $advertise = new \Advertise();

                $advertise->userid = $this->request->getPost('userid', 'string');
                $advertise->deviceid = $this->request->getPost('deviceid', 'string');
                $advertise->currentview = $this->request->getPost('currentview', 'string');
                $advertise->repaired = $this->request->getPost('repaired', 'string');
                $advertise->haveholder = $this->request->getPost('haveholder', 'string');
                $advertise->price = $this->request->getPost('price', 'string');
                $advertise->garantee = $this->request->getPost('garantee', 'string');
                $advertise->moreacc = $this->request->getPost('moreacc', 'string');
                $advertise->visittime = $this->request->getPost('visittime', 'string');
                $advertise->imageid = $this->request->getPost('imageid', 'string');
                if (!$advertise->create()) {
                    $advertise->showErrorMessages($this);
                } else {
                    $advertise->showSuccessMessages($this, 'آگهی جدید با موفقیت اضافه گردید');

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
        $advertises = Advertise::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $advertises,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'شناسه', 'تصویر', 'وضعیت', 'کد کاربر', 'آی پی', 'تاریخ', 'دسته', 'نام دستگاه', 'شهر', 'وضعیت ظاهری', 'تعمیر شدگی', 'قیمت', 'توضیحات'
                ))->
                setFields(array(
                    'id', 'getImageLinkTag()', 'getStatusName()', 'userid', 'ip', 'getDate()', 'getCategoryName()', 'getDeviceName()', 'getCityName()', 'getCurrentView()', 'getRepaired()', 'getHumanPrice()', 'description'
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
        $item = Advertise::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'advertise',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Advertise::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Advertise item');
            } else {
                $this->flash->success('Advertise item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'advertise',
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
        $this->setTitle('Edit Advertise');

        $advertiseItem = Advertise::findFirst($id);

        $this->view->advertise = $advertiseItem->getPublicResponse();

        // create form
        $fr = new AdvertiseForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $advertise = Advertise::findFirst($id);

                $advertise->currentview = $this->request->getPost('currentview', 'string');

                $advertise->description = $this->request->getPost('description', 'string');

                $advertise->repaired = $this->request->getPost('repaired', 'string');

                $advertise->price = $this->request->getPost('price', 'string');

                $advertise->status = $this->request->getPost('status', 'string');

                if (!$advertise->save()) {
                    $advertise->showErrorMessages($this);
                } else {
                    $advertise->showSuccessMessages($this, 'اطلاعات تبلیغ با موفقیت ذخیره گردید');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }

        $fr->get('userid')->setDefault($advertiseItem->userid);
        $fr->get('ip')->setDefault($advertiseItem->ip);
        $fr->get('date')->setDefault($advertiseItem->date);
        $fr->get('deviceid')->setDefault($advertiseItem->deviceid);
        $fr->get('currentview')->setDefault($advertiseItem->currentview);
        $fr->get('repaired')->setDefault($advertiseItem->repaired);
        $fr->get('haveholder')->setDefault($advertiseItem->haveholder);
        $fr->get('price')->setDefault($advertiseItem->price);
        $fr->get('garantee')->setDefault($advertiseItem->garantee);
        $fr->get('moreacc')->setDefault($advertiseItem->moreacc);
        $fr->get('description')->setDefault($advertiseItem->description);
        $fr->get('status')->setDefault($advertiseItem->status);
        $fr->get('visittime')->setDefault($advertiseItem->visittime);
        $fr->get('imageid')->setDefault($advertiseItem->imageid);

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Advertise::findFirst($id);
        $this->view->item = $item;

        $form = new AdvertiseForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userid')->setDefault($item->userid);
        $form->get('ip')->setDefault($item->ip);
        $form->get('date')->setDefault($item->date);
        $form->get('deviceid')->setDefault($item->deviceid);
        $form->get('currentview')->setDefault($item->currentview);
        $form->get('repaired')->setDefault($item->repaired);
        $form->get('haveholder')->setDefault($item->haveholder);
        $form->get('price')->setDefault($item->price);
        $form->get('garantee')->setDefault($item->garantee);
        $form->get('moreacc')->setDefault($item->moreacc);
        $form->get('visittime')->setDefault($item->visittime);
        $form->get('imageid')->setDefault($item->imageid);
        $this->view->form = $form;

    }

}
