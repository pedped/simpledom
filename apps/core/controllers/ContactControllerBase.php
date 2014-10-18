<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use BaseContact;
use BaseUser;
use Simpledom\Core\ContactReplyForm;
use Simpledom\Core\SendBulkEmailForm;

class ContactControllerBase extends ControllerBase {

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
                $emilItem = new \EmailItems();
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
