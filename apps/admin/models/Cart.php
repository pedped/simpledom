<?php

use Simpledom\Core\AtaModel;

class Cart extends AtaModel {

    public function getSource() {
        return 'cart';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return Cart
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Type
     * @var string
     */
    public $type;

    /**
     * Set Type
     * @param type $type
     * @return Cart
     */
    public function setType($type) {
        $this->type = $type;
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
     * @return Cart
     */
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    /**
     * Serial
     * @var string
     */
    public $serial;

    /**
     * Set Serial
     * @param type $serial
     * @return Cart
     */
    public function setSerial($serial) {
        $this->serial = $serial;
        return $this;
    }

    /**
     * Used
     * @var string
     */
    public $used;

    /**
     * Set Used
     * @param type $used
     * @return Cart
     */
    public function setUsed($used) {
        $this->used = $used;
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
     * @return Cart
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
     * @return Cart
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
