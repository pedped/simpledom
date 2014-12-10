<?php

use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;

class BaseSentsms extends AtaModel {

    public function getSource() {
        return 'sentsms';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BaseSentsms
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Phone
     * @var string
     */
    public $phone;

    /**
     * Set Phone
     * @param type $phone
     * @return BaseSentsms
     */
    public function setPhone($phone) {
        $this->phone = $phone;
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
     * @return BaseSentsms
     */
    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    /**
     * From Number
     * @var string
     */
    public $fromnumber;

    /**
     * Set From Number
     * @param type $fromnumber
     * @return BaseSentsms
     */
    public function setFromnumber($fromnumber) {
        $this->fromnumber = $fromnumber;
        return $this;
    }

    /**
     * IP
     * @var string
     */
    public $ip;

    /**
     * Set IP
     * @param type $ip
     * @return BaseSentsms
     */
    public function setIp($ip) {
        $this->ip = $ip;
        return $this;
    }

    /**
     * Provider
     * @var string
     */
    public $provider;

    /**
     * Set Provider
     * @param type $provider
     * @return BaseSentsms
     */
    public function setProvider($provider) {
        $this->provider = $provider;
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
     * @return BaseSentsms
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Result
     * @var string
     */
    public $result;

    /**
     * Set Result
     * @param type $result
     * @return BaseSentsms
     */
    public function setResult($result) {
        $this->result = $result;
        return $this;
    }

    /**
     * Reference Code
     * @var string
     */
    public $refcode;

    /**
     * Set Reference Code
     * @param type $refcode
     * @return BaseSentsms
     */
    public function setRefcode($refcode) {
        $this->refcode = $refcode;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:i:s', $this->date);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

    public function getProviderName() {
        return SMSProvider::findFirst($this->provider)->name;
    }

}
