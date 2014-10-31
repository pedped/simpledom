<?php

define("USERLEVEL_BONGAHDAR", 5);

class User extends BaseUser {

    public function isBongahDar() {
        return intval($this->level) == USERLEVEL_BONGAHDAR;
    }

}
