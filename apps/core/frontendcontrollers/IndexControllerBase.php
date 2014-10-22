<?php

namespace Simpledom\Frontend\BaseControllers;

use BaseUserLog;
use Simpledom\Core\MasterTutorialForm;

class IndexControllerBase extends ControllerBase {

    public function indexAction() {

        // check if the user logged in to the system, log home page visit
        if ($this->session->has("userid")) {
            BaseUserLog::byUserID($this->session->get("userid"))->setAction("Visiting Home Page")->create();
        }

        $fr = new MasterTutorialForm();
        $this->handleFormScripts($fr);
        $this->view->form = $fr;

        $this->setPageTitle(_("Homepage"));
    }

}
