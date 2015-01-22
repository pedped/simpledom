<?php

namespace Simpledom\Api\Controllers;

use AppEmailRequest;
use EmailItems;
use Simpledom\Core\Classes\Config;
use Simpledom\Core\Classes\Helper;
use SMSManager;

class SmsreceiverController extends BaseSmsreceiverController {

    public function onReceievdNewSMS($smsProviderID, $to, $fromnumber, $text) {

        // we have received new email, check if message has email address, 
        // try to get email and send app email to the user
        $message = trim($text);

        // check if message is email
        if (filter_var($message, FILTER_VALIDATE_EMAIL) && Helper::getCorrectIraninanMobilePhoneNumber($fromnumber) != FALSE) {


            // store request information
            $appRequest = new AppEmailRequest();
            $appRequest->email = strtolower($message);
            $appRequest->phone = $fromnumber;
            $appRequest->ip = $_SERVER["REMOTE_ADDR"];
            $appRequest->create();

            // it is email address, we have to send app download file email to user
            $emailItems = new EmailItems();
            $emailItems->sendAndroidApp($message, $fromnumber, "گرامی", Config::GetAndroidDownloadLinkWithCounter(), Config::GetAndroidFilePath());


            // send message about receive mode
            SMSManager::SendSMS($fromnumber, "با تشکر، فایل برنامه به ایمیل شما ارسال گردید", 2);
        }
    }

}
