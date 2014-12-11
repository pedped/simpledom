<?php

use Simpledom\Core\AtaModel;

class BaseSmsNumber extends AtaModel {

    public function getSource() {
        return 'smsnumber';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BaseSmsNumber
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Number
     * @var string
     */
    public $number;

    /**
     * Set Number
     * @param type $number
     * @return BaseSmsNumber
     */
    public function setNumber($number) {
        $this->number = $number;
        return $this;
    }

    /**
     * Enable
     * @var string
     */
    public $enable;

    /**
     * Set Enable
     * @param type $enable
     * @return BaseSmsNumber
     */
    public function setEnable($enable) {
        $this->enable = $enable;
        return $this;
    }

    /**
     * Sent Count
     * @var string
     */
    public $sentcount;

    /**
     * Set Sent Count
     * @param type $sentcount
     * @return BaseSmsNumber
     */
    public function setSentcount($sentcount) {
        $this->sentcount = $sentcount;
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
     * @return BaseSmsNumber
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Description
     * @var string
     */
    public $description;

    /**
     * Set Description
     * @param type $description
     * @return BaseSmsNumber
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Provider Name
     * @var string
     */
    public $providerid;

    /**
     * Set Provider Name
     * @param type $providerid
     * @return BaseSmsNumber
     */
    public function setProviderid($providerid) {
        $this->providerid = $providerid;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:i:s', $this->date);
    }

    public function beforeValidationOnCreate() {
        $this->sentcount = 0;
        $this->date = time();
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

}
