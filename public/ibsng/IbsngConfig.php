<?php

class IbsngConfig {

    /**
     * return the length of the user tokens
     */
    public static function getUserTokenLength() {
        return 128;
    }

    public static function GetPaylineAPI() {
        return 'adxcv-zzadq-polkjsad-opp13opoz-1sdf455aadzmck1244567';
    }

    public static function getPublicUrl() {
        return 'http://hotspot.livarfars.ir/';
    }

    public static function ConvertChargeMinuteToHour($chargeAmount) {
        return ( intval($chargeAmount) / 60 ) . " ساعت";
    }

    public static function GetSMSUserName() {
        return "system";
    }

    public static function GetSMSPassword() {
        return "123456";
    }

    public static function GetSMSNumber() {
        return "12123121212";
    }

    public static function getServerIPAddress() {
        //return $_SERVER["REMOTE_ADDR"];
        return self::ServerIPAddress();
    }

    public static function ServerIPAddress() {
        return "94.74.180.230";
    }

    public static function ServerIPPort() {
        return "1235";
    } 

    public static function GetLogServerURL() {
        return "/home/admin/web/hotspot.livarfars.ir/public_html/public/ibsng/ibs_interface.log";
        //return "/var/log/IBSng/ibs_interfacea.log";
    }

}
