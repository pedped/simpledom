<?php

namespace Simpledom\Frontend\Controllers;

use Agreement;

class AgreementController extends ControllerBase {

    public function viewAction($id = 1) {
        $agreement = Agreement::findFirst($id);
        if (!$agreement) {
            $this->show404();
            return;
        }

        // set view and title
        $this->setPageTitle($agreement->title);
        $this->view->agreement = $agreement;
    }

}
