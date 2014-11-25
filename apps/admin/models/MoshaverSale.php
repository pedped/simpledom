<?php

use Simpledom\Core\AtaModel;

class MoshaverSale extends AtaModel {

    public function getSource() {
        return 'moshaver_sale';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return MoshaverSale
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
     * @return MoshaverSale
     */
    public function setUserid($userid) {
        $this->userid = $userid;
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
     * @return MoshaverSale
     */
    public function setOrderid($orderid) {
        $this->orderid = $orderid;
        return $this;
    }

    /**
     * Percent
     * @var string
     */
    public $percent;

    /**
     * Set Percent
     * @param type $percent
     * @return MoshaverSale
     */
    public function setPercent($percent) {
        $this->percent = $percent;
        return $this;
    }

    /**
     * Value
     * @var string
     */
    public $value;

    /**
     * Set Value
     * @param type $value
     * @return MoshaverSale
     */
    public function setValue($value) {
        $this->value = $value;
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
     * @return MoshaverSale
     */
    public function setDate($date) {
        $this->date = $date;
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
     * @return MoshaverSale
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
