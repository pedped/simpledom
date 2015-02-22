<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use ProductImage;
use ProductImageForm;
use Simpledom\Admin\BaseControllers\ControllerBase;

class ProductImageController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('ProductImage');
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

        $fr = new ProductImageForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $productimage = new \ProductImage();

                $productimage->product_id = $this->request->getPost('product_id', 'string');
                $productimage->imageid = $this->request->getPost('imageid', 'string');
                $productimage->date = $this->request->getPost('date', 'string');
                $productimage->status = $this->request->getPost('status', 'string');
                if (!$productimage->create()) {
                    $productimage->showErrorMessages($this);
                } else {
                    $productimage->showSuccessMessages($this, 'New ProductImage added Successfully');

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
        $productimages = ProductImage::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $productimages,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Product ID', 'Image ID', 'Date', 'Status'
                ))->
                setFields(array(
                    'id', 'product_id', 'imageid', 'getDate()', 'status'
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
        $item = ProductImage::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'productimage',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = ProductImage::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this ProductImage item');
            } else {
                $this->flash->success('ProductImage item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'productimage',
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
        $this->setTitle('Edit ProductImage');

        $productimageItem = ProductImage::findFirst($id);

        // create form
        $fr = new ProductImageForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $productimage = ProductImage::findFirst($id);
                $productimage->product_id = $this->request->getPost('product_id', 'string');

                $productimage->imageid = $this->request->getPost('imageid', 'string');

                $productimage->date = $this->request->getPost('date', 'string');

                $productimage->status = $this->request->getPost('status', 'string');
                if (!$productimage->save()) {
                    $productimage->showErrorMessages($this);
                } else {
                    $productimage->showSuccessMessages($this, 'ProductImage Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('product_id')->setDefault($productimageItem->product_id);
            $fr->get('imageid')->setDefault($productimageItem->imageid);
            $fr->get('date')->setDefault($productimageItem->date);
            $fr->get('status')->setDefault($productimageItem->status);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = ProductImage::findFirst($id);
        $this->view->item = $item;

        $form = new ProductImageForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('product_id')->setDefault($item->product_id);
        $form->get('imageid')->setDefault($item->imageid);
        $form->get('date')->setDefault($item->date);
        $form->get('status')->setDefault($item->status);
        $this->view->form = $form;
    }

}
