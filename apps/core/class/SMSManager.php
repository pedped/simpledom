<?php


namespace Simpledom\Core\Classes;


class SMSManager {

    /**
     * Load SMS Providers
     * @var type 
     */
    public static $PROVIDERS = array(
        "IR Payamak" => "IrPayamakSMSProvider"
    );

    /**
     * 
     * @param type $name
     * @return SmsProviderSystem
     */
    private static function getProvider($name) {
        $className = SMSManager::$PROVIDERS[$name];
        return new $className();
    }

    public static function SendSMS($phones, $message, $smsNumberID) {

        // Get SMS Number
        $smsNumber = SmsNumber::findFirst($smsNumberID);
        $provider = SMSProvider::findFirst($smsNumber->providerid);
        $smsProvder = self::getProvider($provider->name);

        // now, we have to init from prover infos
        $infos = $smsProvder->init($provider->infos)->Send($phones, $message, $smsNumber->number);

        // we have to log the items
        if ($infos) {
            // send succesfully
            foreach ($phones as $phone) {
                $sms = new Sentsms();
                $sms->fromnumber = $smsNumber->number;
                $sms->ip = $_SERVER["SERVER_ADDR"];
                $sms->message = $message;
                $sms->phone = $phone;
                $sms->provider = $provider->id;
                $sms->refcode = 50;
                $sms->result = "success";
                if (!$sms->create()) {
                    var_dump($sms->getMessages());
                }
            }
        }

        return true;
    }

}
