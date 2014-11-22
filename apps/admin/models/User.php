<?php

class User extends BaseUser {

    /**
     * 
     * @return int SMS's Can Send
     */
    public function getSMSCredit() {
        return SMSCredit::findFirst(array("userid = :userid:", "bind" => array("userid" => $this->userid)))->value;
    }

}
