<?php

define("USERLEVEL_SUPERADMIN", 9);
define("USERLEVEL_ADMIN", 8);
define("USERLEVEL_USER", 1);

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Controller;
use Simpledom\Core\AtaModel;
use Simpledom\Core\Classes\Config;
use Simpledom\Core\Classes\SearchResult;

class BaseUser extends AtaModel implements Searchable {

    public function getSource() {
        return "user";
    }

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $userid;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var integer
     */
    public $level;

    /**
     *
     * @var string
     */
    public $fname;

    /**
     *
     * @var string
     */
    public $verifycode;

    /**
     *
     * @var string
     */
    public $lname;

    /**
     *
     * @var integer
     */
    public $gender;

    /**
     *
     * @var string
     */
    public $imagelink;

    /**
     *
     * @var string
     */
    public $regdate;

    /**
     *
     * @var integer
     */
    public $active;

    /**
     *
     * @var integer
     */
    public $verified;

    /**
     *
     * @var string
     */
    public $token;

    /**
     *
     * @var string
     */
    public $regtime;

    /**
     *
     * @var string
     */
    public $resetcode;

    /**
     *
     * @var integer
     */
    public $resetcodedate;

    /**
     *
     * @var integer
     */
    public $logintimes;

    /**
     *
     * @var string
     */
    public $disablemessage;

