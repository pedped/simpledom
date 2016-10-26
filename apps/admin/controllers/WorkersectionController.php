<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ControllerBase;
use AtaPaginator;
use WorkerSection;
use WorkerSectionForm;

class WorkerSectionController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('سمت کارمندان');
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

        $fr = new WorkerSectionForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $workersection = new \WorkerSection();

                $workersection->title = $this->request->getPost('title', 'string');
                if (!$workersection->create()) {
                    $workersection->showErrorMessages($this);
                } else {
                    $workersection->showSuccessMessages($this, 'سمت جدید افزوده گردید');

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
        $workersections = WorkerSection::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $workersections,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'تیتر'
                ))->
                setFields(array(
                    'title'
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
        $item = WorkerSection::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'workersection',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = WorkerSection::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('خطا در حذف سمت');
            } else {
                $this->flash->success('سمت با موفقیت حذف گردید');
                return $this->dispatcher->forward(array(
                            'controller' => 'workersection',
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

        $workersectionItem = WorkerSection::findFirst($id);

        // create form
        $fr = new WorkerSectionForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $workersection = WorkerSection::findFirst($id);
                $workersection->title = $this->request->getPost('title', 'string');
                if (!$workersection->save()) {
                    $workersection->showErrorMessages($this);
                } else {
                    $workersection->showSuccessMessages($this, 'سمت با موفقیت ذخیره گردید');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('title')->setDefault($workersectionItem->title);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = WorkerSection::findFirst($id);
        $this->view->item = $item;

        $form = new WorkerSectionForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('title')->setDefault($item->title);
        $this->view->form = $form;
    }

}
