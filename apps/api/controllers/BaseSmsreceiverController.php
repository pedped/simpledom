<?php

namespace Simpledom\Api\Controllers;

use BaseSystemLog;
use ReceivedSMS;
use SystemLogType;
use ValidProviderIP;

abstract class BaseSmsreceiverController extends ControllerBase {

    abstract function onReceievdNewSMS($smsProviderID, $to, $fromnumber, $text);

    /**
     * this function will validate received sms provider
     * @param type $smsProviderID
     * @return boolean
     */
    private function validProvider($smsProviderID) {
        $provider = ValidProviderIP::findFirst(array("providerid = :providerid:", "bind" => array("providerid" => $smsProviderID)));
        if ($provider == FALSE || $provider->ip != $_SERVER["REMOTE_ADDR"] || intval($provider->enable) == 0) {
            BaseSystemLog::init($item)->setTitle("invalid sms ip")->setMessage("new sms received from invalid provider ip: " . $_SERVER["REMOTE_ADDR"])->setType(SystemLogType::Error)->setIP($_SERVER["REMOTE_ADDR"])->create();
            return false;
        }

        return true;
    }

    /**
     * check for received sms and store validated sms
     * @param type $smsProviderID
     * @param type $to
     * @param type $fromnumber
     * @param type $text
     * @return type
     */
    private function _onReceivedSMS($smsProviderID, $to, $fromnumber, $text) {
        // store the received SMS
        if (!$this->validProvider($smsProviderID)) {
            return;
        }

        // sms received from valid provider
        $received = new ReceivedSMS();
        $received->fromnumber = $to;
        $received->message = isset($_GET["message"]) ? $_GET["message"] : $text;
        $received->phone = $fromnumber;
        $received->provider = $smsProviderID;
        $received->ip = $_SERVER["REMOTE_ADDR"];
        $received->create();

        // call the function 
        $this->onReceievdNewSMS($smsProviderID, $to, $fromnumber, $text);
    }

    public function irapayamakAction($to, $fromnumber, $text, $token) {
        $this->_onReceivedSMS(1, $to, $fromnumber, $text);
    }

    public function melipayamakAction($to, $fromnumber, $text, $token) {
        $this->_onReceivedSMS(2, $to, $fromnumber, $text);
    }

}
