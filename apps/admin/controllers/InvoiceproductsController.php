<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ControllerBase;
use AtaPaginator;
use InvoiceProducts;
use InvoiceProductsForm;

class InvoiceProductsController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('InvoiceProducts');
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

        $fr = new InvoiceProductsForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $invoiceproducts = new \InvoiceProducts();

                $invoiceproducts->invoiceid = $this->request->getPost('invoiceid', 'string');
                $invoiceproducts->productid = $this->request->getPost('productid', 'string');
                $invoiceproducts->count = $this->request->getPost('count', 'string');
                $invoiceproducts->message = $this->request->getPost('message', 'string');
                if (!$invoiceproducts->create()) {
                    $invoiceproducts->showErrorMessages($this);
                } else {
                    $invoiceproducts->showSuccessMessages($this, 'New InvoiceProducts added Successfully');

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
        $invoiceproductss = InvoiceProducts::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $invoiceproductss,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Invoice ID', 'Product ID', 'Date', 'Count', 'Message'
                ))->
                setFields(array(
                    'id', 'invoiceid', 'productid', 'getDate()', 'count', 'message'
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
        $item = InvoiceProducts::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'invoiceproducts',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = InvoiceProducts::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this InvoiceProducts item');
            } else {
                $this->flash->success('InvoiceProducts item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'invoiceproducts',
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
        $this->setTitle('Edit InvoiceProducts');

        $invoiceproductsItem = InvoiceProducts::findFirst($id);

        // create form
        $fr = new InvoiceProductsForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $invoiceproducts = InvoiceProducts::findFirst($id);
                $invoiceproducts->invoiceid = $this->request->getPost('invoiceid', 'string');

                $invoiceproducts->productid = $this->request->getPost('productid', 'string');

                $invoiceproducts->date = $this->request->getPost('date', 'string');

                $invoiceproducts->count = $this->request->getPost('count', 'string');

                $invoiceproducts->message = $this->request->getPost('message', 'string');
                if (!$invoiceproducts->save()) {
                    $invoiceproducts->showErrorMessages($this);
                } else {
                    $invoiceproducts->showSuccessMessages($this, 'InvoiceProducts Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('invoiceid')->setDefault($invoiceproductsItem->invoiceid);
            $fr->get('productid')->setDefault($invoiceproductsItem->productid);
            $fr->get('date')->setDefault($invoiceproductsItem->date);
            $fr->get('count')->setDefault($invoiceproductsItem->count);
            $fr->get('message')->setDefault($invoiceproductsItem->message);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = InvoiceProducts::findFirst($id);
        $this->view->item = $item;

        $form = new InvoiceProductsForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('invoiceid')->setDefault($item->invoiceid);
        $form->get('productid')->setDefault($item->productid);
        $form->get('date')->setDefault($item->date);
        $form->get('count')->setDefault($item->count);
        $form->get('message')->setDefault($item->message);
        $this->view->form = $form;
    }

}
