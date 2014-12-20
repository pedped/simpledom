<?php

namespace Simpledom\Api\Controllers;

use Phalcon\Mvc\Controller;
use stdClass;

class ControllerBase extends Controller {

    protected $errors = array();

    /**
     * check if we have any error
     * @return boolean
     */
    protected function hasError() {
        return count($this->errors) > 0;
    }

    protected function getResponse($results) {

        //check if we have any error
        $result = new stdClass();
        if ($this->hasError()) {
            // error
            $result->statuscode = 0;
            $result->statustext = $this->errors;
        } else {
            // success
            $result->statuscode = 1;
            $result->result = $results;
            $result->statustext = "";
        }

        echo json_encode($result);
    }

    public function initialize() {
        
    }

}
