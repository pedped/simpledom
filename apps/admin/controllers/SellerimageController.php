<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use SellerImage;
use SellerImageForm;
use Simpledom\Admin\BaseControllers\ControllerBase;

class SellerImageController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('SellerImage');
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

        $fr = new SellerImageForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $sellerimage = new \SellerImage();

                $sellerimage->seller_id = $this->request->getPost('seller_id', 'string');
                $sellerimage->imageid = $this->request->getPost('imageid', 'string');
                $sellerimage->date = $this->request->getPost('date', 'string');
                $sellerimage->status = $this->request->getPost('status', 'string');
                if (!$sellerimage->create()) {
                    $sellerimage->showErrorMessages($this);
                } else {
                    $sellerimage->showSuccessMessages($this, 'New SellerImage added Successfully');

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
        $sellerimages = SellerImage::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $sellerimages,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Seller ID', 'Image ID', 'Date', 'Status'
                ))->
                setFields(array(
                    'id', 'seller_id', 'imageid', 'getDate()', 'status'
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
        $item = SellerImage::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'sellerimage',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = SellerImage::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this SellerImage item');
            } else {
                $this->flash->success('SellerImage item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'sellerimage',
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
        $this->setTitle('Edit SellerImage');

        $sellerimageItem = SellerImage::findFirst($id);

        // create form
        $fr = new SellerImageForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $sellerimage = SellerImage::findFirst($id);
                $sellerimage->seller_id = $this->request->getPost('seller_id', 'string');

                $sellerimage->imageid = $this->request->getPost('imageid', 'string');

                $sellerimage->date = $this->request->getPost('date', 'string');

                $sellerimage->status = $this->request->getPost('status', 'string');
                if (!$sellerimage->save()) {
                    $sellerimage->showErrorMessages($this);
                } else {
                    $sellerimage->showSuccessMessages($this, 'SellerImage Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('seller_id')->setDefault($sellerimageItem->seller_id);
            $fr->get('imageid')->setDefault($sellerimageItem->imageid);
            $fr->get('date')->setDefault($sellerimageItem->date);
            $fr->get('status')->setDefault($sellerimageItem->status);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = SellerImage::findFirst($id);
        $this->view->item = $item;

        $form = new SellerImageForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('seller_id')->setDefault($item->seller_id);
        $form->get('imageid')->setDefault($item->imageid);
        $form->get('date')->setDefault($item->date);
        $form->get('status')->setDefault($item->status);
        $this->view->form = $form;
    }

}
