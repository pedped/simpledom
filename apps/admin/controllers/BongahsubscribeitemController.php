<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use BongahSubscribeItem;
use BongahSubscribeItemForm;

class BongahSubscribeItemController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('BongahSubscribeItem');
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

        $fr = new BongahSubscribeItemForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $bongahsubscribeitem = new \BongahSubscribeItem();

                $bongahsubscribeitem->name = $this->request->getPost('name', 'string');
                $bongahsubscribeitem->description = $this->request->getPost('description', 'string');
                $bongahsubscribeitem->melkscanadd = $this->request->getPost('melkscanadd', 'string');
                $bongahsubscribeitem->price = $this->request->getPost('price', 'string');
                $bongahsubscribeitem->validdate = $this->request->getPost('validdate', 'string');
                $bongahsubscribeitem->sendmessagetousers = $this->request->getPost('sendmessagetousers', 'string');
                $bongahsubscribeitem->featured = $this->request->getPost('featured', 'string');
                $bongahsubscribeitem->canseeuserphone = $this->request->getPost('canseeuserphone', 'string');
                $bongahsubscribeitem->defaultsmscredit = $this->request->getPost('defaultsmscredit', 'string');
                $bongahsubscribeitem->receiveportal = $this->request->getPost('receiveportal', 'string');
                $bongahsubscribeitem->enable = $this->request->getPost('enable', 'string');
                if (!$bongahsubscribeitem->create()) {
                    $bongahsubscribeitem->showErrorMessages($this);
                } else {
                    $bongahsubscribeitem->showSuccessMessages($this, 'New BongahSubscribeItem added Successfully');

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
        $bongahsubscribeitems = BongahSubscribeItem::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $bongahsubscribeitems,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Name','Description','Melks Can Add','Price','Valid Days','Send Message To Users','Featured','Can See User Phone','Default SMS Credit','Receive Portal','Enable'
                ))->
                setFields(array(
                    'id','name','description','melkscanadd','price','validdate','sendmessagetousers','featured','canseeuserphone','defaultsmscredit','receiveportal','enable'
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
        $item = BongahSubscribeItem::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'bongahsubscribeitem',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = BongahSubscribeItem::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this BongahSubscribeItem item');
            } else {
                $this->flash->success('BongahSubscribeItem item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'bongahsubscribeitem',
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
        $this->setTitle('Edit BongahSubscribeItem');

        $bongahsubscribeitemItem = BongahSubscribeItem::findFirst($id);

        // create form
        $fr = new BongahSubscribeItemForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $bongahsubscribeitem = BongahSubscribeItem::findFirst($id);
                                $bongahsubscribeitem->name = $this->request->getPost('name', 'string');

                                $bongahsubscribeitem->description = $this->request->getPost('description', 'string');

                                $bongahsubscribeitem->melkscanadd = $this->request->getPost('melkscanadd', 'string');

                                $bongahsubscribeitem->price = $this->request->getPost('price', 'string');

                                $bongahsubscribeitem->validdate = $this->request->getPost('validdate', 'string');

                                $bongahsubscribeitem->sendmessagetousers = $this->request->getPost('sendmessagetousers', 'string');

                                $bongahsubscribeitem->featured = $this->request->getPost('featured', 'string');

                                $bongahsubscribeitem->canseeuserphone = $this->request->getPost('canseeuserphone', 'string');

                                $bongahsubscribeitem->defaultsmscredit = $this->request->getPost('defaultsmscredit', 'string');

                                $bongahsubscribeitem->receiveportal = $this->request->getPost('receiveportal', 'string');

                                $bongahsubscribeitem->enable = $this->request->getPost('enable', 'string');
                if (!$bongahsubscribeitem->save()) {
                    $bongahsubscribeitem->showErrorMessages($this);
                } else {
                    $bongahsubscribeitem->showSuccessMessages($this, 'BongahSubscribeItem Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('name')->setDefault($bongahsubscribeitemItem->name);
                        $fr->get('description')->setDefault($bongahsubscribeitemItem->description);
                        $fr->get('melkscanadd')->setDefault($bongahsubscribeitemItem->melkscanadd);
                        $fr->get('price')->setDefault($bongahsubscribeitemItem->price);
                        $fr->get('validdate')->setDefault($bongahsubscribeitemItem->validdate);
                        $fr->get('sendmessagetousers')->setDefault($bongahsubscribeitemItem->sendmessagetousers);
                        $fr->get('featured')->setDefault($bongahsubscribeitemItem->featured);
                        $fr->get('canseeuserphone')->setDefault($bongahsubscribeitemItem->canseeuserphone);
                        $fr->get('defaultsmscredit')->setDefault($bongahsubscribeitemItem->defaultsmscredit);
                        $fr->get('receiveportal')->setDefault($bongahsubscribeitemItem->receiveportal);
                        $fr->get('enable')->setDefault($bongahsubscribeitemItem->enable); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = BongahSubscribeItem::findFirst($id);
        $this->view->item = $item;

        $form = new BongahSubscribeItemForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('name')->setDefault($item->name);$form->get('description')->setDefault($item->description);$form->get('melkscanadd')->setDefault($item->melkscanadd);$form->get('price')->setDefault($item->price);$form->get('validdate')->setDefault($item->validdate);$form->get('sendmessagetousers')->setDefault($item->sendmessagetousers);$form->get('featured')->setDefault($item->featured);$form->get('canseeuserphone')->setDefault($item->canseeuserphone);$form->get('defaultsmscredit')->setDefault($item->defaultsmscredit);$form->get('receiveportal')->setDefault($item->receiveportal);$form->get('enable')->setDefault($item->enable);$this->view->form = $form;
        
    }

}
