<?php

namespace Simpledom\Api\Controllers;

use Advertise;
use BaseUser;
use Category;
use Device;
use MobileNotification;
use MobileToken;
use Simpledom\Core\Classes\FileManager;
use stdClass;
use User;

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

    public function companylistAction() {
        $results = array();
        $categories = Category::find();
        foreach ($categories as $category) {
            $item = new stdClass();
            $item->id = $category->id;
            $item->value = $category->title;
            $results[] = $item;
        }

        return $this->getResponse($results);
    }

    public function getcompanyproductAction($companyID) {
        $results = array();
        $devices = Device::find(array("categoryid = :categoryid:", "bind" => array("categoryid" => $companyID)));
        foreach ($devices as $device) {
            $item = new stdClass();
            $item->id = $device->id;
            $item->value = $device->name;
            $results[] = $item;
        }

        return $this->getResponse($results);
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
        $username = $this->request->getPost("username");
        $lname = $this->request->getPost("lname");
        $phone = $this->request->getPost("phone");
        $email = $this->request->getPost("email", "email");
        $password = $this->request->getPost("password");
        $gender = $this->request->getPost("gender");
        $deviceid = $this->request->getPost("deviceid");
        $devicetype = $this->request->getPost("devicetype");

        // check if we have username before
        if (BaseUser::count(array("username = :username:", "bind" => array("username" => $username))) > 0) {
            $this->errors[] = "نام کاربری قبلا ثبت شده است";
            return $this->getResponse(false);
        }

        // now, we have to request register
        $user = new User();
        $result = $user->registerAccount($this, $this->errors, $fname, $lname, $gender, $email, $password, USERLEVEL_USER, $phone, $username);
        if ($result != FALSE) {

            $user->userphone = $phone;
            $user->save();


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
            $this->errors[] = "ایمیل و یا رمز عبور شما اشتباه است";
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

    public function loadcategoryAction() {

        $results = array();

        // categors 
        $categories = Category::find();
        foreach ($categories as $category) {
            $results[] = $category->getPublicResponse();
        }
        return $this->getResponse($results);
    }

    public function getcategoryadvertiseAction($categoryID) {

        if (!isset($categoryID) || intval($categoryID) == 0) {
            return $this->getResponse(array());
        }

        $start = (int) $_POST["start"];
        $limit = (int) $_POST["limit"];

        // categors
        $query = Advertise::query();
        $bindparams = array();

        $queryString = "categoryid = :categoryid: AND status = 1 ";
        $bindparams["categoryid"] = $categoryID;

        // check for city
        if (isset($_POST["cityid"])) {
            $queryString .= " AND cityid = :cityid:";
            $bindparams["cityid"] = $_POST["cityid"];
        }

        // check for price min
        if (isset($_POST["pricemin"])) {
            $queryString .= " AND price >= :pricemin:";
            $bindparams["pricemin"] = $_POST["pricemin"];
        }

        // check for price max
        if (isset($_POST["pricemax"])) {
            $queryString .= " AND price <= :pricemax:";
            $bindparams["pricemax"] = $_POST["pricemax"];
        }

        // check for garantee
        if (isset($_POST["garantee"])) {
            if (intval($_POST["garantee"]) == 1) {
                $queryString .= " AND garantee IS NOT NULL AND garantee != ''";
            } else {
                $queryString .= " AND ( garantee IS NULL OR garantee != '') ";
            }
        }


        // check for time id
        if (isset($_POST["timeid"])) {
            if (intval($_POST["timeid"]) == 2) {
                // emrooz;
                $queryString .= " AND date  + ( :day:  * 24 * 3600 ) > UNIX_TIMESTAMP() ";
                $bindparams["day"] = 1;
            } else {

                $queryString .= " AND date  + ( :day:  * 24 * 3600 ) > UNIX_TIMESTAMP() ";
                if (intval($_POST["timeid"]) == 3) {
                    // diirooz tahala;
                    $bindparams["day"] = 2;
                }
                if (intval($_POST["timeid"]) == 4) {
                    // diirooz tahala;
                    $bindparams["day"] = 7;
                }
                if (intval($_POST["timeid"]) == 5) {
                    // diirooz tahala;
                    $bindparams["day"] = 30;
                }
            }
        }



        // load order info
        $orderInfo = "";
        if (isset($_POST["sortby"])) {
            $orderInfo = $_POST["sortby"];
        } else {
            $orderInfo = "id DESC";
        }

        // bind parameter
        $advertise = \Advertise::find(array(
                    $queryString,
                    "bind" => $bindparams,
                    "order" => $orderInfo
        ));

        $results = array();
        foreach ($advertise as $category) {
            $results[] = $category->getPublicResponse();
        }
        return $this->getResponse($results);
    }

}
