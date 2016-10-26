<?php

define("USERLEVEL_SUPERADMIN", 9);
define("USERLEVEL_ADMIN", 8);
define("USERLEVEL_WORKER", 2);
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
    
    public $cach;

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
        $this->cach = 0;
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

        $items = $this->rawQuery("SELECT  YEAR(user.registerdate) as year , MONTH(user.registerdate) as month , day(user.registerdate) as day , count(user.userid) as total FROM `user` WHERE YEAR(user.registerdate) >= YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
AND MONTH(user.registerdate) >= MONTH(CURRENT_DATE - INTERVAL 1 MONTH) GROUP BY day(user.registerdate)");

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
        $this->firstname = $fname;
        $this->realname = $fname . " " . $lname;
        $this->lname = $lname;
        $this->lastname = $lname;
        $this->emailverified = 0;
        $this->mobileverifed = 0;
        $this->lastactivationrequest = 0;
        $this->registerdate = time();
        $this->email = $email;
        $this->gender = $gender;
        $this->password = $password;
        $this->level = $level;
        if (isset($phone)) {
            $this->phone = $phone;
        }

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
            return true;
        }
    }

    public function columnMap() {
        // Keys are the real names in the table and
        // the values their names in the application
        return array(
            'user_id' => 'userid',
            'user_imagelink' => 'imagelink',
            'user_cityid' => 'cityid',
            'user_name' => 'name',
            'user_email' => 'email',
            'user_level' => 'level',
            'user_pass' => 'password',
            'user_realname' => 'realname',
            'user_fname' => 'firstname',
            'user_lname' => 'lastname',
            'user_gender' => 'gender',
            'user_lang' => 'language',
            'user_reg_date' => 'registerdate',
            'user_emailverified' => 'emailverified',
            'user_mobileverifed' => 'mobileverifed',
            'user_country' => 'country',
            'user_activiationtoken' => 'activiationtoken',
            'user_last_activation_request' => 'lastactivationrequest',
            'user_active' => 'active',
            'user_birthday_day' => 'birthday',
            'user_birthday_month' => 'birthmonth',
            'user_birthday_year' => 'birthyear',
            'user_profile_imageid' => 'imageid',
            'user_profile_coverid' => 'profilecoverid',
            'user_profile_blurcoverid' => 'profileblurcoverid',
            'user_university' => 'university',
            'user_teachuniversity' => 'teachuniversity',
            'user_city' => 'city',
            'user_lastqsee' => 'lastquestionsee',
            'user_lastasee' => 'lastanswersee',
            'user_lastmsee' => 'lastmessagesee',
            'user_lastrsee' => 'lastrequestsee',
            'user_isstudent' => 'isstudent',
            'user_newquestioncount' => 'newquestioncount',
            'user_newanswercount' => 'newanswercount',
            'user_newnotificationcount' => 'newnotificationcount',
            'user_lastnsee' => 'lastnotificationsee',
            'user_lastsignindate' => 'lastsignindate',
            'user_passwordresetstring' => 'passwordresetstring',
            'user_lastpasswordrequest' => 'lastpasswordrequest',
            'user_newitem' => 'newitem',
            'user_sitestate' => 'sitestate',
            'user_mobiletokan' => 'mobiletokan',
            'user_mobiletokanexpiredate' => 'mobiletokanexpiredate',
            'user_updatetime' => 'updatetime',
            'user_fbuid' => 'facebookuserid',
            'user_playedvoicecount' => 'playedvoicecount',
            'user_cvvaliddate' => 'cvvaliddate',
            'user_cansetpassword' => 'cansetpassword',
            'user_emailverifycode' => 'emailverifycode',
            'user_emailverifycodesenddate' => 'emailverifycodesenddate',
            'user_about' => 'about',
            'user_work' => 'work',
            'user_sec_email' => 'sec_email',
            'user_phone' => 'phone',
            'user_worktown' => 'worktown',
            'user_isteacher' => 'isteacher',
            'user_xmpppass' => 'xmpppass',
            'user_presentpass' => 'presentpass',
            'user_homepagetour' => 'homepagetour',
            'user_createclasstour' => 'createclasstour',
            'user_pagetour' => 'pagetour',
            'user_abilityadded' => 'abilityadded',
            'user_registerbyuserid' => 'registerbyuserid',
            'user_hasprofileimage' => 'hasprofileimage',
            'user_checkedsolutions' => 'checkedsolutions',
            'user_syncflagpage' => 'syncflagpage',
            'user_syncflagclassroom' => 'syncflagclassroom',
            'user_syncflagclasstime' => 'syncflagclasstime',
            'user_syncflagfreind' => 'syncflagfriend',
            'user_fbtokan' => 'facebooktoken',
            'user_fbjoinimage' => 'facebookjoinimage',
            'user_shebanumber' => 'shebanumber',
            'user_statusmessage' => 'statusmessage',
            'user_statusmessagedate' => 'statusmessagedate',
            'user_privacyaccessfriend' => 'privacyaccessfriend',
            'user_privacyaccessclassroom' => 'privacyaccessclass',
            'user_privacyaccessnote' => 'privacyaccessnote',
            'user_privacyaccessvoice' => 'privacyaccessvoice',
            'user_grade' => 'grade',
            'user_cach' => 'cach',
        );
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
