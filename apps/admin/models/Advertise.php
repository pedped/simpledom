<?php

use Simpledom\Core\AtaModel;

class Advertise extends AtaModel {

    public function getSource() {
        return 'Advertise';
    }

    public $categoryid;
    public $cityid;

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return Advertise
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
     * @return Advertise
     */
    public function setUserid($userid) {
        $this->userid = $userid;
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
     * @return Advertise
     */
    public function setIp($ip) {
        $this->ip = $ip;
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
     * @return Advertise
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Device ID
     * @var string
     */
    public $deviceid;

    /**
     * Set Device ID
     * @param type $deviceid
     * @return Advertise
     */
    public function setDeviceid($deviceid) {
        $this->deviceid = $deviceid;
        return $this;
    }

    /**
     * Current View
     * @var string
     */
    public $currentview;

    /**
     * Set Current View
     * @param type $currentview
     * @return Advertise
     */
    public function setcurrentview($currentview) {
        $this->currentview = $currentview;
        return $this;
    }

    /**
     * Repaired
     * @var string
     */
    public $repaired;

    /**
     * Set Repaired
     * @param type $repaired
     * @return Advertise
     */
    public function setRepaired($repaired) {
        $this->repaired = $repaired;
        return $this;
    }

    /**
     * Haveholder
     * @var string
     */
    public $haveholder;

    /**
     * Set Haveholder
     * @param type $haveholder
     * @return Advertise
     */
    public function setHaveholder($haveholder) {
        $this->haveholder = $haveholder;
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
     * @return Advertise
     */
    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }

    /**
     * Garantee
     * @var string
     */
    public $garantee;

    /**
     * Set Garantee
     * @param type $garantee
     * @return Advertise
     */
    public function setGarantee($garantee) {
        $this->garantee = $garantee;
        return $this;
    }

    /**
     * More Accecories
     * @var string
     */
    public $moreacc;

    /**
     * Set More Accecories
     * @param type $moreacc
     * @return Advertise
     */
    public function setMoreacc($moreacc) {
        $this->moreacc = $moreacc;
        return $this;
    }

    /**
     * Visit Time
     * @var string
     */
    public $visittime;

    /**
     * Set Visit Time
     * @param type $visittime
     * @return Advertise
     */
    public function setVisittime($visittime) {
        $this->visittime = $visittime;
        return $this;
    }

    /**
     * Image ID
     * @var string
     */
    public $imageid;
    public $description;
    public $status;

    /**
     * Set Image ID
     * @param type $imageid
     * @return Advertise
     */
    public function setImageid($imageid) {
        $this->imageid = $imageid;
        return $this;
    }

    public function getDate() {
        return Jalali::date('Y-m-d', $this->date);
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     * return the image object
     * @return BaseImage
     */
    public function getImage() {
        return BaseImage::findFirst($this->imageid);
    }

    /**
     * return the image link
     * @return String imagelink
     */
    public function getImageLink() {

        if (isset($this->imageid)) {
            return $this->getImage()->link;
        } else {
            return $this->getDevice()->getImageLink();
        }
    }

    public function getHumanPrice() {
        return $this->price . " تومان";
    }

    /**
     *
     * @param type $parameters
     * @return Advertise
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        $this->status = "-1";
        $this->ip = $_SERVER["REMOTE_ADDR"];
    }

    public function beforeValidationOnSave() {
        
    }

    public function getImageLinkTag() {
        return "<img style='max-width: 150px;' src='" . $this->getImageLink() . "' />";
    }

    public function getCategoryName() {
        return Category::findFirst(array("id = :id:", "bind" => array("id" => $this->categoryid)))->title;
    }

    public function getCurrentView() {
        return $this->currentview;
    }

    public function getRepaired() {
        return intval($this->repaired) == 1 ? "بله" : "خیر";
    }

    public function getPublicResponse() {

        $item = new stdClass();

        $item->id = $this->id;
        $item->categoryid = $this->categoryid;
        $item->currentview = $this->currentview;
        $item->date = $this->date;
        $item->humandate = $this->getDate();
        $item->deviceid = $this->deviceid;
        $item->garantee = $this->garantee;
        $item->description = $this->description;
        $item->haveholder = $this->haveholder;
        $item->imageid = $this->imageid;
        $item->moreacc = $this->moreacc;
        $item->price = $this->getHumanPrice();
        $item->repaired = $this->repaired;
        $item->userid = $this->userid;
        $item->visittime = $this->visittime;
        $item->imagelink = $this->getImageLink();
        $item->userphone = $this->getUser()->userphone;
        $item->userrealname = $this->getUser()->getFullName();
        $item->username = $this->getUser()->username;
        $item->userprofileimage = $this->getUser()->getImagelink();

        // mobile info
        $device = Device::findFirst(array("id = :id:", "bind" => array("id" => $this->deviceid)));
        $item->device = $device->getPublicResponse();
        $item->title = $device->name;
        $item->companyname = $device->getCompanyName();
        $item->cityname = $this->getCityName();
        return $item;
    }

    public function getCityName() {
        return City::findFirst($this->cityid)->name;
    }

    /**
     * load device
     * @return Device
     */
    public function getDevice() {
        return Device::findFirst(array("id = :id:", "bind" => array("id" => $this->deviceid)));
    }

    public function getDeviceName() {
        return Device::findFirst(array("id = :id:", "bind" => array("id" => $this->deviceid)))->name;
    }

    /**
     * 
     * @return User
     */
    public function getUser() {
        return User::findWithUserID($this->userid);
    }

    public function getStatusName() {
        switch ($this->status) {
            case "1":
                return "تایید شده";
            case "0":
                return "رد شده";
            case "-1":
                return "در انتظار تایید";
        }
    }

}
