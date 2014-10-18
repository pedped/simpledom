<?php

use Simpledom\Core\AtaModel;

class BaseLogins extends AtaModel {

    public function getSource() {
        return "logins";
    }

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $userid;

    /**
     *
     * @var integer
     */
    public $date;

    /**
     *
     * @var string
     */
    public $agent;

    /**
     *
     * @var string
     */
    public $ip;

    /**
     *
     * @var string
     */
    public $time;

    public function getDate() {
        return date("Y-m-d H:i:s", $this->date);
    }

    public function getUser() {
        return BaseUser::findFirst($this->userid);
    }

    public function getUserName() {
        return BaseUser::findFirst($this->userid)->getFullName();
    }

    public function beforeValidationOnCreate() {
        $this->time = date("Y-m-d H:i:s", time());
        $this->date = time();
    }

    public function getPublicResponse() {
        
    }

}
