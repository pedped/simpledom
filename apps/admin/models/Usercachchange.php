<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;

class Usercachchange extends AtaModel {

    public function initialize() {
        
    }

    public function getSource() {
        return 'usercachchange';
    }

    /**
     * کد
     * @FieldName('کد')
     * @var string
     */
    public $id;

    /**
     * Set کد
     * @param type $id
     * @return Usercachchange
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * کاربر
     * @FieldName('کاربر')
     * @var string
     */
    public $userid;

    /**
     * Set کاربر
     * @param type $userid
     * @return Usercachchange
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * مقدار
     * @FieldName('مقدار')
     * @var string
     */
    public $amount;

    /**
     * Set مقدار
     * @param type $amount
     * @return Usercachchange
     */
    public function setAmount($amount) {
        $this->amount = $amount;
        return $this;
    }

    /**
     * تاریخ
     * @FieldName('تاریخ')
     * @var string
     */
    public $date;

    /**
     * Set تاریخ
     * @param type $date
     * @return Usercachchange
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * دلیل تغییر
     * @FieldName('دلیل تغییر')
     * @var string
     */
    public $reasonid;

    /**
     * Set دلیل تغییر
     * @param type $reasonid
     * @return Usercachchange
     */
    public function setReasonid($reasonid) {
        $this->reasonid = $reasonid;
        return $this;
    }

    /**
     * اطلاعات بیشتر
     * @FieldName('اطلاعات بیشتر')
     * @var string
     */
    public $more;

    /**
     * Set اطلاعات بیشتر
     * @param type $more
     * @return Usercachchange
     */
    public function setMore($more) {
        $this->more = $more;
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
     * @return Usercachchange
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
        $result->Amount = $this->amount;
        $result->Date = $this->date;
        $result->MoreInfo = $this->more;

        $reason = Cachchangereason::findFirst($this->reasonid);
        $result->ReasonTitle = $reason->name;
        $result->ReasonDescription = $reason->description;
        $result->IsGift = $reason->isgift;
        $result->IsIncrease = $reason->increase;

        if (isset($reason->imageid))
            $result->ImageLink = $reason->getImage()->link;


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
            'amount' => 'amount',
            'date' => 'date',
            'reasonid' => 'reasonid',
            'more' => 'more',
            'isgift' => 'isgift',
        );
    }

}
