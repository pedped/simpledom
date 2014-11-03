<?php

use Simpledom\Core\AtaModel;
use Simpledom\Core\Classes\Config;
use Simpledom\Core\Classes\Helper;

class MelkSubscribeItem extends AtaModel implements Orderable {

    public function getSource() {
        return 'melksubscribeitem';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return MelkSubscribeItem
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
     * @return MelkSubscribeItem
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
     * @return MelkSubscribeItem
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Melk Can Add
     * @var string
     */
    public $melkscanadd;

    /**
     * Set Melk Can Add
     * @param type $melkscanadd
     * @return MelkSubscribeItem
     */
    public function setmelkscanadd($melkscanadd) {
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
     * @return MelkSubscribeItem
     */
    public function setPrice($price) {
        $this->price = $price;
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
     * @return MelkSubscribeItem
     */
    public function setValiddate($validdate) {
        $this->validdate = $validdate;
        return $this;
    }

    /**
     * Send SMS to Users
     * @var string
     */
    public $sendmessagetousers;

    /**
     * Set Send SMS to Users
     * @param type $sendmessagetousers
     * @return MelkSubscribeItem
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
     * @return MelkSubscribeItem
     */
    public function setFeatured($featured) {
        $this->featured = $featured;
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
     * @return MelkSubscribeItem
     */
    public function setEnable($enable) {
        $this->enable = $enable;
        return $this;
    }

    /**
     *
     * @param type $parameters
     * @return MelkSubscribeItem
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
        return Helper::GetPrice($this->price / 10000000);
    }

    /*     * *******************************************************************
     * ORDER INFO
     * ******************************************************************* */

    public static function CheckAvailableToOrder($id) {
        return true;
    }

    public static function GetCost($id) {
        $result = new stdClass();
        $result->Price = MelkSubscribeItem::findFirst($id)->price;
        $result->Currency = "IRR";
        return $result;
    }

    public static function GetOrderTitle($id) {
        return MelkSubscribeItem::findFirst($id)->name;
    }

    public static function ValidateOrderCreateRequest(&$errors, $id) {
        return true;
    }

    public static function getOrderObjectInfo($id) {
        $object = MelkSubscribeItem::findFirst($id);
        $item = new stdClass();
        $item->title = $object->name;
        $item->description = $object->description;
        $item->Cost = new stdClass();
        $item->Cost->Price = $object->price;
        $item->Cost->Currency = "IRR";
        return $item;
    }

    public static function onSuccessOrder(&$errors, $userid, $id) {
        $user = BaseUser::findFirst($userid);
        $user->melksubscriberplanid = $id;
        if (!$user->save()) {
            $errors[] = "خطا در هنگام پایان سفارش";

            $this->LogError("خطا در هنگام پایان سفارش", "در هنگام پایان عملیات سفارش عضویت برای کاربر $userid خطایی رخ داده است");
            return false;
        } else {

            // create new melk subscribe item
            $melkSubscriber = new MelkSubscriber();
            $melkSubscriber->melksubscribeitemid = $id;
            $melkSubscriber->userid = $userid;
            $melkSubscriber->orderid = 1;
            $melkSubscriber->create();

            // saved successfully
            Helper::RedirectToURL(Config::getPublicUrl() . "melk/start");
        }
        return true;
    }

    /*     * ********************************************************************
     * ORDER INFO
     * ******************************************************************* */
}
