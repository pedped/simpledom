<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use Opinion;
use Simpledom\Core\OpinionForm;

class OpinionControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Opinion');
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

        $fr = new OpinionForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $opinion = new Opinion();

                $opinion->userid = $this->request->getPost('userid', 'string');
                $opinion->name = $this->request->getPost('name', 'string');
                $opinion->email = $this->request->getPost('email', 'string');
                $opinion->message = $this->request->getPost('message', 'string');
                $opinion->date = $this->request->getPost('date', 'string');
                $opinion->rate = $this->request->getPost('rate', 'string');
                if (!$opinion->create()) {
                    $opinion->showErrorMessages($this);
                } else {
                    $opinion->showSuccessMessages($this, 'New Opinion added Successfully');

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
        $opinions = Opinion::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $opinions,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'User ID', 'Name', 'Email', 'Message', 'Date', 'Rating'
                ))->
                setFields(array(
                    'id', 'userid', 'name', 'email', 'message', 'date', 'rate'
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
        $item = Opinion::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'opinion',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Opinion::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Opinion item');
            } else {
                $this->flash->success('Opinion item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'opinion',
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
        $this->setTitle('Edit Opinion');

        $opinionItem = Opinion::findFirst($id);

        // create form
        $fr = new OpinionForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $opinion = Opinion::findFirst($id);
                $opinion->userid = $this->request->getPost('userid', 'string');

                $opinion->name = $this->request->getPost('name', 'string');

                $opinion->email = $this->request->getPost('email', 'string');

                $opinion->message = $this->request->getPost('message', 'string');

                $opinion->date = $this->request->getPost('date', 'string');

                $opinion->rate = $this->request->getPost('rate', 'string');
                if (!$opinion->save()) {
                    $opinion->showErrorMessages($this);
                } else {
                    $opinion->showSuccessMessages($this, 'Opinion Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('userid')->setDefault($opinionItem->userid);
            $fr->get('name')->setDefault($opinionItem->name);
            $fr->get('email')->setDefault($opinionItem->email);
            $fr->get('message')->setDefault($opinionItem->message);
            $fr->get('date')->setDefault($opinionItem->date);
            $fr->get('rate')->setDefault($opinionItem->rate);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Opinion::findFirst($id);
        $this->view->item = $item;

        $form = new OpinionForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userid')->setDefault($item->userid);
        $form->get('name')->setDefault($item->name);
        $form->get('email')->setDefault($item->email);
        $form->get('message')->setDefault($item->message);
        $form->get('date')->setDefault($item->date);
        $form->get('rate')->setDefault($item->rate);
        $this->view->form = $form;
    }

}
