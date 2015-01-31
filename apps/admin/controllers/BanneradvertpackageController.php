<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use BannerAdvertPackage;
use BannerAdvertPackageForm;
use Simpledom\Admin\BaseControllers\ControllerBase;

class BannerAdvertPackageController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('BannerAdvertPackage');
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

        $fr = new BannerAdvertPackageForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $banneradvertpackage = new \BannerAdvertPackage();

                $banneradvertpackage->title = $this->request->getPost('title', 'string');
                $banneradvertpackage->description = $this->request->getPost('description', 'string');
                $banneradvertpackage->cityid = $this->request->getPost('cityid', 'string');
                $banneradvertpackage->price = $this->request->getPost('price', 'string');
                $banneradvertpackage->enable = $this->request->getPost('enable', 'string');
                $banneradvertpackage->totaldays = $this->request->getPost('totaldays', 'string');
                $banneradvertpackage->date = $this->request->getPost('date', 'string');
                if (!$banneradvertpackage->create()) {
                    $banneradvertpackage->showErrorMessages($this);
                } else {
                    $banneradvertpackage->showSuccessMessages($this, 'New BannerAdvertPackage added Successfully');

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
        $banneradvertpackages = BannerAdvertPackage::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $banneradvertpackages,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Title', 'Description', 'City ID', 'Price', 'Enable', 'Total Days', 'Date'
                ))->
                setFields(array(
                    'id', 'title', 'description', 'cityid', 'price', 'enable', 'totaldays', 'getDate()'
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
        $item = BannerAdvertPackage::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'banneradvertpackage',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = BannerAdvertPackage::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this BannerAdvertPackage item');
            } else {
                $this->flash->success('BannerAdvertPackage item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'banneradvertpackage',
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
        $this->setTitle('Edit BannerAdvertPackage');

        $banneradvertpackageItem = BannerAdvertPackage::findFirst($id);

        // create form
        $fr = new BannerAdvertPackageForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $banneradvertpackage = BannerAdvertPackage::findFirst($id);
                $banneradvertpackage->title = $this->request->getPost('title', 'string');

                $banneradvertpackage->description = $this->request->getPost('description', 'string');

                $banneradvertpackage->cityid = $this->request->getPost('cityid', 'string');

                $banneradvertpackage->price = $this->request->getPost('price', 'string');

                $banneradvertpackage->enable = $this->request->getPost('enable', 'string');

                $banneradvertpackage->totaldays = $this->request->getPost('totaldays', 'string');

                $banneradvertpackage->date = $this->request->getPost('date', 'string');
                if (!$banneradvertpackage->save()) {
                    $banneradvertpackage->showErrorMessages($this);
                } else {
                    $banneradvertpackage->showSuccessMessages($this, 'BannerAdvertPackage Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('title')->setDefault($banneradvertpackageItem->title);
            $fr->get('description')->setDefault($banneradvertpackageItem->description);
            $fr->get('cityid')->setDefault($banneradvertpackageItem->cityid);
            $fr->get('price')->setDefault($banneradvertpackageItem->price);
            $fr->get('enable')->setDefault($banneradvertpackageItem->enable);
            $fr->get('totaldays')->setDefault($banneradvertpackageItem->totaldays);
            $fr->get('date')->setDefault($banneradvertpackageItem->date);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = BannerAdvertPackage::findFirst($id);
        $this->view->item = $item;

        $form = new BannerAdvertPackageForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('title')->setDefault($item->title);
        $form->get('description')->setDefault($item->description);
        $form->get('cityid')->setDefault($item->cityid);
        $form->get('price')->setDefault($item->price);
        $form->get('enable')->setDefault($item->enable);
        $form->get('totaldays')->setDefault($item->totaldays);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
