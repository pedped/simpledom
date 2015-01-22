<?php

use Simpledom\Core\AtaModel;

class BaseUserNotification extends AtaModel {

    public function getSource() {
        return 'user_notification';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BaseUserNotification
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
     * @return BaseUserNotification
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * Title
     * @var string
     */
    public $title;

    /**
     * Set Title
     * @param type $title
     * @return BaseUserNotification
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * Message
     * @var string
     */
    public $message;

    /**
     * Set Message
     * @param type $message
     * @return BaseUserNotification
     */
    public function setMessage($message) {
        $this->message = $message;
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
     * @return BaseUserNotification
     */
    public function setLink($link) {
        $this->link = $link;
        return $this;
    }

    /**
     * Link Text
     * @var string
     */
    public $linktext;

    /**
     * Set Link Text
     * @param type $linktext
     * @return BaseUserNotification
     */
    public function setLinktext($linktext) {
        $this->linktext = $linktext;
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
     * @return BaseUserNotification
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Release Date
     * @var string
     */
    public $releasedate;

    /**
     * Set Release Date
     * @param type $releasedate
     * @return BaseUserNotification
     */
    public function setReleasedate($releasedate) {
        $this->releasedate = $releasedate;
        return $this;
    }

    /**
     * Enable
     * @var string
     */
    public $enable;

    /**
     * Set Enable
     * @param type $enable
     * @return BaseUserNotification
     */
    public function setEnable($enable) {
        $this->enable = $enable;
        return $this;
    }

    /**
     * By IP
     * @var string
     */
    public $byip;

    /**
     * Set By IP
     * @param type $byip
     * @return BaseUserNotification
     */
    public function setByip($byip) {
        $this->byip = $byip;
        return $this;
    }

    /**
     * Visited
     * @var string
     */
    public $visited;

    /**
     * Set Visited
     * @param type $visited
     * @return BaseUserNotification
     */
    public function setVisited($visited) {
        $this->visited = $visited;
        return $this;
    }

    /**
     * Visit IP
     * @var string
     */
    public $visitip;

    /**
     * Set Visit IP
     * @param type $visitip
     * @return BaseUserNotification
     */
    public function setVisitip($visitip) {
        $this->visitip = $visitip;
        return $this;
    }

    /**
     * Visit Date
     * @var string
     */
    public $visitdate;

    /**
     * Set Visit Date
     * @param type $visitdate
     * @return BaseUserNotification
     */
    public function setVisitdate($visitdate) {
        $this->visitdate = $visitdate;
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
     * @return BaseUserNotification
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        if (!isset($this->releasedate) || intval($this->releasedate) == 0) {
            $this->releasedate = $this->date + 1;
        }
        $this->visited = "0";
        $this->enable = "1";
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        $item = new stdClass();
        $item->id = $this->id;
        $item->title = $this->title;
        $item->message = $this->message;
        $item->link = $this->link;
        $item->linktext = $this->linktext;
        $item->date = $this->releasedate;
        return $item;
    }

}
