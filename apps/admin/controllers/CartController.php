<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use Cart;
use CartForm;
use Simpledom\Admin\BaseControllers\ControllerBase;

class CartController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Cart');
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

        $fr = new CartForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $cart = new \Cart();

                $cart->type = $this->request->getPost('type', 'string');
                $cart->value = $this->request->getPost('value', 'string');
                $cart->serial = $this->request->getPost('serial', 'string');
                $cart->used = $this->request->getPost('used', 'string');
                $cart->date = $this->request->getPost('date', 'string');
                if (!$cart->create()) {
                    $cart->showErrorMessages($this);
                } else {
                    $cart->showSuccessMessages($this, 'New Cart added Successfully');

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
        $carts = Cart::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $carts,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Type', 'Value', 'Serial', 'Used', 'Date'
                ))->
                setFields(array(
                    'id', 'type', 'value', 'serial', 'used', 'getDate()'
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
        $item = Cart::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'cart',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Cart::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Cart item');
            } else {
                $this->flash->success('Cart item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'cart',
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
        $this->setTitle('Edit Cart');

        $cartItem = Cart::findFirst($id);

        // create form
        $fr = new CartForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $cart = Cart::findFirst($id);
                $cart->type = $this->request->getPost('type', 'string');

                $cart->value = $this->request->getPost('value', 'string');

                $cart->serial = $this->request->getPost('serial', 'string');

                $cart->used = $this->request->getPost('used', 'string');

                $cart->date = $this->request->getPost('date', 'string');
                if (!$cart->save()) {
                    $cart->showErrorMessages($this);
                } else {
                    $cart->showSuccessMessages($this, 'Cart Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('type')->setDefault($cartItem->type);
            $fr->get('value')->setDefault($cartItem->value);
            $fr->get('serial')->setDefault($cartItem->serial);
            $fr->get('used')->setDefault($cartItem->used);
            $fr->get('date')->setDefault($cartItem->date);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Cart::findFirst($id);
        $this->view->item = $item;

        $form = new CartForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('type')->setDefault($item->type);
        $form->get('value')->setDefault($item->value);
        $form->get('serial')->setDefault($item->serial);
        $form->get('used')->setDefault($item->used);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
