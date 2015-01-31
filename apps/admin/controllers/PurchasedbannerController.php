<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use PurchasedBanner;
use PurchasedBannerForm;
use Simpledom\Admin\BaseControllers\ControllerBase;

class PurchasedBannerController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('PurchasedBanner');
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

        $fr = new PurchasedBannerForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $purchasedbanner = new \PurchasedBanner();

                $purchasedbanner->userid = $this->request->getPost('userid', 'string');
                $purchasedbanner->validuntil = $this->request->getPost('validuntil', 'string');
                $purchasedbanner->orderid = $this->request->getPost('orderid', 'string');
                $purchasedbanner->advertid = $this->request->getPost('advertid', 'string');
                $purchasedbanner->cityid = $this->request->getPost('cityid', 'string');
                $purchasedbanner->date = $this->request->getPost('date', 'string');
                $purchasedbanner->imageid = $this->request->getPost('imageid', 'string');
                $purchasedbanner->banner_type = $this->request->getPost('banner_type', 'string');
                if (!$purchasedbanner->create()) {
                    $purchasedbanner->showErrorMessages($this);
                } else {
                    $purchasedbanner->showSuccessMessages($this, 'New PurchasedBanner added Successfully');

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
        $purchasedbanners = PurchasedBanner::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $purchasedbanners,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'User ID', 'Valid Until', 'Order ID', 'Advert ID', 'City ID', 'Date', 'Image ID', 'Banner Type'
                ))->
                setFields(array(
                    'id', 'userid', 'validuntil', 'orderid', 'advertid', 'cityid', 'getDate()', 'imageid', 'banner_type'
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
        $item = PurchasedBanner::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'purchasedbanner',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = PurchasedBanner::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this PurchasedBanner item');
            } else {
                $this->flash->success('PurchasedBanner item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'purchasedbanner',
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
        $this->setTitle('Edit PurchasedBanner');

        $purchasedbannerItem = PurchasedBanner::findFirst($id);

        // create form
        $fr = new PurchasedBannerForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $purchasedbanner = PurchasedBanner::findFirst($id);
                $purchasedbanner->userid = $this->request->getPost('userid', 'string');

                $purchasedbanner->validuntil = $this->request->getPost('validuntil', 'string');

                $purchasedbanner->orderid = $this->request->getPost('orderid', 'string');

                $purchasedbanner->advertid = $this->request->getPost('advertid', 'string');

                $purchasedbanner->cityid = $this->request->getPost('cityid', 'string');

                $purchasedbanner->date = $this->request->getPost('date', 'string');

                $purchasedbanner->imageid = $this->request->getPost('imageid', 'string');

                $purchasedbanner->banner_type = $this->request->getPost('banner_type', 'string');
                if (!$purchasedbanner->save()) {
                    $purchasedbanner->showErrorMessages($this);
                } else {
                    $purchasedbanner->showSuccessMessages($this, 'PurchasedBanner Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('userid')->setDefault($purchasedbannerItem->userid);
            $fr->get('validuntil')->setDefault($purchasedbannerItem->validuntil);
            $fr->get('orderid')->setDefault($purchasedbannerItem->orderid);
            $fr->get('advertid')->setDefault($purchasedbannerItem->advertid);
            $fr->get('cityid')->setDefault($purchasedbannerItem->cityid);
            $fr->get('date')->setDefault($purchasedbannerItem->date);
            $fr->get('imageid')->setDefault($purchasedbannerItem->imageid);
            $fr->get('banner_type')->setDefault($purchasedbannerItem->banner_type);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = PurchasedBanner::findFirst($id);
        $this->view->item = $item;

        $form = new PurchasedBannerForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userid')->setDefault($item->userid);
        $form->get('validuntil')->setDefault($item->validuntil);
        $form->get('orderid')->setDefault($item->orderid);
        $form->get('advertid')->setDefault($item->advertid);
        $form->get('cityid')->setDefault($item->cityid);
        $form->get('date')->setDefault($item->date);
        $form->get('imageid')->setDefault($item->imageid);
        $form->get('banner_type')->setDefault($item->banner_type);
        $this->view->form = $form;
    }

}
