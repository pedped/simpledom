<?php

use Simpledom\Core\AtaModel;

class Melk extends AtaModel {

    public function getSource() {
        return 'melk';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return Melk
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Valid Date
     * @var string
     */
    public $validdate;

    /**
     * Set Valid Date
     * @param type $validdate
     * @return Melk
     */
    public function setValiddate($validdate) {
        $this->validdate = $validdate;
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
     * @return Melk
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * Type
     * @var string
     */
    public $melktypeid;

    /**
     * Set Type
     * @param type $melktypeid
     * @return Melk
     */
    public function setMelktypeid($melktypeid) {
        $this->melktypeid = $melktypeid;
        return $this;
    }

    /**
     * Purpose
     * @var string
     */
    public $melkpurposeid;

    /**
     * Set Purpose
     * @param type $melkpurposeid
     * @return Melk
     */
    public function setMelkpurposeid($melkpurposeid) {
        $this->melkpurposeid = $melkpurposeid;
        return $this;
    }

    /**
     * Condition
     * @var string
     */
    public $melkconditionid;

    /**
     * Set Condition
     * @param type $melkconditionid
     * @return Melk
     */
    public function setMelkconditionid($melkconditionid) {
        $this->melkconditionid = $melkconditionid;
        return $this;
    }

    /**
     * Home Size
     * @var string
     */
    public $home_size;

    /**
     * Set Home Size
     * @param type $home_size
     * @return Melk
     */
    public function setHome_size($home_size) {
        $this->home_size = $home_size;
        return $this;
    }

    /**
     * Lot Size
     * @var string
     */
    public $lot_size;

    /**
     * Set Lot Size
     * @param type $lot_size
     * @return Melk
     */
    public function setLot_size($lot_size) {
        $this->lot_size = $lot_size;
        return $this;
    }

    /**
     * Sale Price
     * @var string
     */
    public $sale_price;

    /**
     * Set Sale Price
     * @param type $sale_price
     * @return Melk
     */
    public function setSale_price($sale_price) {
        $this->sale_price = $sale_price;
        return $this;
    }

    /**
     * Price Per Unit
     * @var string
     */
    public $price_per_unit;

    /**
     * Set Price Per Unit
     * @param type $price_per_unit
     * @return Melk
     */
    public function setPrice_per_unit($price_per_unit) {
        $this->price_per_unit = $price_per_unit;
        return $this;
    }

    /**
     * Ejare
     * @var string
     */
    public $rent_price;

    /**
     * Set Ejare
     * @param type $rent_price
     * @return Melk
     */
    public function setRent_price($rent_price) {
        $this->rent_price = $rent_price;
        return $this;
    }

    /**
     * Rahn
     * @var string
     */
    public $rent_pricerahn;

    /**
     * Set Rahn
     * @param type $rent_pricerahn
     * @return Melk
     */
    public function setRent_pricerahn($rent_pricerahn) {
        $this->rent_pricerahn = $rent_pricerahn;
        return $this;
    }

    /**
     * Bedrooms
     * @var string
     */
    public $bedroom;

    /**
     * Set Bedrooms
     * @param type $bedroom
     * @return Melk
     */
    public function setBedroom($bedroom) {
        $this->bedroom = $bedroom;
        return $this;
    }

    /**
     * Bath
     * @var string
     */
    public $bath;

    /**
     * Set Bath
     * @param type $bath
     * @return Melk
     */
    public function setBath($bath) {
        $this->bath = $bath;
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
     * @return Melk
     */
    public function setStateid($stateid) {
        $this->stateid = $stateid;
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
     * @return Melk
     */
    public function setCityid($cityid) {
        $this->cityid = $cityid;
        return $this;
    }

    /**
     * Create By
     * @var string
     */
    public $createby;

    /**
     * Set Create By
     * @param type $createby
     * @return Melk
     */
    public function setCreateby($createby) {
        $this->createby = $createby;
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
     * @return Melk
     */
    public function setFeatured($featured) {
        $this->featured = $featured;
        return $this;
    }

    /**
     * Approved
     * @var string
     */
    public $approved;

    /**
     * Set Approved
     * @param type $approved
     * @return Melk
     */
    public function setApproved($approved) {
        $this->approved = $approved;
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
     * @return Melk
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
     * @return Melk
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        // increase total one day
        $this->validdate = time() + 3600 * 24 * 1;
        $this->price_per_unit = 1;
        $this->melkconditionid = 1;
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

}
