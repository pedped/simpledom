<?php

use Simpledom\Core\AtaModel;
use Simpledom\Core\Classes\Helper;

class BongahSubscribeItem extends AtaModel {

    public function getSource() {
        return 'bongahsubscribeitem';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BongahSubscribeItem
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
     * @return BongahSubscribeItem
     */
    public function setName($name) {
        $this->name = $name;
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
     * @return BongahSubscribeItem
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Melks Can Add
     * @var string
     */
    public $melkscanadd;

    /**
     * Set Melks Can Add
     * @param type $melkscanadd
     * @return BongahSubscribeItem
     */
    public function setMelkscanadd($melkscanadd) {
        $this->melkscanadd = $melkscanadd;
        return $this;
    }

    /**
     * Price
     * @var string
     */
    public $price;

    /**
     * Set Price
     * @param type $price
     * @return BongahSubscribeItem
     */
    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }

    /**
     * Valid Days
     * @var string
     */
    public $validdate;

    /**
     * Set Valid Days
     * @param type $validdate
     * @return BongahSubscribeItem
     */
    public function setValiddate($validdate) {
        $this->validdate = $validdate;
        return $this;
    }

    /**
     * Send Message To Users
     * @var string
     */
    public $sendmessagetousers;

    /**
     * Set Send Message To Users
     * @param type $sendmessagetousers
     * @return BongahSubscribeItem
     */
    public function setSendmessagetousers($sendmessagetousers) {
        $this->sendmessagetousers = $sendmessagetousers;
        return $this;
    }

    /**
     * Featured
     * @var string
     */
    public $featured;

    /**
     * Set Featured
     * @param type $featured
     * @return BongahSubscribeItem
     */
    public function setFeatured($featured) {
        $this->featured = $featured;
        return $this;
    }

    /**
     * Can See User Phone
     * @var string
     */
    public $canseeuserphone;

    /**
     * Set Can See User Phone
     * @param type $canseeuserphone
     * @return BongahSubscribeItem
     */
    public function setCanseeuserphone($canseeuserphone) {
        $this->canseeuserphone = $canseeuserphone;
        return $this;
    }

    /**
     * Default SMS Credit
     * @var string
     */
    public $defaultsmscredit;

    /**
     * Set Default SMS Credit
     * @param type $defaultsmscredit
     * @return BongahSubscribeItem
     */
    public function setDefaultsmscredit($defaultsmscredit) {
        $this->defaultsmscredit = $defaultsmscredit;
        return $this;
    }

    /**
     * Receive Portal
     * @var string
     */
    public $receiveportal;

    /**
     * Set Receive Portal
     * @param type $receiveportal
     * @return BongahSubscribeItem
     */
    public function setReceiveportal($receiveportal) {
        $this->receiveportal = $receiveportal;
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
     * @return BongahSubscribeItem
     */
    public function setEnable($enable) {
        $this->enable = $enable;
        return $this;
    }

    /**
     *
     * @param type $parameters
     * @return BongahSubscribeItem
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

    public function getHumanPrice() {
        return Helper::getHumanPriceToman($this->price);
    }

}
