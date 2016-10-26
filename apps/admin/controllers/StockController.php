<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ControllerBase;
use AtaPaginator;
use Stock;
use StockForm;

class StockController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('واردات کالا');
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

        $fr = new StockForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $stock = new \Stock();

                $stock->buyprice = $this->request->getPost('buyprice', 'string');
                $stock->sellprice = $this->request->getPost('sellprice', 'string');
                $stock->productid = $this->request->getPost('productid', 'string');
                $stock->total = $this->request->getPost('total', 'string');
                $stock->expiredate = $this->request->getPost('expiredate', 'string');
                $stock->warehousepartid = $this->request->getPost('warehousepartid', 'string');
                if (!$stock->create()) {
                    $stock->showErrorMessages($this);
                } else {
                    $stock->showSuccessMessages($this, 'با موفقیت افزوده گردید');

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
        $stocks = Stock::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $stocks,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'تاریخ', 'قیمت خرید', 'قیمت فروش', 'نام محصول', 'تعداد', 'باقیمانده', 'تاریخ انقضا', 'کد انبار', 'شاخه انبار', 'زیر شاخه انبار'
                ))->
                setFields(array(
                    'id', 'getDate()', 'buyprice', 'sellprice', 'productid', 'total', 'remain', 'expiredate', 'warehousepartid', 'warehousepartid', 'warehousepartid'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'stock/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = Stock::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'stock',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Stock::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Stock item');
            } else {
                $this->flash->success('این مورد با موفقیت حذف گردید');
                return $this->dispatcher->forward(array(
                            'controller' => 'stock',
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
        $this->setTitle('Edit Stock');

        $stockItem = Stock::findFirst($id);

        // create form
        $fr = new StockForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $stock = Stock::findFirst($id);
                $stock->date = $this->request->getPost('date', 'string');

                $stock->buyprice = $this->request->getPost('buyprice', 'string');

                $stock->sellprice = $this->request->getPost('sellprice', 'string');

                $stock->productid = $this->request->getPost('productid', 'string');

                $stock->total = $this->request->getPost('total', 'string');

                $stock->expiredate = $this->request->getPost('expiredate', 'string');

                $stock->warehousepartid = $this->request->getPost('warehousepartid', 'string');
                if (!$stock->save()) {
                    $stock->showErrorMessages($this);
                } else {
                    $stock->showSuccessMessages($this, 'با موفقیت تغییر یافت');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('date')->setDefault($stockItem->date);
            $fr->get('buyprice')->setDefault($stockItem->buyprice);
            $fr->get('sellprice')->setDefault($stockItem->sellprice);
            $fr->get('productid')->setDefault($stockItem->productid);
            $fr->get('total')->setDefault($stockItem->total);
            $fr->get('expiredate')->setDefault($stockItem->expiredate);
            $fr->get('warehousepartid')->setDefault($stockItem->warehousepartid);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Stock::findFirst($id);
        $this->view->item = $item;

        $form = new StockForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('date')->setDefault($item->date);
        $form->get('buyprice')->setDefault($item->buyprice);
        $form->get('sellprice')->setDefault($item->sellprice);
        $form->get('productid')->setDefault($item->productid);
        $form->get('total')->setDefault($item->total);
        $form->get('expiredate')->setDefault($item->expiredate);
        $form->get('warehousepartid')->setDefault($item->warehousepartid);
        $this->view->form = $form;
    }

}
