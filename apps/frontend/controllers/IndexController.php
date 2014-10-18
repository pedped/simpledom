<?php

namespace Simpledom\Frontend\Controllers;

use BaseUserLog;
use Simpledom\Core\MasterTutorialForm;

class IndexController extends ControllerBase {

    public function indexAction() {

        // check if the user logged in to the system, log home page visit
        if ($this->session->has("userid")) {
            BaseUserLog::byUserID($this->session->get("userid"))->setAction("Visiting Home Page")->create();
        }

        $fr = new MasterTutorialForm();
        $this->handleFormScripts($fr);
        $this->view->form = $fr;

        $this->setPageTitle("Homepage");
    }

}
