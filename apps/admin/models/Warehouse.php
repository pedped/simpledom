<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;

class Warehouse extends AtaModel {

    public function initialize() {
        
    }

    public function getSource() {
        return 'warehouse';
    }

    /**
     * ID
     * @FieldName('ID')
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return Warehouse
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Longitude
     * @FieldName('Longitude')
     * @var string
     */
    public $longitude;

    /**
     * Set Longitude
     * @param type $longitude
     * @return Warehouse
     */
    public function setLongitude($longitude) {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * Date
     * @FieldName('Date')
     * @var string
     */
    public $date;

    /**
     * Set Date
     * @param type $date
     * @return Warehouse
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Latitude
     * @FieldName('Latitude')
     * @var string
     */
    public $latitude;

    /**
     * Set Latitude
     * @param type $latitude
     * @return Warehouse
     */
    public function setLatitude($latitude) {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * Address
     * @FieldName('Address')
     * @var string
     */
    public $address;

    /**
     * Set Address
     * @param type $address
     * @return Warehouse
     */
    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

    /**
     * City ID
     * @FieldName('City ID')
     * @var string
     */
    public $cityid;

    /**
     * Set City ID
     * @param type $cityid
     * @return Warehouse
     */
    public function setCityid($cityid) {
        $this->cityid = $cityid;
        return $this;
    }

    /**
     * Status
     * @FieldName('Status')
     * @var string
     */
    public $status;

    /**
     * Set Status
     * @param type $status
     * @return Warehouse
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function getDate() {
        return Jalali::date("Y/m/d H:i:s", $this->date);
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     *
     * @param type $parameters
     * @return Warehouse
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
    }

    public function beforeValidationOnSave() {
        
    }

    public function afterFetch() {
        
    }

    public function getPublicResponse() {

        $result = new stdClass();
        $result->ID = $this->id;
        $result->Longitude = $this->longitude;
        $result->Date = $this->date;
        $result->Latitude = $this->latitude;
        $result->Address = $this->address;
        $result->CityID = $this->cityid;
        $result->Status = $this->status;


        return $result;
    }

    //public function validation()
    //{
    //return $this->validationHasFailed() != true;
    //}



    public function getCityName() {
        return City::findFirst($this->cityid)->name;
    }

    public function columnMap() {
        // Keys are the real names in the table and
        // the values their names in the application
        return array('id' => 'id',
            'longitude' => 'longitude',
            'date' => 'date',
            'latitude' => 'latitude',
            'address' => 'address',
            'cityid' => 'cityid',
            'status' => 'status',
        );
    }

}
