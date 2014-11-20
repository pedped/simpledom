<?php

use Simpledom\Core\AtaModel;

class Moshaver extends AtaModel {

    public function getSource() {
        return 'moshaver';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return Moshaver
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
     * @return Moshaver
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * City ID
     * @var string
     */
    public $cityid;

    /**
     * Set City ID
     * @param type $cityid
     * @return Moshaver
     */
    public function setCityid($cityid) {
        $this->cityid = $cityid;
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
     * @return Moshaver
     */
    public function setAddress($address) {
        $this->address = $address;
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
     * @return Moshaver
     */
    public function setPhone($phone) {
        $this->phone = $phone;
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
     * @return Moshaver
     */
    public function setVerified($verified) {
        $this->verified = $verified;
        return $this;
    }

    /**
     * Moshaver Type
     * @var string
     */
    public $moshavertypeid;

    /**
     * Set Moshaver Type
     * @param type $moshavertypeid
     * @return Moshaver
     */
    public function setMoshavertypeid($moshavertypeid) {
        $this->moshavertypeid = $moshavertypeid;
        return $this;
    }

    /**
     * Degree Type
     * @var string
     */
    public $degreetypeid;

    /**
     * Set Degree Type
     * @param type $degreetypeid
     * @return Moshaver
     */
    public function setDegreetypeid($degreetypeid) {
        $this->degreetypeid = $degreetypeid;
        return $this;
    }

    /**
     * Info
     * @var string
     */
    public $info;

    /**
     * Set Info
     * @param type $info
     * @return Moshaver
     */
    public function setInfo($info) {
        $this->info = $info;
        return $this;
    }

    /**
     * Status
     * @var string
     */
    public $status;

    /**
     * Set Status
     * @param type $status
     * @return Moshaver
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * Date
     * @var string
     */
    public $date;
    public $longitude;
    public $latitude;

    /**
     * Set Date
     * @param type $date
     * @return Moshaver
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:m:s', $this->date);
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     *
     * @param type $parameters
     * @return Moshaver
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        $this->status = "0";
        $this->verified = "0";
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

    public function getUser() {
        return User::findFirst($this->userid);
    }

    public function getTypeName() {
        return MoshaverType::findFirst($this->moshavertypeid)->name;
    }

    public function getDegreeName() {
        return MoshaverDegree::findFirst($this->degreetypeid)->name;
    }

    /**
     * 
     * @return int
     */
    public function getNewQuestionCount() {
        $moshaver = new Moshaver();
        return $moshaver->rawQuery("SELECT COUNT(*) as unanswercount FROM question q WHERE q.moshaverid = 1 AND (SELECT COUNT(*) FROM answer a WHERE q.id = a.questionid)  = 0")->getFirst()->unanswercount;
    }

}
