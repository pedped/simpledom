<?php

use Simpledom\Core\AtaModel;

class CreditChange extends AtaModel {

    public function getSource() {
        return 'creditchange';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return CreditChange
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
     * @return CreditChange
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * Status
     * @var string
     */
    public $status;

    /**
     * Set Status
     * @param type $status
     * @return CreditChange
     */
    public function setStatus($status) {
        $this->status = $status;
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
     * @return CreditChange
     */
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    /**
     * Charge ID
     * @var string
     */
    public $chargeid;

    /**
     * Set Charge ID
     * @param type $chargeid
     * @return CreditChange
     */
    public function setChargeid($chargeid) {
        $this->chargeid = $chargeid;
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
     * @return CreditChange
     */
    public function setDate($date) {
        $this->date = $date;
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
     * @return CreditChange
     */
    public function setMessage($message) {
        $this->message = $message;
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
     * @return CreditChange
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
