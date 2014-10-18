<?php
namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use Simpledom\Core\TransactionTypeForm;
use TransactionType;


class TransactionTypeControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('TransactionType');
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

        $fr = new TransactionTypeForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $transactiontype = new TransactionType();

                $transactiontype->key = $this->request->getPost('key', 'string');
                $transactiontype->name = $this->request->getPost('name', 'string');
                if (!$transactiontype->create()) {
                    $transactiontype->showErrorMessages($this);
                } else {
                    $transactiontype->showSuccessMessages($this, 'New TransactionType added Successfully');

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
        $transactiontypes = TransactionType::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $transactiontypes,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Key','Name'
                ))->
                setFields(array(
                    'id','key','name'
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
        $item = TransactionType::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'transactiontype',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = TransactionType::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this TransactionType item');
            } else {
                $this->flash->success('TransactionType item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'transactiontype',
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
        $this->setTitle('Edit TransactionType');

        $transactiontypeItem = TransactionType::findFirst($id);

        // create form
        $fr = new TransactionTypeForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $transactiontype = TransactionType::findFirst($id);
                                $transactiontype->key = $this->request->getPost('key', 'string');

                                $transactiontype->name = $this->request->getPost('name', 'string');
                if (!$transactiontype->save()) {
                    $transactiontype->showErrorMessages($this);
                } else {
                    $transactiontype->showSuccessMessages($this, 'TransactionType Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('key')->setDefault($transactiontypeItem->key);
                        $fr->get('name')->setDefault($transactiontypeItem->name); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = TransactionType::findFirst($id);
        $this->view->item = $item;

        $form = new TransactionTypeForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('key')->setDefault($item->key);$form->get('name')->setDefault($item->name);$this->view->form = $form;
        
    }

}
