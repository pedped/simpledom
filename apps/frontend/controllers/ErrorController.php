<?php

namespace Simpledom\Frontend\Controllers;

use Simpledom\Frontend\BaseControllers\ErrorControllerBase;

/**
 * ErrorController 
 */
class ErrorController extends ErrorControllerBase {

    public function show404Action() {
        $this->response->setStatusCode(404, 'Not Found');
        $this->view->pick('error/404');

        // set title
        $this->setPageTitle(_("Not Found!"));
    }

}
