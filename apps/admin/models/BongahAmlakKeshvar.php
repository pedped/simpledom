<?php

use Simpledom\Core\AtaModel;

class BongahAmlakKeshvar extends AtaModel {

    public function getSource() {
        return 'bongah_amlakkeshvar';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BongahAmlakKeshvar
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * State
     * @var string
     */
    public $state;

    /**
     * Set State
     * @param type $state
     * @return BongahAmlakKeshvar
     */
    public function setState($state) {
        $this->state = $state;
        return $this;
    }

    /**
     * City
     * @var string
     */
    public $city;

    /**
     * Set City
     * @param type $city
     * @return BongahAmlakKeshvar
     */
    public function setCity($city) {
        $this->city = $city;
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
     * @return BongahAmlakKeshvar
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Code
     * @var string
     */
    public $code;

    /**
     * Set Code
     * @param type $code
     * @return BongahAmlakKeshvar
     */
    public function setCode($code) {
        $this->code = $code;
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
     * @return BongahAmlakKeshvar
     */
    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Mobile
     * @var string
     */
    public $mobile;

    /**
     * Set Mobile
     * @param type $mobile
     * @return BongahAmlakKeshvar
     */
    public function setMobile($mobile) {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * Address
     * @var string
     */
    public $address;

    /**
     * Set Address
     * @param type $address
     * @return BongahAmlakKeshvar
     */
    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

    /**
     * City ID
     * @var string
     */
    public $cityid;

    /**
     * Set City ID
     * @param type $cityid
     * @return BongahAmlakKeshvar
     */
    public function setCityid($cityid) {
        $this->cityid = $cityid;
        return $this;
    }

    /**
     * State ID
     * @var string
     */
    public $stateid;

    /**
     * Set State ID
     * @param type $stateid
     * @return BongahAmlakKeshvar
     */
    public function setStateid($stateid) {
        $this->stateid = $stateid;
        return $this;
    }

    /**
     *
     * @param type $parameters
     * @return BongahAmlakKeshvar
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

}
