<?php

use Simpledom\Core\AtaModel;

class BaseSMSCreditCost extends AtaModel implements Orderable {

    public function getSource() {
        return 'smscreditcost';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BaseSMSCreditCost
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Title
     * @var string
     */
    public $price;

    /**
     * Title
     * @var string
     */
    public $title;

    /**
     * Set Title
     * @param type $title
     * @return BaseSMSCreditCost
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
     * @return BaseSMSCreditCost
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Total SMS
     * @var string
     */
    public $totalsms;

    /**
     * Set Total SMS
     * @param type $totalsms
     * @return BaseSMSCreditCost
     */
    public function setTotalsms($totalsms) {
        $this->totalsms = $totalsms;
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
     * @return BaseSMSCreditCost
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:i:s', $this->date);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        $item = new stdClass();
        $item->id = $this->id;
        $item->price = $this->price;
        $item->title = $this->title;
        $item->totalsms = $this->totalsms;
        $item->description = $this->description;
        return $item;
    }

    /**
     * 
     * @param type $parameters
     * @return SMSCreditCost
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
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
        $item = SMSCreditCost::findFirst($id);
        $result = new stdClass();
        $result->Price = $item->price;
        $result->Currency = "IRR";
        return $result;
    }

    public static function GetOrderTitle($id) {
        return SMSCreditCost::findFirst($id)->title;
    }

    public static function ValidateOrderCreateRequest(&$errors, $id) {
        
    }

    public static function getOrderObjectInfo($id) {
        $item = new stdClass();
        $item->title = "hello";
        $item->description = "this is a good description";
        $item->Cost = new stdClass();
        $item->Cost->Price = 10;
        $item->Cost->Currency = "IRR";
        return $item;
    }

    public static function onSuccessOrder(&$errors, $userid, $id, $orderid = NULL) {
        // user has purchased item successfully, we have to increase the user sms 
        // credit
        $smsCreditCost = SMSCreditCost::findFirst($id);
        $smsCreditChange = new SMSCreditChange();
        $smsCreditChange->value = $smsCreditCost->totalsms;
        $smsCreditChange->userid = $userid;
        if (!$smsCreditChange->create()) {
            // unable to create user value
            BaseSystemLog::init($KKKKKK)->setType(SystemLogType::Error)->setTitle("User purchased SMS credit, But we were unable to add sms credit : " . $smsCreditChange->getMessagesAsLines())->setTitle("Add SMS Credit")->setIP($_SERVER["REMOTE_ADDR"])->create();
        } else {
            // increase user credit
            if (SMSCredit::findFirst(array("userid = :userid:", "bind" => array("userid" => $userid)))) {
                $item = SMSCredit::findFirst(array("userid = :userid:", "bind" => array("userid" => $userid)));
                $item->value += $smsCreditCost->totalsms;
                return $item->save();
            } else {
                // we have to create new item
                $smscredit = new SMSCredit();
                $smscredit->value = $smsCreditCost->totalsms;
                $smscredit->userid = $userid;
                return $smscredit->create();
            }
        }

        return false;
    }

    //***************************************************************************
    // END ORDER INFO
    //***************************************************************************
}
