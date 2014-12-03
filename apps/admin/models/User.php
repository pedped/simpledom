<?php

define("USERLEVEL_BONGAHDAR", 5);

class User extends BaseUser {

    public function isBongahDar() {
        return intval($this->level) == USERLEVEL_BONGAHDAR;
    }

    /**
     * fetch current user sms credit
     * @return type
     */
    public function getSMSCredit() {
        $smsCredit = SMSCredit::findFirst(array("userid = :userid:", "bind" => array("userid" => $this->userid)));
        if (!$smsCredit) {
            return 0;
        } else {
            return $smsCredit->value;
        }
    }

}
