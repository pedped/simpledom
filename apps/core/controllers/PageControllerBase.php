<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use Page;
use Simpledom\Core\PageForm;

class PageControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Page');
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

        $fr = new PageForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $page = new Page();

                $page->key = $this->request->getPost('key', 'string');
                $page->title = $this->request->getPost('title', 'string');
                $page->text = $this->request->getPost('text', 'string');
                $page->metakey = $this->request->getPost('metakey', 'string');
                $page->metadata = $this->request->getPost('metadata', 'string');
                $page->showinhead = $this->request->getPost('showinhead', 'string');
                $page->footer = $this->request->getPost('footer', 'string');
                $page->date = $this->request->getPost('date', 'string');
                if (!$page->create()) {
                    $page->showErrorMessages($this);
                } else {
                    $page->showSuccessMessages($this, 'New Page added Successfully');

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
        $pages = Page::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $pages,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Key', 'Title', 'Text', 'Metadata Tags', 'Metadata Description', 'Show In Header', 'Footer Text', 'Date'
                ))->
                setFields(array(
                    'id', 'key', 'title', 'text', 'metakey', 'metadata', 'showinhead', 'footer', 'getDate()'
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
        $item = Page::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'page',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Page::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Page item');
            } else {
                $this->flash->success('Page item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'page',
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
        $this->setTitle('Edit Page');

        $pageItem = Page::findFirst($id);

        // create form
        $fr = new PageForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $page = Page::findFirst($id);
                $page->key = $this->request->getPost('key', 'string');

                $page->title = $this->request->getPost('title', 'string');

                $page->text = $this->request->getPost('text', 'string');

                $page->metakey = $this->request->getPost('metakey', 'string');

                $page->metadata = $this->request->getPost('metadata', 'string');

                $page->showinhead = $this->request->getPost('showinhead', 'string');

                $page->footer = $this->request->getPost('footer', 'string');

                $page->date = $this->request->getPost('date', 'string');
                if (!$page->save()) {
                    $page->showErrorMessages($this);
                } else {
                    $page->showSuccessMessages($this, 'Page Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('key')->setDefault($pageItem->key);
            $fr->get('title')->setDefault($pageItem->title);
            $fr->get('text')->setDefault($pageItem->text);
            $fr->get('metakey')->setDefault($pageItem->metakey);
            $fr->get('metadata')->setDefault($pageItem->metadata);
            $fr->get('showinhead')->setDefault($pageItem->showinhead);
            $fr->get('footer')->setDefault($pageItem->footer);
            $fr->get('date')->setDefault($pageItem->date);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Page::findFirst($id);
        $this->view->item = $item;

        $form = new PageForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('key')->setDefault($item->key);
        $form->get('title')->setDefault($item->title);
        $form->get('text')->setDefault($item->text);
        $form->get('metakey')->setDefault($item->metakey);
        $form->get('metadata')->setDefault($item->metadata);
        $form->get('showinhead')->setDefault($item->showinhead);
        $form->get('footer')->setDefault($item->footer);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
