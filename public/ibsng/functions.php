<?php

require_once 'IbsngConfig.php';
require_once 'handler.php';

class IBSngFunctions {

    public static function GenerateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    public static function GenerateRandomNumber($length = 10) {
        $characters = '123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function GetUserID(&$errors, $username) {
        // change user credit
        $ui = new GetUserInfo(null, $username);
        $k = $ui->send();
        var_dump($k);
        $keys = array_keys($k[1]);
        return $keys[0];
    }

    public static function ChangeCredit(&$errors, $userid, $credit, $creditChangeComment = "") {

        // make sure we have recicved valid userid
        $userID = strval($userid);

        // change user credit
        $changeUserCredit = new ChangeUserCredit($userID, $credit, $creditChangeComment);

        // do action
        $result = $changeUserCredit->send();

        // send back result
        return $result[0];
    }

    public static function CheckUserExist(&$errors, $username) {
//        var_dump($username);
//        die();
        // search throgh usernames
        $ui = new GetUserInfo(null, $username);

        // fetch the result
        $result = $ui->send();

        //var_dump($result);
        // check if we have recieved array
        if (is_array($result) && $result[0] == TRUE) {
            return true;
        } else {
            // we have recived error object
            return false;
        }
    }

    public static function CreateUser(&$errors, $username, $password) {

//        var_dump($username);
//        die();
        // check if user name is not exist before
        if (self::CheckUserExist($errors, $username)) {
            // user exists
            $errors[] = "username exist!";
            return false;
        }

        // create user
        $add_user_req = new AddNewUsers(1, "1800", "system", "main", "default credit");
        $res = $add_user_req->send();
        list($success, $userids) = $res;
        if ($success) {
            // set username and password
            $userid = $userids[0];

            // load user by userid and try to set user name and password for that
            $userInfo = new UpdateUserAttrs(strval($userid), array(
                "normal_username" => strval($username),
                "normal_password" => strval($password),
                "normal_generate_password" => false,
                "normal_generate_password_len" => "6",
                "normal_save_usernames" => "true",
            ));

            // commit username and password
            $info = $userInfo->send();

            return $info[0];
        }
    }

    public static function RedirectToURL($url) {
        // add the website link
        $urlinof = parse_url($url);
        if (!isset($urlinof["host"])) {
            $url = IbsngConfig::getPublicUrl() . $url;
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

}
