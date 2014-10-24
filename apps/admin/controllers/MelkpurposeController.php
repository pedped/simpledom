<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use MelkPurpose;
use MelkPurposeForm;

class MelkPurposeController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('MelkPurpose');
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

        $fr = new MelkPurposeForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melkpurpose = new \MelkPurpose();

                $melkpurpose->name = $this->request->getPost('name', 'string');
                $melkpurpose->date = $this->request->getPost('date', 'string');
                if (!$melkpurpose->create()) {
                    $melkpurpose->showErrorMessages($this);
                } else {
                    $melkpurpose->showSuccessMessages($this, 'New MelkPurpose added Successfully');

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
        $melkpurposes = MelkPurpose::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $melkpurposes,
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
                'list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = MelkPurpose::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'melkpurpose',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = MelkPurpose::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this MelkPurpose item');
            } else {
                $this->flash->success('MelkPurpose item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'melkpurpose',
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
        $this->setTitle('Edit MelkPurpose');

        $melkpurposeItem = MelkPurpose::findFirst($id);

        // create form
        $fr = new MelkPurposeForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melkpurpose = MelkPurpose::findFirst($id);
                                $melkpurpose->name = $this->request->getPost('name', 'string');

                                $melkpurpose->date = $this->request->getPost('date', 'string');
                if (!$melkpurpose->save()) {
                    $melkpurpose->showErrorMessages($this);
                } else {
                    $melkpurpose->showSuccessMessages($this, 'MelkPurpose Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('name')->setDefault($melkpurposeItem->name);
                        $fr->get('date')->setDefault($melkpurposeItem->date); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = MelkPurpose::findFirst($id);
        $this->view->item = $item;

        $form = new MelkPurposeForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('name')->setDefault($item->name);$form->get('date')->setDefault($item->date);$this->view->form = $form;
        
    }

}
