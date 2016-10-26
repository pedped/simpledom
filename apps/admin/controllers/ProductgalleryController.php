<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ControllerBase;
use AtaPaginator;
use ProductGallery;
use ProductGalleryForm;

class ProductGalleryController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('ProductGallery');
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

        $fr = new ProductGalleryForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $productgallery = new \ProductGallery();

                $productgallery->product_id = $this->request->getPost('product_id', 'string');
                $productgallery->imageid = $this->request->getPost('imageid', 'string');
                if (!$productgallery->create()) {
                    $productgallery->showErrorMessages($this);
                } else {
                    $productgallery->showSuccessMessages($this, 'New ProductGallery added Successfully');

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
        $productgallerys = ProductGallery::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $productgallerys,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Product ID', 'Image ID'
                ))->
                setFields(array(
                    'id', 'product_id', 'imageid'
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
        $item = ProductGallery::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'productgallery',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = ProductGallery::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this ProductGallery item');
            } else {
                $this->flash->success('ProductGallery item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'productgallery',
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
        $this->setTitle('Edit ProductGallery');

        $productgalleryItem = ProductGallery::findFirst($id);

        // create form
        $fr = new ProductGalleryForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $productgallery = ProductGallery::findFirst($id);
                $productgallery->product_id = $this->request->getPost('product_id', 'string');

                $productgallery->imageid = $this->request->getPost('imageid', 'string');
                if (!$productgallery->save()) {
                    $productgallery->showErrorMessages($this);
                } else {
                    $productgallery->showSuccessMessages($this, 'ProductGallery Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('product_id')->setDefault($productgalleryItem->product_id);
            $fr->get('imageid')->setDefault($productgalleryItem->imageid);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = ProductGallery::findFirst($id);
        $this->view->item = $item;

        $form = new ProductGalleryForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('product_id')->setDefault($item->product_id);
        $form->get('imageid')->setDefault($item->imageid);
        $this->view->form = $form;
    }

}
