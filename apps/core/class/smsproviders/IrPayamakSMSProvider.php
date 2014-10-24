<?php

use Simpledom\Core\Classes\SMSProviderInterface;

class IrPayamakSMSProvider extends SmsProviderSystem implements SMSProviderInterface {

    public function getDelivered($referneceCode) {
        
    }

    public function getProviderName() {
        
    }

    public function getStatus($id) {
        
    }

    public function getRemain($includeCurrency = true) {

        $soapClient = new SoapClient("http://login.irpayamak.com/API/Send.asmx?wsdl");
        $result = $soapClient->Credit(array(
            "username" => $this->parameters["username"],
            "password" => $this->parameters["password"],
        ));

        if ($includeCurrency) {
            return intval($result->CreditResult) . " " . _("SMS Messages") . "";
        } else {
            return intval($result->CreditResult);
        }
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
