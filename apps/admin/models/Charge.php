<?php

use Simpledom\Core\AtaModel;

class Charge extends AtaModel implements Orderable {

    public function getSource() {
        return 'charge';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return Charge
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
     * @return Charge
     */
    public function setUserid($userid) {
        $this->userid = $userid;
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
     * @return Charge
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
     * @return Charge
     */
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    /**
     * Phone Number
     * @var string
     */
    public $phonenumber;

    /**
     * Set Phone Number
     * @param type $phonenumber
     * @return Charge
     */
    public function setPhonenumber($phonenumber) {
        $this->phonenumber = $phonenumber;
        return $this;
    }

    /**
     * Target Phone Number
     * @var string
     */
    public $targetphonenumber;

    /**
     * Set Target Phone Number
     * @param type $targetphonenumber
     * @return Charge
     */
    public function setTargetphonenumber($targetphonenumber) {
        $this->targetphonenumber = $targetphonenumber;
        return $this;
    }

    /**
     * Offline Mode
     * @var string
     */
    public $offlinemode;

    /**
     * Set Offline Mode
     * @param type $offlinemode
     * @return Charge
     */
    public function setOfflinemode($offlinemode) {
        $this->offlinemode = $offlinemode;
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
     * @return Charge
     */
    public function setOrderid($orderid) {
        $this->orderid = $orderid;
        return $this;
    }

    /**
     * Credit ID
     * @var string
     */
    public $creditid;

    /**
     * Set Credit ID
     * @param type $creditid
     * @return Charge
     */
    public function setCreditid($creditid) {
        $this->creditid = $creditid;
        return $this;
    }

    /**
     * Elka Trans ID
     * @var string
     */
    public $elkatransid;

    /**
     * Set Elka Trans ID
     * @param type $elkatransid
     * @return Charge
     */
    public function setElkatransid($elkatransid) {
        $this->elkatransid = $elkatransid;
        return $this;
    }

    /**
     * Cart ID
     * @var string
     */
    public $cartid;

    /**
     * Set Cart ID
     * @param type $cartid
     * @return Charge
     */
    public function setCartid($cartid) {
        $this->cartid = $cartid;
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
     * @return Charge
     */
    public function setStatus($status) {
        $this->status = $status;
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
     * @return Charge
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
     * @return Charge
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

    /**
     * Charge Simcart
     * @param type $errors
     * @param User $user user of person who wants to charge
     * @param type $targetPhone phone number that should be charged
     * @param type $type
     * @param type $amount
     */
    public static function ChargeSimCart(&$errors, $user, $targetPhone, $type, $amount) {

        // check if the system is enabled, but we have to firts know the charge type
        $chargeType = ChargeType::findPhoneNumberType($targetPhone);

        // check if we have nderstood phone type
        if (!$chargeType) {
            $errors[] = "سیم کارت در حال حاضر پشتیبانی نمی شود";
            return false;
        }

        // check if system enabled for devide
        if (!self::SystemEnabled($chargeType)) {
            $errors[] = "در حال حاضر امکان شارژ سیم کارت مورد نظر امکان پذیر نمی باشد، لطفا ساعاتی بعدر تلاش نمایید";
            return false;
        }

        return true;
    }

    /**
     * 
     * @param ChargeType $chargeType
     */
    public static function SystemEnabled($chargeType) {

        if (DEBUG_MODE) {
            return true;
        }

        // check disable mode by admin
        if (intval($chargeType->status) != 1) {
            // charge system is disabled by admin
            return false;
        }

        // check if we have any system that is able to charge
        $elka = new Elka($error);
        if ($elka->IsLoggedIn()) {

            // check if elka system is enabled
            if (!$elka->GetStatus(intval($chargeType->id) == ChargeType::CHARGETYPEID_IRANCELL)) {
                // system is disabled
                return false;
            }

            // able to charge
            return true;
        }

        // we was not able to check elka, we have to switch mobinteck
    }

    ////////////////////////////////////////////////
    // Start ORDER INFO
    ////////////////////////////////////////////////



    public static function CheckAvailableToOrder($id) {
        return true;
    }

    public static function GetCost($id) {
        
    }

    public static function GetOrderTitle($id) {
        
    }

    public static function ValidateOrderCreateRequest(&$errors, $id) {
        
    }

    public static function getOrderObjectInfo($id) {
        
    }

    public static function onSuccessOrder(&$errors, $userid, $id, $orderid = null) {
        
    }

    ////////////////////////////////////////////////
    // END ORDER INFO
    ////////////////////////////////////////////////
}
