<?php
namespace Simpledom\Frontend\Controllers;

use AtaPaginator;
use Post;
use PostForm;
use Simpledom\Frontend\BaseControllers\ControllerBase;

class PostController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setPageTitle('Post');
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

        $fr = new PostForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $post = new \Post();

                $post->organid = $this->request->getPost('organid', 'string');
                $post->name = $this->request->getPost('name', 'string');
                $post->key = $this->request->getPost('key', 'string');
                $post->smskey = $this->request->getPost('smskey', 'string');
                if (!$post->create()) {
                    $post->showErrorMessages($this);
                } else {
                    $post->showSuccessMessages($this, 'New Post added Successfully');

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
        $posts = Post::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $posts,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID','Organ ID','Name','Key','SMS Key'
                ))->
                setFields(array(
                    'id','organid','name','key','smskey'
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
        $item = Post::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'post',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Post::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Post item');
            } else {
                $this->flash->success('Post item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'post',
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
        $this->setTitle('Edit Post');

        $postItem = Post::findFirst($id);

        // create form
        $fr = new PostForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $post = Post::findFirst($id);
                                $post->organid = $this->request->getPost('organid', 'string');

                                $post->name = $this->request->getPost('name', 'string');

                                $post->key = $this->request->getPost('key', 'string');

                                $post->smskey = $this->request->getPost('smskey', 'string');
                if (!$post->save()) {
                    $post->showErrorMessages($this);
                } else {
                    $post->showSuccessMessages($this, 'Post Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
            
        }else{

        // set default values

                        $fr->get('organid')->setDefault($postItem->organid);
                        $fr->get('name')->setDefault($postItem->name);
                        $fr->get('key')->setDefault($postItem->key);
                        $fr->get('smskey')->setDefault($postItem->smskey); 
            }
            
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Post::findFirst($id);
        $this->view->item = $item;

        $form = new PostForm();
        $this->handleFormScripts($form);
$form->get('id')->setDefault($item->id);$form->get('organid')->setDefault($item->organid);$form->get('name')->setDefault($item->name);$form->get('key')->setDefault($item->key);$form->get('smskey')->setDefault($item->smskey);$this->view->form = $form;
        
    }

}
