<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use MoshaverSale;
use MoshaverSaleForm;

class MoshaverSaleController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('MoshaverSale');
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

        $fr = new MoshaverSaleForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $moshaversale = new \MoshaverSale();

                $moshaversale->userid = $this->request->getPost('userid', 'string');
                $moshaversale->orderid = $this->request->getPost('orderid', 'string');
                $moshaversale->percent = $this->request->getPost('percent', 'string');
                $moshaversale->value = $this->request->getPost('value', 'string');
                $moshaversale->date = $this->request->getPost('date', 'string');
                if (!$moshaversale->create()) {
                    $moshaversale->showErrorMessages($this);
                } else {
                    $moshaversale->showSuccessMessages($this, 'New MoshaverSale added Successfully');

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
        $moshaversales = MoshaverSale::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $moshaversales,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','User ID','Order ID','Percent','Value','Date'
                ))->
                setFields(array(
                    'id','userid','orderid','percent','value','getDate()'
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
        $item = MoshaverSale::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'moshaversale',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = MoshaverSale::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this MoshaverSale item');
            } else {
                $this->flash->success('MoshaverSale item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'moshaversale',
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
        $this->setTitle('Edit MoshaverSale');

        $moshaversaleItem = MoshaverSale::findFirst($id);

        // create form
        $fr = new MoshaverSaleForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $moshaversale = MoshaverSale::findFirst($id);
                                $moshaversale->userid = $this->request->getPost('userid', 'string');

                                $moshaversale->orderid = $this->request->getPost('orderid', 'string');

                                $moshaversale->percent = $this->request->getPost('percent', 'string');

                                $moshaversale->value = $this->request->getPost('value', 'string');

                                $moshaversale->date = $this->request->getPost('date', 'string');
                if (!$moshaversale->save()) {
                    $moshaversale->showErrorMessages($this);
                } else {
                    $moshaversale->showSuccessMessages($this, 'MoshaverSale Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('userid')->setDefault($moshaversaleItem->userid);
                        $fr->get('orderid')->setDefault($moshaversaleItem->orderid);
                        $fr->get('percent')->setDefault($moshaversaleItem->percent);
                        $fr->get('value')->setDefault($moshaversaleItem->value);
                        $fr->get('date')->setDefault($moshaversaleItem->date); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = MoshaverSale::findFirst($id);
        $this->view->item = $item;

        $form = new MoshaverSaleForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('userid')->setDefault($item->userid);$form->get('orderid')->setDefault($item->orderid);$form->get('percent')->setDefault($item->percent);$form->get('value')->setDefault($item->value);$form->get('date')->setDefault($item->date);$this->view->form = $form;
        
    }

}
