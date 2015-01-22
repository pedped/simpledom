<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ControllerBase;
use AtaPaginator;
use BongahSentMelk;
use BongahSentMelkForm;

class BongahSentMelkController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('BongahSentMelk');
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

        $fr = new BongahSentMelkForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $bongahsentmelk = new \BongahSentMelk();

                $bongahsentmelk->bongahid = $this->request->getPost('bongahid', 'string');
                $bongahsentmelk->melkphonelistnerid = $this->request->getPost('melkphonelistnerid', 'string');
                $bongahsentmelk->melkid = $this->request->getPost('melkid', 'string');
                $bongahsentmelk->message = $this->request->getPost('message', 'string');
                $bongahsentmelk->date = $this->request->getPost('date', 'string');
                if (!$bongahsentmelk->create()) {
                    $bongahsentmelk->showErrorMessages($this);
                } else {
                    $bongahsentmelk->showSuccessMessages($this, 'New BongahSentMelk added Successfully');

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
        $bongahsentmelks = BongahSentMelk::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $bongahsentmelks,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'کد بنگاه', 'نام بنگاه', 'کد دریافت کننده', 'شماره موبایل', 'کد ملک', 'پیام', 'تاریخ'
                ))->
                setFields(array(
                    'id', 'bongahid', 'getBongahName()', 'melkphonelistnerid', 'getPhoneNumber()', 'melkid', 'message', 'getDate()'
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
        $item = BongahSentMelk::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'bongahsentmelk',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = BongahSentMelk::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this BongahSentMelk item');
            } else {
                $this->flash->success('BongahSentMelk item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'bongahsentmelk',
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
        $this->setTitle('Edit BongahSentMelk');

        $bongahsentmelkItem = BongahSentMelk::findFirst($id);

        // create form
        $fr = new BongahSentMelkForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $bongahsentmelk = BongahSentMelk::findFirst($id);
                $bongahsentmelk->bongahid = $this->request->getPost('bongahid', 'string');

                $bongahsentmelk->melkphonelistnerid = $this->request->getPost('melkphonelistnerid', 'string');

                $bongahsentmelk->melkid = $this->request->getPost('melkid', 'string');

                $bongahsentmelk->message = $this->request->getPost('message', 'string');

                $bongahsentmelk->date = $this->request->getPost('date', 'string');
                if (!$bongahsentmelk->save()) {
                    $bongahsentmelk->showErrorMessages($this);
                } else {
                    $bongahsentmelk->showSuccessMessages($this, 'BongahSentMelk Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('bongahid')->setDefault($bongahsentmelkItem->bongahid);
            $fr->get('melkphonelistnerid')->setDefault($bongahsentmelkItem->melkphonelistnerid);
            $fr->get('melkid')->setDefault($bongahsentmelkItem->melkid);
            $fr->get('message')->setDefault($bongahsentmelkItem->message);
            $fr->get('date')->setDefault($bongahsentmelkItem->date);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = BongahSentMelk::findFirst($id);
        $this->view->item = $item;

        $form = new BongahSentMelkForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('bongahid')->setDefault($item->bongahid);
        $form->get('melkphonelistnerid')->setDefault($item->melkphonelistnerid);
        $form->get('melkid')->setDefault($item->melkid);
        $form->get('message')->setDefault($item->message);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
