<?php

use Simpledom\Core\AtaModel;

class BaseUserCachChange extends AtaModel {

    public function getSource() {
        return 'usercachchange';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BaseUserCachChange
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
     * @return BaseUserCachChange
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * Amount
     * @var string
     */
    public $amount;

    /**
     * Set Amount
     * @param type $amount
     * @return BaseUserCachChange
     */
    public function setAmount($amount) {
        $this->amount = $amount;
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
     * @return BaseUserCachChange
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Reason
     * @var string
     */
    public $reasonid;

    /**
     * Set Reason
     * @param type $reasonid
     * @return BaseUserCachChange
     */
    public function setReasonid($reasonid) {
        $this->reasonid = $reasonid;
        return $this;
    }

    /**
     * More Info
     * @var string
     */
    public $more;

    /**
     * Set More Info
     * @param type $more
     * @return BaseUserCachChange
     */
    public function setMore($more) {
        $this->more = $more;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:m:s', $this->date);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

}
