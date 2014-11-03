<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use MelkCreatedBy;
use MelkCreatedByForm;

class MelkCreatedByController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('MelkCreatedBy');
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

        $fr = new MelkCreatedByForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melkcreatedby = new \MelkCreatedBy();

                $melkcreatedby->name = $this->request->getPost('name', 'string');
                $melkcreatedby->date = $this->request->getPost('date', 'string');
                if (!$melkcreatedby->create()) {
                    $melkcreatedby->showErrorMessages($this);
                } else {
                    $melkcreatedby->showSuccessMessages($this, 'New MelkCreatedBy added Successfully');

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
        $melkcreatedbys = MelkCreatedBy::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $melkcreatedbys,
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
                'melkcreatedby/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = MelkCreatedBy::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'melkcreatedby',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = MelkCreatedBy::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this MelkCreatedBy item');
            } else {
                $this->flash->success('MelkCreatedBy item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'melkcreatedby',
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
        $this->setTitle('Edit MelkCreatedBy');

        $melkcreatedbyItem = MelkCreatedBy::findFirst($id);

        // create form
        $fr = new MelkCreatedByForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melkcreatedby = MelkCreatedBy::findFirst($id);
                                $melkcreatedby->name = $this->request->getPost('name', 'string');

                                $melkcreatedby->date = $this->request->getPost('date', 'string');
                if (!$melkcreatedby->save()) {
                    $melkcreatedby->showErrorMessages($this);
                } else {
                    $melkcreatedby->showSuccessMessages($this, 'MelkCreatedBy Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('name')->setDefault($melkcreatedbyItem->name);
                        $fr->get('date')->setDefault($melkcreatedbyItem->date); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = MelkCreatedBy::findFirst($id);
        $this->view->item = $item;

        $form = new MelkCreatedByForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('name')->setDefault($item->name);$form->get('date')->setDefault($item->date);$this->view->form = $form;
        
    }

}
