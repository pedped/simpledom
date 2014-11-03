<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use MelkType;
use MelkTypeForm;
use Simpledom\Admin\BaseControllers\ControllerBase;

class MelkTypeController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('MelkType');
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

        $fr = new MelkTypeForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melktype = new MelkType();

                $melktype->name = $this->request->getPost('name', 'string');
                $melktype->date = $this->request->getPost('date', 'string');
                if (!$melktype->create()) {
                    $melktype->showErrorMessages($this);
                } else {
                    $melktype->showSuccessMessages($this, 'New MelkType added Successfully');

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
        $melktypes = MelkType::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $melktypes,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Name','Date'
                ))->
                setFields(array(
                    'id','name','getDate()'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'melktype/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = MelkType::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'melktype',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = MelkType::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this MelkType item');
            } else {
                $this->flash->success('MelkType item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'melktype',
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
        $this->setTitle('Edit MelkType');

        $melktypeItem = MelkType::findFirst($id);

        // create form
        $fr = new MelkTypeForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melktype = MelkType::findFirst($id);
                                $melktype->name = $this->request->getPost('name', 'string');

                                $melktype->date = $this->request->getPost('date', 'string');
                if (!$melktype->save()) {
                    $melktype->showErrorMessages($this);
                } else {
                    $melktype->showSuccessMessages($this, 'MelkType Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('name')->setDefault($melktypeItem->name);
                        $fr->get('date')->setDefault($melktypeItem->date); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = MelkType::findFirst($id);
        $this->view->item = $item;

        $form = new MelkTypeForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('name')->setDefault($item->name);$form->get('date')->setDefault($item->date);$this->view->form = $form;
        
    }

}
