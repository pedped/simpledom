<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use SpecialNumberPlans;
use SpecialNumberPlansForm;

class SpecialNumberPlansController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('SpecialNumberPlans');
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

        $fr = new SpecialNumberPlansForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $specialnumberplans = new \SpecialNumberPlans();

                $specialnumberplans->name = $this->request->getPost('name', 'string');
                $specialnumberplans->length = $this->request->getPost('length', 'string');
                $specialnumberplans->precode = $this->request->getPost('precode', 'string');
                $specialnumberplans->price = $this->request->getPost('price', 'string');
                $specialnumberplans->enable = $this->request->getPost('enable', 'string');
                if (!$specialnumberplans->create()) {
                    $specialnumberplans->showErrorMessages($this);
                } else {
                    $specialnumberplans->showSuccessMessages($this, 'New SpecialNumberPlans added Successfully');

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
        $specialnumberplanss = SpecialNumberPlans::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $specialnumberplanss,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Name','Length','Pre Code','Price','Enable'
                ))->
                setFields(array(
                    'id','name','length','precode','price','enable'
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
        $item = SpecialNumberPlans::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'specialnumberplans',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = SpecialNumberPlans::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this SpecialNumberPlans item');
            } else {
                $this->flash->success('SpecialNumberPlans item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'specialnumberplans',
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
        $this->setTitle('Edit SpecialNumberPlans');

        $specialnumberplansItem = SpecialNumberPlans::findFirst($id);

        // create form
        $fr = new SpecialNumberPlansForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $specialnumberplans = SpecialNumberPlans::findFirst($id);
                                $specialnumberplans->name = $this->request->getPost('name', 'string');

                                $specialnumberplans->length = $this->request->getPost('length', 'string');

                                $specialnumberplans->precode = $this->request->getPost('precode', 'string');

                                $specialnumberplans->price = $this->request->getPost('price', 'string');

                                $specialnumberplans->enable = $this->request->getPost('enable', 'string');
                if (!$specialnumberplans->save()) {
                    $specialnumberplans->showErrorMessages($this);
                } else {
                    $specialnumberplans->showSuccessMessages($this, 'SpecialNumberPlans Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('name')->setDefault($specialnumberplansItem->name);
                        $fr->get('length')->setDefault($specialnumberplansItem->length);
                        $fr->get('precode')->setDefault($specialnumberplansItem->precode);
                        $fr->get('price')->setDefault($specialnumberplansItem->price);
                        $fr->get('enable')->setDefault($specialnumberplansItem->enable); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = SpecialNumberPlans::findFirst($id);
        $this->view->item = $item;

        $form = new SpecialNumberPlansForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('name')->setDefault($item->name);$form->get('length')->setDefault($item->length);$form->get('precode')->setDefault($item->precode);$form->get('price')->setDefault($item->price);$form->get('enable')->setDefault($item->enable);$this->view->form = $form;
        
    }

}
