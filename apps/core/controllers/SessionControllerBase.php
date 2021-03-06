<?php
namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use Session;
use Simpledom\Core\SessionForm;

class SessionControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Session');
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

        $fr = new SessionForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $session = new \Session();

                $session->userid = $this->request->getPost('userid', 'string');
                $session->ip = $this->request->getPost('ip', 'string');
                $session->agent = $this->request->getPost('agent', 'string');
                $session->session = $this->request->getPost('session', 'string');
                $session->date = $this->request->getPost('date', 'string');
                if (!$session->create()) {
                    $session->showErrorMessages($this);
                } else {
                    $session->showSuccessMessages($this, 'New Session added Successfully');

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
        $sessions = Session::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $sessions,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','User ID','IP','Agent','Session','Date'
                ))->
                setFields(array(
                    'id','userid','ip','agent','session','getDate()'
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
        $item = Session::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'session',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Session::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Session item');
            } else {
                $this->flash->success('Session item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'session',
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
        $this->setTitle('Edit Session');

        $sessionItem = Session::findFirst($id);

        // create form
        $fr = new SessionForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $session = Session::findFirst($id);
                                $session->userid = $this->request->getPost('userid', 'string');

                                $session->ip = $this->request->getPost('ip', 'string');

                                $session->agent = $this->request->getPost('agent', 'string');

                                $session->session = $this->request->getPost('session', 'string');

                                $session->date = $this->request->getPost('date', 'string');
                if (!$session->save()) {
                    $session->showErrorMessages($this);
                } else {
                    $session->showSuccessMessages($this, 'Session Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('userid')->setDefault($sessionItem->userid);
                        $fr->get('ip')->setDefault($sessionItem->ip);
                        $fr->get('agent')->setDefault($sessionItem->agent);
                        $fr->get('session')->setDefault($sessionItem->session);
                        $fr->get('date')->setDefault($sessionItem->date); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Session::findFirst($id);
        $this->view->item = $item;

        $form = new SessionForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('userid')->setDefault($item->userid);$form->get('ip')->setDefault($item->ip);$form->get('agent')->setDefault($item->agent);$form->get('session')->setDefault($item->session);$form->get('date')->setDefault($item->date);$this->view->form = $form;
        
    }

}
