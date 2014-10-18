<?php

namespace Simpledom\Frontend\Controllers;

use BaseUser;
use BaseUserLog;
use Opinion;
use Simpledom\Core\OpinionForm;

class OpinionController extends ControllerBase {

    public function indexAction() {

        $fr = new OpinionForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // valid request
                $opinion = new Opinion();
                $opinion->email = $this->request->getPost("email", "email");
                $opinion->message = $this->request->getPost("message", "string");
                $opinion->name = $this->request->getPost("name", "string");
                $opinion->rate = $this->request->getPost("rate", "int");
                $opinion->userid = $this->session->has("userid") ? $this->session->get("userid") : null;

                if (!$opinion->create()) {
                    $opinion->showErrorMessages($this);
                } else {

                    // check if the user logged in to the system, log home page visit
                    if ($this->session->has("userid")) {
                        BaseUserLog::byUserID($this->session->get("userid"))->setAction("Inserted New Opinion")->setInfo("opinion id is " . $opinion->id)->create();
                    }

                    $opinion->showSuccessMessages($this, "Your opinion has been inserted successfully");

                    // clear the form
                    $fr->clear();
                }
            } else {
                // invalid request
            }
        }
        // check if user logged in to system, set name and email
        if ($this->session->has("userid")) {
            $fr->get("name")->setDefault($this->user->getFullName());
            $fr->get("email")->setDefault($this->user->email);
        }

        // load last opinions
        $this->view->opinions = Opinion::find(array(
                    "limit" => 10,
                    "order" => "id DESC",
        ));

        $this->view->form = $fr;
    }

}
