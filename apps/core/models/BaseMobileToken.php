<?php

use Simpledom\Core\AtaModel;

class BaseMobileToken extends AtaModel {

    public function getSource() {
        return 'user_mobile_token';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BaseMobileToken
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
     * @return BaseMobileToken
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * Device ID
     * @var string
     */
    public $deviceid;

    /**
     * Set Device ID
     * @param type $deviceid
     * @return BaseMobileToken
     */
    public function setDeviceid($deviceid) {
        $this->deviceid = $deviceid;
        return $this;
    }

    /**
     * Device Type
     * @var string
     */
    public $devicetype;

    /**
     * Set Device Type
     * @param type $devicetype
     * @return BaseMobileToken
     */
    public function setDevicetype($devicetype) {
        $this->devicetype = $devicetype;
        return $this;
    }

    /**
     * Token
     * @var string
     */
    public $token;

    /**
     * Set Token
     * @param type $token
     * @return BaseMobileToken
     */
    public function setToken($token) {
        $this->token = $token;
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
     * @return BaseMobileToken
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:m:s', $this->date);
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     *
     * @param type $parameters
     * @return BaseMobileToken
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

}
