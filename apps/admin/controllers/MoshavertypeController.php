<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use MoshaverType;
use MoshaverTypeForm;

class MoshaverTypeController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('MoshaverType');
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

        $fr = new MoshaverTypeForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $moshavertype = new \MoshaverType();

                $moshavertype->name = $this->request->getPost('name', 'string');
                $moshavertype->description = $this->request->getPost('description', 'string');
                $moshavertype->enable = $this->request->getPost('enable', 'string');
                $moshavertype->imageid = $this->request->getPost('imageid', 'string');
                if (!$moshavertype->create()) {
                    $moshavertype->showErrorMessages($this);
                } else {
                    $moshavertype->showSuccessMessages($this, 'New MoshaverType added Successfully');

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
        $moshavertypes = MoshaverType::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $moshavertypes,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Name','Description','Enable','Image ID'
                ))->
                setFields(array(
                    'id','name','description','enable','imageid'
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
        $item = MoshaverType::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'moshavertype',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = MoshaverType::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this MoshaverType item');
            } else {
                $this->flash->success('MoshaverType item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'moshavertype',
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
        $this->setTitle('Edit MoshaverType');

        $moshavertypeItem = MoshaverType::findFirst($id);

        // create form
        $fr = new MoshaverTypeForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $moshavertype = MoshaverType::findFirst($id);
                                $moshavertype->name = $this->request->getPost('name', 'string');

                                $moshavertype->description = $this->request->getPost('description', 'string');

                                $moshavertype->enable = $this->request->getPost('enable', 'string');

                                $moshavertype->imageid = $this->request->getPost('imageid', 'string');
                if (!$moshavertype->save()) {
                    $moshavertype->showErrorMessages($this);
                } else {
                    $moshavertype->showSuccessMessages($this, 'MoshaverType Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('name')->setDefault($moshavertypeItem->name);
                        $fr->get('description')->setDefault($moshavertypeItem->description);
                        $fr->get('enable')->setDefault($moshavertypeItem->enable);
                        $fr->get('imageid')->setDefault($moshavertypeItem->imageid); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = MoshaverType::findFirst($id);
        $this->view->item = $item;

        $form = new MoshaverTypeForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('name')->setDefault($item->name);$form->get('description')->setDefault($item->description);$form->get('enable')->setDefault($item->enable);$form->get('imageid')->setDefault($item->imageid);$this->view->form = $form;
        
    }

}
