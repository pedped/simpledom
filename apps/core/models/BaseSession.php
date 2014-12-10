<?php

use Simpledom\Core\AtaModel;

class BaseSession extends AtaModel {

    public function getSource() {
        return 'session';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BaseSession
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * User ID
     * @var string
     */
    public $userid;

    /**
     * Set User ID
     * @param type $userid
     * @return BaseSession
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * IP
     * @var string
     */
    public $ip;

    /**
     * Set IP
     * @param type $ip
     * @return BaseSession
     */
    public function setIp($ip) {
        $this->ip = $ip;
        return $this;
    }

    /**
     * Agent
     * @var string
     */
    public $agent;

    /**
     * Set Agent
     * @param type $agent
     * @return BaseSession
     */
    public function setAgent($agent) {
        $this->agent = $agent;
        return $this;
    }

    /**
     * Session
     * @var string
     */
    public $session;

    /**
     * Set Session
     * @param type $session
     * @return BaseSession
     */
    public function setSession($session) {
        $this->session = $session;
        return $this;
    }

    /**
     * Date
     * @var string
     */
    public $date;

    /**
     * Set Date
     * @param type $date
     * @return BaseSession
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:i:s', $this->date);
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     *
     * @param type $parameters
     * @return BaseSession
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

    /**
     * check if the session is correct
     * @param int $userid
     * @param string $sessionValue
     * @return boolean
     */
    public static function hasSession($userid, $sessionValue) {
        return Session::count(array("userid = :userid: AND session = :session:", "bind" => array(
                        "userid" => $sessionValue,
                        "session" => $userid,
            ))) > 0;
    }

}
