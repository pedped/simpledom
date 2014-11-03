<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use BaseContact;
use BaseUser;
use EmailItems;
use Simpledom\Core\ContactReplyForm;
use Simpledom\Core\SendBulkEmailForm;

class ContactControllerBase extends ControllerBase {

    public function unseenAction($page = 1) {

        // load the unseenmessages
        $contacts = BaseContact::find(
                        array(
                            'seen = 0',
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $contacts,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Name', 'Email', 'Section', 'Message', 'Date'
                ))->
                setFields(array(
                    'id', 'name', 'email', 'section', 'message', 'getDate()'
                ))->
                setEditUrl(
                        'view'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'contact/unseen');

        $this->view->list = $paginator->getPaginate();
    }

    public function listAction($page = 1) {


        // load the users
        $contacts = BaseContact::find(
                        array(
                            "order" => "date DESC"
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            "data" => $contacts,
            "limit" => 10,
            "page" => $numberPage
        ));
        $this->view->contactsList = $paginator->getPaginate();
    }

    public function unansweredAction($page = 1) {


        // set title
        $this->setTitle("Un Answered");

        // load the users
        $contacts = BaseContact::find(
                        array(
                            "reply IS NULL",
                            "order" => "date DESC"
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            "data" => $contacts,
            "limit" => 10,
            "page" => $numberPage
        ));
        $this->view->contactsList = $paginator->getPaginate();
    }

    public function sentAction($page = 1) {

        // set title
        $this->setTitle("Sent Message");

        // load the users
        $contacts = BaseContact::find(
                        array(
                            "reply IS NOT NULL",
                            "order" => "date DESC"
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            "data" => $contacts,
            "limit" => 10,
            "page" => $numberPage
        ));
        $this->view->contactsList = $paginator->getPaginate();
    }

    public function deleteAction($id) {
        // set title
        $this->setTitle("Delete Message");

        $this->view->contactItem = BaseContact::findFirst($id);

        // create reply form
        $fr = new ContactReplyForm();
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $contact = BaseContact::findFirst($id);
                $contact->reply = $this->request->getPost("message", "string");
                if (!$contact->save()) {
                    $contact->showErrorMessages($this);
                } else {
                    $contact->showErrorMessages($this, "Reply Message Sent Successfully");
                }
            } else {
                // invalid
            }
        }
        // $this->view->item = $fr;
    }

    public function viewAction($id) {
        // set title
        $this->setTitle("View Contact");

        $contact = BaseContact::findFirst($id);

        $this->view->contactItem = $contact;

        // create reply form
        $fr = new ContactReplyForm();
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $contact = BaseContact::findFirst($id);
                $contact->reply = $this->request->getPost("message", "string");


                if (!$contact->save()) {
                    $contact->showErrorMessages($this);
                } else {

                    // Send Email
                    $emailItems = new EmailItems();
                    $emailItems->sendReply($contact->email, $contact->name, $contact->message, $contact->reply);

                    // show the succcess mesage
                    $contact->showSuccessMessages($this, "Reply Message Sent Successfully");
                }
            } else {
                // invalid
            }
        }

        // set the contact item as seen
        $contact->seen = "1";
        $contact->save();

        $this->handleFormScripts($fr);
        $this->view->replyForm = $fr;
    }

    function sendbulkAction() {

        $this->setTitle("Send Email To Users");

        $fr = new SendBulkEmailForm();
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid, we have to send email
                // TODO send email
                $users = BaseUser::find();
                $emails = array();
                foreach ($users as $user) {
                    $emails[] = $user->email;
                }

                $subject = $this->request->getPost("subject", "string");
                $message = $this->request->getPost("message");

                // send email
                $emilItem = new EmailItems();
                $emilItem->sendBulkEmail($emails, $subject, $message);
            } else {
                // invalid
            }
        }
        $this->view->sendForm = $fr;
    }

    protected function ValidateAccess($id) {
        
    }

}
