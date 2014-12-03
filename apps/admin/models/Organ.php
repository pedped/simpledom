<?php

use Simpledom\Core\AtaModel;

class Organ extends AtaModel {

    public function getSource() {
        return 'organ';
    }
    
    private $password;
    
    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return Organ
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Name
     * @var string
     */
    public $name;

    /**
     * Set Name
     * @param type $name
     * @return Organ
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * By User
     * @var string
     */
    public $byuserid;

    /**
     * Set By User
     * @param type $byuserid
     * @return Organ
     */
    public function setByuserid($byuserid) {
        $this->byuserid = $byuserid;
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
     * @return Organ
     */
    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

    /**
     * State ID
     * @var string
     */
    public $stateid;

    /**
     * Set State ID
     * @param type $stateid
     * @return Organ
     */
    public function setStateid($stateid) {
        $this->stateid = $stateid;
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
     * @return Organ
     */
    public function setCityid($cityid) {
        $this->cityid = $cityid;
        return $this;
    }

    /**
     * Description
     * @var string
     */
    public $description;

    /**
     * Set Description
     * @param type $description
     * @return Organ
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Phone Number
     * @var string
     */
    public $phonenumber;

    /**
     * Set Phone Number
     * @param type $phonenumber
     * @return Organ
     */
    public function setPhonenumber($phonenumber) {
        $this->phonenumber = $phonenumber;
        return $this;
    }

    /**
     * SMS Credit
     * @var string
     */
    public $smscredit;

    /**
     * Set SMS Credit
     * @param type $smscredit
     * @return Organ
     */
    public function setSmscredit($smscredit) {
        $this->smscredit = $smscredit;
        return $this;
    }

    /**
     * Interface URL
     * @var string
     */
    public $interfaceurl;

    /**
     * Set Interface URL
     * @param type $interfaceurl
     * @return Organ
     */
    public function setInterfaceurl($interfaceurl) {
        $this->interfaceurl = $interfaceurl;
        return $this;
    }

    /**
     * Use Interface
     * @var string
     */
    public $useinterface;

    /**
     * Set Use Interface
     * @param type $useinterface
     * @return Organ
     */
    public function setUserinterface($useinterface) {
        $this->useinterface = $useinterface;
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
     * @return Organ
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * Disable Message
     * @var string
     */
    public $disablemessage;

    /**
     * Set Disable Message
     * @param type $disablemessage
     * @return Organ
     */
    public function setDisablemessage($disablemessage) {
        $this->disablemessage = $disablemessage;
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
     * @return Organ
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

    public $smsnumberid;

    /**
     *
     * @param type $parameters
     * @return Organ
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        $this->smsnumberid = "0";
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

    /**
     * 
     * @return int SMS's Can send
     */
    public function getSMSCredit() {
        return $this->getUser()->getSMSCredit();
    }

    /**
     * get organ userid
     * @return User
     */
    public function getUser() {
        return User::findFirst($this->byuserid);
    }
    
    public function beforeCreate() {
        $this->password = $this->getDI()->getSecurity()->hash($this->password);
    }

}
