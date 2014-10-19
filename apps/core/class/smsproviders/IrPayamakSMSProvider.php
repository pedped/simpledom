<?php

use Simpledom\Core\Classes\SMSProviderInterface;

class IrPayamakSMSProvider extends SmsProviderSystem implements SMSProviderInterface {

    public function getDelivered($referneceCode) {
        
    }

    public function getProviderName() {
        
    }

    public function getStatus($id) {
        
    }

    public static function getRemain() {
        
    }

    public static function isDelivered($referneceCode) {
        
    }

    public function Send($phones, $message, $fromnumber) {

        $soapClient = new SoapClient("http://login.irpayamak.com/API/Send.asmx?wsdl");
        return $soapClient->SendSms(array(
                    "username" => $this->parameters["username"],
                    "password" => $this->parameters["password"],
                    "text" => $message,
                    "to" => $phones,
                    "from" => $fromnumber,
                    "flash" => false,
        ));
    }

}
