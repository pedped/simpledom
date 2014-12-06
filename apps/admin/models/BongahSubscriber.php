<?php

use Simpledom\Core\AtaModel;

class BongahSubscriber extends AtaModel {

    public function getSource() {
        return 'bongahsubscriber';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BongahSubscriber
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
     * @return BongahSubscriber
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * Bongah Subscribe Item
     * @var string
     */
    public $bongahsubscribeitemid;

    /**
     * Set Bongah Subscribe Item
     * @param type $bongahsubscribeitemid
     * @return BongahSubscriber
     */
    public function setBongahsubscribeitemid($bongahsubscribeitemid) {
        $this->bongahsubscribeitemid = $bongahsubscribeitemid;
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
     * @return BongahSubscriber
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Order ID
     * @var string
     */
    public $orderid;

    /**
     * Set Order ID
     * @param type $orderid
     * @return BongahSubscriber
     */
    public function setOrderid($orderid) {
        $this->orderid = $orderid;
        return $this;
    }

    public function getDate() {
        return Jalali::date('Y-m-d H:i:s', $this->date);
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     *
     * @param type $parameters
     * @return BongahSubscriber
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

    public function getSubscribeItemName() {
        return BongahSubscribeItem::findFirst($this->bongahsubscribeitemid)->name;
    }

}
