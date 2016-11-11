<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ControllerBase;
use AtaPaginator;
use PromotionProduct;
use PromotionProductForm;

class PromotionProductController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('PromotionProduct');
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

        $fr = new PromotionProductForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $promotionproduct = new \PromotionProduct();

                $promotionproduct->byuserid = $this->request->getPost('byuserid', 'string');
                $promotionproduct->productid = $this->request->getPost('productid', 'string');
                $promotionproduct->promotionid = $this->request->getPost('promotionid', 'string');
                $promotionproduct->totalorderperuser = $this->request->getPost('totalorderperuser', 'string');
                $promotionproduct->totalorder = $this->request->getPost('totalorder', 'string');
                $promotionproduct->title = $this->request->getPost('title', 'string');
                $promotionproduct->percent = $this->request->getPost('percent', 'string');
                $promotionproduct->fee = $this->request->getPost('fee', 'string');
                $promotionproduct->status = $this->request->getPost('status', 'string');
                if (!$promotionproduct->create()) {
                    $promotionproduct->showErrorMessages($this);
                } else {
                    $promotionproduct->showSuccessMessages($this, 'New PromotionProduct added Successfully');

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
        $promotionproducts = PromotionProduct::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $promotionproducts,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Date', 'By User ID', 'Product ID', 'Promotion ID', 'Total Order Per User', 'Total Order', 'Title', 'Percent', 'Fee', 'Status'
                ))->
                setFields(array(
                    'id', 'getDate()', 'byuserid', 'productid', 'promotionid', 'totalorderperuser', 'totalorder', 'title', 'percent', 'fee', 'status'
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
        $item = PromotionProduct::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'promotionproduct',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = PromotionProduct::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this PromotionProduct item');
            } else {
                $this->flash->success('PromotionProduct item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'promotionproduct',
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
        $this->setTitle('Edit PromotionProduct');

        $promotionproductItem = PromotionProduct::findFirst($id);

        // create form
        $fr = new PromotionProductForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $promotionproduct = PromotionProduct::findFirst($id);
                $promotionproduct->date = $this->request->getPost('date', 'string');

                $promotionproduct->byuserid = $this->request->getPost('byuserid', 'string');

                $promotionproduct->productid = $this->request->getPost('productid', 'string');

                $promotionproduct->promotionid = $this->request->getPost('promotionid', 'string');

                $promotionproduct->totalorderperuser = $this->request->getPost('totalorderperuser', 'string');

                $promotionproduct->totalorder = $this->request->getPost('totalorder', 'string');

                $promotionproduct->title = $this->request->getPost('title', 'string');

                $promotionproduct->percent = $this->request->getPost('percent', 'string');

                $promotionproduct->fee = $this->request->getPost('fee', 'string');

                $promotionproduct->status = $this->request->getPost('status', 'string');
                if (!$promotionproduct->save()) {
                    $promotionproduct->showErrorMessages($this);
                } else {
                    $promotionproduct->showSuccessMessages($this, 'PromotionProduct Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('date')->setDefault($promotionproductItem->date);
            $fr->get('byuserid')->setDefault($promotionproductItem->byuserid);
            $fr->get('productid')->setDefault($promotionproductItem->productid);
            $fr->get('promotionid')->setDefault($promotionproductItem->promotionid);
            $fr->get('totalorderperuser')->setDefault($promotionproductItem->totalorderperuser);
            $fr->get('totalorder')->setDefault($promotionproductItem->totalorder);
            $fr->get('title')->setDefault($promotionproductItem->title);
            $fr->get('percent')->setDefault($promotionproductItem->percent);
            $fr->get('fee')->setDefault($promotionproductItem->fee);
            $fr->get('status')->setDefault($promotionproductItem->status);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = PromotionProduct::findFirst($id);
        $this->view->item = $item;

        $form = new PromotionProductForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('date')->setDefault($item->date);
        $form->get('byuserid')->setDefault($item->byuserid);
        $form->get('productid')->setDefault($item->productid);
        $form->get('promotionid')->setDefault($item->promotionid);
        $form->get('totalorderperuser')->setDefault($item->totalorderperuser);
        $form->get('totalorder')->setDefault($item->totalorder);
        $form->get('title')->setDefault($item->title);
        $form->get('percent')->setDefault($item->percent);
        $form->get('fee')->setDefault($item->fee);
        $form->get('status')->setDefault($item->status);
        $this->view->form = $form;
    }

}
