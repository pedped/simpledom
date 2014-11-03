<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use MelkFacilities;
use MelkFacilitiesForm;

class MelkFacilitiesController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('MelkFacilities');
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

        $fr = new MelkFacilitiesForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melkfacilities = new \MelkFacilities();

                $melkfacilities->name = $this->request->getPost('name', 'string');
                $melkfacilities->date = $this->request->getPost('date', 'string');
                $melkfacilities->imageid = $this->request->getPost('imageid', 'string');
                if (!$melkfacilities->create()) {
                    $melkfacilities->showErrorMessages($this);
                } else {
                    $melkfacilities->showSuccessMessages($this, 'New MelkFacilities added Successfully');

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
        $melkfacilitiess = MelkFacilities::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $melkfacilitiess,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Name','Date','Image'
                ))->
                setFields(array(
                    'id','name','getDate()','imageid'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'melkfacilities/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = MelkFacilities::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'melkfacilities',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = MelkFacilities::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this MelkFacilities item');
            } else {
                $this->flash->success('MelkFacilities item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'melkfacilities',
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
        $this->setTitle('Edit MelkFacilities');

        $melkfacilitiesItem = MelkFacilities::findFirst($id);

        // create form
        $fr = new MelkFacilitiesForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melkfacilities = MelkFacilities::findFirst($id);
                                $melkfacilities->name = $this->request->getPost('name', 'string');

                                $melkfacilities->date = $this->request->getPost('date', 'string');

                                $melkfacilities->imageid = $this->request->getPost('imageid', 'string');
                if (!$melkfacilities->save()) {
                    $melkfacilities->showErrorMessages($this);
                } else {
                    $melkfacilities->showSuccessMessages($this, 'MelkFacilities Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('name')->setDefault($melkfacilitiesItem->name);
                        $fr->get('date')->setDefault($melkfacilitiesItem->date);
                        $fr->get('imageid')->setDefault($melkfacilitiesItem->imageid); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = MelkFacilities::findFirst($id);
        $this->view->item = $item;

        $form = new MelkFacilitiesForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('name')->setDefault($item->name);$form->get('date')->setDefault($item->date);$form->get('imageid')->setDefault($item->imageid);$this->view->form = $form;
        
    }

}
