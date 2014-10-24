<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use MelkSubscribeItem;
use MelkSubscribeItemForm;

class MelkSubscribeItemController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('MelkSubscribeItem');
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

        $fr = new MelkSubscribeItemForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melksubscribeitem = new \MelkSubscribeItem();

                $melksubscribeitem->name = $this->request->getPost('name', 'string');
                $melksubscribeitem->description = $this->request->getPost('description', 'string');
                $melksubscribeitem->melkscanadd = $this->request->getPost('melkscanadd', 'string');
                $melksubscribeitem->price = $this->request->getPost('price', 'string');
                $melksubscribeitem->validdate = $this->request->getPost('validdate', 'string');
                $melksubscribeitem->sendmessagetousers = $this->request->getPost('sendmessagetousers', 'string');
                $melksubscribeitem->featured = $this->request->getPost('featured', 'string');
                $melksubscribeitem->enable = $this->request->getPost('enable', 'string');
                if (!$melksubscribeitem->create()) {
                    $melksubscribeitem->showErrorMessages($this);
                } else {
                    $melksubscribeitem->showSuccessMessages($this, 'New MelkSubscribeItem added Successfully');

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
        $melksubscribeitems = MelkSubscribeItem::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $melksubscribeitems,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Name','Description','Melk Can Add','Price','Valid Date','Send SMS to Users','Featured','Enable'
                ))->
                setFields(array(
                    'id','name','description','melkscanadd','price','validdate','sendmessagetousers','featured','enable'
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
        $item = MelkSubscribeItem::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'melksubscribeitem',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = MelkSubscribeItem::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this MelkSubscribeItem item');
            } else {
                $this->flash->success('MelkSubscribeItem item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'melksubscribeitem',
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
        $this->setTitle('Edit MelkSubscribeItem');

        $melksubscribeitemItem = MelkSubscribeItem::findFirst($id);

        // create form
        $fr = new MelkSubscribeItemForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melksubscribeitem = MelkSubscribeItem::findFirst($id);
                                $melksubscribeitem->name = $this->request->getPost('name', 'string');

                                $melksubscribeitem->description = $this->request->getPost('description', 'string');

                                $melksubscribeitem->melkscanadd = $this->request->getPost('melkscanadd', 'string');

                                $melksubscribeitem->price = $this->request->getPost('price', 'string');

                                $melksubscribeitem->validdate = $this->request->getPost('validdate', 'string');

                                $melksubscribeitem->sendmessagetousers = $this->request->getPost('sendmessagetousers', 'string');

                                $melksubscribeitem->featured = $this->request->getPost('featured', 'string');

                                $melksubscribeitem->enable = $this->request->getPost('enable', 'string');
                if (!$melksubscribeitem->save()) {
                    $melksubscribeitem->showErrorMessages($this);
                } else {
                    $melksubscribeitem->showSuccessMessages($this, 'MelkSubscribeItem Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('name')->setDefault($melksubscribeitemItem->name);
                        $fr->get('description')->setDefault($melksubscribeitemItem->description);
                        $fr->get('melkscanadd')->setDefault($melksubscribeitemItem->melkscanadd);
                        $fr->get('price')->setDefault($melksubscribeitemItem->price);
                        $fr->get('validdate')->setDefault($melksubscribeitemItem->validdate);
                        $fr->get('sendmessagetousers')->setDefault($melksubscribeitemItem->sendmessagetousers);
                        $fr->get('featured')->setDefault($melksubscribeitemItem->featured);
                        $fr->get('enable')->setDefault($melksubscribeitemItem->enable); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = MelkSubscribeItem::findFirst($id);
        $this->view->item = $item;

        $form = new MelkSubscribeItemForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('name')->setDefault($item->name);$form->get('description')->setDefault($item->description);$form->get('melkscanadd')->setDefault($item->melkscanadd);$form->get('price')->setDefault($item->price);$form->get('validdate')->setDefault($item->validdate);$form->get('sendmessagetousers')->setDefault($item->sendmessagetousers);$form->get('featured')->setDefault($item->featured);$form->get('enable')->setDefault($item->enable);$this->view->form = $form;
        
    }

}
