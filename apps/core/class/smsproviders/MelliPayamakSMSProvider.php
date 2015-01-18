<?php

use Simpledom\Core\Classes\SMSProviderInterface;

class MelliPayamakSMSProvider extends SmsProviderSystem implements SMSProviderInterface {

    public function getDelivered($referneceCode) {
        
    }

    public function getProviderName() {
        
    }

    public function getStatus($id) {
        
    }

    public function getRemain($includeCurrency = true) {

        ini_set("soap.wsdl_cache_enabled", "0");
        $sms_client = new SoapClient('http://87.107.121.54/post/Send.asmx?wsdl', array('encoding' => 'UTF-8'));

        $parameters['username'] = $this->parameters["username"];
        $parameters['password'] = $this->parameters["password"];

        $result = $sms_client->GetCredit($parameters)->GetCreditResult;

        if ($includeCurrency) {
            return intval($result) . " " . _("SMS Messages") . "";
        } else {
            return intval($result);
        }
    }

    public static function isDelivered($referneceCode) {
        
    }

    public function Send($phones, $message, $fromnumber) {

        // turn off the WSDL cache
        //ini_set("soap.wsdl_cache_enabled", "0");

        try {
            $client = new SoapClient("http://api.payamak-panel.com/post/send.asmx?wsdl");
            $parameters['username'] = $this->parameters["username"];
            $parameters['password'] = $this->parameters["password"];
            $parameters['from'] = $fromnumber;
            $parameters['to'] = $phones;
            $parameters['text'] = iconv('UTF-8', 'UTF-8//TRANSLIT', $message);
            $parameters['isflash'] = false;
            $parameters['udh'] = "";
            $parameters['recId'] = array(0);
            $parameters['status'] = 0x0;
            return $client->SendSms($parameters)->SendSmsResult;
        } catch (SoapFault $ex) {
            echo $ex->faultstring;
        }
    }

}
