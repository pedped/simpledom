<?php

use Simpledom\Core\Classes\SMSProviderInterface;

class KavehnegarSMSProvider extends SmsProviderSystem implements SMSProviderInterface {

    public function getDelivered($referneceCode) {
        
    }

    public function getProviderName() {
        
    }

    public function getStatus($id) {
        
    }

    public function getRemain($includeCurrency = true) {

        $soapClient = new SoapClient("http://api.kavenegar.com/soap/v1.asmx?WSDL");
        $result = $soapClient->RemainCreditByLogininfo(array(
            "username" => $this->parameters["username"],
            "password" => $this->parameters["password"],
        ));

        if ($includeCurrency) {
            return intval($result) . " " . _("SMS Messages") . "";
        } else {
            return intval($result);
        }
    }

    public static function isDelivered($referneceCode) {
        
    }

    public function SendVerificatin($phone, $token, $verifytemplate) {

        require_once __DIR__ . "/Kavenegar/KavenegarApi.php";

        try {
            $api = new KavenegarApi($this->parameters["apikey"]);
            $result = $api->VerifyLookup($phone, $token, $verifytemplate);
            return $result;
        } catch (ApiException $ex) {
            return false;
        } catch (HttpException $ex) {
            return false;
        }
    }

    public function Send($phones, $message, $fromnumber) {

        $soapClient = new SoapClient("http://api.kavenegar.com/soap/v1.asmx?WSDL");
        $result = $soapClient->SendSimpleByApikey(array(
                    "apikey" => $this->parameters["apikey"],
                    "message" => $message,
                    "receptor" => $phones,
                    "unixdate" => 0,
                    "type" => 1,
                    "status" => 1,
                    "msgmode" => 1,
                    "sender" => $fromnumber,
                ))->SendSimpleByApikeyResult->long;
    }

}
