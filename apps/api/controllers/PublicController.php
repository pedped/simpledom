<?php

namespace Simpledom\Api\Controllers;

use BaseUser;
use MobileNotification;
use MobileToken;
use stdClass;

class PublicController extends ControllerBase {

    public function mobileversionAction() {
//        int version = json . getInt("versioncode");
//        String versionName = json . getString("versionname");
//        String md5 = json . getString("md5");
//        String downloadlink = json
//                . getString("downloadlink");

        $result = new stdClass();
        $result->versioncode = 1;
        $result->versionname = 2.25;
        $result->md5 = "232656122152";
        $result->downloadlink = "http://www.google.com";
        return $this->getResponse($result);
    }

    public function newnotificationAction() {

        // get last visit
        $lastvisit = $this->request->getPost("lastvisit");

        // check for last visit
        if (!isset($lastvisit) || strlen($lastvisit) == 0) {
            // return $this->getResponse(false);
            $lastvisit = 0;
        }

        // get new notfications
        $notification = MobileNotification::findFirst(array("releasedate >= :releasedate: AND enable = 1", "order" => "id DESC", "bind" => array("releasedate" => $lastvisit)));
        if (!$notification) {
            // there is no new notification, check may be user has custom message
            return $this->dispatcher->forward(array(
                        "controller" => "user",
                        "action" => "getnotification",
                        "params" => array()
            ));
        }

        // send notification
        return $this->getResponse($notification->getPublicResponse());
    }

    /**
     * this function will get some information and register new account for the user
     * @mobile
     */
    public function registermobileAction() {

        // get user inputs
        $fname = $this->request->getPost("fname");
        $lname = $this->request->getPost("lname");
        $phone = $this->request->getPost("phone");
        $email = $this->request->getPost("email", "email");
        $password = $this->request->getPost("password");
        $gender = $this->request->getPost("gender");
        $deviceid = $this->request->getPost("deviceid");
        $devicetype = $this->request->getPost("devicetype");

        // now, we have to request register
        $user = new BaseUser();
        $result = $user->registerAccount($this, $this->errors, $fname, $lname, $gender, $email, $password, USERLEVEL_USER, $phone);
        if ($result != FALSE) {

            // success, we have to create new LoginResult
            $token = MobileToken::GetToken($this->errors, $user->userid, $deviceid, $devicetype);
            if (!$token) {
                return $this->getResponse(false);
            }

            // token created successfully
            $result = new stdClass();
            $result->User = $user->getPublicResponse();
            $result->Token = $token;
            return $this->getResponse($result);
        }

        // unable to create new user
        $this->getResponse(false);
    }

    /**
     * @mobile
     * @return type
     */
    public function loginmobileAction() {
        // fetch user email and password
        $email = $this->request->getPost("email", "email");
        $password = $this->request->getPost("password");
        $deviceid = $this->request->getPost("deviceid");
        $devicetype = $this->request->getPost("devicetype");

        // check if user can have success login
        $user = BaseUser::Login($email, $password);
        if (!$user) {
            return $this->getResponse(false);
        }

        // success login, we have to create response for the user
        $token = MobileToken::GetToken($this->errors, $user->userid, $deviceid, $devicetype);
        if (!$token) {
            return $this->getResponse(false);
        }


        // token created successfully
        $result = new stdClass();
        $result->User = $user->getPublicResponse();
        $result->Token = $token;
        return $this->getResponse($result);
    }

}
