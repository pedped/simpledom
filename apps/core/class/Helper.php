<?php

namespace Simpledom\Core\Classes;

use Phalcon\Http\Response;

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

    public static function getHumanPriceToman($priceInRials) {
        if ($priceInRials == 0) {
            return "رایگان";
        } else {
            return ( $priceInRials / 10000 ) . " هزار تومان";
        }
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

}
