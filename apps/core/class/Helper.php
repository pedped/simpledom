<?php

namespace Simpledom\Core\Classes;

use Jalali;

class Helper {

    /**
     * Retrun the human readble file size
     * @param long $bytes
     * @return String
     */
    public static function convertSizeToHumanReadable($bytes) {

        if ($bytes > 0) {
            $unit = intval(log($bytes, 1024));
            $units = array('B', 'KB', 'MB', 'GB');

            if (array_key_exists($unit, $units) === true) {
                return sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]);
            }
        }

        return $bytes;
    }

    public static function RedirectToURL($url) {
// add the website link
        $urlinof = parse_url($url);
        if (!isset($urlinof["host"])) {
            $url = Config::getPublicUrl() . $url;
        }

// now redrct the user
        if (!headers_sent())
            header("Location: $url");
        else {
            echo '<script type="text/javascript">';
            echo 'window.location.href="' . $url . '";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
            echo '</noscript>';
        }
        die();
    }

    public static function formatDate($date) {
        return date("Y-m-d H:i:s", $date);
    }

    public static function GenerateRandomString($length = 64) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    public static function GetSpace($size) {
        return $size . " متر مربع";
    }

    public static function GetPrice($price) {
        if ($price == 0) {
// should be hezar toman
            return "0";
        } else if ($price < 1) {
// should be hezar toman
            return number_format($price * 1000) . " " . "هزار تومان";
        } else if ($price == 1) {
            return "یک میلیون تومان";
        } else if ($price > 1 && $price < 1000) {
            return number_format($price) . " " . "میلیون تومان";
        } else {
            return number_format($price / 1000, 2) . " " . "میلیارد تومان";
        }
    }

    public static function GetPersianDate($time) {
        return Jalali::date("Y/m/d H:i:s", $time);
    }

    public static function getDistance($lat1, $lon1, $lat2, $lon2, $unit = "K") {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    /**
     * this function will get correct iranaian phone numberS
     * @param type $mobileNumber
     * @return mixed false if the phone number is not valid, fixed mobile number
     * on valid phone number
     */
    public static function getCorrectIraninanMobilePhoneNumber($mobileNumber) {

        // check if the mobile number is correct
        if (strlen($mobileNumber) > 11 || strlen($mobileNumber) < 10) {
            return false;
        }

        // check for the correct mobile number
        if (strlen($mobileNumber) == 10) {
            if (intval($mobileNumber[0]) != 9) {
                // invalid phone number
                return false;
            } else {
                // valid phone number
                return "0" . $mobileNumber;
            }
        } else {
            if (intval($mobileNumber[0]) != 0 || intval($mobileNumber[1]) != 9) {
                // invalid phone number
                return false;
            } else {
                // valid phone number
                return $mobileNumber;
            }
        }
    }

}
