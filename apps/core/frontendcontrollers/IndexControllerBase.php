<?php

namespace Simpledom\Frontend\BaseControllers;

use Simpledom\Core\MasterTutorialForm;

class IndexControllerBase extends ControllerBase {

    public function indexAction() {

        $this->AddUserLog("Visit Home Page");

        $fr = new MasterTutorialForm();
        $this->handleFormScripts($fr);
        $this->view->form = $fr;

        $this->setPageTitle(_("Homepage"));
    }

    protected function ValidateAccess($id) {
        return true;
    }

}
