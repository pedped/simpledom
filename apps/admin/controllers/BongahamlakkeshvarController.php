<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ControllerBase;
use AtaPaginator;
use BongahAmlakKeshvar;
use BongahAmlakKeshvarForm;

class BongahAmlakKeshvarController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('BongahAmlakKeshvar');
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

        $fr = new BongahAmlakKeshvarForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $bongahamlakkeshvar = new \BongahAmlakKeshvar();

                $bongahamlakkeshvar->state = $this->request->getPost('state', 'string');
                $bongahamlakkeshvar->city = $this->request->getPost('city', 'string');
                $bongahamlakkeshvar->name = $this->request->getPost('name', 'string');
                $bongahamlakkeshvar->code = $this->request->getPost('code', 'string');
                $bongahamlakkeshvar->phone = $this->request->getPost('phone', 'string');
                $bongahamlakkeshvar->mobile = $this->request->getPost('mobile', 'string');
                $bongahamlakkeshvar->address = $this->request->getPost('address', 'string');
                $bongahamlakkeshvar->cityid = $this->request->getPost('cityid', 'string');
                $bongahamlakkeshvar->stateid = $this->request->getPost('stateid', 'string');
                if (!$bongahamlakkeshvar->create()) {
                    $bongahamlakkeshvar->showErrorMessages($this);
                } else {
                    $bongahamlakkeshvar->showSuccessMessages($this, 'New BongahAmlakKeshvar added Successfully');

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
        $bongahamlakkeshvars = BongahAmlakKeshvar::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $bongahamlakkeshvars,
            'limit' => 50,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'State', 'City', 'Name', 'Code', 'Phone', 'Mobile', 'Address', 'City ID', 'State ID'
                ))->
                setFields(array(
                    'id', 'state', 'city', 'name', 'code', 'phone', 'mobile', 'address', 'cityid', 'stateid'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'bongahamlakkeshvar/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = BongahAmlakKeshvar::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'bongahamlakkeshvar',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = BongahAmlakKeshvar::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this BongahAmlakKeshvar item');
            } else {
                $this->flash->success('BongahAmlakKeshvar item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'bongahamlakkeshvar',
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
        $this->setTitle('Edit BongahAmlakKeshvar');

        $bongahamlakkeshvarItem = BongahAmlakKeshvar::findFirst($id);

        // create form
        $fr = new BongahAmlakKeshvarForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $bongahamlakkeshvar = BongahAmlakKeshvar::findFirst($id);
                $bongahamlakkeshvar->state = $this->request->getPost('state', 'string');

                $bongahamlakkeshvar->city = $this->request->getPost('city', 'string');

                $bongahamlakkeshvar->name = $this->request->getPost('name', 'string');

                $bongahamlakkeshvar->code = $this->request->getPost('code', 'string');

                $bongahamlakkeshvar->phone = $this->request->getPost('phone', 'string');

                $bongahamlakkeshvar->mobile = $this->request->getPost('mobile', 'string');

                $bongahamlakkeshvar->address = $this->request->getPost('address', 'string');

                $bongahamlakkeshvar->cityid = $this->request->getPost('cityid', 'string');

                $bongahamlakkeshvar->stateid = $this->request->getPost('stateid', 'string');
                if (!$bongahamlakkeshvar->save()) {
                    $bongahamlakkeshvar->showErrorMessages($this);
                } else {
                    $bongahamlakkeshvar->showSuccessMessages($this, 'BongahAmlakKeshvar Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('state')->setDefault($bongahamlakkeshvarItem->state);
            $fr->get('city')->setDefault($bongahamlakkeshvarItem->city);
            $fr->get('name')->setDefault($bongahamlakkeshvarItem->name);
            $fr->get('code')->setDefault($bongahamlakkeshvarItem->code);
            $fr->get('phone')->setDefault($bongahamlakkeshvarItem->phone);
            $fr->get('mobile')->setDefault($bongahamlakkeshvarItem->mobile);
            $fr->get('address')->setDefault($bongahamlakkeshvarItem->address);
            $fr->get('cityid')->setDefault($bongahamlakkeshvarItem->cityid);
            $fr->get('stateid')->setDefault($bongahamlakkeshvarItem->stateid);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = BongahAmlakKeshvar::findFirst($id);
        $this->view->item = $item;

        $form = new BongahAmlakKeshvarForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('state')->setDefault($item->state);
        $form->get('city')->setDefault($item->city);
        $form->get('name')->setDefault($item->name);
        $form->get('code')->setDefault($item->code);
        $form->get('phone')->setDefault($item->phone);
        $form->get('mobile')->setDefault($item->mobile);
        $form->get('address')->setDefault($item->address);
        $form->get('cityid')->setDefault($item->cityid);
        $form->get('stateid')->setDefault($item->stateid);
        $this->view->form = $form;
    }

}
