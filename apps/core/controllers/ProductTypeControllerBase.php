<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use ProductType;
use Simpledom\Core\ProductTypeForm;

class ProductTypeControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('ProductType');
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

        $fr = new ProductTypeForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $producttype = new ProductType();

                $producttype->key = $this->request->getPost('key', 'string');
                $producttype->name = $this->request->getPost('name', 'string');
                $producttype->enable = $this->request->getPost('enable', 'string');
                if (!$producttype->create()) {
                    $producttype->showErrorMessages($this);
                } else {
                    $producttype->showSuccessMessages($this, 'New ProductType added Successfully');

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
        $producttypes = ProductType::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $producttypes,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Key', 'Name', 'Enable'
                ))->
                setFields(array(
                    'id', 'key', 'name', 'enable'
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
        $item = ProductType::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'producttype',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = ProductType::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this ProductType item');
            } else {
                $this->flash->success('ProductType item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'producttype',
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
        $this->setTitle('Edit ProductType');

        $producttypeItem = ProductType::findFirst($id);

        // create form
        $fr = new ProductTypeForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $producttype = ProductType::findFirst($id);
                $producttype->key = $this->request->getPost('key', 'string');

                $producttype->name = $this->request->getPost('name', 'string');

                $producttype->enable = $this->request->getPost('enable', 'string');
                if (!$producttype->save()) {
                    $producttype->showErrorMessages($this);
                } else {
                    $producttype->showSuccessMessages($this, 'ProductType Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('key')->setDefault($producttypeItem->key);
            $fr->get('name')->setDefault($producttypeItem->name);
            $fr->get('enable')->setDefault($producttypeItem->enable);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = ProductType::findFirst($id);
        $this->view->item = $item;

        $form = new ProductTypeForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('key')->setDefault($item->key);
        $form->get('name')->setDefault($item->name);
        $form->get('enable')->setDefault($item->enable);
        $this->view->form = $form;
    }

}
