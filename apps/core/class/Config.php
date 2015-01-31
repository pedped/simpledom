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
        return true;
    }

    public static function GetDefaultSMSCreditOnBongahSignUp() {
        return 50;
    }

    public static function GetBongahFreeDate() {
        return 30;
    }

    public static function inStartCities($cityID) {
        return in_array($cityID, array(
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
        return "http://amlak.edspace.org/app/file/v1_2/AmlakGostarApp.apk";
    }

    public static function GetAndroidDownloadLinkWithCounter() {
        return "http://amlak.edspace.org/index/downloadbongahapp";
    }

    public static function GetAndroidFilePath() {
        return dirname(dirname(dirname(__DIR__))) . "/public/app/file/v1/AmlakGostarApp.apk";
    }

    public static function ShowFullCityMelkInAndroid() {
        return false;
    }

    public static function ShowAndroidStatusBox() {
        return false;
    }

    public static function TotalBannerCanSupportInCityList() {
        return 4;
    }

    public static function GetGooglePlayLink() {
        return "https://play.google.com/store/apps/details?id=com.ataalla.amlakgostar";
    }

    public static function GetAmlakBreadcrump($cityID, $cityName) {
        return self::getPublicUrl() . "$cityID" . "/" . ("املاک-" . $cityName) . "/1";
    }

    public static function GetAmlakBreadcrumpWithType($cityID, $cityName, $MelkTypeName) {
        return self::getPublicUrl() . "$cityID" . "/" . ("املاک-" . $cityName) . "/" . self::replaceMelkTypeToEnglish($MelkTypeName) . "/1";
    }

    public static function GetAmlakBreadcrumpWithPurpose($cityID, $cityName, $MelkTypeName, $MelkPurpose) {
        return self::getPublicUrl() . "$cityID" . "/" . ("املاک-" . $cityName) . "/" . self::replaceMelkTypeToEnglish($MelkTypeName) . "/" . self::replaceMelkPurposeToEnglish($MelkPurpose) . "/1";
    }

    public static function replaceMelkPurposeToEnglish($MelkPurpose) {
        // replace some text
        $MelkPurpose = str_replace("فروش", "sale", $MelkPurpose);
        $MelkPurpose = str_replace("رهن و اجاره", "rent", $MelkPurpose);
        return $MelkPurpose;
    }

    public static function replaceMelkTypeToEnglish($MelkTypeName) {

        $MelkTypeName = str_replace("آپارتمان", "apartment", $MelkTypeName);
        $MelkTypeName = str_replace("خانه", "home", $MelkTypeName);
        $MelkTypeName = str_replace("ویلا", "villa", $MelkTypeName);
        $MelkTypeName = str_replace("زمین", "land", $MelkTypeName);
        $MelkTypeName = str_replace("اتاق کار", "office-room", $MelkTypeName);
        $MelkTypeName = str_replace("دفتر کار", "office", $MelkTypeName);
        return $MelkTypeName;
    }

    public static function GetMelkTypeIDByEnglishName($requestedMelkType) {
        switch ($requestedMelkType) {
            case "apartment":
                return 2;
            case "home":
                return 1;
            case "villa":
                return 4;
            case "land":
                return 5;
            case "office-room":
                return 6;
            case "office":
                return 3;
        }
    }

    public static function GetMelkPurposeIDByEnglishName($requestedMelkPurpose) {
        switch ($requestedMelkPurpose) {
            case "sale":
                return 1;
            case "rent":
                return 2;
        }
    }

    public static function GetMelkTypeNameEnglishByID($typeIndex) {
        switch ($typeIndex) {
            case 2:
                return "apartment";
            case 1 :
                return "home";
            case 4 :
                return "villa";
            case 5 :
                return "land";
            case 6 :
                return "office-room";
            case 3 :
                return "office";
        }
    }

    public static function GetMelkPurposeNameEnglishByID($purposeIndex) {
        switch ($purposeIndex) {
            case 1 :
                return "sale";
            case 2:
                return "rent";
        }
    }

    public static function GetMelkTypeNameByID($typeIndex) {
        switch ($typeIndex) {
            case 2:
                return "آپارتمان";
            case 1 :
                return "خانه";
            case 4 :
                return "ویلا";
            case 5 :
                return "زمین";
            case 6 :
                return "اتاق کار";
            case 3 :
                return "دفتر کار";
        }
    }

    public static function GetMelkPurposeNameByID($purposeIndex) {
        switch ($purposeIndex) {
            case 1 :
                return "فروش";
            case 2:
                return "رهن و اجاره";
        }
    }

}
