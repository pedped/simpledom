<?php

use Simpledom\Core\Classes\Helper;

class MobileToken extends BaseMobileToken {

    /**
     * generate mobile token
     * @param array $errors
     * @param type $userid
     * @param type $deviceid
     * @param type $devicetype
     * @return boolean|String tken on success, false on unsuccess
     */
    public static function GetToken(&$errors, $userid, $deviceid, $devicetype) {
        $mobileToken = new MobileToken();
        $mobileToken->userid = $userid;
        $mobileToken->deviceid = $deviceid;
        $mobileToken->devicetype = $devicetype;
        $mobileToken->token = Helper::generateRandomString(512);
        if ($mobileToken->create()) {
            return $mobileToken->token;
        } else {
            $errors[] = _("Unable to create token");
            return false;
        }
    }

}
