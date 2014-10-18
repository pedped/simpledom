<?php

namespace Simpledom\Api\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {

    protected function getResponse($results) {
        echo json_encode($results);
    }

    public function initialize() {
        
    }

}
