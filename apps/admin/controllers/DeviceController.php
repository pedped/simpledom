<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use Device;
use DeviceForm;
use Simpledom\Admin\BaseControllers\ControllerBase;
use Simpledom\Core\Classes\FileManager;

class DeviceController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Device');
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



        $fr = new DeviceForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {

            $canContine = false;
            $image = null;
            if (!$this->request->hasFiles()) {
                $this->flash->error("شما باید تصویر دستگاه را انتخاب نمایید");
            } else {
                // valid request, load the files
                foreach ($this->request->getUploadedFiles() as $file) {
                    $image = FileManager::HandleImageUpload($this->errors, $file, $outputname, $realtiveloaction);
                    if ($image) {
                        $canContine = true;
                    }
                }
            }

            $device = new \Device();
            $device->categoryid = $this->request->getPost('categoryid', 'string');
            $device->name = $this->request->getPost('name', 'string');
            $device->dimensions = $this->request->getPost('dimensions', 'string');
            $device->weight = $this->request->getPost('weight', 'string');
            $device->simcount = $this->request->getPost('simcount', 'string');
            $device->display = $this->request->getPost('display', 'string');
            $device->resolution = $this->request->getPost('resolution', 'string');
            $device->sdsupport = $this->request->getPost('sdsupport', 'string');
            $device->os = $this->request->getPost('os', 'string');
            $device->cpu = $this->request->getPost('cpu', 'string');
            $device->gpu = $this->request->getPost('gpu', 'string');
            $device->internal_memory = $this->request->getPost('internal_memory', 'string');
            $device->camera = $this->request->getPost('camera', 'string');
            $device->moreinfo = $this->request->getPost('moreinfo', 'string');


            if ($canContine && $fr->isValid($_POST)) {
                // form is valid
                $device->imageid = $image->id;
                if (!$device->create()) {
                    $device->showErrorMessages($this);
                } else {
                    $device->showSuccessMessages($this, 'دستگاه جدید با موفقیت اضافه گردید');

                    // clear the title and message so the user can add better info
                    $fr->clear();
                }
            } else {

                // set default values
                $fr->get('company')->setDefault($device->company);
                $fr->get('categoryid')->setDefault($device->categoryid);
                $fr->get('name')->setDefault($device->name);
                $fr->get('dimensions')->setDefault($device->dimensions);
                $fr->get('weight')->setDefault($device->weight);
                $fr->get('simcount')->setDefault($device->simcount);
                $fr->get('display')->setDefault($device->display);
                $fr->get('resolution')->setDefault($device->resolution);
                $fr->get('sdsupport')->setDefault($device->sdsupport);
                $fr->get('os')->setDefault($device->os);
                $fr->get('cpu')->setDefault($device->cpu);
                $fr->get('gpu')->setDefault($device->gpu);
                $fr->get('internal_memory')->setDefault($device->internal_memory);
                $fr->get('camera')->setDefault($device->camera);
                $fr->get('moreinfo')->setDefault($device->moreinfo);


                // invalid
                $fr->flashErrors($this);
            }
        }
        $this->view->form = $fr;
    }

    public function listAction($page = 1) {

        // load the users
        $devices = Device::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $devices,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'image', 'Category', 'Name', 'Dimensions', 'Weight', 'Simcount', 'Display', 'Resolution', 'SD Cart Support', 'OS', 'CPU', 'GPU', 'Internal_memory', 'Camera'
                ))->
                setFields(array(
                    'id', 'getImageElement()', 'getCompanyName()', 'name', 'dimensions', 'weight', 'simcount', 'display', 'resolution', 'sdsupport', 'os', 'cpu', 'gpu', 'internal_memory', 'camera'
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
        $item = Device::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'device',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Device::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Device item');
            } else {
                $this->flash->success('Device item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'device',
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
        $this->setTitle('Edit Device');

        $deviceItem = Device::findFirst($id);

        // create form
        $fr = new DeviceForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $device = Device::findFirst($id);
                $device->company = $this->request->getPost('company', 'string');

                $device->categoryid = $this->request->getPost('categoryid', 'string');

                $device->name = $this->request->getPost('name', 'string');

                $device->dimensions = $this->request->getPost('dimensions', 'string');

                $device->weight = $this->request->getPost('weight', 'string');

                $device->simcount = $this->request->getPost('simcount', 'string');

                $device->display = $this->request->getPost('display', 'string');

                $device->resolution = $this->request->getPost('resolution', 'string');

                $device->sdsupport = $this->request->getPost('sdsupport', 'string');

                $device->os = $this->request->getPost('os', 'string');

                $device->cpu = $this->request->getPost('cpu', 'string');

                $device->gpu = $this->request->getPost('gpu', 'string');

                $device->internal_memory = $this->request->getPost('internal_memory', 'string');

                $device->camera = $this->request->getPost('camera', 'string');

                $device->moreinfo = $this->request->getPost('moreinfo', 'string');
                if (!$device->save()) {
                    $device->showErrorMessages($this);
                } else {
                    $device->showSuccessMessages($this, 'Device Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('company')->setDefault($deviceItem->company);
            $fr->get('categoryid')->setDefault($deviceItem->categoryid);
            $fr->get('name')->setDefault($deviceItem->name);
            $fr->get('dimensions')->setDefault($deviceItem->dimensions);
            $fr->get('weight')->setDefault($deviceItem->weight);
            $fr->get('simcount')->setDefault($deviceItem->simcount);
            $fr->get('display')->setDefault($deviceItem->display);
            $fr->get('resolution')->setDefault($deviceItem->resolution);
            $fr->get('sdsupport')->setDefault($deviceItem->sdsupport);
            $fr->get('os')->setDefault($deviceItem->os);
            $fr->get('cpu')->setDefault($deviceItem->cpu);
            $fr->get('gpu')->setDefault($deviceItem->gpu);
            $fr->get('internal_memory')->setDefault($deviceItem->internal_memory);
            $fr->get('camera')->setDefault($deviceItem->camera);
            $fr->get('moreinfo')->setDefault($deviceItem->moreinfo);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Device::findFirst($id);
        $this->view->item = $item;

        $form = new DeviceForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('company')->setDefault($item->company);
        $form->get('categoryid')->setDefault($item->categoryid);
        $form->get('name')->setDefault($item->name);
        $form->get('dimensions')->setDefault($item->dimensions);
        $form->get('weight')->setDefault($item->weight);
        $form->get('simcount')->setDefault($item->simcount);
        $form->get('display')->setDefault($item->display);
        $form->get('resolution')->setDefault($item->resolution);
        $form->get('sdsupport')->setDefault($item->sdsupport);
        $form->get('os')->setDefault($item->os);
        $form->get('cpu')->setDefault($item->cpu);
        $form->get('gpu')->setDefault($item->gpu);
        $form->get('internal_memory')->setDefault($item->internal_memory);
        $form->get('camera')->setDefault($item->camera);
        $form->get('moreinfo')->setDefault($item->moreinfo);
        $this->view->form = $form;
    }

}
