<?php

namespace Simpledom\Admin\Controllers;

use MelkPhoneListner;
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

    public function activephonelistnerAction($phoneListnerID) {
        if (!isset($phoneListnerID)) {
            return false;
        }

        $phone = MelkPhoneListner::findFirst(array("id = :id:", "bind" => array("id" => $phoneListnerID)));
        $phone->status = "1";
        return $phone->save();
    }

    public function deactivephonelistnerAction($phoneListnerID) {
        if (!isset($phoneListnerID)) {
            return false;
        }

        $phone = MelkPhoneListner::findFirst(array("id = :id:", "bind" => array("id" => $phoneListnerID)));
        $phone->status = "-1";
        return $phone->save();
    }

}
