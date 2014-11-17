<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use MoshaverDegree;
use MoshaverDegreeForm;

class MoshaverDegreeController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('MoshaverDegree');
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

        $fr = new MoshaverDegreeForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $moshaverdegree = new \MoshaverDegree();

                $moshaverdegree->name = $this->request->getPost('name', 'string');
                if (!$moshaverdegree->create()) {
                    $moshaverdegree->showErrorMessages($this);
                } else {
                    $moshaverdegree->showSuccessMessages($this, 'New MoshaverDegree added Successfully');

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
        $moshaverdegrees = MoshaverDegree::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $moshaverdegrees,
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
        $item = MoshaverDegree::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'moshaverdegree',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = MoshaverDegree::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this MoshaverDegree item');
            } else {
                $this->flash->success('MoshaverDegree item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'moshaverdegree',
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
        $this->setTitle('Edit MoshaverDegree');

        $moshaverdegreeItem = MoshaverDegree::findFirst($id);

        // create form
        $fr = new MoshaverDegreeForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $moshaverdegree = MoshaverDegree::findFirst($id);
                                $moshaverdegree->name = $this->request->getPost('name', 'string');
                if (!$moshaverdegree->save()) {
                    $moshaverdegree->showErrorMessages($this);
                } else {
                    $moshaverdegree->showSuccessMessages($this, 'MoshaverDegree Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('name')->setDefault($moshaverdegreeItem->name); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = MoshaverDegree::findFirst($id);
        $this->view->item = $item;

        $form = new MoshaverDegreeForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('name')->setDefault($item->name);$this->view->form = $form;
        
    }

}
