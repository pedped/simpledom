<?php

namespace Simpledom\Core\Classes;

class Config {

    public static function generateRandomString($length = 32) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    /**
     * return the path we have to use for upload
     * @return string
     */
    public static function GetImagePath() {

        return $_SERVER["DOCUMENT_ROOT"] . "/public/userupload/image";
    }

    /**
     * return the maximum file size
     * @return type
     */
    public static function getMaxUserImageFileSizeUploadLimit() {
        return 1024 * 1024 * 8;
    }

    public static function GetDefaultProfileLink($gender) {
        return "http://amlak.edspace.org/userupload/image/4MqyybZ94UNDsXsJ2M3FGmb8I9XmZ8X4.jpg";
    }

    public static function getPublicUrl() {
        return "http://amlak.edspace.org/";
    }

    public static function GetPaylineAPI() {
        return "adxcv-zzadq-polkjsad-opp13opoz-1sdf455aadzmck1244567";
        //return "d7625-87fe2-3280d-33c4a-91f8960a31e673c0e8be11314a82";
    }

    public static function GetRecaptchaPublicKey() {
        return "6Lc_ffwSAAAAAK5eQq9lHLdGR8F-l98MQtXEL1GH";
    }

    public static function GetRecaptchaPrivateKey() {
        return "6Lc_ffwSAAAAAJpg5DyYeRiPWhlBvBTojn8ETwUh";
    }

    public static function CheckForSMSCreditOnAdminPanel() {
        return false;
    }

    public static function GetDefaultSMSCreditOnBongahSignUp() {
        return 50;
    }

    public static function GetBongahFreeDate() {
        return 7;
    }

    public static function inStartCities($cityID) {
        return in_array($cityID, array(
            60
        ));
    }

    public static function GetDefaultMelkImageID() {
        return 105;
    }

    public static function GetAndroidVersionCode() {
        return "1";
    }

    public static function GetAndroidVersionName() {
        return "1";
    }

    public static function GetAndroidDownloadLink() {
        return "http://amlak.edspace.org/app/file/v1/AmlakGostarApp.apk";
    }

}
