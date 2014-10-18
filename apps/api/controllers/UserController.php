<?php

namespace Simpledom\Api\Controllers;

use BaseUser;

class UserController extends ControllerBase {

    public function getAction($id) {
        return $this->getResponse(BaseUser::findFirst($id)->getPublicResponse());
    }

    public function listAction() {
        $results = array();
        foreach (BaseUser::find() as $value) {
            $results[] = $value->getPublicResponse();
        }
        return $this->getResponse($results);
    }

}
