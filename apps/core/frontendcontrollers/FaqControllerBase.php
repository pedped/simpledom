<?php

namespace Simpledom\Frontend\BaseControllers;

use BaseFaq;
use BaseUserLog;

class FaqControllerBase extends ControllerBase {

    public function indexAction() {

        $this->view->list = BaseFaq::find(array(
                    "group" => "head",
                    "order" => "head ASC, id DESC"
        ));


        // set page title
        $this->setPageTitle(_("FAQ"));
    }

    protected function ValidateAccess($id) {
        return true;
    }

}
