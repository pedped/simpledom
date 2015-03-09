<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use Category;
use CategoryForm;
use Simpledom\Admin\BaseControllers\ControllerBase;

class CategoryController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('دسته ها');
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

        $fr = new CategoryForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $category = new \Category();

                $category->title = $this->request->getPost('title', 'string');
                $category->date = $this->request->getPost('date', 'string');
                $category->description = $this->request->getPost('description', 'string');
                if (!$category->create()) {
                    $category->showErrorMessages($this);
                } else {
                    $category->showSuccessMessages($this, 'دسته جدید با موفقیت اضافه گردید');

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
        $categorys = Category::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $categorys,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Title', 'Date', 'Description'
                ))->
                setFields(array(
                    'id', 'title', 'getDate()', 'description'
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
        $item = Category::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'category',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Category::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Category item');
            } else {
                $this->flash->success('Category item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'category',
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
        $this->setTitle('Edit Category');

        $categoryItem = Category::findFirst($id);

        // create form
        $fr = new CategoryForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $category = Category::findFirst($id);
                $category->title = $this->request->getPost('title', 'string');

                $category->date = $this->request->getPost('date', 'string');

                $category->description = $this->request->getPost('description', 'string');
                if (!$category->save()) {
                    $category->showErrorMessages($this);
                } else {
                    $category->showSuccessMessages($this, 'اطلاعات دسته با موفقیت ذخیره گردید');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('title')->setDefault($categoryItem->title);
            $fr->get('date')->setDefault($categoryItem->date);
            $fr->get('description')->setDefault($categoryItem->description);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Category::findFirst($id);
        $this->view->item = $item;

        $form = new CategoryForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('title')->setDefault($item->title);
        $form->get('date')->setDefault($item->date);
        $form->get('description')->setDefault($item->description);
        $this->view->form = $form;
    }

}
