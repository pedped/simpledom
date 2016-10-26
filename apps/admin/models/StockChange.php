<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;

define("STOCKCHANGE_REASON_FOROSH", 10);

class StockChange extends AtaModel {

    public function initialize() {
        
    }

    public function getSource() {
        return 'stock_change';
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
     * @return StockChange
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Stock ID
     * @FieldName('Stock ID')
     * @var string
     */
    public $stockid;

    /**
     * Set Stock ID
     * @param type $stockid
     * @return StockChange
     */
    public function setStockid($stockid) {
        $this->stockid = $stockid;
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
     * @return StockChange
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * Worker ID
     * @FieldName('Worker ID')
     * @var string
     */
    public $workerid;

    /**
     * Set Worker ID
     * @param type $workerid
     * @return StockChange
     */
    public function setWorkerid($workerid) {
        $this->workerid = $workerid;
        return $this;
    }

    /**
     * Count
     * @FieldName('Count')
     * @var string
     */
    public $count;

    /**
     * Set Count
     * @param type $count
     * @return StockChange
     */
    public function setCount($count) {
        $this->count = $count;
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
     * @return StockChange
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Reason Code
     * @FieldName('Reason Code')
     * @var string
     */
    public $reasoncode;

    /**
     * Set Reason Code
     * @param type $reasoncode
     * @return StockChange
     */
    public function setReasoncode($reasoncode) {
        $this->reasoncode = $reasoncode;
        return $this;
    }

    /**
     * Reason
     * @FieldName('Reason')
     * @var string
     */
    public $reason;

    /**
     * Set Reason
     * @param type $reason
     * @return StockChange
     */
    public function setReason($reason) {
        $this->reason = $reason;
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
     * @return StockChange
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
        $result->StockID = $this->stockid;
        $result->UserID = $this->userid;
        $result->WorkerID = $this->workerid;
        $result->Count = $this->count;
        $result->Date = $this->date;
        $result->ReasonCode = $this->reasoncode;
        $result->Reason = $this->reason;


        return $result;
    }

    //public function validation()
    //{
    //return $this->validationHasFailed() != true;
    //}


    public function getReasonCodeFlag() {
        switch ($this->reasoncode) {
            case STOCKCHANGE_REASON_FOROSH:
                return "<span class='btn btn-sm btn-primary disabled btn-block'>فروش محصول</span>";
        }
    }

    public function columnMap() {
        // Keys are the real names in the table and
        // the values their names in the application
        return array('id' => 'id',
            'stockid' => 'stockid',
            'userid' => 'userid',
            'workerid' => 'workerid',
            'count' => 'count',
            'date' => 'date',
            'reasoncode' => 'reasoncode',
            'reason' => 'reason',
        );
    }

}
