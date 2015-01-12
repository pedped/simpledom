<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use Charge;
use ChargeForm;
use Simpledom\Admin\BaseControllers\ControllerBase;

class ChargeController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Charge');
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

        $fr = new ChargeForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $charge = new \Charge();

                $charge->userid = $this->request->getPost('userid', 'string');
                $charge->type = $this->request->getPost('type', 'string');
                $charge->value = $this->request->getPost('value', 'string');
                $charge->phonenumber = $this->request->getPost('phonenumber', 'string');
                $charge->targetphonenumber = $this->request->getPost('targetphonenumber', 'string');
                $charge->offlinemode = $this->request->getPost('offlinemode', 'string');
                $charge->orderid = $this->request->getPost('orderid', 'string');
                $charge->creditid = $this->request->getPost('creditid', 'string');
                $charge->elkatransid = $this->request->getPost('elkatransid', 'string');
                $charge->cartid = $this->request->getPost('cartid', 'string');
                $charge->status = $this->request->getPost('status', 'string');
                $charge->date = $this->request->getPost('date', 'string');
                if (!$charge->create()) {
                    $charge->showErrorMessages($this);
                } else {
                    $charge->showSuccessMessages($this, 'New Charge added Successfully');

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
        $charges = Charge::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $charges,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'User ID', 'Type', 'Value', 'Phone Number', 'Target Phone Number', 'Offline Mode', 'Order ID', 'Credit ID', 'Elka Trans ID', 'Cart ID', 'Status', 'Date'
                ))->
                setFields(array(
                    'id', 'userid', 'type', 'value', 'phonenumber', 'targetphonenumber', 'offlinemode', 'orderid', 'creditid', 'elkatransid', 'cartid', 'status', 'getDate()'
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
        $item = Charge::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'charge',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Charge::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Charge item');
            } else {
                $this->flash->success('Charge item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'charge',
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
        $this->setTitle('Edit Charge');

        $chargeItem = Charge::findFirst($id);

        // create form
        $fr = new ChargeForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $charge = Charge::findFirst($id);
                $charge->userid = $this->request->getPost('userid', 'string');

                $charge->type = $this->request->getPost('type', 'string');

                $charge->value = $this->request->getPost('value', 'string');

                $charge->phonenumber = $this->request->getPost('phonenumber', 'string');

                $charge->targetphonenumber = $this->request->getPost('targetphonenumber', 'string');

                $charge->offlinemode = $this->request->getPost('offlinemode', 'string');

                $charge->orderid = $this->request->getPost('orderid', 'string');

                $charge->creditid = $this->request->getPost('creditid', 'string');

                $charge->elkatransid = $this->request->getPost('elkatransid', 'string');

                $charge->cartid = $this->request->getPost('cartid', 'string');

                $charge->status = $this->request->getPost('status', 'string');

                $charge->date = $this->request->getPost('date', 'string');
                if (!$charge->save()) {
                    $charge->showErrorMessages($this);
                } else {
                    $charge->showSuccessMessages($this, 'Charge Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('userid')->setDefault($chargeItem->userid);
            $fr->get('type')->setDefault($chargeItem->type);
            $fr->get('value')->setDefault($chargeItem->value);
            $fr->get('phonenumber')->setDefault($chargeItem->phonenumber);
            $fr->get('targetphonenumber')->setDefault($chargeItem->targetphonenumber);
            $fr->get('offlinemode')->setDefault($chargeItem->offlinemode);
            $fr->get('orderid')->setDefault($chargeItem->orderid);
            $fr->get('creditid')->setDefault($chargeItem->creditid);
            $fr->get('elkatransid')->setDefault($chargeItem->elkatransid);
            $fr->get('cartid')->setDefault($chargeItem->cartid);
            $fr->get('status')->setDefault($chargeItem->status);
            $fr->get('date')->setDefault($chargeItem->date);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Charge::findFirst($id);
        $this->view->item = $item;

        $form = new ChargeForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userid')->setDefault($item->userid);
        $form->get('type')->setDefault($item->type);
        $form->get('value')->setDefault($item->value);
        $form->get('phonenumber')->setDefault($item->phonenumber);
        $form->get('targetphonenumber')->setDefault($item->targetphonenumber);
        $form->get('offlinemode')->setDefault($item->offlinemode);
        $form->get('orderid')->setDefault($item->orderid);
        $form->get('creditid')->setDefault($item->creditid);
        $form->get('elkatransid')->setDefault($item->elkatransid);
        $form->get('cartid')->setDefault($item->cartid);
        $form->get('status')->setDefault($item->status);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
