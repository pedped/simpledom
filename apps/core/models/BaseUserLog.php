<?php

use Simpledom\Core\AtaModel;

class BaseUserLog extends AtaModel {

    public function getSource() {
        return "userlog";
    }

    public $id;
    public $userid;
    public $action;
    public $info;
    public $date;

    public function beforeValidationOnCreate() {
        $this->date = date(time());
    }

    public function getPublicResponse() {
        
    }

    /**
     * init the new 
     * @param type $userid
     * @return BaseUserLog
     */
    public static function byUserID($userid) {
        $userLog = new BaseUserLog();
        $userLog->userid = $userid;
        return $userLog;
    }

    /**
     * set user action
     * @param type $action
     * @return BaseUserLog
     */
    public function setAction($action) {
        $this->action = $action;
        return $this;
    }

    /**
     * Fetch the user who visited the page
     * @return BaseUser
     */
    public function getUser() {
        return BaseUser::findFirst($this->userid);
    }

    public function getDate() {
        return date("Y-m-d H:i:s", $this->date);
    }

    /**
     * Set Info
     * @param type $title
     * @return BaseUserLog
     */
    public function setInfo($title) {
        $this->info = $title;
        return $this;
    }

}
