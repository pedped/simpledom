<?php

use Phalcon\Mvc\Model\Resultset;
use Simpledom\Core\AtaModel;

class MelkPhoneListner extends AtaModel {

    public function getSource() {
        return 'melkphonelistner';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return MelkPhoneListner
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Purpose ID
     * @var string
     */
    public $melkpurposeid;

    /**
     * Set Purpose ID
     * @param type $melkpurposeid
     * @return MelkPhoneListner
     */
    public function setMelkpurposeid($melkpurposeid) {
        $this->melkpurposeid = $melkpurposeid;
        return $this;
    }

    /**
     * Type ID
     * @var string
     */
    public $melktypeid;

    /**
     * Set Type ID
     * @param type $melktypeid
     * @return MelkPhoneListner
     */
    public function setMelktypeid($melktypeid) {
        $this->melktypeid = $melktypeid;
        return $this;
    }

    /**
     * Bedroom Start
     * @var string
     */
    public $bedroom_start;

    /**
     * Set Bedroom Start
     * @param type $bedroom_start
     * @return MelkPhoneListner
     */
    public function setBedroom_start($bedroom_start) {
        $this->bedroom_start = $bedroom_start;
        return $this;
    }

    /**
     * Bedroom End
     * @var string
     */
    public $bedroom_end;

    /**
     * Set Bedroom End
     * @param type $bedroom_end
     * @return MelkPhoneListner
     */
    public function setBedroom_end($bedroom_end) {
        $this->bedroom_end = $bedroom_end;
        return $this;
    }

    /**
     * Phone ID
     * @var string
     */
    public $phoneid;

    /**
     * Set Phone ID
     * @param type $phoneid
     * @return MelkPhoneListner
     */
    public function setPhoneid($phoneid) {
        $this->phoneid = $phoneid;
        return $this;
    }

    /**
     * Received Count
     * @var string
     */
    public $receivedcount;

    /**
     * Set Received Count
     * @param type $receivedcount
     * @return MelkPhoneListner
     */
    public function setReceivedcount($receivedcount) {
        $this->receivedcount = $receivedcount;
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
     * @return MelkPhoneListner
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * Rent Price Start
     * @var string
     */
    public $rent_price_start;

    /**
     * Set Rent Price Start
     * @param type $rent_price_start
     * @return MelkPhoneListner
     */
    public function setRent_price_start($rent_price_start) {
        $this->rent_price_start = $rent_price_start;
        return $this;
    }

    /**
     * Rent Price End
     * @var string
     */
    public $rent_price_end;

    /**
     * Set Rent Price End
     * @param type $rent_price_end
     * @return MelkPhoneListner
     */
    public function setRent_price_end($rent_price_end) {
        $this->rent_price_end = $rent_price_end;
        return $this;
    }

    /**
     * Rahn Start
     * @var string
     */
    public $rent_pricerahn_start;

    /**
     * Set Rahn Start
     * @param type $rent_pricerahn_start
     * @return MelkPhoneListner
     */
    public function setRent_pricerahn_start($rent_pricerahn_start) {
        $this->rent_pricerahn_start = $rent_pricerahn_start;
        return $this;
    }

    /**
     * Rahn End
     * @var string
     */
    public $rent_pricerahn_end;

    /**
     * Set Rahn End
     * @param type $rent_pricerahn_end
     * @return MelkPhoneListner
     */
    public function setRent_pricerahn_end($rent_pricerahn_end) {
        $this->rent_pricerahn_end = $rent_pricerahn_end;
        return $this;
    }

    /**
     * Sale Start
     * @var string
     */
    public $sale_price_start;

    /**
     * Set Sale Start
     * @param type $sale_price_start
     * @return MelkPhoneListner
     */
    public function setSale_price_start($sale_price_start) {
        $this->sale_price_start = $sale_price_start;
        return $this;
    }

    /**
     * Sale End
     * @var string
     */
    public $sale_price_end;

    /**
     * Set Sale End
     * @param type $sale_price_end
     * @return MelkPhoneListner
     */
    public function setSale_price_end($sale_price_end) {
        $this->sale_price_end = $sale_price_end;
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
     * @return MelkPhoneListner
     */
    public function setDate($date) {
        $this->date = $date;
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
     * @return MelkPhoneListner
     */
    public function setCityid($cityid) {
        $this->cityid = $cityid;
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
     * @return MelkPhoneListner
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        $this->status = "1";
        $this->receivedcount = "0";
        $this->ip = $_SERVER["REMOTE_ADDR"];
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

    /**
     * melkphonelistner
     * @param type $cityID
     * @param type $latitude
     * @param type $longitude
     * @param type $maxDistance
     * @return Resultset
     */
    public static function getNearest($cityID, $latitude, $longitude, $maxDistance) {
        return null;
    }

    public function getPurposeTitle() {
        return MelkPurpose::findFirst($this->melkpurposeid)->name;
    }

    public function getTypeTitle() {
        return MelkType::findFirst($this->melktypeid)->name;
    }

    public function getPhoneNumber() {
        return UserPhone::findFirst($this->phoneid)->phone;
    }

    public function getCityName() {
        return City::findFirst($this->cityid)->name;
    }

}
