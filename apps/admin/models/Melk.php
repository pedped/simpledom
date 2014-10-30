<?php

use Phalcon\Mvc\Model\Resultset;
use Simpledom\Core\AtaModel;
use Simpledom\Core\Classes\Config;
use Simpledom\Core\Classes\Helper;

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
     * Hidden value of melkinfo
     * @var MelkInfo 
     */
    private $melkinfo;

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
        return Jalali::date("Y/m/d-H:i:s", $this->date);
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

    public function getTypeName() {
        return MelkType::findFirst($this->melktypeid)->name;
    }

    public function getPurposeType() {
        return MelkPurpose::findFirst($this->melkpurposeid)->name;
    }

    public function getCondiationType() {
        return MelkCondition::findFirst($this->melkconditionid)->name;
    }

    public function getCityName() {
        return City::findFirst($this->cityid)->name;
    }

    /**
     * Get Nearset Melks
     * @param type $cityID
     * @param type $latitude
     * @param type $longitude
     * @param type $minDistance
     * @return Resultset
     */
    public static function getNearest($cityID, $latitude, $longitude, $minDistance) {
        $melk = new Melk();
        $result = $melk->rawQuery("select melk.* ,  
                                ( 3959 * acos( cos( radians(?) ) 
                                       * cos( radians( melkinfo.latitude ) ) 
                                       * cos( radians( melkinfo.longitude ) - radians(?) ) 
                                       + sin( radians(?) ) 
                                       * sin( radians( melkinfo.latitude ) ) ) ) AS distance 
                         FROM melk JOIN melkinfo ON  melk.id = melkinfo.melkid WHERE melk.cityid = ?
                         having distance < ? ORDER BY distance", array(
            $latitude, $longitude, $latitude, $cityID, $minDistance
        ));
        return $result;
    }

    /**
     * Get Melk Information
     * @return MelkInfo
     */
    public function getInfo() {
        if (isset($this->melkinfo)) {
            return $this->melkinfo;
        } else {
            $this->melkinfo = MelkInfo::findFirst(array("melkid = :melkid:", "bind" => array("melkid" => $this->id)));
            return $this->melkinfo;
        }
    }

    public function getCreateByTilte() {
        return MelkCreatedBy::findFirst($this->createby)->name;
    }

    public function getViewButton() {
        $purl = Config::getPublicUrl();
        $html = "<a href='$purl" . "melk/view/" . $this->id . "'>مشاهده ملک</a>";
        return $html;
    }

    /**
     * 
     * @return Resultset
     */
    public function getImages() {
        return MelkImage::find(array("melkid = :melkid:", "bind" => array("melkid" => $this->id)));
    }

    public function getZirbana() {
        return Helper::GetSpace($this->home_size);
    }

    public function getMetraj() {
        return Helper::GetSpace($this->lot_size);
    }

    public function getSalePrice() {
        return Helper::GetPrice($this->sale_price);
    }

    public function getEjarePrice() {
        return Helper::GetPrice($this->rent_price);
    }

    public function getRahnPrice() {
        return Helper::GetPrice($this->rent_pricerahn);
    }

    /**
     * 
     * @param type $maxDistance
     * @return Resultset
     */
    public function getNearsetBongahs($maxDistance = 10) {
        return Bongah::getNearestBongahs($this->cityid, $this->getInfo()->latitude, $this->getInfo()->longitude, $maxDistance);
    }

    /**
     * return The Bongah who created the melk
     * @return null|Bongah
     */
    public function getBongah() {
        if (intval($this->createby) == 1) {
            return Bongah::findFirst(array("id = :id:", "bind" => array("id" => $this->getInfo()->bongahid)));
        } else {
            return null;
        }
    }

    /**
     * Get Contact Email
     */
    public function getContactEmail() {
        switch ($this->createby) {
            case 1:
                // bongah dar
                return $this->getBongah()->getUser()->email;
            case 2:
                // karbare site
                return $this->getUser()->email;
            case 3:
                // modiriyate site
                return Settings::Get()->contactemail;
            default :
                $this->LogError("Invalid Type", "Invalid getContactEmail()");
                break;
        }
    }

    /**
     * Get Contact Phone Number For Melk
     * @return type
     */
    public function getContactPhone() {
        switch ($this->createby) {
            case 1:
                // bongah dar
                return $this->getBongah()->mobile;
            case 2:
                // karbare site
                return $this->getInfo()->private_mobile;
            case 3:
                // modiriyate site
                return Settings::$mobilephonenumber;
            default :
                $this->LogError("Invalid Type", "Invalid getContactPhone()");
                break;
        }
    }

    /**
     * 
     * @return BaseUser 
     */
    public function getUser() {
        return BaseUser::findFirst($this->userid);
    }

    /**
     * check if the melk has facility based on facility id
     * @param int $facilityID
     * @return boolean
     */
    public function hasFacility($facilityID) {
        $melkinfo = $this->getInfo();
        $facilities = explode(",", $melkinfo->facilities);
        foreach ($facilities as $item) {
            if (intval($facilityID) == intval($item)) {
                return true;
            }
        }

        return false;
    }

    public function getQuickInfo() {
        $message = "";

        // add type
        $message.= $this->getTypeName();


        switch (intval($this->melktypeid)) {
            case 1:
                // home
                $message.= $this->bedroom . " خوابه" . "،";
                $message.= "متراژ" . $this->lot_size . " مترمربع" . "،";
                $message.= "زیربنا" . $this->home_size . " مترمربع" . "،";
                break;
            case 2:
                // apartment
                $message.= $this->bedroom . " خوابه" . "،";
                $message.= "زیربنا" . $this->home_size . " مترمربع" . "،";
                break;
            case 3:
                // daftare kar
                $message.="دفتر کار" . "،";
                $message.= "متراژ" . $this->home_size . " مترمربع" . "،";
                break;
            case 4:
                // villa
                $message.= $this->bedroom . " خوابه" . "،";
                $message.= $this->lot_size . " متری" . "،";
                break;
            case 5:
                //zamin
                $message.= $this->lot_size . " متری" . "،";
                break;
            case 6:
                // oraghe kar
                $message .= $this->bedroom . " اتاقه" . "،";
                break;
            default:
                $this->LogError("Invalid Melk Type", "getQuickInfo()");
                break;
        }


        switch ($this->melkpurposeid) {
            case 1 :
                $message.= "جهت فروش" . " ";
                $message .= "به مبلغ " . Helper::GetPrice($this->sale_price) . " ،";
                break;
            case 2 :
                $message .= "جهت رهن و اجاره" . " ";
                $message .= "به رهن " . Helper::GetPrice($this->rent_pricerahn) . " و اجاره" . Helper::GetPrice($this->rent_price) . " ،";
                break;
            case 3 :
                $message.= "جهت اجاره و فروش" . " ";
                $message .= "به مبلغ " . Helper::GetPrice($this->sale_price) . " ";
                $message .= "به رهن " . Helper::GetPrice($this->rent_pricerahn) . " و اجاره" . Helper::GetPrice($this->rent_price) . " ،";
                break;
            default:
                break;
        }


        $message.= "واقع در" . " " . $this->getInfo()->address . "." . " کد ملک: " . $this->id;

        return $message;
    }

}
