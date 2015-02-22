<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use Product;
use ProductForm;
use Simpledom\Admin\BaseControllers\ControllerBase;

class ProductController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Product');
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

        $fr = new ProductForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $product = new \Product();

                $product->userid = $this->request->getPost('userid', 'string');
                $product->categoryid = $this->request->getPost('categoryid', 'string');
                $product->title = $this->request->getPost('title', 'string');
                $product->description = $this->request->getPost('description', 'string');
                $product->country_who_made = $this->request->getPost('country_who_made', 'string');
                $product->send_point = $this->request->getPost('send_point', 'string');
                $product->price = $this->request->getPost('price', 'string');
                $product->sale_price = $this->request->getPost('sale_price', 'string');
                $product->currency = $this->request->getPost('currency', 'string');
                $product->min_request_count = $this->request->getPost('min_request_count', 'string');
                $product->barcodenumber = $this->request->getPost('barcodenumber', 'string');
                $product->color = $this->request->getPost('color', 'string');
                $product->uuid = $this->request->getPost('uuid', 'string');
                $product->offlineadd = $this->request->getPost('offlineadd', 'string');
                $product->token = $this->request->getPost('token', 'string');
                $product->featured = $this->request->getPost('featured', 'string');
                $product->date = $this->request->getPost('date', 'string');
                $product->order_request_instruction = $this->request->getPost('order_request_instruction', 'string');
                if (!$product->create()) {
                    $product->showErrorMessages($this);
                } else {
                    $product->showSuccessMessages($this, 'New Product added Successfully');

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
        $products = Product::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $products,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'User ID', 'Category ID', 'Title', 'Description', 'Made By', 'Send Point', 'Price', 'Sale Price', 'Price Currency', 'Minimum Request Count', 'Barcode Number', 'Color', 'UUID', 'Offline Add', 'Token', 'Featured', 'Date', 'Order Request Instruction'
                ))->
                setFields(array(
                    'id', 'userid', 'categoryid', 'title', 'description', 'country_who_made', 'send_point', 'price', 'sale_price', 'currency', 'min_request_count', 'barcodenumber', 'color', 'uuid', 'offlineadd', 'token', 'featured', 'getDate()', 'order_request_instruction'
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
        $item = Product::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'product',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Product::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Product item');
            } else {
                $this->flash->success('Product item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'product',
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
        $this->setTitle('Edit Product');

        $productItem = Product::findFirst($id);

        // create form
        $fr = new ProductForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $product = Product::findFirst($id);
                $product->userid = $this->request->getPost('userid', 'string');

                $product->categoryid = $this->request->getPost('categoryid', 'string');

                $product->title = $this->request->getPost('title', 'string');

                $product->description = $this->request->getPost('description', 'string');

                $product->country_who_made = $this->request->getPost('country_who_made', 'string');

                $product->send_point = $this->request->getPost('send_point', 'string');

                $product->price = $this->request->getPost('price', 'string');

                $product->sale_price = $this->request->getPost('sale_price', 'string');

                $product->currency = $this->request->getPost('currency', 'string');

                $product->min_request_count = $this->request->getPost('min_request_count', 'string');

                $product->barcodenumber = $this->request->getPost('barcodenumber', 'string');

                $product->color = $this->request->getPost('color', 'string');

                $product->uuid = $this->request->getPost('uuid', 'string');

                $product->offlineadd = $this->request->getPost('offlineadd', 'string');

                $product->token = $this->request->getPost('token', 'string');

                $product->featured = $this->request->getPost('featured', 'string');

                $product->date = $this->request->getPost('date', 'string');

                $product->order_request_instruction = $this->request->getPost('order_request_instruction', 'string');
                if (!$product->save()) {
                    $product->showErrorMessages($this);
                } else {
                    $product->showSuccessMessages($this, 'Product Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('userid')->setDefault($productItem->userid);
            $fr->get('categoryid')->setDefault($productItem->categoryid);
            $fr->get('title')->setDefault($productItem->title);
            $fr->get('description')->setDefault($productItem->description);
            $fr->get('country_who_made')->setDefault($productItem->country_who_made);
            $fr->get('send_point')->setDefault($productItem->send_point);
            $fr->get('price')->setDefault($productItem->price);
            $fr->get('sale_price')->setDefault($productItem->sale_price);
            $fr->get('currency')->setDefault($productItem->currency);
            $fr->get('min_request_count')->setDefault($productItem->min_request_count);
            $fr->get('barcodenumber')->setDefault($productItem->barcodenumber);
            $fr->get('color')->setDefault($productItem->color);
            $fr->get('uuid')->setDefault($productItem->uuid);
            $fr->get('offlineadd')->setDefault($productItem->offlineadd);
            $fr->get('token')->setDefault($productItem->token);
            $fr->get('featured')->setDefault($productItem->featured);
            $fr->get('date')->setDefault($productItem->date);
            $fr->get('order_request_instruction')->setDefault($productItem->order_request_instruction);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Product::findFirst($id);
        $this->view->item = $item;

        $form = new ProductForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userid')->setDefault($item->userid);
        $form->get('categoryid')->setDefault($item->categoryid);
        $form->get('title')->setDefault($item->title);
        $form->get('description')->setDefault($item->description);
        $form->get('country_who_made')->setDefault($item->country_who_made);
        $form->get('send_point')->setDefault($item->send_point);
        $form->get('price')->setDefault($item->price);
        $form->get('sale_price')->setDefault($item->sale_price);
        $form->get('currency')->setDefault($item->currency);
        $form->get('min_request_count')->setDefault($item->min_request_count);
        $form->get('barcodenumber')->setDefault($item->barcodenumber);
        $form->get('color')->setDefault($item->color);
        $form->get('uuid')->setDefault($item->uuid);
        $form->get('offlineadd')->setDefault($item->offlineadd);
        $form->get('token')->setDefault($item->token);
        $form->get('featured')->setDefault($item->featured);
        $form->get('date')->setDefault($item->date);
        $form->get('order_request_instruction')->setDefault($item->order_request_instruction);
        $this->view->form = $form;
    }

}
