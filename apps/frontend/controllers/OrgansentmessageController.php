<?php

namespace Simpledom\Frontend\Controllers;

use AtaPaginator;
use OrganSentMessage;
use OrganSentMessageForm;
use Simpledom\Frontend\BaseControllers\ControllerBase;

class OrganSentMessageController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setPageTitle('OrganSentMessage');
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

        $fr = new OrganSentMessageForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $organsentmessage = new \OrganSentMessage();

                $organsentmessage->organid = $this->request->getPost('organid', 'string');
                $organsentmessage->message = $this->request->getPost('message', 'string');
                $organsentmessage->date = $this->request->getPost('date', 'string');
                $organsentmessage->sendernumber = $this->request->getPost('sendernumber', 'string');
                $organsentmessage->fromnumber = $this->request->getPost('fromnumber', 'string');
                $organsentmessage->tonumber = $this->request->getPost('tonumber', 'string');
                $organsentmessage->cost = $this->request->getPost('cost', 'string');
                if (!$organsentmessage->create()) {
                    $organsentmessage->showErrorMessages($this);
                } else {
                    $organsentmessage->showSuccessMessages($this, 'New OrganSentMessage added Successfully');

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
        $organsentmessages = OrganSentMessage::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $organsentmessages,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Organ ID', 'Message', 'Date', 'Sender Number', 'From Number', 'To Number', 'Cost'
                ))->
                setFields(array(
                    'id', 'organid', 'message', 'getDate()', 'sendernumber', 'fromnumber', 'tonumber', 'cost'
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
        $item = OrganSentMessage::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'organsentmessage',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = OrganSentMessage::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this OrganSentMessage item');
            } else {
                $this->flash->success('OrganSentMessage item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'organsentmessage',
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
        $this->setTitle('Edit OrganSentMessage');

        $organsentmessageItem = OrganSentMessage::findFirst($id);

        // create form
        $fr = new OrganSentMessageForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $organsentmessage = OrganSentMessage::findFirst($id);
                $organsentmessage->organid = $this->request->getPost('organid', 'string');

                $organsentmessage->message = $this->request->getPost('message', 'string');

                $organsentmessage->date = $this->request->getPost('date', 'string');

                $organsentmessage->sendernumber = $this->request->getPost('sendernumber', 'string');

                $organsentmessage->fromnumber = $this->request->getPost('fromnumber', 'string');

                $organsentmessage->tonumber = $this->request->getPost('tonumber', 'string');

                $organsentmessage->cost = $this->request->getPost('cost', 'string');
                if (!$organsentmessage->save()) {
                    $organsentmessage->showErrorMessages($this);
                } else {
                    $organsentmessage->showSuccessMessages($this, 'OrganSentMessage Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('organid')->setDefault($organsentmessageItem->organid);
            $fr->get('message')->setDefault($organsentmessageItem->message);
            $fr->get('date')->setDefault($organsentmessageItem->date);
            $fr->get('sendernumber')->setDefault($organsentmessageItem->sendernumber);
            $fr->get('fromnumber')->setDefault($organsentmessageItem->fromnumber);
            $fr->get('tonumber')->setDefault($organsentmessageItem->tonumber);
            $fr->get('cost')->setDefault($organsentmessageItem->cost);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = OrganSentMessage::findFirst($id);
        $this->view->item = $item;

        $form = new OrganSentMessageForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('organid')->setDefault($item->organid);
        $form->get('message')->setDefault($item->message);
        $form->get('date')->setDefault($item->date);
        $form->get('sendernumber')->setDefault($item->sendernumber);
        $form->get('fromnumber')->setDefault($item->fromnumber);
        $form->get('tonumber')->setDefault($item->tonumber);
        $form->get('cost')->setDefault($item->cost);
        $this->view->form = $form;
    }

}
