<?php

namespace Simpledom\Api\Controllers;

use BaseSystemLog;
use Simpledom\Core\Classes\NotifySMSManager;
use SMSManager;
use SmsNumber;
use SystemLogType;

class SmsreceiverController extends BaseSmsreceiverController {

    public function onReceievdNewSMS($smsProviderID, $to, $fromnumber, $text) {

        $smsNumber = $to;
        $phone = $fromnumber;
        $message = $_GET["message"];
        $errors = array();
        NotifySMSManager::onNewMessageReceived($errors, $smsNumber, $phone, $message);
        if (count($errors) > 0) {
            BaseSystemLog::init($item)->setIP($_SERVER["REMOTE_ADDR"])->setTitle("Error In Message Sending")->setMessage(implode(",", $errors))->setType(SystemLogType::Error)->create();
            //SMSManager::SendSMS($fromnumber, implode("\n", $errors), SmsNumber::findFirst());
        }
    }

}
