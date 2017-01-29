<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use Invoice;
use InvoiceForm;
use InvoiceProducts;
use InvoiceStatusForm;
use Simpledom\Admin\BaseControllers\ControllerBase;

class InvoiceController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('سفارشات');
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

        $fr = new InvoiceForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $invoice = new \Invoice();

                $invoice->userid = $this->request->getPost('userid', 'string');
                $invoice->price = $this->request->getPost('price', 'string');
                $invoice->currency = $this->request->getPost('currency', 'string');
                $invoice->status = $this->request->getPost('status', 'string');
                $invoice->user_status = $this->request->getPost('user_status', 'string');
                $invoice->cityid = $this->request->getPost('cityid', 'string');
                $invoice->address = $this->request->getPost('address', 'string');
                $invoice->usercomment = $this->request->getPost('usercomment', 'string');
                $invoice->address_longitude = $this->request->getPost('address_longitude', 'string');
                $invoice->address_latitude = $this->request->getPost('address_latitude', 'string');
                $invoice->address_gpsapprox = $this->request->getPost('address_gpsapprox', 'string');
                $invoice->phone = $this->request->getPost('phone', 'string');
                $invoice->mobile = $this->request->getPost('mobile', 'string');
                $invoice->deliverdate = $this->request->getPost('deliverdate', 'string');
                if (!$invoice->create()) {
                    $invoice->showErrorMessages($this);
                } else {
                    $invoice->showSuccessMessages($this, 'New Invoice added Successfully');

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
        $invoices = Invoice::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $invoices,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد سفارش', 'کد کاربر', 'مجموع قیمت', 'آدرس', 'موبایل', 'تاریخ تحویل', 'تاریخ', 'وضعیت سفارش'
                ))->
                setFields(array(
                    'id', 'userid', 'price', 'address', 'mobile', 'deliverdate', 'getDate()', 'getStatusLabel()'
                ))->
                setEditUrl(
                        'invoice/edit'
                )->setListPath(
                'invoice/list');

        $this->view->list = $paginator->getPaginate();

        $this->view->totalInvoices = Invoice::count();
        $this->view->totalWaiting = Invoice::count(array("status = :status:", "bind" => array("status" => INVOICESTATUS_REQUESTED)));
        $this->view->totalDelivered = Invoice::count(array("status = :status:", "bind" => array("status" => INVOICESTATUS_RECEIVED)));
    }

//    public function deleteAction($id) {
//
//        if (!$this->ValidateAccess($id)) {
//            // user do not have permission to remove this object
//            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
//        }
//
//        // check if item exist
//        $item = Invoice::findFirst($id);
//        if (!$item) {
//            // item is not exist any more
//            return $this->dispatcher->forward(array(
//                        'controller' => 'invoice',
//                        'action' => 'list'
//            ));
//        }
//
//        // check if user want to remove it
//        if ($this->request->isPost()) {
//            $result = Invoice::findFirst($id)->delete();
//            if (!$result) {
//                $this->flash->error('unable to remove this Invoice item');
//            } else {
//                $this->flash->success('Invoice item deleted successfully');
//                return $this->dispatcher->forward(array(
//                            'controller' => 'invoice',
//                            'action' => 'list'
//                ));
//            }
//        }
//    }

    public function editAction($id, $tab = "info", $page = 1) {


        if (!$this->ValidateAccess($id)) {
            // user do not have permission to edut this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        switch ($tab) {
            case "info" :
                $this->viewTabInfo($id);
                break;
            case "products" :
                $this->viewTabProducts($id, $page);
                break;
            case "status" :
                $this->viewTabStatus($id, $page);
                break;
            default :
                var_dump("invalid tab");
                die();
        }

        // set tab info
        $invoiceItem = \Invoice::findFirst(array("id = :id:", "bind" => array("id" => $id)));
        $this->view->tab = $tab;
        $this->view->invoice = $invoiceItem;
    }

    public function viewTabInfo($id) {

        $invoiceItem = Invoice::findFirst($id);

        // create form
        $fr = new InvoiceForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $invoice = Invoice::findFirst($id);

                $invoice->address = $this->request->getPost('address', 'string');

                $invoice->usercomment = $this->request->getPost('usercomment', 'string');

                if (!$invoice->save()) {
                    $invoice->showErrorMessages($this);
                } else {
                    $invoice->showSuccessMessages($this, 'فاکتور با موفقیت ذخیره گردید');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }

        $fr->get('userid')->setDefault($invoiceItem->userid);
        $fr->get('mobile')->setDefault($invoiceItem->mobile);
        $fr->get('phone')->setDefault($invoiceItem->phone);
        $fr->get('address')->setDefault($invoiceItem->address);
        $fr->get('price')->setDefault($invoiceItem->price);

        $fr->get('usercomment')->setDefault($invoiceItem->usercomment);

        if (!isset($invoiceItem->address_longitude) || strlen($invoiceItem->address_longitude) == 0) {
            $fr->get('map')->setLongtude(0);
        } else {
            $fr->get('map')->setLongtude($invoiceItem->address_longitude);
        }

        if (!isset($invoiceItem->address_latitude) || strlen($invoiceItem->address_latitude) == 0) {
            $fr->get('map')->setLathitude(0);
        } else {
            $fr->get('map')->setLathitude($invoiceItem->address_latitude);
        }

        $this->view->form = $fr;
    }

    public function viewTabProducts($id, $page = 1) {

        // load the users
        $products = InvoiceProducts::find(array("invoiceid = :invoiceid:", "bind" => array("invoiceid" => $id)));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $products,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'نام کالا', 'دسته', 'تعداد', 'وضعیت کالا', 'قیمت بدون تخفیف' , 'قیمت نهایی'
                ))->
                setFields(array(
                    'id', 'getProductTitle()', 'getCategoryName()', 'count', 'getProductStatus()', 'getInitalPrice()' , 'getFinalPrice()'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'product/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function viewTabStatus($id, $page) {

        // create form
        $fr = new InvoiceStatusForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $invoice = Invoice::findFirst($id);

                $invoice->status = $this->request->getPost('status', 'string');
                $invoice->user_status = $this->request->getPost('status', 'string');

                if (!$invoice->save()) {
                    $invoice->showErrorMessages($this);
                } else {
                    $invoice->showSuccessMessages($this, 'وضعیت فاکتور با موفقیت ذخیره گردید');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }
        $invoiceItem = Invoice::findFirst($id);
        $fr->get("status")->setDefault($invoiceItem->status);
        $this->view->form = $fr;
    }

}
