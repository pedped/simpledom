<?php

namespace Simpledom\Frontend\BaseControllers;

class IndexControllerBase extends ControllerBase {

    public function indexAction() {

        $this->setPageTitle(_("Homepage"));
    }

    protected function ValidateAccess($id) {
        return true;
    }

}
