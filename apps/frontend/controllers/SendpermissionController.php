<?php

namespace Simpledom\Frontend\Controllers;

use AtaPaginator;
use SendPermission;
use SendPermissionForm;
use Simpledom\Frontend\BaseControllers\ControllerBase;

class SendpermissionController extends ControllerBase {
    
    private $_organId;
    public function initialize() {
        parent::initialize();
        $this->_organId = $this->dispatcher->getParam("organid");
        $this->view->organId = $this->_organId;
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

        $fr = new SendPermissionForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $sendpermission = new \SendPermission();

                $sendpermission->userpost1 = $this->request->getPost('userpost1', 'string');
                $sendpermission->userpost2 = $this->request->getPost('userpost2', 'string');
                $sendpermission->cansend = $this->request->hasPost('cansend') ? $this->request->getPost('cansend') : 0;
                if (!$sendpermission->create()) {
                    $sendpermission->showErrorMessages($this);
                } else {
                    $sendpermission->showSuccessMessages($this, 'New SendPermission added Successfully');

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
        $sendpermissions = SendPermission::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $sendpermissions,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'User Post From', 'User Post To', 'Can Send'
                ))->
                setFields(array(
                    'id', 'userpost1', 'userpost2', 'cansend'
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
        $item = SendPermission::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'organ',
                        'action' => 'permissions',
                        "organid" => $this->_organId
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = SendPermission::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this SendPermission item');
            } else {
                $this->flash->success('SendPermission item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'organ',
                            'action' => 'permissions',
                            "organid" => $this->_organId
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
        $this->setPageTitle('ویرایش مجوز ارسال');

        $sendpermissionItem = SendPermission::findFirst($id);

        // create form
        $fr = new SendPermissionForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $sendpermission = SendPermission::findFirst($id);
                $sendpermission->userpost1 = $this->request->getPost('userpost1', 'string');

                $sendpermission->userpost2 = $this->request->getPost('userpost2', 'string');

                $sendpermission->cansend = $this->request->hasPost('cansend') ? $this->request->getPost('cansend') : 0;
                if (!$sendpermission->save()) {
                    $sendpermission->showErrorMessages($this);
                } else {
                    $sendpermission->showSuccessMessages($this, 'SendPermission Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('userpost1')->setDefault($sendpermissionItem->userpost1);
            $fr->get('userpost2')->setDefault($sendpermissionItem->userpost2);
            $fr->get('cansend')->setDefault($sendpermissionItem->cansend);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = SendPermission::findFirst($id);
        $this->view->item = $item;

        $form = new SendPermissionForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userpost1')->setDefault($item->userpost1);
        $form->get('userpost2')->setDefault($item->userpost2);
        $form->get('cansend')->setDefault($item->cansend);
        $this->view->form = $form;
    }

}
