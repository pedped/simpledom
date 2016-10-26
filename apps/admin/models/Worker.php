<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;

class Worker extends AtaModel {

    public function initialize() {
        
    }

    public function getSource() {
        return 'worker';
    }

    /**
     * ID
     * @FieldName('ID')
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return Worker
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * User ID
     * @FieldName('User ID')
     * @var string
     */
    public $userid;

    /**
     * Set User ID
     * @param type $userid
     * @return Worker
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * First Name
     * @FieldName('First Name')
     * @var string
     */
    public $firstname;

    /**
     * Set First Name
     * @param type $firstname
     * @return Worker
     */
    public function setFirstname($firstname) {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Last Name
     * @FieldName('Last Name')
     * @var string
     */
    public $lastname;

    /**
     * Set Last Name
     * @param type $lastname
     * @return Worker
     */
    public function setLastname($lastname) {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * Father Name
     * @FieldName('Father Name')
     * @var string
     */
    public $fathername;

    /**
     * Set Father Name
     * @param type $fathername
     * @return Worker
     */
    public function setFathername($fathername) {
        $this->fathername = $fathername;
        return $this;
    }

    /**
     * Identity Number
     * @FieldName('Identity Number')
     * @var string
     */
    public $identitynumber;

    /**
     * Set Identity Number
     * @param type $identitynumber
     * @return Worker
     */
    public function setIdentitynumber($identitynumber) {
        $this->identitynumber = $identitynumber;
        return $this;
    }

    /**
     * Birthday
     * @FieldName('Birthday')
     * @var string
     */
    public $birthday;

    /**
     * Set Birthday
     * @param type $birthday
     * @return Worker
     */
    public function setBirthday($birthday) {
        $this->birthday = $birthday;
        return $this;
    }

    /**
     * Worker Section ID
     * @FieldName('Worker Section ID')
     * @var string
     */
    public $workersectionid;

    /**
     * Set Worker Section ID
     * @param type $workersectionid
     * @return Worker
     */
    public function setWorkersectionid($workersectionid) {
        $this->workersectionid = $workersectionid;
        return $this;
    }

    /**
     * Date
     * @FieldName('Date')
     * @var string
     */
    public $date;

    /**
     * Set Date
     * @param type $date
     * @return Worker
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Address
     * @FieldName('Address')
     * @var string
     */
    public $address;

    /**
     * Set Address
     * @param type $address
     * @return Worker
     */
    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

    /**
     * Phone
     * @FieldName('Phone')
     * @var string
     */
    public $phone;

    /**
     * Set Phone
     * @param type $phone
     * @return Worker
     */
    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Mobile
     * @FieldName('Mobile')
     * @var string
     */
    public $mobile;

    /**
     * Set Mobile
     * @param type $mobile
     * @return Worker
     */
    public function setMobile($mobile) {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * Status
     * @FieldName('Status')
     * @var string
     */
    public $status;

    /**
     * Set Status
     * @param type $status
     * @return Worker
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function getDate() {
        return Jalali::date("Y/m/d H:i:s", $this->date);
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     *
     * @param type $parameters
     * @return Worker
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
    }

    public function beforeValidationOnSave() {
        
    }

    public function afterFetch() {
        
    }

    public function getPublicResponse() {

        $result = new stdClass();
        $result->ID = $this->id;
        $result->UserID = $this->userid;
        $result->FirstName = $this->firstname;
        $result->LastName = $this->lastname;
        $result->FatherName = $this->fathername;
        $result->IdentityNumber = $this->identitynumber;
        $result->Birthday = $this->birthday;
        $result->WorkerSectionID = $this->workersectionid;
        $result->Date = $this->date;
        $result->Address = $this->address;
        $result->Phone = $this->phone;
        $result->Mobile = $this->mobile;
        $result->Status = $this->status;


        return $result;
    }

    //public function validation()
    //{
    //return $this->validationHasFailed() != true;
    //}





    public function columnMap() {
        // Keys are the real names in the table and
        // the values their names in the application
        return array('id' => 'id',
            'userid' => 'userid',
            'gender' => 'gender',
            'firstname' => 'firstname',
            'lastname' => 'lastname',
            'fathername' => 'fathername',
            'identitynumber' => 'identitynumber',
            'birthday' => 'birthday',
            'workersectionid' => 'workersectionid',
            'date' => 'date',
            'address' => 'address',
            'phone' => 'phone',
            'mobile' => 'mobile',
            'status' => 'status',
        );
    }

    public function getUser() {
        return User::findWithUserID($this->userid);
    }

}
