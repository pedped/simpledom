<?php

define("USERLEVEL_SUPERADMIN", 9);
define("USERLEVEL_ADMIN", 8);
define("USERLEVEL_USER", 1);

use Phalcon\Mvc\Controller;
use Simpledom\Core\AtaModel;
use Simpledom\Core\Classes\Config;

class BaseUser extends AtaModel implements Searchable {

    public function getSource() {
        return "user";
    }

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

    public function getUserid() {
        return $this->userid;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getLevel() {
        return $this->level;
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
    }

    public function beforeValidationOnSave() {
        $this->fullname = $this->fname . " " . $this->lname;
    }

    public function beforeCreate() {
        $this->password = md5($this->password);
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
     * @return boolean|BaseUser
     */
    public static function Login($email, $password) {

        // TODO validate email
        $user = BaseUser::findFirst(array(
                    "email = '$email'"
        ));

        if (isset($user->userid)) {
            // user found, we have to check for password
            if (md5($password) === $user->password) {
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
        return $result;
    }

    /**
     * get last month registration count
     * @return BaseUser
     */
    public function getLastMonthRegistarChart() {

        return $this->rawQuery("SELECT  YEAR(user.regtime) as year , MONTH(user.regtime) as month , day(user.regtime) as day , count(user.userid) as total FROM `user` WHERE YEAR(user.regtime) >= YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
AND MONTH(user.regtime) >= MONTH(CURRENT_DATE - INTERVAL 1 MONTH) GROUP BY day(user.regtime)");
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
        return strlen($password) > 2 && $this->password == md5($password);
    }

    /**
     *  Set new password for user
     * @param type $errors
     * @param type $newpass
     * @return boolean
     */
    public function changePassword(&$errors, $newpass) {
        $newpasshash = md5($newpass);
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

}
