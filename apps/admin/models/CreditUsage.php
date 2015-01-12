<?php

use Simpledom\Core\AtaModel;

class CreditUsage extends AtaModel {

    public function getSource() {
        return 'creditusage';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return CreditUsage
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Amount
     * @var string
     */
    public $amount;

    /**
     * Set Amount
     * @param type $amount
     * @return CreditUsage
     */
    public function setAmount($amount) {
        $this->amount = $amount;
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
     * @return CreditUsage
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
     * @return CreditUsage
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
     * @return CreditUsage
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
