<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ApiControllerBase;
use UserPhone;

class ApiController extends ApiControllerBase {

    public function verifyphoneAction($phoneid) {
        if (!isset($phoneid)) {
            return false;
        }

        $phone = UserPhone::findFirst(array("id = :id:", "bind" => array("id" => $phoneid)));
        $phone->verified = 1;
        return $phone->save();
    }

}
