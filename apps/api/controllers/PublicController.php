<?php

namespace Simpledom\Api\Controllers;

use BaseUser;
use MobileToken;
use stdClass;

class PublicController extends ControllerBase {


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
