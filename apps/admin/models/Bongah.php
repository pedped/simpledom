<?php

use Phalcon\Mvc\Model\Resultset;
use Simpledom\Core\AtaModel;

class Bongah extends AtaModel {

    public function getSource() {
        return 'bongah';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return Bongah
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Title
     * @var string
     */
    public $title;

    /**
     * Set Title
     * @param type $title
     * @return Bongah
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * Shomare Peygiri
     * @var string
     */
    public $peygiri;

    /**
     * Set Shomare Peygiri
     * @param type $peygiri
     * @return Bongah
     */
    public function setPeygiri($peygiri) {
        $this->peygiri = $peygiri;
        return $this;
    }

    /**
     * First Name
     * @var string
     */
    public $fname;

    /**
     * Set First Name
     * @param type $fname
     * @return Bongah
     */
    public function setFname($fname) {
        $this->fname = $fname;
        return $this;
    }

    /**
     * Last Name
     * @var string
     */
    public $lname;

    /**
     * Set Last Name
     * @param type $lname
     * @return Bongah
     */
    public function setLname($lname) {
        $this->lname = $lname;
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
     * @return Bongah
     */
    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

    /**
     * City
     * @var string
     */
    public $cityid;

    /**
     * Set City
     * @param type $cityid
     * @return Bongah
     */
    public function setCityid($cityid) {
        $this->cityid = $cityid;
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
     * @return Bongah
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
     * @return Bongah
     */
    public function setLongitude($longitude) {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * Locations Can Support
     * @var string
     */
    public $locationscansupport;

    /**
     * Set Locations Can Support
     * @param type $locationscansupport
     * @return Bongah
     */
    public function setLocationscansupport($locationscansupport) {
        $this->locationscansupport = $locationscansupport;
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
     * @return Bongah
     */
    public function setMobile($mobile) {
        $this->mobile = $mobile;
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
     * @return Bongah
     */
    public function setPhone($phone) {
        $this->phone = $phone;
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
     * @return Bongah
     */
    public function setEnable($enable) {
        $this->enable = $enable;
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
     * @return Bongah
     */
    public function setFeatured($featured) {
        $this->featured = $featured;
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
     * @return Bongah
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:m:s', $this->date);
    }

    public $userid;
    public $validdate;
    public $bongahsubscribeitemid;
    public $planvaliddate;

    public function getBongahsubscribeitemid() {
        return $this->bongahsubscribeitemid;
    }

    public function setBongahsubscribeitemid($bongahsubscribeitemid) {
        $this->bongahsubscribeitemid = $bongahsubscribeitemid;
        return $this;
    }

    public function getUserid() {
        return $this->userid;
    }

    public function getValiddate() {
        return $this->validdate;
    }

    /**
     * 
     * @param type $userid
     * @return Bongah
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * 
     * @param type $validdate
     * @return Bongah
     */
    public function setValiddate($validdate) {
        $this->validdate = $validdate;
        return $this;
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     *
     * @param type $parameters
     * @return Bongah
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        $this->featured = "0";
        $this->enable = "-1"; // wait for approve
        $this->bongahsubscribeitemid = "0";
        $this->planvaliddate = "0";
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

    public function getCityName() {
        return City::findFirst($this->cityid)->name;
    }

    /**
     * 
     * @return BaseUser
     */
    public function getUser() {
        return BaseUser::findFirst($this->userid);
    }

    /**
     * 
     * find nearset bongah to specefic location
     * @param int $cityID
     * @param double $latitude
     * @param double $longitude
     * @param double $minDistance
     * @return Resultset bongah
     */
    public static function getNearestBongahs($cityID, $latitude, $longitude, $minDistance) {

        $bongah = new Bongah();
        $result = $bongah->rawQuery("select bongah.* ,  
                                ( 3959 * acos( cos( radians(?) ) 
                                       * cos( radians( bongah.latitude ) ) 
                                       * cos( radians( bongah.longitude ) - radians(?) ) 
                                       + sin( radians(?) ) 
                                       * sin( radians( bongah.latitude ) ) ) ) AS distance 
                         from bongah WHERE cityid = ? AND bongah.enable = 1
                         having distance < ? ORDER BY distance", array(
            $latitude, $longitude, $latitude, $cityID, $minDistance
        ));
        return $result;
    }

    /**
     * get supported names
     * @return Array
     */
    public function getSupporrtedLocationsName() {
        $supportsName = array();
        $k = explode(",", $this->locationscansupport);
        foreach ($k as $value) {
            $supportsName[] = Area::findFirst($value)->name;
        }
        return $supportsName;
    }

    public function getSupporrtedLocationsNameAsString() {
        return implode(", ", $this->getSupporrtedLocationsName());
    }

    public function getImagelink() {
        return User::findFirst($this->userid)->getImagelink();
    }

    public function getStateID() {
        return City::findFirst($this->cityid)->stateid;
    }

    /**
     * fetch Bongah Subscribed Plan
     * @return BongahSubscribeItem
     */
    public function getSubscribedPlan() {
        if ($this->bongahsubscribeitemid > 0 && $this->planvaliddate >= time()) {
            return BongahSubscribeItem::findFirst($this->bongahsubscribeitemid);
        } else {
            return null;
        }
    }

    /**
     * get total melk count
     * @return integer
     */
    public function getTotalMelks() {
        return MelkInfo::count(array("bongahid = :bongahid:", "bind" => array("bongahid" => $this->id)));
    }

}
