<?php

use Simpledom\Core\AtaModel;
use Simpledom\Core\Classes\Config;
use Simpledom\Core\Classes\Helper;

class BaseUserPhone extends AtaModel {

    public function getSource() {
        return 'userphone';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BaseUserPhone
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * User ID
     * @var string
     */
    public $userid;

    /**
     * Set User ID
     * @param type $userid
     * @return BaseUserPhone
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * Phone
     * @var string
     */
    public $phone;

    /**
     * Set Phone
     * @param type $phone
     * @return BaseUserPhone
     */
    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Verify Code
     * @var string
     */
    public $verifycode;

    /**
     * Set Verify Code
     * @param type $verifycode
     * @return BaseUserPhone
     */
    public function setVerifycode($verifycode) {
        $this->verifycode = $verifycode;
        return $this;
    }

    /**
     * Verified
     * @var string
     */
    public $verified;

    /**
     * Set Verified
     * @param type $verified
     * @return BaseUserPhone
     */
    public function setVerified($verified) {
        $this->verified = $verified;
        return $this;
    }

    /**
     * Last SMS Sent Date
     * @var string
     */
    public $lastsmsdate;

    /**
     * Set Last SMS Sent Date
     * @param type $lastsmsdate
     * @return BaseUserPhone
     */
    public function setLastsmsdate($lastsmsdate) {
        $this->lastsmsdate = $lastsmsdate;
        return $this;
    }

    /**
     * Date
     * @var string
     */
    public $date;

    /**
     * Set Date
     * @param type $date
     * @return BaseUserPhone
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:i:s', $this->date);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        $this->lastsmsdate = time();
        $this->verified = "0";
        $this->verifycode = $this->generateRandomNumber(8);
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

    public function getVerifiedText() {
        return intval($this->verified) == 1 ? _("Yes") : _("No");
    }

    public function getVerifiedLink() {
        $publicUrl = Config::getPublicUrl();
        return intval($this->verified) == 0 ? "<a href='$publicUrl" . "phone/verify/$this->phone' class='btn btn-primary btn-sm' >" . _("Verify Phone") . "</a>" : "<a class='btn btn-success btn-sm disabled' >" . _("Already Verified") . "</a>";
    }

    public function getUserName() {
        return BaseUser::findFirst($this->userid)->getFullName();
    }

    public function sendVerificationNumber() {
        $message = "" . _("Verfication Number") . ":\n" . $this->verifycode;
        $this->LogInfo("Verification Number Sent", "verification Number Sent to User : " . $this->userid);
        return SMSManager::SendSMS($this->phone, $message, SmsNumber::findFirst("enable = 1"));
    }

    public function getAdminVerifyButton() {

        if ($this->verified) {
            return "";
        }
        $link = $this->getDI()->get("url")->getBaseUri() . "api/verifyphone/" . $this->id;
        return Helper::generateAjaxButton("btn_verify", "Verify", $link, '', 'btn btn-sm btn-primary');
    }

}
