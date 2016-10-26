<?php

use Simpledom\Core\AtaModel;
use Simpledom\Core\Classes\Helper;

class BaseOnTimeToken extends AtaModel {

    public function getSource() {
        return 'onetimetoken';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BaseOnTimeToken
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * userid
     * @var string
     */
    public $userid;

    /**
     * Set userid
     * @param type $userid
     * @return BaseOnTimeToken
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * token
     * @var string
     */
    public $token;

    /**
     * Set token
     * @param type $token
     * @return BaseOnTimeToken
     */
    public function setToken($token) {
        $this->token = $token;
        return $this;
    }

    /**
     * date
     * @var string
     */
    public $date;

    /**
     * Set date
     * @param type $date
     * @return BaseOnTimeToken
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getDate() {
         return Jalali::date("Y/m/d H:i:s", $this->date);
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     *
     * @param type $parameters
     * @return BaseOnTimeToken
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

    public static function GenerateToken($userid) {
        $oneTimeToken = new OneTimeToken();
        $oneTimeToken->userid = $userid;
        $oneTimeToken->token = Helper::GenerateRandomString(64);
        if ($oneTimeToken->create()) {
            return $oneTimeToken->token;
        }
        // unable to create token
        return false;
    }

}
