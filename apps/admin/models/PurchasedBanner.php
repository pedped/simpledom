<?php

use Respect\Validation\Rules\String;
use Simpledom\Core\AtaModel;
use Simpledom\Core\Classes\Helper;

class PurchasedBanner extends AtaModel {

    const BANNERTYPE_CITYBANNER = 1;

    public function getSource() {
        return 'purchased_banner';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return PurchasedBanner
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
     * @return PurchasedBanner
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * Valid Until
     * @var string
     */
    public $validuntil;

    /**
     * Set Valid Until
     * @param type $validuntil
     * @return PurchasedBanner
     */
    public function setValiduntil($validuntil) {
        $this->validuntil = $validuntil;
        return $this;
    }

    /**
     * Order ID
     * @var string
     */
    public $orderid;

    /**
     * Set Order ID
     * @param type $orderid
     * @return PurchasedBanner
     */
    public function setOrderid($orderid) {
        $this->orderid = $orderid;
        return $this;
    }

    /**
     * Advert ID
     * @var string
     */
    public $advertid;

    /**
     * Set Advert ID
     * @param type $advertid
     * @return PurchasedBanner
     */
    public function setAdvertid($advertid) {
        $this->advertid = $advertid;
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
     * @return PurchasedBanner
     */
    public function setCityid($cityid) {
        $this->cityid = $cityid;
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
     * @return PurchasedBanner
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Image ID
     * @var string
     */
    public $imageid;

    /**
     * Set Image ID
     * @param type $imageid
     * @return PurchasedBanner
     */
    public function setImageid($imageid) {
        $this->imageid = $imageid;
        return $this;
    }

    /**
     * Banner Type
     * @var string
     */
    public $banner_type;

    /**
     * Set Banner Type
     * @param type $banner_type
     * @return PurchasedBanner
     */
    public function setBanner_type($banner_type) {
        $this->banner_type = $banner_type;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:m:s', $this->date);
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
        return $this->getImage()->link;
    }

    /**
     *
     * @param type $parameters
     * @return PurchasedBanner
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

    /**
     * Get User
     * @return User
     */
    public function getUser() {
        return User::findWithUserID($this->userid);
    }

    public function getEndDay() {
        return Helper::GetPersianDate($this->validuntil);
    }

}
