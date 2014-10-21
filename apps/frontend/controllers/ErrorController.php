<?php

namespace Simpledom\Frontend\Controllers;

/**
 * ErrorController 
 */
class ErrorController extends ControllerBase {

    public function show404Action() {
        $this->response->setStatusCode(404, 'Not Found');
        $this->view->pick('error/404');

        // set title
        $this->setPageTitle(_("Not Found!"));
    }

}
