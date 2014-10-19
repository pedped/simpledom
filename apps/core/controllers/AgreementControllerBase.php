<?php

namespace Simpledom\Admin\BaseControllers;

use Agreement;
use AtaPaginator;
use Simpledom\Core\AgreementForm;

class AgreementControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Agreement');
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

        $fr = new AgreementForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $agreement = new Agreement();

                $agreement->title = $this->request->getPost('title', 'string');
                $agreement->text = $this->request->getPost('text', 'string');
                $agreement->date = $this->request->getPost('date', 'string');
                if (!$agreement->create()) {
                    $agreement->showErrorMessages($this);
                } else {
                    $agreement->showSuccessMessages($this, 'New Agreement added Successfully');

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
        $agreements = Agreement::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $agreements,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Title', 'Text', 'Date'
                ))->
                setFields(array(
                    'id', 'title', 'text', 'date'
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
        $item = Agreement::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'agreement',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Agreement::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Agreement item');
            } else {
                $this->flash->success('Agreement item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'agreement',
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
        $this->setTitle('Edit Agreement');

        $agreementItem = Agreement::findFirst($id);

        // create form
        $fr = new AgreementForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $agreement = Agreement::findFirst($id);
                $agreement->title = $this->request->getPost('title', 'string');

                $agreement->text = $this->request->getPost('text', 'string');

                $agreement->date = $this->request->getPost('date', 'string');
                if (!$agreement->save()) {
                    $agreement->showErrorMessages($this);
                } else {
                    $agreement->showSuccessMessages($this, 'Agreement Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('title')->setDefault($agreementItem->title);
            $fr->get('text')->setDefault($agreementItem->text);
            $fr->get('date')->setDefault($agreementItem->date);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Agreement::findFirst($id);
        $this->view->item = $item;

        $form = new AgreementForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('title')->setDefault($item->title);
        $form->get('text')->setDefault($item->text);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
