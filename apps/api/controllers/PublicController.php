<?php

namespace Simpledom\Api\Controllers;

use BaseSearchHistory;
use BaseUser;
use Category;
use DBServer;
use Familycode;
use Feedback;
use LoginRequest;
use MobileNotification;
use MobileToken;
use PriceCalculator;
use Product;
use Settings;
use Simpledom\Core\Classes\Config;
use Simpledom\Core\Classes\Helper;
use SMSManager;
use SmsNumber;
use stdClass;

class PublicController extends ControllerBase {

    public function testAction() {
        var_dump(\User::findFirst()->getPublicResponse());
    }

    /**
     * when a user requested contact
     */
    public function requestcontactAction() {


        // Check if the user requested feedback during last hour
        $errors = array();
//        if (!Limitation::OnUserEvent($errors, LIMIT_REQUESTFEEDBACK, $this->user->userid)) {
//            // user has reached the limitation
//            $result = new stdClass();
//            $result->title = "Dear " . $this->user->getFullName();
//            $result->message = "We have received your request during last hour, we will contact you very soon";
//            return $this->getResponse($result);
//        }
        // create new feedback
        $feedback = new Feedback();
        if (isset($this->user))
            $feedback->userid = $this->user->userid;
        $feedback->devcieinfo = "Android";
        $feedback->phone = $_POST["phone"];
        if ($feedback->save()) {
            $result = new stdClass();
            $result->title = "بسیار ممنونیم!";
            $result->message = "درخواست شما با موفقیت به دست ما رسید، به زودی با شما تماس خواهیم گرفت";
            return $this->getResponse($result);
        } else {
            $result = new stdClass();
            $result->title = "Ooops!";
            $result->message = "Feedback center is closed at this time";
            return $this->getResponse($result);
        }
    }

    public function loadnewproductsAction() {

        $products = Product::find(array(
                    "order" => "id DESC",
                    "limit" => "100"
        ));

        return $this->getResponse($products);
    }

    public function loadnewpromotionsAction() {

        $products = Product::find(array(
                    "flag_offpage = '1'",
                    "order" => "id DESC",
                    "limit" => "100"
        ));

        return $this->getResponse($products);
    }

    public function loadspecialproductsAction() {

        $products = Product::find(array(
                    "flag_special = '1'",
                    "order" => "id DESC",
                    "limit" => "100"
        ));

        return $this->getResponse($products);
    }

    public function loadtopsalesAction() {
        // we have to find the products top sales in last 3 days
        $topSalesDay = Config::TopSalesDayLimit();

        // find the product list in the factor items 
        $productIDs = DBServer::LoadTopSaleProducts($topSalesDay);

        if (count($productIDs) > 0) {
            // convert them to string
            $pdis = implode(", ", $productIDs);
            $products = Product::find(array("id IN (" . $pdis . ")", "order" => "id DESC"));
        } else {
            $products = array();
        }
//        var_dump($pdis);
//        die();
        // load the product list
        // send back the products
        return $this->getResponse($products);
    }

    public function onsearchAction() {
        $query = $_POST["query"];

        // log search history
        $searchhistory = new BaseSearchHistory();
        $searchhistory->query = $query;

        // add userid if user is logged in
        if (isset($this->user)) {
            $searchhistory->user = $this->user->userid;
        }

        $searchhistory->save();
    }

    public function signupwithmobileAction() {

        // check phone number
        $phone = $_POST["phone"];
        $androidversioncode = $_POST["androidversioncode"];
        $androidversionname = $_POST["androidversionname"];
        $deviceid = $_POST["deviceid"];
        $devicemodel = $_POST["devicemodel"];
        $ip = $_SERVER["REMOTE_PORT"];



        if (!Helper::ValidateIranianPhoneNumber($this->errors, $phone)) {
            // invalid phone number
            return $this->getResponse(false);
        }


        // generate phone number token
        $token = LoginRequest::GenerateToken($this->errors, $phone, $androidversioncode, $androidversionname, $deviceid, $devicemodel, $ip);

        // check if token is valid
        if ($token != FALSE) {
            // we have to send phone number this token
            //SMSManager::SendSMS($phone, _("Your confirm code is : ") . $token, SmsNumber::findFirst("enable = 1")->id);
            SMSManager::SendVerificatinSMS($phone, $token, SmsNumber::findFirst("providerid = 3")->id, "verify");
        } else {
            // there is a problem in activatating
            $this->errors[] = _("There was a problem in activating your phone");
            return $this->getResponse(false);
        }

        // send success status
        return $this->getResponse(1);
    }

    public function validateconfirmcodeAction() {

        $phone = $_POST["phone"];
        $token = $_POST["token"];
        $deviceid = $_POST["deviceid"];
        $devicetype = $_POST["devicetype"];

        // validate phone token
        if (!LoginRequest::ValidateToken($this->errors, $phone, $token)) {
            $this->errors[] = _("Invalid Token! please enter confirm code we just sent to your phone");
            return $this->getResponse(false);
        } else {
            // valid token
            // check if the user exist with such phone
            $user = \User::findFirst(array("phone = :phone:", "bind" => array("phone" => $phone)));
            if ($user != FALSE) {
                // user already exist with this phone, we have to geneate login info for the user
                // success login, we have to create response for the user
                $token = MobileToken::GetToken($this->errors, $user->userid, $deviceid, $devicetype);
                if (!$token) {
                    return $this->getResponse(false);
                }

                // token created successfully
                $result = new stdClass();
                //$result->AccountSetting = $user->getAccountSetting();
                $result->User = $user->getPublicResponse();
                $result->Token = $token;
                return $this->getResponse($result);
            } else {
                // user is not exist, we have to create default user for this phone
                $user = new \User();
                $result = $user->registerAccount($this, $this->errors, EMPTYCOLUMN, EMPTYCOLUMN, 1, Helper::GenerateRandomString(32) . "@gmail.com", Helper::GenerateRandomString(24), USERLEVEL_USER, $phone);
                if ($result == TRUE) {

                    // Create token
                    $token = MobileToken::GetToken($this->errors, $user->userid, $deviceid, $devicetype);
                    if ($token == FALSE) {
                        return $this->getResponse(false);
                    }

                    // successfully created
                    $result = new stdClass();
                    // $result->AccountSetting = $user->getAccountSetting();
                    $result->User = $user->getPublicResponse();
                    $result->Token = $token;
                    return $this->getResponse($result);
                } else {
                    // unable to create new account
                    $this->errors[] = _("Unable to create new account");
                    return $this->getResponse(false);
                }
            }
        }
    }

    public function calcordercostAction() {
        $products = json_decode($_POST["products"]);
        $deliverTime = $_POST["delivertime"];
    

        // request price calculator calc the price
        $finalPrice = PriceCalculator::CalcCost($products, $deliverTime);

        return $this->getResponse($finalPrice);
    }

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

    public function loadappdataAction() {
        // load categories 
        $categories = Category::GetList();
        $products = Product::GetList();


        $result = new \stdClass();
        $result->categories = $categories;
        $result->products = $products;


        // show list
        return $this->getResponse($result);
    }

    public function gethomeimageAction() {
        return $this->getResponse(Config::getAppImageLink());
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

    public function needtoenterfamilycodeAction() {
        return $this->getResponse(Settings::Get()->needfamilycode == true ? "1" : "0");
    }

    public function validatefamilycodeAction() {
        $code = $_POST["code"];
        $count = Familycode::count(array("code = :code:", "bind" => array("code" => $code)));
        if ($count > 0) {
            return $this->getResponse("1");
        } else {
            return $this->getResponse("0");
        }
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
