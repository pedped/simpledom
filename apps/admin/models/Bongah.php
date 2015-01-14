<?php

use Phalcon\Mvc\Model\Resultset;
use Simpledom\Core\AtaModel;
use Simpledom\Core\Classes\Helper;

class Bongah extends AtaModel {

    public function getSource() {
        return 'bongah';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return Bongah
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Title
     * @var string
     */
    public $title;

    /**
     * Set Title
     * @param type $title
     * @return Bongah
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * Shomare Peygiri
     * @var string
     */
    public $peygiri;

    /**
     * Set Shomare Peygiri
     * @param type $peygiri
     * @return Bongah
     */
    public function setPeygiri($peygiri) {
        $this->peygiri = $peygiri;
        return $this;
    }

    /**
     * First Name
     * @var string
     */
    public $fname;

    /**
     * Set First Name
     * @param type $fname
     * @return Bongah
     */
    public function setFname($fname) {
        $this->fname = $fname;
        return $this;
    }

    /**
     * Last Name
     * @var string
     */
    public $lname;

    /**
     * Set Last Name
     * @param type $lname
     * @return Bongah
     */
    public function setLname($lname) {
        $this->lname = $lname;
        return $this;
    }

    /**
     * Address
     * @var string
     */
    public $address;

    /**
     * Set Address
     * @param type $address
     * @return Bongah
     */
    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

    /**
     * City
     * @var string
     */
    public $cityid;

    /**
     * Set City
     * @param type $cityid
     * @return Bongah
     */
    public function setCityid($cityid) {
        $this->cityid = $cityid;
        return $this;
    }

    /**
     * Latitude
     * @var string
     */
    public $latitude;

    /**
     * Set Latitude
     * @param type $latitude
     * @return Bongah
     */
    public function setLatitude($latitude) {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * Longitude
     * @var string
     */
    public $longitude;

    /**
     * Set Longitude
     * @param type $longitude
     * @return Bongah
     */
    public function setLongitude($longitude) {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * Locations Can Support
     * @var string
     */
    public $locationscansupport;

    /**
     * Set Locations Can Support
     * @param type $locationscansupport
     * @return Bongah
     */
    public function setLocationscansupport($locationscansupport) {
        $this->locationscansupport = $locationscansupport;
        return $this;
    }

    /**
     * Mobile
     * @var string
     */
    public $mobile;

    /**
     * Set Mobile
     * @param type $mobile
     * @return Bongah
     */
    public function setMobile($mobile) {
        $this->mobile = $mobile;
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
     * @return Bongah
     */
    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Enable
     * @var string
     */
    public $enable;

    /**
     * Set Enable
     * @param type $enable
     * @return Bongah
     */
    public function setEnable($enable) {
        $this->enable = $enable;
        return $this;
    }

    /**
     * Featured
     * @var string
     */
    public $featured;

    /**
     * Set Featured
     * @param type $featured
     * @return Bongah
     */
    public function setFeatured($featured) {
        $this->featured = $featured;
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
     * @return Bongah
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getDate() {
        return Jalali::date('Y-m-d H:i:s', $this->date);
    }

    public $userid;
    public $validdate;
    public $bongahsubscribeitemid;
    public $planvaliddate;
    public $visitedtutorial;

    public function getBongahsubscribeitemid() {
        return $this->bongahsubscribeitemid;
    }

    public function setBongahsubscribeitemid($bongahsubscribeitemid) {
        $this->bongahsubscribeitemid = $bongahsubscribeitemid;
        return $this;
    }

    public function getUserid() {
        return $this->userid;
    }

    public function getValiddate() {
        return $this->validdate;
    }

    /**
     * 
     * @param type $userid
     * @return Bongah
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * 
     * @param type $validdate
     * @return Bongah
     */
    public function setValiddate($validdate) {
        $this->validdate = $validdate;
        return $this;
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     *
     * @param type $parameters
     * @return Bongah
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        $this->featured = "0";
        $this->enable = "-1"; // wait for approve
        $this->bongahsubscribeitemid = "0";
        $this->visitedtutorial = "0";
    }

    public function getPublicResponse() {
        
    }

    public function getCityName() {
        return City::findFirst($this->cityid)->name;
    }

    /**
     * 
     * @return BaseUser
     */
    public function getUser() {
        return BaseUser::findFirst($this->userid);
    }

    /**
     * 
     * find nearset bongah to specefic location
     * @param int $cityID
     * @param double $latitude
     * @param double $longitude
     * @param double $minDistance
     * @return Resultset bongah
     */
    public static function getNearestBongahs($cityID, $latitude, $longitude, $minDistance) {

        $bongah = new Bongah();
        $result = $bongah->rawQuery("select bongah.* ,  
                                ( 3959 * acos( cos( radians(?) ) 
                                       * cos( radians( bongah.latitude ) ) 
                                       * cos( radians( bongah.longitude ) - radians(?) ) 
                                       + sin( radians(?) ) 
                                       * sin( radians( bongah.latitude ) ) ) ) AS distance 
                         from bongah WHERE cityid = ? AND bongah.enable = 1
                         having distance < ? ORDER BY distance", array(
            $latitude, $longitude, $latitude, $cityID, $minDistance
        ));
        return $result;
    }

    /**
     * get supported names
     * @return Array
     */
    public function getSupporrtedLocationsName() {
        $supportsName = array();
        $k = explode(",", $this->locationscansupport);
        foreach ($k as $value) {
            $supportsName[] = Area::findFirst($value)->name;
        }
        return $supportsName;
    }

    public function getSupporrtedLocationsNameAsString() {
        return implode(", ", $this->getSupporrtedLocationsName());
    }

    public function getImagelink() {
        return User::findFirst($this->userid)->getImagelink();
    }

    public function getStateID() {
        return City::findFirst($this->cityid)->stateid;
    }

    /**
     * fetch Bongah Subscribed Plan
     * @return BongahSubscribeItem
     */
    public function getSubscribedPlan() {
        if ($this->bongahsubscribeitemid > 0 && $this->planvaliddate >= time()) {
            return BongahSubscribeItem::findFirst($this->bongahsubscribeitemid);
        } else {
            return null;
        }
    }

    /**
     * get total melk count
     * @return integer
     */
    public function getTotalMelks() {
        return MelkInfo::count(array("bongahid = :bongahid:", "bind" => array("bongahid" => $this->id)));
    }

    public function getRemainingPlanDays() {
        $remainday = (int) (($this->planvaliddate - time()) / (3600 * 24));
        return $remainday > 0 ? $remainday : 0;
    }

    /**
     * find total number of melks that has been sent
     * @return int
     */
    public function getSentMelkCount() {
        return BongahSentMelk::count(array("bongahid = :bongahid:", "bind" => array("bongahid" => $this->id)));
    }

    public function getMelksCount() {
        return Melk::count(array("userid = :userid:", "bind" => array("userid" => $this->userid)));
    }

    public function sendMelkInfo(&$errors, $melkPhoneListnerID, $melkID, &$needToIncreaseSMSCredit = false, &$message = "") {

        BaseUserLog::byUserID($this->userid)->setAction("تلاش برای ارسال ملک به درخواست کننده ملک")->create();

        // check for melk
        $melk = Melk::findFirst(array("id = :id:", "bind" => array("id" => $melkID)));
        $phonelistner = MelkPhoneListner::findFirst(array("id = :id:", "bind" => array("id" => $melkPhoneListnerID)));


        if (!$melk || !$phonelistner || intval($melk->userid) != intval($this->userid)) {
            // one thing is not exist
            //$this->show404();
            $errors[] = "خطا در هنگام ارسال اطلاعات ملک";
            return;
        }

        // check if the bongah have not sent this item before this melk listner
        $sentBefore = BongahSentMelk::count(array("melkphonelistnerid = :melkphonelistnerid: AND melkid = :melkid:", "bind" => array(
                        "melkid" => $melkID,
                        "melkphonelistnerid" => $melkPhoneListnerID
            ))) > 0;

        if ($sentBefore) {
            // user 
            // 
            // TODO remove below comment
            $errors[] = ("شما قبلا ملک شماره " . $melkID . " را به شماره " . $phonelistner->getPhoneNumber() . " ارسال نموده اید");
            return;
        }

        // send melk info
        // check for user credit
        if (User::findFirst($this->userid)->getSMSCredit() <= 0) {
            // user do not have enogh money to send message
            $errors[] = ("اعتبار شما برای ارسال پیام کافی نیست، لطفا ابتدا اعتبار خود را افزایش دهید");
            // forward to user page
            $needToIncreaseSMSCredit = true;
            return false;
        }

        // create message
        $message = "مشتری گرامی، ملک جدید مطابق با نیاز شما به مشاور املاک " . $this->title . " سپرده گردید";
        $message .= "\n";
        $message .= "\n";
        $message .= $melk->getQuickInfo();
        $message .="\n";
        $message .="\n";
        $message .= "با تشکر";
        $message .= $this->title;
        $message .="\n";
        $message .= $this->phone;

        // we have to send sms
        SMSManager::SendSMS($phonelistner->getPhoneNumber(), $message, SmsNumber::findFirst()->id);
        // 
        // // TODO find sms id and use for decrease credit
        // decraese user sms credit
        $isPersian = false;
        $messageSize = Helper::GetMessageSize($message, $isPersian);
        SMSCredit::decreaseCredit($errors, $this->userid, 8, $isPersian ? $messageSize * 2 : $messageSize );

        // we have to create new sent message
        $bongahSentMessage = new BongahSentMelk();
        $bongahSentMessage->bongahid = $this->id;
        $bongahSentMessage->melkid = $melk->id;
        $bongahSentMessage->melkphonelistnerid = $phonelistner->id;
        $bongahSentMessage->message = $message;
        $bongahSentMessage->create();

        // show success messgae
        BaseUserLog::byUserID($this->userid)->setAction("ملک برای درخواست کننده ملک ارسال گردید")->create();
        return true;
    }

}
