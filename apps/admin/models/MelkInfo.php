<?php

use Simpledom\Core\AtaModel;

class MelkInfo extends AtaModel {

    public function getSource() {
        return 'melkinfo';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return MelkInfo
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Melk ID
     * @var string
     */
    public $melkid;

    /**
     * Set Melk ID
     * @param type $melkid
     * @return MelkInfo
     */
    public function setMelkid($melkid) {
        $this->melkid = $melkid;
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
     * @return MelkInfo
     */
    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

    /**
     * Latitude
     * @var string
     */
    public $latitude;

    /**
     * Set Latitude
     * @param type $latitude
     * @return MelkInfo
     */
    public function setLatitude($latitude) {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * Longitude
     * @var string
     */
    public $longitude;

    /**
     * Set Longitude
     * @param type $longitude
     * @return MelkInfo
     */
    public function setLongitude($longitude) {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * Facilities
     * @var string
     */
    public $facilities;

    /**
     * Set Facilities
     * @param type $facilities
     * @return MelkInfo
     */
    public function setFacilities($facilities) {
        $this->facilities = $facilities;
        return $this;
    }

    /**
     * Total View
     * @var string
     */
    public $total_view;

    /**
     * Set Total View
     * @param type $total_view
     * @return MelkInfo
     */
    public function setTotal_view($total_view) {
        $this->total_view = $total_view;
        return $this;
    }

    /**
     * Search Meta Information
     * @var string
     */
    public $search_meta;

    /**
     * Set Search Meta Information
     * @param type $search_meta
     * @return MelkInfo
     */
    public function setSearch_meta($search_meta) {
        $this->search_meta = $search_meta;
        return $this;
    }

    /**
     * Private Phone
     * @var string
     */
    public $private_phone;

    /**
     * Set Private Phone
     * @param type $private_phone
     * @return MelkInfo
     */
    public function setPrivate_phone($private_phone) {
        $this->private_phone = $private_phone;
        return $this;
    }

    /**
     * Private Mobile
     * @var string
     */
    public $private_mobile;

    /**
     * Set Private Mobile
     * @param type $private_mobile
     * @return MelkInfo
     */
    public function setPrivate_mobile($private_mobile) {
        $this->private_mobile = $private_mobile;
        return $this;
    }

    /**
     * Private Address
     * @var string
     */
    public $private_address;

    /**
     * Set Private Address
     * @param type $private_address
     * @return MelkInfo
     */
    public function setPrivate_address($private_address) {
        $this->private_address = $private_address;
        return $this;
    }

    public $canreferbongah;
    public $description;
    public $bongahid;

    public function getCanreferbongah() {
        return $this->canreferbongah;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setCanreferbongah($canreferbongah) {
        $this->canreferbongah = $canreferbongah;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     *
     * @param type $parameters
     * @return MelkInfo
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->total_view = 0;
        $this->facilities = isset($this->facilities) && strlen($this->facilities) > 0 ? $this->facilities : "";
        $this->search_meta = "";
        $this->canreferbongah = "0";
        $this->bongahid = isset($this->bongahid) && intval($this->bongahid) > 0 ? $this->bongahid : "0";
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

}
