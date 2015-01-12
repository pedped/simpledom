<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use CreditUsage;
use CreditUsageForm;
use Simpledom\Admin\BaseControllers\ControllerBase;

class CreditUsageController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('CreditUsage');
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

        $fr = new CreditUsageForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $creditusage = new \CreditUsage();

                $creditusage->amount = $this->request->getPost('amount', 'string');
                $creditusage->chargeid = $this->request->getPost('chargeid', 'string');
                $creditusage->date = $this->request->getPost('date', 'string');
                if (!$creditusage->create()) {
                    $creditusage->showErrorMessages($this);
                } else {
                    $creditusage->showSuccessMessages($this, 'New CreditUsage added Successfully');

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
        $creditusages = CreditUsage::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $creditusages,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Amount', 'Charge ID', 'Date'
                ))->
                setFields(array(
                    'id', 'amount', 'chargeid', 'getDate()'
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
        $item = CreditUsage::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'creditusage',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = CreditUsage::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this CreditUsage item');
            } else {
                $this->flash->success('CreditUsage item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'creditusage',
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
        $this->setTitle('Edit CreditUsage');

        $creditusageItem = CreditUsage::findFirst($id);

        // create form
        $fr = new CreditUsageForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $creditusage = CreditUsage::findFirst($id);
                $creditusage->amount = $this->request->getPost('amount', 'string');

                $creditusage->chargeid = $this->request->getPost('chargeid', 'string');

                $creditusage->date = $this->request->getPost('date', 'string');
                if (!$creditusage->save()) {
                    $creditusage->showErrorMessages($this);
                } else {
                    $creditusage->showSuccessMessages($this, 'CreditUsage Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('amount')->setDefault($creditusageItem->amount);
            $fr->get('chargeid')->setDefault($creditusageItem->chargeid);
            $fr->get('date')->setDefault($creditusageItem->date);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = CreditUsage::findFirst($id);
        $this->view->item = $item;

        $form = new CreditUsageForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('amount')->setDefault($item->amount);
        $form->get('chargeid')->setDefault($item->chargeid);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
