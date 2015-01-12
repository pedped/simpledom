<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use Group;
use GroupForm;
use Simpledom\Admin\BaseControllers\ControllerBase;

class GroupController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Group');
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

        $fr = new GroupForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $group = new \Group();

                $group->userid = $this->request->getPost('userid', 'string');
                $group->phonenumber = $this->request->getPost('phonenumber', 'string');
                $group->name = $this->request->getPost('name', 'string');
                $group->date = $this->request->getPost('date', 'string');
                $group->status = $this->request->getPost('status', 'string');
                if (!$group->create()) {
                    $group->showErrorMessages($this);
                } else {
                    $group->showSuccessMessages($this, 'New Group added Successfully');

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
        $groups = Group::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $groups,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'User ID', 'Phone Number', 'Name', 'Date', 'Status'
                ))->
                setFields(array(
                    'id', 'userid', 'phonenumber', 'name', 'getDate()', 'status'
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
        $item = Group::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'group',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Group::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Group item');
            } else {
                $this->flash->success('Group item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'group',
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
        $this->setTitle('Edit Group');

        $groupItem = Group::findFirst($id);

        // create form
        $fr = new GroupForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $group = Group::findFirst($id);
                $group->userid = $this->request->getPost('userid', 'string');

                $group->phonenumber = $this->request->getPost('phonenumber', 'string');

                $group->name = $this->request->getPost('name', 'string');

                $group->date = $this->request->getPost('date', 'string');

                $group->status = $this->request->getPost('status', 'string');
                if (!$group->save()) {
                    $group->showErrorMessages($this);
                } else {
                    $group->showSuccessMessages($this, 'Group Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('userid')->setDefault($groupItem->userid);
            $fr->get('phonenumber')->setDefault($groupItem->phonenumber);
            $fr->get('name')->setDefault($groupItem->name);
            $fr->get('date')->setDefault($groupItem->date);
            $fr->get('status')->setDefault($groupItem->status);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Group::findFirst($id);
        $this->view->item = $item;

        $form = new GroupForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userid')->setDefault($item->userid);
        $form->get('phonenumber')->setDefault($item->phonenumber);
        $form->get('name')->setDefault($item->name);
        $form->get('date')->setDefault($item->date);
        $form->get('status')->setDefault($item->status);
        $this->view->form = $form;
    }

}
