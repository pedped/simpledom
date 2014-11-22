<?php

namespace Simpledom\Admin\BaseControllers;

use Article;
use AtaPaginator;
use Simpledom\Core\ArticleForm;

class ArticleControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Article');
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

        $fr = new ArticleForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $article = new \Article();

                $article->link = $this->request->getPost('link', 'string');
                $article->title = $this->request->getPost('title', 'string');
                $article->text = $this->request->getPost('text', 'string');
                $article->userid = $this->request->getPost('userid', 'string');
                $article->date = $this->request->getPost('date', 'string');
                $article->approved = $this->request->getPost('approved', 'string');
                $article->delete = $this->request->getPost('delete', 'string');
                if (!$article->create()) {
                    $article->showErrorMessages($this);
                } else {
                    $article->showSuccessMessages($this, 'New Article added Successfully');

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
        $articles = Article::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $articles,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Title', 'Text', 'User ID', 'Date', 'Approved', 'Link', 'Delete'
                ))->
                setFields(array(
                    'id', 'title', 'text', 'userid', 'getDate()', 'approved', 'link', 'delete'
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
        $item = Article::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'article',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Article::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Article item');
            } else {
                $this->flash->success('Article item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'article',
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
        $this->setTitle('Edit Article');

        $articleItem = Article::findFirst($id);

        // create form
        $fr = new ArticleForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $article = Article::findFirst($id);
                $article->title = $this->request->getPost('title', 'string');

                $article->text = $this->request->getPost('text', 'string');

                $article->userid = $this->request->getPost('userid', 'string');

                $article->link = $this->request->getPost('link', 'string');

                $article->date = $this->request->getPost('date', 'string');

                $article->approved = $this->request->getPost('approved', 'string');

                $article->delete = $this->request->getPost('delete', 'string');
                if (!$article->save()) {
                    $article->showErrorMessages($this);
                } else {
                    $article->showSuccessMessages($this, 'Article Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('title')->setDefault($articleItem->title);
            $fr->get('text')->setDefault($articleItem->text);
            $fr->get('userid')->setDefault($articleItem->userid);
            $fr->get('date')->setDefault($articleItem->date);
            $fr->get('link')->setDefault($articleItem->link);
            $fr->get('approved')->setDefault($articleItem->approved);
            $fr->get('delete')->setDefault($articleItem->delete);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Article::findFirst($id);
        $this->view->item = $item;

        $form = new ArticleForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('title')->setDefault($item->title);
        $form->get('text')->setDefault($item->text);
        $form->get('userid')->setDefault($item->userid);
        $form->get('date')->setDefault($item->date);
        $form->get('approved')->setDefault($item->approved);
        $form->get('link')->setDefault($item->link);
        $form->get('delete')->setDefault($item->delete);
        $this->view->form = $form;
    }

}
