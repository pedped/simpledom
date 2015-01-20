<?php

use Simpledom\Core\AtaModel;

class AppDownload extends AtaModel {

    public function getSource() {
        return 'app_download';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return AppDownload
     */
    public function setId($id) {
        $this->id = $id;
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
     * @return AppDownload
     */
    public function setIp($ip) {
        $this->ip = $ip;
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
     * @return AppDownload
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * Link
     * @var string
     */
    public $link;

    /**
     * Set Link
     * @param type $link
     * @return AppDownload
     */
    public function setLink($link) {
        $this->link = $link;
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
     * @return AppDownload
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * App Version
     * @var string
     */
    public $appversion;

    /**
     * Set App Version
     * @param type $appversion
     * @return AppDownload
     */
    public function setAppversion($appversion) {
        $this->appversion = $appversion;
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
     * @return AppDownload
     */
    public function setAgent($agent) {
        $this->agent = $agent;
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
     * @return AppDownload
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
