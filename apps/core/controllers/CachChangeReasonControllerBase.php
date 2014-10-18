<?php
namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use CachChangeReason;
use Simpledom\Core\CachChangeReasonForm;


class CachChangeReasonControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('CachChangeReason');
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

        $fr = new CachChangeReasonForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $cachchangereason = new CachChangeReason();

                $cachchangereason->name = $this->request->getPost('name', 'string');
                $cachchangereason->description = $this->request->getPost('description', 'string');
                $cachchangereason->date = $this->request->getPost('date', 'string');
                if (!$cachchangereason->create()) {
                    $cachchangereason->showErrorMessages($this);
                } else {
                    $cachchangereason->showSuccessMessages($this, 'New CachChangeReason added Successfully');

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
        $cachchangereasons = CachChangeReason::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $cachchangereasons,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Name','Description','Date'
                ))->
                setFields(array(
                    'id','name','description','date'
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
        $item = CachChangeReason::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'cachchangereason',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = CachChangeReason::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this CachChangeReason item');
            } else {
                $this->flash->success('CachChangeReason item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'cachchangereason',
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
        $this->setTitle('Edit CachChangeReason');

        $cachchangereasonItem = CachChangeReason::findFirst($id);

        // create form
        $fr = new CachChangeReasonForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $cachchangereason = CachChangeReason::findFirst($id);
                                $cachchangereason->name = $this->request->getPost('name', 'string');

                                $cachchangereason->description = $this->request->getPost('description', 'string');

                                $cachchangereason->date = $this->request->getPost('date', 'string');
                if (!$cachchangereason->save()) {
                    $cachchangereason->showErrorMessages($this);
                } else {
                    $cachchangereason->showSuccessMessages($this, 'CachChangeReason Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('name')->setDefault($cachchangereasonItem->name);
                        $fr->get('description')->setDefault($cachchangereasonItem->description);
                        $fr->get('date')->setDefault($cachchangereasonItem->date); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = CachChangeReason::findFirst($id);
        $this->view->item = $item;

        $form = new CachChangeReasonForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('name')->setDefault($item->name);$form->get('description')->setDefault($item->description);$form->get('date')->setDefault($item->date);$this->view->form = $form;
        
    }

}
