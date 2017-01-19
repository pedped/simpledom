<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ControllerBase;
use AtaPaginator;
use Usercachchange;
use UsercachchangeForm;

class UsercachchangeController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('تغییرات اعتبار');
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

        $fr = new UsercachchangeForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {


                $userID = $this->request->getPost('userid', 'string');
                if (intval($userID) > 0 && \User::findWithUserID($userID) != FALSE) {
                    // form is valid
                    $usercachchange = new \Usercachchange();

                    $usercachchange->userid = $userID;
                    $usercachchange->amount = $this->request->getPost('amount', 'string');
                    $usercachchange->reasonid = $this->request->getPost('reasonid', 'string');
                    $usercachchange->more = $this->request->getPost('more', 'string');
                    if (!$usercachchange->create()) {
                        $usercachchange->showErrorMessages($this);
                    } else {

                        // we have to increase user cach 
                        $user = \User::findWithUserID($userID);

                        // check for the reasosn
                        $reasonType = \Cachchangereason::findFirst($usercachchange->reasonid);
                        if ($reasonType->isgift) {
                            $user->gift += $usercachchange->amount;
                        } else {
                            $user->cach += $usercachchange->amount;
                        }

                        $user->save();

                        $usercachchange->showSuccessMessages($this, 'با موفقیت ثبت شد');

                        // clear the title and message so the user can add better info
                        $fr->clear();
                    }
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
        $usercachchanges = Usercachchange::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $usercachchanges,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'کاربر', 'مقدار', 'تاریخ', 'دلیل تغییر', 'اطلاعات بیشتر'
                ))->
                setFields(array(
                    'id', 'userid', 'amount', 'getDate()', 'reasonid', 'more'
                ))->
                setEditUrl(
                        'usercachchange/edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'usercachchange/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function editAction($id) {


        if (!$this->ValidateAccess($id)) {
            // user do not have permission to edut this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }


        $usercachchangeItem = Usercachchange::findFirst($id);

        // create form
        $fr = new UsercachchangeForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $usercachchange = Usercachchange::findFirst($id);
                $usercachchange->userid = $this->request->getPost('userid', 'string');

                $usercachchange->amount = $this->request->getPost('amount', 'string');

                $usercachchange->date = $this->request->getPost('date', 'string');

                $usercachchange->reasonid = $this->request->getPost('reasonid', 'string');

                $usercachchange->more = $this->request->getPost('more', 'string');

                $usercachchange->isgift = $this->request->getPost('isgift', 'string');
                if (!$usercachchange->save()) {
                    $usercachchange->showErrorMessages($this);
                } else {
                    $usercachchange->showSuccessMessages($this, 'ثبت شد');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }

        $fr->get('userid')->setDefault($usercachchangeItem->userid);
        $fr->get('amount')->setDefault($usercachchangeItem->amount);
        $fr->get('date')->setDefault($usercachchangeItem->date);
        $fr->get('reasonid')->setDefault($usercachchangeItem->reasonid);
        $fr->get('more')->setDefault($usercachchangeItem->more);
        $fr->get('isgift')->setDefault(0);

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Usercachchange::findFirst($id);
        $this->view->item = $item;

        $form = new UsercachchangeForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userid')->setDefault($item->userid);
        $form->get('amount')->setDefault($item->amount);
        $form->get('date')->setDefault($item->date);
        $form->get('reasonid')->setDefault($item->reasonid);
        $form->get('more')->setDefault($item->more);
        $form->get('isgift')->setDefault($item->isgift);
        $this->view->form = $form;
    }

}
