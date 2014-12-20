<?php

use Simpledom\Core\AtaModel;

class BaseMobileNotification extends AtaModel {

    public function getSource() {
        return 'mobile_notification';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BaseMobileNotification
     */
    public function setId($id) {
        $this->id = $id;
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
     * @return BaseMobileNotification
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
     * @return BaseMobileNotification
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
     * @return BaseMobileNotification
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
     * @return BaseMobileNotification
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
     * @return BaseMobileNotification
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
     * @return BaseMobileNotification
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
     * @return BaseMobileNotification
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
    public $viewcount;

    /**
     * Set By IP
     * @param type $byip
     * @return BaseMobileNotification
     */
    public function setByip($byip) {
        $this->byip = $byip;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:i:s', $this->date);
    }

    /**
     *
     * @param type $parameters
     * @return BaseMobileNotification
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();

        if (!isset($this->releasedate) || strlen($this->releasedate) == 0) {
            $this->releasedate = time();
        }
        $this->byip = $_SERVER["REMOTE_ADDR"];
        $this->viewcount = 0;
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

    /**
     * this function will increase view count
     * @param User $user
     */
    public function onView($user = null) {
        $this->viewcount++;
        $this->save();
    }

}
