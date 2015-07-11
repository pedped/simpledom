<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use Simpledom\Core\UserOrderForm;
use UserOrder;

class UserOrderControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('UserOrder');
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

        $fr = new UserOrderForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $userorder = new UserOrder();

                $userorder->userid = $this->request->getPost('userid', 'string');
                $userorder->type = $this->request->getPost('type', 'string');
                $userorder->itemid = $this->request->getPost('itemid', 'string');
                $userorder->paymenttype = $this->request->getPost('paymenttype', 'string');
                $userorder->paymentitemid = $this->request->getPost('paymentitemid', 'string');
                $userorder->price = $this->request->getPost('price', 'string');
                $userorder->pricecurrency = $this->request->getPost('pricecurrency', 'string');
                $userorder->date = $this->request->getPost('date', 'string');
                if (!$userorder->create()) {
                    $userorder->showErrorMessages($this);
                } else {
                    $userorder->showSuccessMessages($this, 'New UserOrder added Successfully');

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
        $userorders = UserOrder::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $userorders,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'کد کاربر', 'شماره تماس', 'نوع', 'اطلاعات خرید', 'کد محصول', 'پرداخت شده توسط', 'کد پرداخت کننده', 'قیمت', 'واحد', 'تاریخ', 'انجام شده'
                ))->
                setFields(array(
                    'id', 'userid', 'getPhone()', 'getTypeName()', 'getItemTitle()', 'itemid', 'getPaymentTypeName()', 'paymentitemid', 'price', 'pricecurrency', 'getDate()', 'getDoneTag()'
                ))->setListPath(
                'userorder/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = UserOrder::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'userorder',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = UserOrder::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this UserOrder item');
            } else {
                $this->flash->success('UserOrder item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'userorder',
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
        $this->setTitle('Edit UserOrder');

        $userorderItem = UserOrder::findFirst($id);

        // create form
        $fr = new UserOrderForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $userorder = UserOrder::findFirst($id);
                $userorder->userid = $this->request->getPost('userid', 'string');

                $userorder->type = $this->request->getPost('type', 'string');

                $userorder->itemid = $this->request->getPost('itemid', 'string');

                $userorder->paymenttype = $this->request->getPost('paymenttype', 'string');

                $userorder->paymentitemid = $this->request->getPost('paymentitemid', 'string');

                $userorder->price = $this->request->getPost('price', 'string');

                $userorder->pricecurrency = $this->request->getPost('pricecurrency', 'string');

                $userorder->date = $this->request->getPost('date', 'string');
                if (!$userorder->save()) {
                    $userorder->showErrorMessages($this);
                } else {
                    $userorder->showSuccessMessages($this, 'UserOrder Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('userid')->setDefault($userorderItem->userid);
            $fr->get('type')->setDefault($userorderItem->type);
            $fr->get('itemid')->setDefault($userorderItem->itemid);
            $fr->get('paymenttype')->setDefault($userorderItem->paymenttype);
            $fr->get('paymentitemid')->setDefault($userorderItem->paymentitemid);
            $fr->get('price')->setDefault($userorderItem->price);
            $fr->get('pricecurrency')->setDefault($userorderItem->pricecurrency);
            $fr->get('date')->setDefault($userorderItem->date);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = UserOrder::findFirst($id);
        $this->view->item = $item;

        $form = new UserOrderForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userid')->setDefault($item->userid);
        $form->get('type')->setDefault($item->type);
        $form->get('itemid')->setDefault($item->itemid);
        $form->get('paymenttype')->setDefault($item->paymenttype);
        $form->get('paymentitemid')->setDefault($item->paymentitemid);
        $form->get('price')->setDefault($item->price);
        $form->get('pricecurrency')->setDefault($item->pricecurrency);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
