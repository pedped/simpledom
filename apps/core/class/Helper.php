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

    public static function generateAjaxButton($id, $name, $link, $buttonStyle = "", $buttonClass = "btn btn-default", $onData = "") {
        $html = "<div id='$id' class='$buttonClass' style='$buttonStyle'>$name</div>";
        $html .= "
            <script>
                $('#$id').click(function(){
                    
                    $.get('$link', function(data){
                        console.log('server request to uri : $link', data);
                        $onData
                    });
                });
            </script>";
        return $html;
    }

}