    public function getUserid() {
        return $this->userid;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getLevel() {
        return $this->level;
    }

    public function afterFetch() {
        //Convert the string to an array
        $this->id = $this->userid;
    }

    public function getLevelName() {
        switch ($this->level) {
            case USERLEVEL_SUPERADMIN:
                return "Super Adminstator";
            case USERLEVEL_ADMIN:
                return "Adminstator";
            case USERLEVEL_USER:
                return "General User";
        }
    }

    /**
     * find user with user id
     * @param int $userid user id of person who need to load
     * @return User
     */
    public static function findWithUserID($userid) {
        return User::findFirst(array("userid = :userid:", "bind" => array("userid" => $userid)));
    }

    public function getFname() {
        return $this->fname;
    }

    public function getLname() {
        return $this->lname;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getImagelink() {
        return $this->imagelink;
    }

    public function getRegdate() {
        return $this->regdate;
    }

    public function getActive() {
        return $this->active;
    }

    public function getVerified() {
        return $this->verified;
    }

    public function getToken() {
        return $this->token;
    }

    public function getRegtime() {
        return $this->regtime;
    }

    public function getResetcode() {
        return $this->resetcode;
    }

    public function getResetcodedate() {
        return $this->resetcodedate;
    }

    /**
     * 
     * @param type $userid
     * @return BaseUser
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * 
     * @param type $email
     * @return BaseUser
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /**
     * 
     * @param type $level
     * @return BaseUser
     */
    public function setLevel($level) {
        $this->level = $level;
        return $this;
    }

    /**
     * 
     * @param type $fname
     * @return BaseUser
     */
    public function setFname($fname) {
        $this->fname = $fname;
        return $this;
    }

    /**
     * 
     * @param type $lname
     * @return BaseUser
     */
    public function setLname($lname) {
        $this->lname = $lname;
        return $this;
    }

    /**
     * 
     * @param type $gender
     * @return BaseUser
     */
    public function setGender($gender) {
        $this->gender = $gender;
        return $this;
    }

    /**
     * 
     * @param type $imagelink
     * @return BaseUser
     */
    public function setImagelink($imagelink) {
        $this->imagelink = $imagelink;
        return $this;
    }

    /**
     * 
     * @param type $regdate
     * @return BaseUser
     */
    public function setRegdate($regdate) {
        $this->regdate = $regdate;
        return $this;
    }

    /**
     * 
     * @param type $active
     * @return BaseUser
     */
    public function setActive($active) {
        $this->active = $active;
        return $this;
    }

    /**
     * 
     * @param type $verified
     * @return BaseUser
     */
    public function setVerified($verified) {
        $this->verified = $verified;
        return $this;
    }

    /**
     * 
     * @param type $token
     * @return BaseUser
     */
    public function setToken($token) {
        $this->token = $token;
        return $this;
    }

    /**
     * 
     * @param type $regtime
     * @return BaseUser
     */
    public function setRegtime($regtime) {
        $this->regtime = $regtime;
        return $this;
    }

    /**
     * 
     * @param type $resetcode
     * @return BaseUser
     */
    public function setResetcode($resetcode) {
        $this->resetcode = $resetcode;
        return $this;
    }

    /**
     * 
     * @param type $resetcodedate
     * @return BaseUser
     */
    public function setResetcodedate($resetcodedate) {
        $this->resetcodedate = $resetcodedate;
        return $this;
    }

    public function getGenderTitle() {
        if ($this->gender == 1) {
            return "Male";
        } else {
            return "Female";
        }
    }

    public function getJoinDate() {
        return date("Y-m-d H:i:s ", $this->regdate);
    }

    public function beforeValidationOnCreate() {
        $this->imagelink = Config::GetDefaultProfileLink($this->gender);
        $this->verified = 0;
        $this->active = 1;
        $this->regdate = date(time());
        $this->verifycode = $this->generateRandomString(256);
        $this->resetcode = "0";
        $this->resetcodedate = "0";
        $this->fullname = $this->fname . " " . $this->lname;
        $this->regtime = date(time());
        $this->logintimes = "0";
        $this->date = time();
    }

    public function beforeValidationOnSave() {
        $this->fullname = $this->fname . " " . $this->lname;
    }

    public function beforeCreate() {
        $this->password = $this->getDI()->getSecurity()->hash($this->password);
    }

    public function afterCreate() {
        // user created successfully, we have to send email message for the request
    }

    /**
     * Generate a token for the user
     */
    public function generateToken() {

        $this->token = $this->generateRandomString(256);
    }

    /**
     * Try to login to the system, retrun user on succcessfully
     * @param type $email
     * @param type $password
     * @return boolean|User
     */
    public static function Login($email, $password) {

        // TODO validate email
        $user = User::findFirst(array("email = :email:", "bind" => array("email" => $email)));

        if (isset($user->userid)) {
            // user found, we have to check for password
            if (FactoryDefault::getDefault()->getSecurity()->checkHash($password, $user->password)) {
                // valid password, we have to generate token for the request
                $user->generateToken();

                // load the user
                return $user;
            } else {
                return false;
            }
        }

        // invalid request
        return false;
    }

    /**
     * store the session
     * @param Controller $controller
     */
    public function setSession($controller) {
        $controller->session->set("userid", $this->userid);
        $controller->session->set("fname", $this->fname);
        $controller->session->set("lname", $this->lname);
        $controller->session->set("imagelink", $this->imagelink);
        $controller->session->set("email", $this->email);
        $controller->session->set("level", $this->level);
    }

    /**
     * 
     * @param type $parameters
     * @return BaseUser
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    /**
     * send password request email
     * @return boolean
     */
    public function requestResetPassword() {

        // we have to generate a password request code
        $this->resetcode = $this->generateRandomString(64);
        $this->resetcodedate = time() + 3600 * 24;

        // send email to user about the request
        if ($this->save()) {
            $email = new EmailItems();
            return $email->sendPasswordRequest($this->getFullName(), $this->email, $this->resetcode);
        } else {
            return false;
        }
    }

    /**
     * get the user Full Name
     * @return String
     */
    public function getFullName() {
        return $this->fname . " " . $this->lname;
    }

    /**
     * Track User Login
     */
    public function trackLogin($agent, $ip) {
        $login = new BaseLogins();
        $login->agent = $agent;
        $login->ip = $ip;
        $login->userid = $this->userid;

        // try to log login
        $login->create();
    }

    public function isSuperAdmin() {
        return $this->level == USERLEVEL_SUPERADMIN;
    }

    public function getPublicResponse() {
        $result = new stdClass();
        $result->userid = $this->userid;
        $result->firstname = $this->fname;
        $result->lastname = $this->lname;
        $result->imagelink = $this->getImagelink();
        $result->gender = $this->gender;
        return $result;
    }

    /**
     * get last month registration count
     * @return BaseUser
     */
    public function getLastMonthRegistarChart() {

        $items = $this->rawQuery("SELECT  YEAR(user.regtime) as year , MONTH(user.regtime) as month , day(user.regtime) as day , count(user.userid) as total FROM `user` WHERE YEAR(user.regtime) >= YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
AND MONTH(user.regtime) >= MONTH(CURRENT_DATE - INTERVAL 1 MONTH) GROUP BY day(user.regtime)");

        $results = array();
        foreach ($items as $value) {
            $results["$value->year/$value->month/$value->day"] = $value->total;
        }
        return $results;
    }

    public function getProfileImageLink() {
        return $this->imagelink;
    }

    /**
     * verify the password
     * @param type $password
     * @return boolean
     */
    public function verifyPassword($password) {
        return strlen($password) > 2 && $this->getDI()->getSecurity()->checkHash($password, $this->password);
    }

    /**
     *  Set new password for user
     * @param type $errors
     * @param type $newpass
     * @return boolean
     */
    public function changePassword(&$errors, $newpass) {
        $newpasshash = $this->getDI->getSecurity()->hash($newpass);
        $this->password = $newpasshash;
        return $this->save();
    }

    /**
     * 
     * @param type $query
     * @param type $start
     * @param type $limit
     * @param type $foundedCount
     * @param type $results
     * @param type $viewName
     * @return SearchResult
     */
    public static function RequestSearch($query, $start, $limit, &$foundedCount = -1, &$results = array(), &$viewName = "default") {

        $users = BaseUser::find(array(
                    "fullname LIKE '%$query%'",
                    "limit" => "$start , $limit",
        ));

        $total = BaseUser::count(array(
                    "fullname LIKE '%$query%'",
        ));

        $foundedCount = $total;
        $results = $users;

        $result = new SearchResult();
        $result->query = $query;
        $result->count = $total;
        $result->items = $results;
        $result->start = $start;
        $result->limit = $limit;
        return $result;
    }

    public function hasVerifiedPhone() {
        return UserPhone::count(array(
                    "userid = :userid: AND verified = '1'",
                    "bind" => array(
                        "userid" => $this->userid
                    )
        ));
    }

    /**
     * fetch the user verified phone
     * @return string
     */
    public function getVerifiedPhone() {
        return UserPhone::findFirst(array(
                    "userid = :userid: AND verified = '1'",
                    "bind" => array(
                        "userid" => $this->userid
                    )
                ))->phone;
    }

    public function getActiveButton() {
        return intval($this->active) == 1 ? "<div class='btn btn-sm btn-default disabled'>Active</div>" : "<div class='btn btn-sm btn-danger disabled'>Deactive</div>";
    }

    public function getVerifiedButton() {
        return intval($this->verified) == 1 ? "<div class='btn btn-sm btn-default disabled'>Verified</div>" : "<div class='btn btn-sm btn-warning disabled'>Not Verified</div>";
    }

    public function registerAccount($controller, &$errors, $fname, $lname, $gender, $email, $password, $level, $phone = null) {

        // check if the login is enabled
        if (Settings::Get()->enabledisablesignup === false) {
            $errors[] = (_("Sorry!<br/>But the register system is disabled by Super Adminstator at this time."));
            return false;
        }



        $this->fname = $fname;
        $this->lname = $lname;
        $this->email = $email;
        $this->gender = $gender;
        $this->password = $password;
        $this->level = $level;

        // check if email is not registered
        if (BaseUser::hasEmail($this->email)) {
            // email exist before
            $errors[] = _("Email was in database before");
            return;
        }


        // check if we can save user
        if (!$this->create()) {
            // unable to save user
            $errors[] = $this->getMessagesAsLines();
            return false;
        } else {

            // user created in database, we have to generate 
            $email = new EmailItems();
            $email->sendRegsiterNotification($this->userid, $this->getFullName(), $this->email, $this->verifycode);

            // check if user has entered an not exist phone, add the phone
            // to the user phones and send sms to user
            $count = UserPhone::count(array(
                        "phone = :phone:",
                        "bind" => array(
                            "phone" => $phone
                        )
            ));
            if ($count == 0) {
                // we have no user based on that phone, it is valid to add
                // the phone to the UserPhone table and notify of the phone
                // with verify code
                $userPhone = new UserPhone();
                $userPhone->phone = $phone;
                $userPhone->userid = $this->userid;
                if (!$userPhone->create()) {
                    // usre phone not created
                    BaseSystemLog::init($item)->setTitle("Unable to create User Phone Item")->setMessage("When we are going to create a new UserPhone item for new registered user, we were unable to insert new item")->setIP($_SERVER["REMOTE_ADDR"])->create();
                } else {
                    // user phone created, we have to send the verify code to user
                    $smsMessage = sprintf(_('"Hi %s \nThank you for interseting in %s.\n Please use this code to verify your phone number address :\n %s'), $this->getFullName(), Settings::Get()->websitename, $userPhone->verifycode);
                    //$smsMessage = "Hi " . $this->getFullName() . "\nThank you for interseting in " . Settings::Get()->websitename . ".\n Please use this code to verify your phone number address :\n" . $thisphone->verifycode;
                    //SMSManager::SendSMS($userPhone->phone, $smsMessage, SmsNumber::findFirst("enable = '1'")->id);
                }
            } else {
                // phone exist in database before
                $errors[] = (_("Your Entered Phone was exist in database, please add another phone"));
            }

            return true;
        }
    }

    /**
     * checks if the email is in database
     * @param type $email
     * @return type
     */
    public static function hasEmail($email) {
        return BaseUser::count(array("email = :email:", "bind" => array("email" => $email))) > 0;
    }

}
