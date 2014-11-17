<?php
namespace Simpledom\Admin\Controllers;
    use Simpledom\Admin\BaseControllers\ControllerBase;

use AtaPaginator;
use Question;
use QuestionForm;

class QuestionController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Question');
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

        $fr = new QuestionForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $question = new \Question();

                $question->userid = $this->request->getPost('userid', 'string');
                $question->moshaverid = $this->request->getPost('moshaverid', 'string');
                $question->question = $this->request->getPost('question', 'string');
                $question->aboutyourself = $this->request->getPost('aboutyourself', 'string');
                $question->disorderhistory = $this->request->getPost('disorderhistory', 'string');
                $question->usingtablet = $this->request->getPost('usingtablet', 'string');
                $question->cityid = $this->request->getPost('cityid', 'string');
                $question->date = $this->request->getPost('date', 'string');
                if (!$question->create()) {
                    $question->showErrorMessages($this);
                } else {
                    $question->showSuccessMessages($this, 'New Question added Successfully');

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
        $questions = Question::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $questions,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','User ID','Moshaver ID','Question','About Yourself','Disorder History','Using Tablet','City ID','Date'
                ))->
                setFields(array(
                    'id','userid','moshaverid','question','aboutyourself','disorderhistory','usingtablet','cityid','getDate()'
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
        $item = Question::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'question',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Question::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Question item');
            } else {
                $this->flash->success('Question item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'question',
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
        $this->setTitle('Edit Question');

        $questionItem = Question::findFirst($id);

        // create form
        $fr = new QuestionForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $question = Question::findFirst($id);
                                $question->userid = $this->request->getPost('userid', 'string');

                                $question->moshaverid = $this->request->getPost('moshaverid', 'string');

                                $question->question = $this->request->getPost('question', 'string');

                                $question->aboutyourself = $this->request->getPost('aboutyourself', 'string');

                                $question->disorderhistory = $this->request->getPost('disorderhistory', 'string');

                                $question->usingtablet = $this->request->getPost('usingtablet', 'string');

                                $question->cityid = $this->request->getPost('cityid', 'string');

                                $question->date = $this->request->getPost('date', 'string');
                if (!$question->save()) {
                    $question->showErrorMessages($this);
                } else {
                    $question->showSuccessMessages($this, 'Question Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('userid')->setDefault($questionItem->userid);
                        $fr->get('moshaverid')->setDefault($questionItem->moshaverid);
                        $fr->get('question')->setDefault($questionItem->question);
                        $fr->get('aboutyourself')->setDefault($questionItem->aboutyourself);
                        $fr->get('disorderhistory')->setDefault($questionItem->disorderhistory);
                        $fr->get('usingtablet')->setDefault($questionItem->usingtablet);
                        $fr->get('cityid')->setDefault($questionItem->cityid);
                        $fr->get('date')->setDefault($questionItem->date); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Question::findFirst($id);
        $this->view->item = $item;

        $form = new QuestionForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('userid')->setDefault($item->userid);$form->get('moshaverid')->setDefault($item->moshaverid);$form->get('question')->setDefault($item->question);$form->get('aboutyourself')->setDefault($item->aboutyourself);$form->get('disorderhistory')->setDefault($item->disorderhistory);$form->get('usingtablet')->setDefault($item->usingtablet);$form->get('cityid')->setDefault($item->cityid);$form->get('date')->setDefault($item->date);$this->view->form = $form;
        
    }

}
