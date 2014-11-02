<?php

namespace Simpledom\Api\Controllers;

class SmsreceiverController extends ControllerBase {

    private function onReceivedSMS($smsProviderID, $to, $fromnumber, $text) {
        
    }

    public function irapayamakReceiverAction($to, $fromnumber, $text, $token) {
        $this->onReceivedSMS($to, $fromnumber, $text);
    }

}
