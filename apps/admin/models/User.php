<?php

class User extends BaseUser {

    public function beforeValidationOnCreate() {
        parent::beforeValidationOnCreate();
        $this->questioncanask = "0";
    }

    /**
     * 
     * @return boolean
     */
    public function isMoshaver() {
        return Moshaver::count(array("userid = :userid:", "bind" => array("userid" => $this->userid))) > 0;
    }

    /**
     * 
     * @return Moshaver
     */
    public function getMoshaver() {
        return Moshaver::findFirst(array("userid = :userid:", "bind" => array("userid" => $this->userid)));
    }

}
