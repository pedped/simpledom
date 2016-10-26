<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ControllerBase;
use AtaPaginator;
use StockChange;
use StockChangeForm;

class StockChangeController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('تغییرات در موجودی کالا');
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

        $fr = new StockChangeForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $stockchange = new \StockChange();

                $stockchange->stockid = $this->request->getPost('stockid', 'string');
                $stockchange->userid = $this->request->getPost('userid', 'string');
                $stockchange->workerid = $this->request->getPost('workerid', 'string');
                $stockchange->count = $this->request->getPost('count', 'string');
                $stockchange->reasoncode = $this->request->getPost('reasoncode', 'string');
                $stockchange->reason = $this->request->getPost('reason', 'string');
                if (!$stockchange->create()) {
                    $stockchange->showErrorMessages($this);
                } else {
                    $stockchange->showSuccessMessages($this, 'New StockChange added Successfully');

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
        $stockchanges = StockChange::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $stockchanges,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'کد ورودی کالا', 'کاربر دریافت کننده', 'کرمند مسئول', 'تعداد', 'تاریخ', 'دلیل', 'توضیحات'
                ))->
                setFields(array(
                    'id', 'stockid', 'userid', 'workerid', 'count', 'getDate()', 'reasoncode', 'reason'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'stockchange/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = StockChange::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'stockchange',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = StockChange::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this StockChange item');
            } else {
                $this->flash->success('تغییرات با موفقیت حذف گردید');
                return $this->dispatcher->forward(array(
                            'controller' => 'stockchange',
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
        $this->setTitle('Edit StockChange');

        $stockchangeItem = StockChange::findFirst($id);

        // create form
        $fr = new StockChangeForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $stockchange = StockChange::findFirst($id);
                $stockchange->stockid = $this->request->getPost('stockid', 'string');

                $stockchange->userid = $this->request->getPost('userid', 'string');

                $stockchange->workerid = $this->request->getPost('workerid', 'string');

                $stockchange->count = $this->request->getPost('count', 'string');

                $stockchange->date = $this->request->getPost('date', 'string');

                $stockchange->reasoncode = $this->request->getPost('reasoncode', 'string');

                $stockchange->reason = $this->request->getPost('reason', 'string');
                if (!$stockchange->save()) {
                    $stockchange->showErrorMessages($this);
                } else {
                    $stockchange->showSuccessMessages($this, 'تغییرات موجودی با موفقیت ذخیره گردید');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('stockid')->setDefault($stockchangeItem->stockid);
            $fr->get('userid')->setDefault($stockchangeItem->userid);
            $fr->get('workerid')->setDefault($stockchangeItem->workerid);
            $fr->get('count')->setDefault($stockchangeItem->count);
            $fr->get('date')->setDefault($stockchangeItem->date);
            $fr->get('reasoncode')->setDefault($stockchangeItem->reasoncode);
            $fr->get('reason')->setDefault($stockchangeItem->reason);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = StockChange::findFirst($id);
        $this->view->item = $item;

        $form = new StockChangeForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('stockid')->setDefault($item->stockid);
        $form->get('userid')->setDefault($item->userid);
        $form->get('workerid')->setDefault($item->workerid);
        $form->get('count')->setDefault($item->count);
        $form->get('date')->setDefault($item->date);
        $form->get('reasoncode')->setDefault($item->reasoncode);
        $form->get('reason')->setDefault($item->reason);
        $this->view->form = $form;
    }

}
