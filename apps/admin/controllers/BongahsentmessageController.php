<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use BongahSentMessage;
use BongahSentMessageForm;

class BongahSentMessageController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('BongahSentMessage');
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

        $fr = new BongahSentMessageForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $bongahsentmessage = new \BongahSentMessage();

                $bongahsentmessage->bongahid = $this->request->getPost('bongahid', 'string');
                $bongahsentmessage->bongahtitle = $this->request->getPost('bongahtitle', 'string');
                $bongahsentmessage->tophone = $this->request->getPost('tophone', 'string');
                $bongahsentmessage->message = $this->request->getPost('message', 'string');
                $bongahsentmessage->date = $this->request->getPost('date', 'string');
                $bongahsentmessage->smsmessageid = $this->request->getPost('smsmessageid', 'string');
                $bongahsentmessage->received = $this->request->getPost('received', 'string');
                $bongahsentmessage->bongahphone = $this->request->getPost('bongahphone', 'string');
                $bongahsentmessage->distance = $this->request->getPost('distance', 'string');
                $bongahsentmessage->type = $this->request->getPost('type', 'string');
                if (!$bongahsentmessage->create()) {
                    $bongahsentmessage->showErrorMessages($this);
                } else {
                    $bongahsentmessage->showSuccessMessages($this, 'New BongahSentMessage added Successfully');

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
        $bongahsentmessages = BongahSentMessage::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $bongahsentmessages,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Bongah ID','Bongah Title','To Phone','Message','Date','SMS Message ID','Received','Bongah Phone','Distance','Type'
                ))->
                setFields(array(
                    'id','bongahid','bongahtitle','tophone','message','getDate()','smsmessageid','received','bongahphone','distance','type'
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
        $item = BongahSentMessage::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'bongahsentmessage',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = BongahSentMessage::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this BongahSentMessage item');
            } else {
                $this->flash->success('BongahSentMessage item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'bongahsentmessage',
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
        $this->setTitle('Edit BongahSentMessage');

        $bongahsentmessageItem = BongahSentMessage::findFirst($id);

        // create form
        $fr = new BongahSentMessageForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $bongahsentmessage = BongahSentMessage::findFirst($id);
                                $bongahsentmessage->bongahid = $this->request->getPost('bongahid', 'string');

                                $bongahsentmessage->bongahtitle = $this->request->getPost('bongahtitle', 'string');

                                $bongahsentmessage->tophone = $this->request->getPost('tophone', 'string');

                                $bongahsentmessage->message = $this->request->getPost('message', 'string');

                                $bongahsentmessage->date = $this->request->getPost('date', 'string');

                                $bongahsentmessage->smsmessageid = $this->request->getPost('smsmessageid', 'string');

                                $bongahsentmessage->received = $this->request->getPost('received', 'string');

                                $bongahsentmessage->bongahphone = $this->request->getPost('bongahphone', 'string');

                                $bongahsentmessage->distance = $this->request->getPost('distance', 'string');

                                $bongahsentmessage->type = $this->request->getPost('type', 'string');
                if (!$bongahsentmessage->save()) {
                    $bongahsentmessage->showErrorMessages($this);
                } else {
                    $bongahsentmessage->showSuccessMessages($this, 'BongahSentMessage Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('bongahid')->setDefault($bongahsentmessageItem->bongahid);
                        $fr->get('bongahtitle')->setDefault($bongahsentmessageItem->bongahtitle);
                        $fr->get('tophone')->setDefault($bongahsentmessageItem->tophone);
                        $fr->get('message')->setDefault($bongahsentmessageItem->message);
                        $fr->get('date')->setDefault($bongahsentmessageItem->date);
                        $fr->get('smsmessageid')->setDefault($bongahsentmessageItem->smsmessageid);
                        $fr->get('received')->setDefault($bongahsentmessageItem->received);
                        $fr->get('bongahphone')->setDefault($bongahsentmessageItem->bongahphone);
                        $fr->get('distance')->setDefault($bongahsentmessageItem->distance);
                        $fr->get('type')->setDefault($bongahsentmessageItem->type); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = BongahSentMessage::findFirst($id);
        $this->view->item = $item;

        $form = new BongahSentMessageForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('bongahid')->setDefault($item->bongahid);$form->get('bongahtitle')->setDefault($item->bongahtitle);$form->get('tophone')->setDefault($item->tophone);$form->get('message')->setDefault($item->message);$form->get('date')->setDefault($item->date);$form->get('smsmessageid')->setDefault($item->smsmessageid);$form->get('received')->setDefault($item->received);$form->get('bongahphone')->setDefault($item->bongahphone);$form->get('distance')->setDefault($item->distance);$form->get('type')->setDefault($item->type);$this->view->form = $form;
        
    }

}
