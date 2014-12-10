<?php

use Phalcon\Mvc\Model\Transaction;
use Simpledom\Core\AtaModel;

class BasePaymentPayline extends AtaModel {

    public static $PaylineIDGetValues = array(
        "IRR" => "Iranian Riyals"
    );

    public function getSource() {
        return 'payment_payline';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BasePaymentPayline
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
     * @return BasePaymentPayline
     */
    public function setUserid($userid) {
        $this->userid = $userid;
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
     * @return BasePaymentPayline
     */
    public function setDate($date) {
        $this->date = $date;
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
     * @return BasePaymentPayline
     */
    public function setAmount($amount) {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Currency
     * @var string
     */
    public $cur;

    /**
     * Set Currency
     * @param type $cur
     * @return BasePaymentPayline
     */
    public function setCur($cur) {
        $this->cur = $cur;
        return $this;
    }

    /**
     * User Transaction ID
     * @var string
     */
    public $usertransactionid;

    /**
     * Set User Transaction ID
     * @param type $usertransactionid
     * @return BasePaymentPayline
     */
    public function setUsertransactionid($usertransactionid) {
        $this->usertransactionid = $usertransactionid;
        return $this;
    }

    /**
     * Payline ID Get
     * @var string
     */
    public $paylineidget;

    /**
     * Set Payline ID Get
     * @param type $paylineidget
     * @return BasePaymentPayline
     */
    public function setPaylineidget($paylineidget) {
        $this->paylineidget = $paylineidget;
        return $this;
    }

 

    /**
     * Payline Transaction ID
     * @var string
     */
    public $paylinetransactionid;

    /**
     * Set Payline Transaction ID
     * @param type $paylinetransactionid
     * @return BasePaymentPayline
     */
    public function setPaylinetransactionid($paylinetransactionid) {
        $this->paylinetransactionid = $paylinetransactionid;
        return $this;
    }

    /**
     * Done
     * @var string
     */
    public $done;

    /**
     * Set Done
     * @param type $done
     * @return BasePaymentPayline
     */
    public function setDone($done) {
        $this->done = $done;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:i:s', $this->date);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        $this->done = "0";
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

    /**
     * get the user behind this payment
     * @return type
     */
    public function getUser() {
        return BaseUser::findFirst($this->userid);
    }

    /**
     * 
     * @param type $parameters
     * @return PaymentPayline
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    /**
     * get the user behind this payment
     * @return type
     */
    public function getUserName() {
        return BaseUser::findFirst($this->userid)->getFullName();
    }

    public function getDoneTag() {
        return ( intval($this->done) == 1 ) ? "<div class='btn btn-sm btn-success' style='padding: 2px 10px;'>Yes</div>" : "<div class='btn btn-sm btn-danger' style='padding: 2px 10px;'>No</div>";
    }

}
