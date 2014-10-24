<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use MelkSubscriber;
use MelkSubscriberForm;

class MelkSubscriberController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('MelkSubscriber');
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

        $fr = new MelkSubscriberForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melksubscriber = new \MelkSubscriber();

                $melksubscriber->userid = $this->request->getPost('userid', 'string');
                $melksubscriber->melksubscribeitemid = $this->request->getPost('melksubscribeitemid', 'string');
                $melksubscriber->date = $this->request->getPost('date', 'string');
                $melksubscriber->orderid = $this->request->getPost('orderid', 'string');
                if (!$melksubscriber->create()) {
                    $melksubscriber->showErrorMessages($this);
                } else {
                    $melksubscriber->showSuccessMessages($this, 'New MelkSubscriber added Successfully');

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
        $melksubscribers = MelkSubscriber::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $melksubscribers,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','User ID','Melk Subscribe ID','Date','Order ID'
                ))->
                setFields(array(
                    'id','userid','melksubscribeitemid','getDate()','orderid'
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
        $item = MelkSubscriber::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'melksubscriber',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = MelkSubscriber::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this MelkSubscriber item');
            } else {
                $this->flash->success('MelkSubscriber item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'melksubscriber',
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
        $this->setTitle('Edit MelkSubscriber');

        $melksubscriberItem = MelkSubscriber::findFirst($id);

        // create form
        $fr = new MelkSubscriberForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melksubscriber = MelkSubscriber::findFirst($id);
                                $melksubscriber->userid = $this->request->getPost('userid', 'string');

                                $melksubscriber->melksubscribeitemid = $this->request->getPost('melksubscribeitemid', 'string');

                                $melksubscriber->date = $this->request->getPost('date', 'string');

                                $melksubscriber->orderid = $this->request->getPost('orderid', 'string');
                if (!$melksubscriber->save()) {
                    $melksubscriber->showErrorMessages($this);
                } else {
                    $melksubscriber->showSuccessMessages($this, 'MelkSubscriber Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('userid')->setDefault($melksubscriberItem->userid);
                        $fr->get('melksubscribeitemid')->setDefault($melksubscriberItem->melksubscribeitemid);
                        $fr->get('date')->setDefault($melksubscriberItem->date);
                        $fr->get('orderid')->setDefault($melksubscriberItem->orderid); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = MelkSubscriber::findFirst($id);
        $this->view->item = $item;

        $form = new MelkSubscriberForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('userid')->setDefault($item->userid);$form->get('melksubscribeitemid')->setDefault($item->melksubscribeitemid);$form->get('date')->setDefault($item->date);$form->get('orderid')->setDefault($item->orderid);$this->view->form = $form;
        
    }

}
