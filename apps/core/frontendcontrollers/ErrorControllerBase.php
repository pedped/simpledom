<?php

namespace Simpledom\Frontend\BaseControllers;


/**
 * ErrorController 
 */
class ErrorControllerBase extends ControllerBase {

    public function show404Action() {
        $this->response->setStatusCode(404, 'Not Found');
        $this->view->pick('error/404');

        // set title
        $this->setPageTitle(_("Not Found!"));
    }
    
     protected function ValidateAccess($id) {
        return true;
    }

}
