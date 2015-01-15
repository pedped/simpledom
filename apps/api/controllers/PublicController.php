<?php

namespace Simpledom\Api\Controllers;

use Area;
use BaseSystemLog;
use BaseUser;
use Bongah;
use City;
use MobileNotification;
use MobileToken;
use Simpledom\Core\Classes\Config;
use SMSCredit;
use SMSManager;
use SmsNumber;
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
        $result->versioncode = Config::GetAndroidVersionCode();
        $result->versionname = Config::GetAndroidVersionName();
        $result->md5 = "232656122152";
        $result->downloadlink = Config::GetAndroidDownloadLink();
        return $this->getResponse($result);
    }

    public function trackintroAction() {

        $deviceid = $this->request->getPost("deviceid");

        // we have to track user intro action
        BaseSystemLog::CreateLogInfo("باز شدن برنامه اندروید", "صفحه اول برنامه اندروید باز شد" . ": $deviceid");
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
        BaseSystemLog::CreateLogWarning("خطا در ساخت بنگاه", implode(", ", $this->errors) . "\n\n\n" . json_encode($_POST));
    }

    public function registerbongahAction() {

        $bongah = new Bongah();
        $this->user = new User();
        $bongah->title = $this->request->getPost('title', 'string');
        $bongah->fname = $this->request->getPost('fname', 'string');
        $bongah->lname = $this->request->getPost('lname', 'string');
        $bongah->address = $this->request->getPost('address', 'string');
        $bongah->mobile = $this->request->getPost('phone', 'string');
        $bongah->phone = $this->request->getPost('shomaresabet', 'string');

        // check for valid inputs
        if (strlen($bongah->title) == 0 || strlen($bongah->address) == 0 || strlen($bongah->phone) == 0) {
            $this->errors[] = _("لطفا تمامی موارد خواسته شده شامل نام مشاور املاک، آدرس، و شماره ثابت را وارد نمایید");

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
            $bongah->userid = $this->user->userid;
            $bongah->cityid = $cityID;
            $bongah->latitude = $this->request->getPost('latitude');
            $bongah->longitude = $this->request->getPost('longitude');
            $areaIDs = Area::GetMultiID($bongah->cityid, $this->request->getPost('city', 'string'));
            $bongah->locationscansupport = implode(',', $areaIDs);

            // valid bongah for 30 days
            $bongah->planvaliddate = (3600 * 24 * Config::GetBongahFreeDate() + 3600) + time();



            if (!$bongah->create()) {
                // unable to create bongah
                $this->errors[] = $bongah->getMessagesAsLines();

                // log error
                $this->logError();

                return $this->getResponse(false);
            } else {

                $this->user->level = USERLEVEL_BONGAHDAR;
                $this->user->save();



                // add sms credit for the user
                // increase user credit
                if (SMSCredit::findFirst(array("userid = :userid:", "bind" => array("userid" => $this->user->userid)))) {
                    $item = SMSCredit::findFirst(array("userid = :userid:", "bind" => array("userid" => $this->user->userid)));
                    $item->value += Config::GetDefaultSMSCreditOnBongahSignUp();
                    $item->save();
                } else {
                    // we have to create new item
                    $smscredit = new SMSCredit();
                    $smscredit->value = Config::GetDefaultSMSCreditOnBongahSignUp();
                    $smscredit->userid = $this->user->userid;
                    $smscredit->create();
                }


                // send sms about add
                //SMSManager::SendSMS($bongah->mobile, "مشاور املاک گرامی، مشخصات شما برای بررسی به مسئولان سایت ارسال گردید، همکاران ما به زودی با شما تماس خواهند گرفت", SmsNumber::findFirst()->id);

                // send sms to myself
                SMSManager::SendSMS("09399477290", "بنگاه جدیدی توسط برنامه موبایل به عضویت در سایت درآمد", SmsNumber::findFirst()->id);

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
            $this->errors[] = _("ایمیل یا رمز عبور شما اشتباه می باشد");
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
