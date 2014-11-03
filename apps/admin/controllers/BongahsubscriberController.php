<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use BongahSubscriber;
use BongahSubscriberForm;

class BongahSubscriberController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('BongahSubscriber');
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

        $fr = new BongahSubscriberForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $bongahsubscriber = new \BongahSubscriber();

                $bongahsubscriber->userid = $this->request->getPost('userid', 'string');
                $bongahsubscriber->bongahsubscribeitemid = $this->request->getPost('bongahsubscribeitemid', 'string');
                $bongahsubscriber->date = $this->request->getPost('date', 'string');
                $bongahsubscriber->orderid = $this->request->getPost('orderid', 'string');
                if (!$bongahsubscriber->create()) {
                    $bongahsubscriber->showErrorMessages($this);
                } else {
                    $bongahsubscriber->showSuccessMessages($this, 'New BongahSubscriber added Successfully');

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
        $bongahsubscribers = BongahSubscriber::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $bongahsubscribers,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','User ID','Bongah Subscribe Item','Date','Order ID'
                ))->
                setFields(array(
                    'id','userid','bongahsubscribeitemid','getDate()','orderid'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'bongahsubscriber/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = BongahSubscriber::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'bongahsubscriber',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = BongahSubscriber::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this BongahSubscriber item');
            } else {
                $this->flash->success('BongahSubscriber item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'bongahsubscriber',
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
        $this->setTitle('Edit BongahSubscriber');

        $bongahsubscriberItem = BongahSubscriber::findFirst($id);

        // create form
        $fr = new BongahSubscriberForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $bongahsubscriber = BongahSubscriber::findFirst($id);
                                $bongahsubscriber->userid = $this->request->getPost('userid', 'string');

                                $bongahsubscriber->bongahsubscribeitemid = $this->request->getPost('bongahsubscribeitemid', 'string');

                                $bongahsubscriber->date = $this->request->getPost('date', 'string');

                                $bongahsubscriber->orderid = $this->request->getPost('orderid', 'string');
                if (!$bongahsubscriber->save()) {
                    $bongahsubscriber->showErrorMessages($this);
                } else {
                    $bongahsubscriber->showSuccessMessages($this, 'BongahSubscriber Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('userid')->setDefault($bongahsubscriberItem->userid);
                        $fr->get('bongahsubscribeitemid')->setDefault($bongahsubscriberItem->bongahsubscribeitemid);
                        $fr->get('date')->setDefault($bongahsubscriberItem->date);
                        $fr->get('orderid')->setDefault($bongahsubscriberItem->orderid); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = BongahSubscriber::findFirst($id);
        $this->view->item = $item;

        $form = new BongahSubscriberForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('userid')->setDefault($item->userid);$form->get('bongahsubscribeitemid')->setDefault($item->bongahsubscribeitemid);$form->get('date')->setDefault($item->date);$form->get('orderid')->setDefault($item->orderid);$this->view->form = $form;
        
    }

}
