<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use Simpledom\Core\UserNotificationForm;
use UserNotification;

class UserNotificationControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('UserNotification');
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

        $fr = new UserNotificationForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $usernotification = new \UserNotification();

                $usernotification->userid = $this->request->getPost('userid', 'string');
                $usernotification->title = $this->request->getPost('title', 'string');
                $usernotification->message = $this->request->getPost('message', 'string');
                $usernotification->link = $this->request->getPost('link', 'string');
                $usernotification->linktext = $this->request->getPost('linktext', 'string');
                $usernotification->date = $this->request->getPost('date', 'string');
                $usernotification->releasedate = $this->request->getPost('releasedate', 'string');
                $usernotification->enable = $this->request->getPost('enable', 'string');
                $usernotification->byip = $this->request->getPost('byip', 'string');
                $usernotification->visited = $this->request->getPost('visited', 'string');
                $usernotification->visitip = $this->request->getPost('visitip', 'string');
                $usernotification->visitdate = $this->request->getPost('visitdate', 'string');
                if (!$usernotification->create()) {
                    $usernotification->showErrorMessages($this);
                } else {
                    $usernotification->showSuccessMessages($this, 'New UserNotification added Successfully');

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
        $usernotifications = UserNotification::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $usernotifications,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'User ID', 'Title', 'Message', 'Link', 'Link Text', 'Date', 'Release Date', 'Enable', 'By IP', 'Visited', 'Visit IP', 'Visit Date'
                ))->
                setFields(array(
                    'id', 'userid', 'title', 'message', 'link', 'linktext', 'getDate()', 'releasedate', 'enable', 'byip', 'visited', 'visitip', 'visitdate'
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
        $item = UserNotification::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'usernotification',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = UserNotification::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this UserNotification item');
            } else {
                $this->flash->success('UserNotification item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'usernotification',
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
        $this->setTitle('Edit UserNotification');

        $usernotificationItem = UserNotification::findFirst($id);

        // create form
        $fr = new UserNotificationForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $usernotification = UserNotification::findFirst($id);
                $usernotification->userid = $this->request->getPost('userid', 'string');

                $usernotification->title = $this->request->getPost('title', 'string');

                $usernotification->message = $this->request->getPost('message', 'string');

                $usernotification->link = $this->request->getPost('link', 'string');

                $usernotification->linktext = $this->request->getPost('linktext', 'string');

                $usernotification->date = $this->request->getPost('date', 'string');

                $usernotification->releasedate = $this->request->getPost('releasedate', 'string');

                $usernotification->enable = $this->request->getPost('enable', 'string');

                $usernotification->byip = $this->request->getPost('byip', 'string');

                $usernotification->visited = $this->request->getPost('visited', 'string');

                $usernotification->visitip = $this->request->getPost('visitip', 'string');

                $usernotification->visitdate = $this->request->getPost('visitdate', 'string');
                if (!$usernotification->save()) {
                    $usernotification->showErrorMessages($this);
                } else {
                    $usernotification->showSuccessMessages($this, 'UserNotification Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('userid')->setDefault($usernotificationItem->userid);
            $fr->get('title')->setDefault($usernotificationItem->title);
            $fr->get('message')->setDefault($usernotificationItem->message);
            $fr->get('link')->setDefault($usernotificationItem->link);
            $fr->get('linktext')->setDefault($usernotificationItem->linktext);
            $fr->get('date')->setDefault($usernotificationItem->date);
            $fr->get('releasedate')->setDefault($usernotificationItem->releasedate);
            $fr->get('enable')->setDefault($usernotificationItem->enable);
            $fr->get('byip')->setDefault($usernotificationItem->byip);
            $fr->get('visited')->setDefault($usernotificationItem->visited);
            $fr->get('visitip')->setDefault($usernotificationItem->visitip);
            $fr->get('visitdate')->setDefault($usernotificationItem->visitdate);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = UserNotification::findFirst($id);
        $this->view->item = $item;

        $form = new UserNotificationForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userid')->setDefault($item->userid);
        $form->get('title')->setDefault($item->title);
        $form->get('message')->setDefault($item->message);
        $form->get('link')->setDefault($item->link);
        $form->get('linktext')->setDefault($item->linktext);
        $form->get('date')->setDefault($item->date);
        $form->get('releasedate')->setDefault($item->releasedate);
        $form->get('enable')->setDefault($item->enable);
        $form->get('byip')->setDefault($item->byip);
        $form->get('visited')->setDefault($item->visited);
        $form->get('visitip')->setDefault($item->visitip);
        $form->get('visitdate')->setDefault($item->visitdate);
        $this->view->form = $form;
    }

}
