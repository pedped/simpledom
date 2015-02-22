<?php

namespace Simpledom\Api\Controllers;

use BaseSystemLog;
use BaseUser;
use Category;
use City;
use MobileNotification;
use MobileToken;
use Product;
use Seller;
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

    public function getcategoryproductsAction($categoryid) {

        // find user products
        $start = (int) $_POST["start"];
        $limit = (int) $_POST["limit"];
        $categoryid = intval($categoryid);


        // we have to find category and subcategory items too
        $categoryList = Category::findFirst(array("id = :id:", "bind" => array("id" => $categoryid)))->LoadSubCategoryIDs();


        // implode items as array
        $categoryIDs = implode(", ", $categoryList);

        $products = Product::find(
                        array(
                            "categoryid IN ( $categoryid , $categoryIDs) AND status = 1",
                            "order" => "id DESC",
                            "limit" => "$start , $limit",
                            "bind" =>
                            array(
                                "categoryid" => $categoryid
                            )
                        )
        );

        // send products
        $results = array();
        foreach ($products as $product) {
            $results[] = $product->getPublicResponse();
        }
        return $this->getResponse($results);
    }

    public function getcategoriesAction() {
        // we have to list of cateories
        $topCategories = Category::find("parent_id = 0 AND status = '1'");

        // find results
        $categories = array();
        foreach ($topCategories as $topCategoriy) {
            $categories[] = $topCategoriy->getPublicResponse();
        }
        return $this->getResponse($categories);
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
            // there is no new notification
            return $this->getResponse(false);
        }

        // send notification
        return $this->getResponse($notification->getPublicResponse());
    }

    private function logError() {
        // log error
        BaseSystemLog::CreateLogWarning("خطا در ساخت فروشنده", implode(", ", $this->errors) . "\n\n\n" . json_encode($_POST));
    }

    public function registersellerAction() {

        $seller = new Seller();
        $this->user = new User();

        $seller->type = $this->request->getPost('type', 'string');
        $seller->title = $this->request->getPost('title', 'string');
        $seller->address = $this->request->getPost('address', 'string');
        $seller->phone = $this->request->getPost('shomaresabet', 'string');

        // check for valid inputs
        if (strlen($seller->title) == 0 || strlen($seller->address) == 0 || strlen($seller->phone) == 0) {
            $this->errors[] = _("شما می بایست شماره تلفن، آدرس و نام صنف خود را وارد نمایید");

            // log error
            $this->logError();

            // send response
            return $this->getResponse(false);
        }


        // we need to create an account for the user
        $fname = $this->request->getPost("fname");
        $lname = $this->request->getPost("lname");
        $email = $this->request->getPost("email", "email");
        $password = $this->request->getPost("password");
        $mobile = $this->request->getPost("phone");
        $deviceid = $this->request->getPost("deviceid");
        $devicetype = $this->request->getPost("devicetype");
        $result = $this->user->registerAccount($this, $this->errors, $fname, $lname, 1, $email, $password, USERLEVEL_USER, $mobile, false);
        if (!$this->hasError() && $result == true) {
            // user successfully created 
        } else {

            // unable to create user
            return $this->getResponse(false);
        }

        if (!$this->hasError()) {

            $cityID = City::findFirst(array("name = :name:", "bind" => array("name" => $this->request->getPost('city', 'string'))))->id;

            // form is valid
            $seller->userid = $this->user->userid;
            $seller->cityid = $cityID;
            $seller->latitude = $this->request->getPost('latitude');
            $seller->longitude = $this->request->getPost('longitude');

            if (!$seller->create()) {
                // unable to create seller
                $this->errors[] = $seller->getMessagesAsLines();

                // log error
                $this->logError();

                return $this->getResponse(false);
            } else {

                $this->user->level = USERLEVEL_SELLER;
                $this->user->save();

                // success, we have to create new LoginResult
                $token = MobileToken::GetToken($this->errors, $this->user->userid, $deviceid, $devicetype);
                if (!$token) {

                    // log error
                    $this->logError();

                    return $this->getResponse(false);
                }

                // token created successfully
                $result = new stdClass();
                $result->User = $this->user->getPublicResponse();
                $result->Token = $token;
                $result->Type = USERLEVEL_SELLER;
                return $this->getResponse($result);
            }
        }

        // log error
        $this->logError();

        // unable to create new user or bongah
        $this->getResponse(false);
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
            $this->errors[] = "کاربری با چنین ایمیل و رمز عبوری یافت نگردید";
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
        $result->Type = $user->level;
        return $this->getResponse($result);
    }

}
