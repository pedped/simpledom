<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ControllerBase;
use AtaPaginator;
use ProductSpecification;
use ProductSpecificationForm;

class ProductspecificationController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('مشخصه های محصولات');
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

        $fr = new ProductSpecificationForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                
                 // find product id for each item
                 $pids = explode(",", $this->request->getPost('productid', 'string'));
                $prlist = array();
                foreach ($pids as $item) {
                    $k = \Product::findFirst(array("title = :title:", "bind" => array("title" => $item)));
                    if ($k != FALSE) {
                        $prlist[] = $k->id;
                    }
                }

          
                foreach ($prlist as $value) {
                    $productspecification = new \ProductSpecification();
                    $productspecification->productid = $value;
                    $productspecification->title = $this->request->getPost('title', 'string');
                    $productspecification->value = $this->request->getPost('value', 'string');
                    $productspecification->orderid = $this->request->getPost('orderid', 'string');
                    $productspecification->create();
                }
                $productspecification->showSuccessMessages($this, 'مشخصه های جدید با موفقیت اضافه گردید');
                // clear the title and message so the user can add better info
                $fr->clear();
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }
        $this->view->form = $fr;
    }

    public function listAction($page = 1) {

        // load the users
        $productspecifications = ProductSpecification::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $productspecifications,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Product ID', 'Title', 'Value', 'Order ID'
                ))->
                setFields(array(
                    'id', 'productid', 'title', 'value', 'orderid'
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
        $item = ProductSpecification::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'productspecification',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = ProductSpecification::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this ProductSpecification item');
            } else {
                $this->flash->success('ProductSpecification item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'productspecification',
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
        $this->setTitle('Edit ProductSpecification');

        $productspecificationItem = ProductSpecification::findFirst($id);

        // create form
        $fr = new ProductSpecificationForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $productspecification = ProductSpecification::findFirst($id);
                $productspecification->productid = $this->request->getPost('productid', 'string');

                $productspecification->title = $this->request->getPost('title', 'string');

                $productspecification->value = $this->request->getPost('value', 'string');

                $productspecification->orderid = $this->request->getPost('orderid', 'string');
                if (!$productspecification->save()) {
                    $productspecification->showErrorMessages($this);
                } else {
                    $productspecification->showSuccessMessages($this, 'ProductSpecification Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('productid')->setDefault($productspecificationItem->productid);
            $fr->get('title')->setDefault($productspecificationItem->title);
            $fr->get('value')->setDefault($productspecificationItem->value);
            $fr->get('orderid')->setDefault($productspecificationItem->orderid);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = ProductSpecification::findFirst($id);
        $this->view->item = $item;

        $form = new ProductSpecificationForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('productid')->setDefault($item->productid);
        $form->get('title')->setDefault($item->title);
        $form->get('value')->setDefault($item->value);
        $form->get('orderid')->setDefault($item->orderid);
        $this->view->form = $form;
    }

}
