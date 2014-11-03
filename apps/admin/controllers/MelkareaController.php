<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ControllerBase;
use AtaPaginator;
use MelkArea;
use MelkAreaForm;

class MelkAreaController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('MelkArea');
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

        $fr = new MelkAreaForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melkarea = new \MelkArea();

                $melkarea->melkid = $this->request->getPost('melkid', 'string');
                $melkarea->areaid = $this->request->getPost('areaid', 'string');
                $melkarea->cityid = $this->request->getPost('cityid', 'string');
                $melkarea->byuserid = $this->request->getPost('byuserid', 'string');
                $melkarea->ip = $this->request->getPost('ip', 'string');
                $melkarea->date = $this->request->getPost('date', 'string');
                if (!$melkarea->create()) {
                    $melkarea->showErrorMessages($this);
                } else {
                    $melkarea->showSuccessMessages($this, 'New MelkArea added Successfully');

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
        $melkareas = MelkArea::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $melkareas,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Melk ID', 'Area ID', 'City ID', 'By User ID', 'IP', 'Date'
                ))->
                setFields(array(
                    'id', 'melkid', 'areaid', 'cityid', 'byuserid', 'ip', 'getDate()'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'melkarea/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = MelkArea::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'melkarea',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = MelkArea::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this MelkArea item');
            } else {
                $this->flash->success('MelkArea item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'melkarea',
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
        $this->setTitle('Edit MelkArea');

        $melkareaItem = MelkArea::findFirst($id);

        // create form
        $fr = new MelkAreaForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melkarea = MelkArea::findFirst($id);
                $melkarea->melkid = $this->request->getPost('melkid', 'string');

                $melkarea->areaid = $this->request->getPost('areaid', 'string');

                $melkarea->cityid = $this->request->getPost('cityid', 'string');

                $melkarea->byuserid = $this->request->getPost('byuserid', 'string');

                $melkarea->ip = $this->request->getPost('ip', 'string');

                $melkarea->date = $this->request->getPost('date', 'string');
                if (!$melkarea->save()) {
                    $melkarea->showErrorMessages($this);
                } else {
                    $melkarea->showSuccessMessages($this, 'MelkArea Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('melkid')->setDefault($melkareaItem->melkid);
            $fr->get('areaid')->setDefault($melkareaItem->areaid);
            $fr->get('cityid')->setDefault($melkareaItem->cityid);
            $fr->get('byuserid')->setDefault($melkareaItem->byuserid);
            $fr->get('ip')->setDefault($melkareaItem->ip);
            $fr->get('date')->setDefault($melkareaItem->date);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = MelkArea::findFirst($id);
        $this->view->item = $item;

        $form = new MelkAreaForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('melkid')->setDefault($item->melkid);
        $form->get('areaid')->setDefault($item->areaid);
        $form->get('cityid')->setDefault($item->cityid);
        $form->get('byuserid')->setDefault($item->byuserid);
        $form->get('ip')->setDefault($item->ip);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
