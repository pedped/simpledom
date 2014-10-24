<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use State;
use StateForm;

class StateController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('State');
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

        $fr = new StateForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $state = new \State();

                $state->name = $this->request->getPost('name', 'string');
                if (!$state->create()) {
                    $state->showErrorMessages($this);
                } else {
                    $state->showSuccessMessages($this, 'New State added Successfully');

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
        $states = State::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $states,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Name'
                ))->
                setFields(array(
                    'id','name'
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
        $item = State::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'state',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = State::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this State item');
            } else {
                $this->flash->success('State item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'state',
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
        $this->setTitle('Edit State');

        $stateItem = State::findFirst($id);

        // create form
        $fr = new StateForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $state = State::findFirst($id);
                                $state->name = $this->request->getPost('name', 'string');
                if (!$state->save()) {
                    $state->showErrorMessages($this);
                } else {
                    $state->showSuccessMessages($this, 'State Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('name')->setDefault($stateItem->name); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = State::findFirst($id);
        $this->view->item = $item;

        $form = new StateForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('name')->setDefault($item->name);$this->view->form = $form;
        
    }

}
