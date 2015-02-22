<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use BongahAction;
use BongahActionForm;
use Simpledom\Admin\BaseControllers\ControllerBase;

class BongahActionController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('BongahAction');
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

        $fr = new BongahActionForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $bongahaction = new \BongahAction();

                $bongahaction->bongahid = $this->request->getPost('bongahid', 'string');
                $bongahaction->actioncode = $this->request->getPost('actioncode', 'string');
                $bongahaction->data = $this->request->getPost('data', 'string');
                $bongahaction->date = $this->request->getPost('date', 'string');
                if (!$bongahaction->create()) {
                    $bongahaction->showErrorMessages($this);
                } else {
                    $bongahaction->showSuccessMessages($this, 'New BongahAction added Successfully');

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
        $bongahactions = BongahAction::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $bongahactions,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Bongah ID', 'Action Code', 'Data', 'Date'
                ))->
                setFields(array(
                    'id', 'bongahid', 'actioncode', 'data', 'getDate()'
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
        $item = BongahAction::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'bongahaction',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = BongahAction::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this BongahAction item');
            } else {
                $this->flash->success('BongahAction item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'bongahaction',
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
        $this->setTitle('Edit BongahAction');

        $bongahactionItem = BongahAction::findFirst($id);

        // create form
        $fr = new BongahActionForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $bongahaction = BongahAction::findFirst($id);
                $bongahaction->bongahid = $this->request->getPost('bongahid', 'string');

                $bongahaction->actioncode = $this->request->getPost('actioncode', 'string');

                $bongahaction->data = $this->request->getPost('data', 'string');

                $bongahaction->date = $this->request->getPost('date', 'string');
                if (!$bongahaction->save()) {
                    $bongahaction->showErrorMessages($this);
                } else {
                    $bongahaction->showSuccessMessages($this, 'BongahAction Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('bongahid')->setDefault($bongahactionItem->bongahid);
            $fr->get('actioncode')->setDefault($bongahactionItem->actioncode);
            $fr->get('data')->setDefault($bongahactionItem->data);
            $fr->get('date')->setDefault($bongahactionItem->date);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = BongahAction::findFirst($id);
        $this->view->item = $item;

        $form = new BongahActionForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('bongahid')->setDefault($item->bongahid);
        $form->get('actioncode')->setDefault($item->actioncode);
        $form->get('data')->setDefault($item->data);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
