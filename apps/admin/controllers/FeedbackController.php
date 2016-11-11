<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ControllerBase;
use AtaPaginator;
use Feedback;
use FeedbackForm;

class FeedbackController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('پشتیبانی');
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

        $fr = new FeedbackForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $feedback = new \Feedback();

                $feedback->userid = $this->request->getPost('userid', 'string');
                $feedback->devcieinfo = $this->request->getPost('devcieinfo', 'string');
                $feedback->result_type = $this->request->getPost('result_type', 'string');
                $feedback->result_response = $this->request->getPost('result_response', 'string');
                $feedback->result_comment = $this->request->getPost('result_comment', 'string');
                if (!$feedback->create()) {
                    $feedback->showErrorMessages($this);
                } else {
                    $feedback->showSuccessMessages($this, 'New Feedback added Successfully');

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
        $feedbacks = Feedback::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $feedbacks,
            'limit' => 20,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد درخواست', 'شماره تماس', 'تاریخ', 'وضعیت', 'نتیجه گفتگو', 'توضیحات'
                ))->
                setFields(array(
                    'id', 'phone', 'getDate()', 'getStatusAdmin()', 'result_response', 'result_comment'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'feedback/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = Feedback::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'feedback',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Feedback::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Feedback item');
            } else {
                $this->flash->success('Feedback item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'feedback',
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


        $feedbackItem = Feedback::findFirst($id);

        // create form
        $fr = new FeedbackForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $feedback = Feedback::findFirst($id);
                $feedback->result_type = $this->request->getPost('result_type', 'string');

                $feedback->result_response = $this->request->getPost('result_response', 'string');

                $feedback->result_comment = $this->request->getPost('result_comment', 'string');
                if (!$feedback->save()) {
                    $feedback->showErrorMessages($this);
                } else {
                    $feedback->showSuccessMessages($this, 'نتیجه گفتگو با موفقیت ذخیره گردید');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('userid')->setDefault($feedbackItem->userid);
            $fr->get('devcieinfo')->setDefault($feedbackItem->devcieinfo);
            $fr->get('result_type')->setDefault($feedbackItem->result_type);
            $fr->get('result_response')->setDefault($feedbackItem->result_response);
            $fr->get('result_comment')->setDefault($feedbackItem->result_comment);
        }

        $this->view->item = $feedbackItem;

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Feedback::findFirst($id);
        $this->view->item = $item;

        $form = new FeedbackForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userid')->setDefault($item->userid);
        $form->get('date')->setDefault($item->date);
        $form->get('devcieinfo')->setDefault($item->devcieinfo);
        $form->get('result_type')->setDefault($item->result_type);
        $form->get('result_response')->setDefault($item->result_response);
        $form->get('result_comment')->setDefault($item->result_comment);
        $this->view->form = $form;
    }

}
