<?php

use Simpledom\Core\AtaModel;
use Simpledom\Core\Classes\Config;
use Simpledom\Core\Classes\Helper;

class BannerAdvertPackage extends AtaModel implements Orderable {

    public function getSource() {
        return 'banner_advert_package';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BannerAdvertPackage
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
     * @return BannerAdvertPackage
     */
    public function setTitle($title) {
        $this->title = $title;
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
     * @return BannerAdvertPackage
     */
    public function setDescription($description) {
        $this->description = $description;
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
     * @return BannerAdvertPackage
     */
    public function setCityid($cityid) {
        $this->cityid = $cityid;
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
     * @return BannerAdvertPackage
     */
    public function setPrice($price) {
        $this->price = $price;
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
     * @return BannerAdvertPackage
     */
    public function setEnable($enable) {
        $this->enable = $enable;
        return $this;
    }

    /**
     * Total Days
     * @var string
     */
    public $totaldays;

    /**
     * Set Total Days
     * @param type $totaldays
     * @return BannerAdvertPackage
     */
    public function setTotaldays($totaldays) {
        $this->totaldays = $totaldays;
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
     * @return BannerAdvertPackage
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
     * @return BannerAdvertPackage
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

    public function getValidDateHuman() {
        return $this->totaldays . " روز";
    }

    public function getHumanPrice() {
        return Helper::GetPrice($this->price / 10000000);
    }

    public function getPurchaseButton() {
        return "<a class='btn btn-success btn-lg' href='" . Config::getPublicUrl() . "bongahbanneradvert/purchase/" . $this->id . "' />سفارش تبلیغ</a>";
    }

    //***************************************************************************
    // ORDER INFO
    //***************************************************************************

    /**
     * 
     * @param type $id
     */
    public static function CheckAvailableToOrder($id) {
        // we always allow to purchase sms cost
        // TODO change by settings
        return true;
    }

    /**
     * return the cost of SMS CREDIT
     * @param type $id
     * @return stdClass
     */
    public static function GetCost($id) {
        $item = BannerAdvertPackage::findFirst(array("id = :id:", "bind" => array("id" => $id)));
        $result = new stdClass();
        $result->Price = $item->price;
        $result->Currency = "IRR";
        return $result;
    }

    public static function GetOrderTitle($id) {
        return BannerAdvertPackage::findFirst($id)->title;
    }

    public static function ValidateOrderCreateRequest(&$errors, $id) {
        
    }

    public static function getOrderObjectInfo($id) {

        $smscreditcost = BannerAdvertPackage::findFirst(array("id = :id:", "bind" => array("id" => $id)));

        $item = new stdClass();
        $item->title = "سفارش تبلیغات املاک در صفحه املاک شهر";
        $item->description = "this is a good description";
        $item->Cost = new stdClass();
        $item->Cost->Price = $smscreditcost->price;
        $item->Cost->Currency = "IRR";
        return $item;
    }

    public static function onSuccessOrder(&$errors, $userid, $id, $orderid = NULL) {

        // we have to get bongah id first
        $bongah = Bongah::findFirst(array("userid = :userid:", "bind" => array("userid" => $userid)));

        // get purchased package
        $bannerPackage = BannerAdvertPackage::findFirst(array("id = :id:", "bind" => array("id" => $id)));

        // we have to creare new request
        $purchasedPackage = new PurchasedBanner();
        $purchasedPackage->advertid = $id;
        $purchasedPackage->banner_type = PurchasedBanner::BANNERTYPE_CITYBANNER;
        $purchasedPackage->cityid = $bongah->cityid;
        $purchasedPackage->orderid = $orderid;
        $purchasedPackage->userid = $userid;
        $purchasedPackage->validuntil = (($bannerPackage->totaldays + 1) * ( 3600 * 24)) + time();
        if ($purchasedPackage->create()) {
            // notify user of new purchase
            SMSManager::SendSMS($bongah->mobile, "با تشکر از خرید شما، هم اکنون تبلیغ در شهر انتخابی نمایش داده شده است. در صورت نیاز همکاران ما با شما تماس خواهند گرفت", 1);
            return true;
        } else {
            // there is a problem
            BaseSystemLog::CreateLogFetal("خطا در ساخت اتمام سفارش", $purchasedPackage->getMessagesAsLines());
            return false;
        }
    }

    //***************************************************************************
    // END ORDER INFO
    //***************************************************************************
}
