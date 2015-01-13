<?php

use Simpledom\Core\AtaModel;

class ChargeType extends AtaModel {

    const CHARGETYPEID_IRANCELL = 1;
    const CHARGETYPEID_TCI = 2;

    public function getSource() {
        return 'charge_type';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return ChargeType
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Name
     * @var string
     */
    public $name;

    /**
     * Set Name
     * @param type $name
     * @return ChargeType
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Persian Name
     * @var string
     */
    public $persianname;

    /**
     * Set Persian Name
     * @param type $persianname
     * @return ChargeType
     */
    public function setPersianname($persianname) {
        $this->persianname = $persianname;
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
     * @return ChargeType
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * Status Message
     * @var string
     */
    public $statusmessage;

    /**
     * Set Status Message
     * @param type $statusmessage
     * @return ChargeType
     */
    public function setStatusmessage($statusmessage) {
        $this->statusmessage = $statusmessage;
        return $this;
    }

    /**
     *
     * @param type $parameters
     * @return ChargeType
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

    /**
     * Check for charge type
     * @param int $targetPhone
     * @return boolean|ChargeType if found , return type , otthwise return false
     */
    public static function findPhoneNumberType($targetPhone) {
        if (substr($targetPhone, 0, 3) == "093") {
            // irancel
            return ChargeType::findFirst(ChargeType::CHARGETYPEID_IRANCELL);
        }if (substr($targetPhone, 0, 3) == "091") {
            // irancel
            return ChargeType::findFirst(ChargeType::CHARGETYPEID_TCI);
        }

        // invalid
        return false;
    }

}
