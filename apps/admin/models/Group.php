<?php

use Simpledom\Core\AtaModel;

class Group extends AtaModel {

    public function getSource() {
        return 'group';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return Group
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
     * @return Group
     */
    public function setUserid($userid) {
        $this->userid = $userid;
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
     * @return Group
     */
    public function setPhonenumber($phonenumber) {
        $this->phonenumber = $phonenumber;
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
     * @return Group
     */
    public function setName($name) {
        $this->name = $name;
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
     * @return Group
     */
    public function setDate($date) {
        $this->date = $date;
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
     * @return Group
     */
    public function setStatus($status) {
        $this->status = $status;
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
     * @return Group
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

}
