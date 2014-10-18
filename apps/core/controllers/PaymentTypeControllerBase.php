<?php
namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use PaymentType;
use Simpledom\Core\PaymentTypeForm;


class PaymentTypeControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('PaymentType');
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

        $fr = new PaymentTypeForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $paymenttype = new PaymentType();

                $paymenttype->key = $this->request->getPost('key', 'string');
                $paymenttype->name = $this->request->getPost('name', 'string');
                $paymenttype->enable = $this->request->getPost('enable', 'string');
                if (!$paymenttype->create()) {
                    $paymenttype->showErrorMessages($this);
                } else {
                    $paymenttype->showSuccessMessages($this, 'New PaymentType added Successfully');

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
        $paymenttypes = PaymentType::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $paymenttypes,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Key','Name','Enable'
                ))->
                setFields(array(
                    'id','key','name','enable'
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
        $item = PaymentType::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'paymenttype',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = PaymentType::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this PaymentType item');
            } else {
                $this->flash->success('PaymentType item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'paymenttype',
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
        $this->setTitle('Edit PaymentType');

        $paymenttypeItem = PaymentType::findFirst($id);

        // create form
        $fr = new PaymentTypeForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $paymenttype = PaymentType::findFirst($id);
                                $paymenttype->key = $this->request->getPost('key', 'string');

                                $paymenttype->name = $this->request->getPost('name', 'string');

                                $paymenttype->enable = $this->request->getPost('enable', 'string');
                if (!$paymenttype->save()) {
                    $paymenttype->showErrorMessages($this);
                } else {
                    $paymenttype->showSuccessMessages($this, 'PaymentType Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('key')->setDefault($paymenttypeItem->key);
                        $fr->get('name')->setDefault($paymenttypeItem->name);
                        $fr->get('enable')->setDefault($paymenttypeItem->enable); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = PaymentType::findFirst($id);
        $this->view->item = $item;

        $form = new PaymentTypeForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('key')->setDefault($item->key);$form->get('name')->setDefault($item->name);$form->get('enable')->setDefault($item->enable);$this->view->form = $form;
        
    }

}
