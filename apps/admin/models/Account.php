<?php

use Simpledom\Core\AtaModel;
use Simpledom\Core\Classes\Helper;

class Account extends AtaModel implements Orderable {

    public function getSource() {
        return 'account';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return Account
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
     * @return Account
     */
    public function setTitle($title) {
        $this->title = $title;
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
     * @return Account
     */
    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }

    /**
     * Credit
     * @var string
     */
    public $credit;

    /**
     * Set Credit
     * @param type $credit
     * @return Account
     */
    public function setCredit($credit) {
        $this->credit = $credit;
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
     * @return Account
     */
    public function setDate($date) {
        $this->date = $date;
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
     * @return Account
     */
    public function setEnable($enable) {
        $this->enable = $enable;
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
     * @return Account
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

    /*     * *******************************************************************
     * ORDER INFO
     * ******************************************************************* */

    public static function CheckAvailableToOrder($id) {
        return true;
    }

    public static function GetCost($id) {
        $result = new stdClass();
        $result->Price = Account::findFirst($id)->price;
        $result->Currency = "IRR";
        return $result;
    }

    public static function GetOrderTitle($id) {
        return Account::findFirst($id)->title;
    }

    public static function ValidateOrderCreateRequest(&$errors, $id) {
        return true;
    }

    public static function getOrderObjectInfo($id) {
        $object = Account::findFirst($id);
        $item = new stdClass();
        $item->title = $object->title;
        $item->description = "بسته های اینترنتی";
        $item->Cost = new stdClass();
        $item->Cost->Price = $object->price;
        $item->Cost->Currency = "IRR";
        return $item;
    }

    public static function onSuccessOrder(&$errors, $userid, $id, $orderid = null) {

        $account = Account::findFirst($id);
        $userPhone = UserPhone::findFirst(array("userid = :userid:", "bind" => array("userid" => $userid)))->phone;

        $ibsngUserID = IBSngFunctions::GetUserID($errors, $userPhone . "");
        // we have to increase user credit
        $result = IBSngFunctions::ChangeCredit($errors, $ibsngUserID, $account->credit);
        if ($result == TRUE) {

            // send user a message about this
            SMSManager::SendSMS($userPhone, Settings::Get()->accuntmessage, SmsNumber::findFirst("enable = 1")->id);

            // redirect user to success page
            Helper::RedirectToURL("index/success/" . $userPhone);
            return true;
        } else {
            return false;
        }
    }

}
