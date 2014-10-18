<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use BaseFaq;
use Simpledom\Core\FaqForm;

class FaqControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle("FAQ");
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

        $fr = new FaqForm();
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $faq = new \BaseFaq();
                $faq->head = $this->request->getPost("head", "string");
                $faq->title = $this->request->getPost("title", "string");
                $faq->message = $this->request->getPost("message", "string");
                if (!$faq->create()) {
                    $faq->showErrorMessages($this);
                } else {
                    $faq->showSuccessMessages($this, "New FAQ added Successfully");

                    // clear the title and message so the user can add better info
                    $fr->get("title")->clear();
                    $fr->get("message")->clear();
                }
            } else {
                // invalid
            }
        }
        $this->view->form = $fr;
    }

    public function listAction($page = 1) {

        // load the users
        $faqs = BaseFaq::find(
                        array(
                            "order" => "head ASC , id DESC"
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            "data" => $faqs,
            "limit" => 10,
            "page" => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    "ID", "Head", "Title", "Description"
                ))->
                setFields(array(
                    "id", "head", "title", "message"
                ))->
                setEditUrl(
                        "edit"
                )->
                setDeleteUrl(
                        "delete"
                )->setListPath(
                'list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do nto have permession to remove this object
            return $this->response->setStatusCode("403", "You do not have permession to access this page");
        }

        // check if item exist
        $item = BaseFaq::findFirst($id);
        if (!$item) {
            // item is not exist anymore
            return $this->dispatcher->forward(array(
                        "controller" => "faq",
                        "action" => "list"
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = BaseFaq::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error("unable to remove this FAQ item");
            } else {
                $this->flash->success("FAQ item deleted successfully");
                return $this->dispatcher->forward(array(
                            "controller" => "faq",
                            "action" => "list"
                ));
            }
        }
    }

    public function editAction($id) {
        // set title
        $this->setTitle("Edit FAQ");

        $faqItem = BaseFaq::findFirst($id);

        // create form
        $fr = new FaqForm();

        // set default values
        $fr->get("head")->setDefault($faqItem->head);
        $fr->get("title")->setDefault($faqItem->title);
        $fr->get("message")->setDefault($faqItem->message);

        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $faq = BaseFaq::findFirst($id);
                $faq->head = $this->request->getPost("head", "string");
                $faq->title = $this->request->getPost("title", "string");
                $faq->message = $this->request->getPost("message", "string");
                if (!$faq->save()) {
                    $faq->showErrorMessages($this);
                } else {
                    $faq->showSuccessMessages($this, "FAQ Saved Successfully");
                }
            } else {
                // invalid
            }
        }
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = BaseFaq::findFirst($id);
        $this->view->item = $item;

        $form = new FaqForm();
        $form->get("head")->setDefault($item->head);
        $form->get("title")->setDefault($item->title);
        $form->get("message")->setDefault($item->message);
        $this->view->form = $form;
        
    }

}
