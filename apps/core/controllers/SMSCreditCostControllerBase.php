<?php
namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use SMSCreditCost;
use Simpledom\Core\SMSCreditCostForm;

class SMSCreditCostControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('SMSCreditCost');
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

        $fr = new SMSCreditCostForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $smscreditcost = new \SMSCreditCost();

                $smscreditcost->title = $this->request->getPost('title', 'string');
                $smscreditcost->description = $this->request->getPost('description', 'string');
                $smscreditcost->totalsms = $this->request->getPost('totalsms', 'string');
                $smscreditcost->price = $this->request->getPost('price', 'string');
                $smscreditcost->date = $this->request->getPost('date', 'string');
                if (!$smscreditcost->create()) {
                    $smscreditcost->showErrorMessages($this);
                } else {
                    $smscreditcost->showSuccessMessages($this, 'New SMSCreditCost added Successfully');

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
        $smscreditcosts = SMSCreditCost::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $smscreditcosts,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Title','Description','Total SMS Can Send','Price','Date'
                ))->
                setFields(array(
                    'id','title','description','totalsms','price','getDate()'
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
        $item = SMSCreditCost::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'smscreditcost',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = SMSCreditCost::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this SMSCreditCost item');
            } else {
                $this->flash->success('SMSCreditCost item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'smscreditcost',
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
        $this->setTitle('Edit SMSCreditCost');

        $smscreditcostItem = SMSCreditCost::findFirst($id);

        // create form
        $fr = new SMSCreditCostForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $smscreditcost = SMSCreditCost::findFirst($id);
                                $smscreditcost->title = $this->request->getPost('title', 'string');

                                $smscreditcost->description = $this->request->getPost('description', 'string');

                                $smscreditcost->totalsms = $this->request->getPost('totalsms', 'string');

                                $smscreditcost->price = $this->request->getPost('price', 'string');

                                $smscreditcost->date = $this->request->getPost('date', 'string');
                if (!$smscreditcost->save()) {
                    $smscreditcost->showErrorMessages($this);
                } else {
                    $smscreditcost->showSuccessMessages($this, 'SMSCreditCost Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('title')->setDefault($smscreditcostItem->title);
                        $fr->get('description')->setDefault($smscreditcostItem->description);
                        $fr->get('totalsms')->setDefault($smscreditcostItem->totalsms);
                        $fr->get('price')->setDefault($smscreditcostItem->price);
                        $fr->get('date')->setDefault($smscreditcostItem->date); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = SMSCreditCost::findFirst($id);
        $this->view->item = $item;

        $form = new SMSCreditCostForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('title')->setDefault($item->title);$form->get('description')->setDefault($item->description);$form->get('totalsms')->setDefault($item->totalsms);$form->get('price')->setDefault($item->price);$form->get('date')->setDefault($item->date);$this->view->form = $form;
        
    }

}
