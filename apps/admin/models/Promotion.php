<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;



class Promotion extends AtaModel {

    public function initialize() {
        
    }

    public function getSource() {
        return 'promotion';
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
     * @return Promotion
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Title
     * @FieldName('Title')
     * @var string
     */
    public $title;

    /**
     * Set Title
     * @param type $title
     * @return Promotion
     */
    public function setTitle($title) {
        $this->title = $title;
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
     * @return Promotion
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * By User ID
     * @FieldName('By User ID')
     * @var string
     */
    public $byuserid;

    /**
     * Set By User ID
     * @param type $byuserid
     * @return Promotion
     */
    public function setByuserid($byuserid) {
        $this->byuserid = $byuserid;
        return $this;
    }

    /**
     * End Date
     * @FieldName('End Date')
     * @var string
     */
    public $end_date;

    /**
     * Set End Date
     * @param type $end_date
     * @return Promotion
     */
    public function setEnd_date($end_date) {
        $this->end_date = $end_date;
        return $this;
    }

    /**
     * Total
     * @FieldName('Total')
     * @var string
     */
    public $total;

    /**
     * Set Total
     * @param type $total
     * @return Promotion
     */
    public function setTotal($total) {
        $this->total = $total;
        return $this;
    }

    /**
     * Default Percent
     * @FieldName('Default Percent')
     * @var string
     */
    public $default_percent;

    /**
     * Set Default Percent
     * @param type $default_percent
     * @return Promotion
     */
    public function setDefault_percent($default_percent) {
        $this->default_percent = $default_percent;
        return $this;
    }

    /**
     * Default Fee
     * @FieldName('Default Fee')
     * @var string
     */
    public $default_fee;

    /**
     * Set Default Fee
     * @param type $default_fee
     * @return Promotion
     */
    public function setDefault_fee($default_fee) {
        $this->default_fee = $default_fee;
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
     * @return Promotion
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function getDate() {
        return Jalali::date('Y-m-d H:m:s', $this->date);
    }

    public function getEndDate() {
        if ($this->end_date > 0) {
            return Jalali::date('Y-m-d H:m:s', $this->end_date);
        } else {
            return "";
        }
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     *
     * @param type $parameters
     * @return Promotion
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

    public function getPublicResponse($user = null, array $items = null) {

        $result = new stdClass();
        $result->ID = $this->id;
        $result->Title = $this->title;
        $result->Date = $this->date;
        $result->ByUserID = $this->byuserid;
        $result->EndDate = $this->end_date;
        $result->Total = $this->total;
        $result->DefaultPercent = $this->default_percent;
        $result->DefaultFee = $this->default_fee;
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
            'title' => 'title',
            'date' => 'date',
            'byuserid' => 'byuserid',
            'end_date' => 'end_date',
            'total' => 'total',
            'default_percent' => 'default_percent',
            'default_fee' => 'default_fee',
            'status' => 'status',
        );
    }

}
