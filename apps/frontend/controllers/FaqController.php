<?php

namespace Simpledom\Frontend\Controllers;

use BaseFaq;
use BaseUserLog;
use Simpledom\Frontend\BaseControllers\FaqControllerBase;

class FaqController extends FaqControllerBase {

    public function indexAction() {

        // check if the user logged in to the system, log home page visit
        if ($this->session->has("userid")) {
            BaseUserLog::byUserID($this->session->get("userid"))->setAction("Visiting FAQ Page")->create();
        }


        // Load the FAQ's
        $this->view->list = BaseFaq::find(array(
                    "group" => "head",
                    "order" => "head ASC, id DESC"
        ));


        // set page title
        $this->setPageTitle(_("FAQ"));
    }

}
