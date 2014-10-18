<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use BaseEmailTemplate;
use Simpledom\Core\EmailTemplateForm;

class EmailTemplateControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('EmailTemplate');
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

        $fr = new EmailTemplateForm();
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $emailtemplate = new BaseEmailTemplate();

                $emailtemplate->name = $this->request->getPost('name', 'string');
                $emailtemplate->template = $this->request->getPost('template', 'string');
                if (!$emailtemplate->create()) {
                    $emailtemplate->showErrorMessages($this);
                } else {
                    $emailtemplate->showSuccessMessages($this, 'New EmailTemplate added Successfully');

                    // clear the title and message so the user can add better info
                    $fr->clear();
                }
            } else {
                // invalid
            }
        }
        $this->view->form = $fr;
    }

    public function listAction($page = 1) {

        // load the users
        $emailtemplates = BaseEmailTemplate::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $emailtemplates,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Name', 'Template'
                ))->
                setFields(array(
                    'id', 'name', 'template'
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
        $item = BaseEmailTemplate::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'emailtemplate',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = BaseEmailTemplate::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this EmailTemplate item');
            } else {
                $this->flash->success('EmailTemplate item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'emailtemplate',
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
        $this->setTitle('Edit EmailTemplate');

        $emailtemplateItem = BaseEmailTemplate::findFirst($id);

        // create form
        $fr = new EmailTemplateForm();

        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $emailtemplate = BaseEmailTemplate::findFirst($id);
                $emailtemplate->name = $this->request->getPost('name', 'string');

                $emailtemplate->template = $this->request->getPost('template', 'string');
                if (!$emailtemplate->save()) {
                    $emailtemplate->showErrorMessages($this);
                } else {
                    $emailtemplate->showSuccessMessages($this, 'EmailTemplate Saved Successfully');
                }
            } else {
                // invalid
            }
        } else {
            // set default values
            $fr->get('name')->setDefault($emailtemplateItem->name);
            $fr->get('template')->setDefault($emailtemplateItem->template);
        }
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = BaseEmailTemplate::findFirst($id);
        $this->view->item = $item;

        $form = new EmailTemplateForm();
        $form->get('id')->setDefault($item->id);
        $form->get('name')->setDefault($item->name);
        $form->get('template')->setDefault($item->template);
        $this->view->form = $form;
    }

}
