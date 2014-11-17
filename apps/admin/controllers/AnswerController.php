<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use Answer;
use AnswerForm;

class AnswerController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Answer');
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

        $fr = new AnswerForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $answer = new \Answer();

                $answer->questionid = $this->request->getPost('questionid', 'string');
                $answer->userid = $this->request->getPost('userid', 'string');
                $answer->date = $this->request->getPost('date', 'string');
                $answer->message = $this->request->getPost('message', 'string');
                $answer->delete = $this->request->getPost('delete', 'string');
                if (!$answer->create()) {
                    $answer->showErrorMessages($this);
                } else {
                    $answer->showSuccessMessages($this, 'New Answer added Successfully');

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
        $answers = Answer::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $answers,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Question ID','User ID','Date','Message','Delete'
                ))->
                setFields(array(
                    'id','questionid','userid','getDate()','message','delete'
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
        $item = Answer::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'answer',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Answer::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Answer item');
            } else {
                $this->flash->success('Answer item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'answer',
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
        $this->setTitle('Edit Answer');

        $answerItem = Answer::findFirst($id);

        // create form
        $fr = new AnswerForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $answer = Answer::findFirst($id);
                                $answer->questionid = $this->request->getPost('questionid', 'string');

                                $answer->userid = $this->request->getPost('userid', 'string');

                                $answer->date = $this->request->getPost('date', 'string');

                                $answer->message = $this->request->getPost('message', 'string');

                                $answer->delete = $this->request->getPost('delete', 'string');
                if (!$answer->save()) {
                    $answer->showErrorMessages($this);
                } else {
                    $answer->showSuccessMessages($this, 'Answer Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('questionid')->setDefault($answerItem->questionid);
                        $fr->get('userid')->setDefault($answerItem->userid);
                        $fr->get('date')->setDefault($answerItem->date);
                        $fr->get('message')->setDefault($answerItem->message);
                        $fr->get('delete')->setDefault($answerItem->delete); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Answer::findFirst($id);
        $this->view->item = $item;

        $form = new AnswerForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('questionid')->setDefault($item->questionid);$form->get('userid')->setDefault($item->userid);$form->get('date')->setDefault($item->date);$form->get('message')->setDefault($item->message);$form->get('delete')->setDefault($item->delete);$this->view->form = $form;
        
    }

}
