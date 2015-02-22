<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use Seller;
use SellerForm;
use Simpledom\Admin\BaseControllers\ControllerBase;

class SellerController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Seller');
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

        $fr = new SellerForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $seller = new \Seller();
 
                $seller->userid = $this->request->getPost('userid', 'string');
                $seller->parent_seller = $this->request->getPost('parent_seller', 'string');
                $seller->type = $this->request->getPost('type', 'string');
                $seller->title = $this->request->getPost('title', 'string');
                $seller->description = $this->request->getPost('description', 'string');
                $seller->cityid = $this->request->getPost('cityid', 'string');
                $seller->latitude = $this->request->getPost('latitude', 'string');
                $seller->longitude = $this->request->getPost('longitude', 'string');
                $seller->address = $this->request->getPost('address', 'string');
                $seller->phone = $this->request->getPost('phone', 'string');
                $seller->postal_code = $this->request->getPost('postal_code', 'string');
                $seller->business_code = $this->request->getPost('business_code', 'string');
                $seller->fax = $this->request->getPost('fax', 'string');
                $seller->imageid = $this->request->getPost('imageid', 'string');
                $seller->location_can_send = $this->request->getPost('location_can_send', 'string');
                $seller->status = $this->request->getPost('status', 'string');
                $seller->date = $this->request->getPost('date', 'string');
                if (!$seller->create()) {
                    $seller->showErrorMessages($this);
                } else {
                    $seller->showSuccessMessages($this, 'New Seller added Successfully');

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
        $sellers = Seller::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $sellers,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'User ID', 'Parent Seller', 'Type', 'Title', 'Description', 'City ID', 'Latitude', 'Longitude', 'Address', 'Phone', 'Postal Code', 'Business Code', 'Fax', 'Image ID', 'Location Can Send', 'Status', 'Date'
                ))->
                setFields(array(
                    'id', 'userid', 'parent_seller', 'type', 'title', 'description', 'cityid', 'latitude', 'longitude', 'address', 'phone', 'postal_code', 'business_code', 'fax', 'imageid', 'location_can_send', 'status', 'getDate()'
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
        $item = Seller::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'seller',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Seller::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Seller item');
            } else {
                $this->flash->success('Seller item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'seller',
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
        $this->setTitle('Edit Seller');

        $sellerItem = Seller::findFirst($id);

        // create form
        $fr = new SellerForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $seller = Seller::findFirst($id);
                $seller->userid = $this->request->getPost('userid', 'string');

                $seller->parent_seller = $this->request->getPost('parent_seller', 'string');

                $seller->type = $this->request->getPost('type', 'string');

                $seller->title = $this->request->getPost('title', 'string');

                $seller->description = $this->request->getPost('description', 'string');

                $seller->cityid = $this->request->getPost('cityid', 'string');

                $seller->latitude = $this->request->getPost('latitude', 'string');

                $seller->longitude = $this->request->getPost('longitude', 'string');

                $seller->address = $this->request->getPost('address', 'string');

                $seller->phone = $this->request->getPost('phone', 'string');

                $seller->postal_code = $this->request->getPost('postal_code', 'string');

                $seller->business_code = $this->request->getPost('business_code', 'string');

                $seller->fax = $this->request->getPost('fax', 'string');

                $seller->imageid = $this->request->getPost('imageid', 'string');

                $seller->location_can_send = $this->request->getPost('location_can_send', 'string');

                $seller->status = $this->request->getPost('status', 'string');

                $seller->date = $this->request->getPost('date', 'string');
                if (!$seller->save()) {
                    $seller->showErrorMessages($this);
                } else {
                    $seller->showSuccessMessages($this, 'Seller Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('userid')->setDefault($sellerItem->userid);
            $fr->get('parent_seller')->setDefault($sellerItem->parent_seller);
            $fr->get('type')->setDefault($sellerItem->type);
            $fr->get('title')->setDefault($sellerItem->title);
            $fr->get('description')->setDefault($sellerItem->description);
            $fr->get('cityid')->setDefault($sellerItem->cityid);
            $fr->get('latitude')->setDefault($sellerItem->latitude);
            $fr->get('longitude')->setDefault($sellerItem->longitude);
            $fr->get('address')->setDefault($sellerItem->address);
            $fr->get('phone')->setDefault($sellerItem->phone);
            $fr->get('postal_code')->setDefault($sellerItem->postal_code);
            $fr->get('business_code')->setDefault($sellerItem->business_code);
            $fr->get('fax')->setDefault($sellerItem->fax);
            $fr->get('imageid')->setDefault($sellerItem->imageid);
            $fr->get('location_can_send')->setDefault($sellerItem->location_can_send);
            $fr->get('status')->setDefault($sellerItem->status);
            $fr->get('date')->setDefault($sellerItem->date);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Seller::findFirst($id);
        $this->view->item = $item;

        $form = new SellerForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userid')->setDefault($item->userid);
        $form->get('parent_seller')->setDefault($item->parent_seller);
        $form->get('type')->setDefault($item->type);
        $form->get('title')->setDefault($item->title);
        $form->get('description')->setDefault($item->description);
        $form->get('cityid')->setDefault($item->cityid);
        $form->get('latitude')->setDefault($item->latitude);
        $form->get('longitude')->setDefault($item->longitude);
        $form->get('address')->setDefault($item->address);
        $form->get('phone')->setDefault($item->phone);
        $form->get('postal_code')->setDefault($item->postal_code);
        $form->get('business_code')->setDefault($item->business_code);
        $form->get('fax')->setDefault($item->fax);
        $form->get('imageid')->setDefault($item->imageid);
        $form->get('location_can_send')->setDefault($item->location_can_send);
        $form->get('status')->setDefault($item->status);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
