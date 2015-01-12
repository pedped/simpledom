<?php

use Simpledom\Core\AtaModel;

class UnsuccessCharge extends AtaModel {

    public function getSource() {
        return 'unsuccesscharge';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return UnsuccessCharge
     */
    public function setId($id) {
        $this->id = $id;
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
     * @return UnsuccessCharge
     */
    public function setChargeid($chargeid) {
        $this->chargeid = $chargeid;
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
     * @return UnsuccessCharge
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
     * @return UnsuccessCharge
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
     * @return UnsuccessCharge
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
