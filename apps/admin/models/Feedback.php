<?php

use Simpledom\Core\AtaModel;

define("CONTACTSTATUS_WAITINGFORCALL", 1);
define("CONTACTSTATUS_CALLED", 2);
define("CONTACTSTATUS_NOTANSWERD", 3);

class Feedback extends AtaModel {

    public function initialize() {
        
    }

    public function getSource() {
        return 'feedback';
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
     * @return Feedback
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
     * @return Feedback
     */
    public function setUserid($userid) {
        $this->userid = $userid;
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
     * @return Feedback
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Devcie Info
     * @FieldName('Devcie Info')
     * @var string
     */
    public $devcieinfo;

    /**
     * Set Devcie Info
     * @param type $devcieinfo
     * @return Feedback
     */
    public function setDevcieinfo($devcieinfo) {
        $this->devcieinfo = $devcieinfo;
        return $this;
    }

    /**
     * Result Type
     * @FieldName('Result Type')
     * @var string
     */
    public $result_type;

    /**
     * Set Result Type
     * @param type $result_type
     * @return Feedback
     */
    public function setResult_type($result_type) {
        $this->result_type = $result_type;
        return $this;
    }

    /**
     * Result Response
     * @FieldName('Result Response')
     * @var string
     */
    public $result_response;

    /**
     * Set Result Response
     * @param type $result_response
     * @return Feedback
     */
    public function setResult_response($result_response) {
        $this->result_response = $result_response;
        return $this;
    }

    /**
     * Result Comment
     * @FieldName('Result Comment')
     * @var string
     */
    public $result_comment;

    /**
     * Set Result Comment
     * @param type $result_comment
     * @return Feedback
     */
    public function setResult_comment($result_comment) {
        $this->result_comment = $result_comment;
        return $this;
    }

    public function getDate() {
        return Jalali::date('Y-m-d H:m:s', $this->date);
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    public $phone;

    /**
     *
     * @param type $parameters
     * @return Feedback
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        $this->result_type = CONTACTSTATUS_WAITINGFORCALL;
    }

    public function beforeValidationOnSave() {
        
    }

    public function afterFetch() {
        
    }

    public function getPublicResponse($user = null, array $items = null) {

        $result = new stdClass();
        $result->ID = $this->id;
        $result->UserID = $this->userid;
        $result->Date = $this->date;
        $result->DevcieInfo = $this->devcieinfo;
        $result->ResultType = $this->result_type;
        $result->ResultResponse = $this->result_response;
        $result->ResultComment = $this->result_comment;


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
            'date' => 'date',
            'devcieinfo' => 'devcieinfo',
            'phone' => 'phone',
            'result_type' => 'result_type',
            'result_response' => 'result_response',
            'result_comment' => 'result_comment',
        );
    }

    public function getStatusAdmin() {
        switch ($this->result_type) {
            case CONTACTSTATUS_WAITINGFORCALL:
                return "<span style='font-weight: normal;    font-size: 100%;' class='label label-danger'>منتظر تماس</span>";
            case CONTACTSTATUS_NOTANSWERD:
                return "<span style='font-weight: normal;    font-size: 100%;'  class='label label-warning'>عدم پاسخگویی کاربر</span>";
            case CONTACTSTATUS_CALLED:
                return "<span style='font-weight: normal;    font-size: 100%;'  class='label label-success'>تماس گرفته شد</span>";
            default:
                return "<span style='font-weight: normal;    font-size: 100%;'  class='label label-default'>وضعیت نامشخص</span>";
        }
    }

}
