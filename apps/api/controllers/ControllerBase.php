<?php

namespace Simpledom\Api\Controllers;

use MobileToken;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Resultset\Simple;
use Phalcon\Paginator\Adapter\Model;
use stdClass;
use User;

class ControllerBase extends Controller {

    protected $errors = array();

    /**
     * Logged In User
     * @var User 
     */
    protected $user;

    /**
     * check if we have any error
     * @return boolean
     */
    protected function hasError() {
        return count($this->errors) > 0;
    }

    protected function getResponse($results, array $items = null) {

        
        
        $result = new stdClass();
        if ($this->hasError()) {
            // error
            $result->statuscode = 0;
            $result->statustext = implode("\n", $this->errors);
        } else {
            // success
            $result->statuscode = 1;

            // now , we have to get result
            if ($results instanceof Simple) {
                // it is simple result set
                $k = array();
                foreach ($results as $item) {
                    $f = $item->getPublicResponse();
                    if (isset($f)) {
                        $k[] = $f;
                    }
                }
                $result->result = $k;
            } else if ($results instanceof Model) {
                // it is basic model
                $result->result = $results->getPublicResponse();
            } else {
                // it is usual item
                $result->result = $results;
            }
            $result->statustext = "";
        }

        echo str_replace("www.avoocado.com", "192.168.43.95", json_encode($result));
    }

    public function initialize() {
        // check if we need to get user info
        if ($this->dispatcher->getControllerName() != "public" && $this->dispatcher->getControllerName() != "smsreceiver") {
            // we have to request user login info
            $userid = $this->request->getPost("auth_userid");
            $token = $this->request->getPost("auth_token");

            // check for token
            if (MobileToken::count(array("userid = :userid: AND token = :token:", "bind" => array(
                            "userid" => $userid,
                            "token" => $token,
                ))) == 0) {
                // user token not found
                die();
            }

            // valid user
            $this->user = User::findFirst(array("userid = :userid:", "bind" => array("userid" => $userid)));
        }
    }

}
