<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;

class DeliveryModeOption extends AtaModel {

    public function initialize() {
        
    }

    public function getSource() {
        return 'delivery_mode_option';
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
     * @return DeliveryModeOption
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * تیتر
     * @FieldName('تیتر')
     * @var string
     */
    public $title;

    /**
     * Set تیتر
     * @param type $title
     * @return DeliveryModeOption
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * نحوه ارسال مربوطه
     * @FieldName('نحوه ارسال مربوطه')
     * @var string
     */
    public $delivery_mode_id;

    /**
     * Set نحوه ارسال مربوطه
     * @param type $delivery_mode_id
     * @return DeliveryModeOption
     */
    public function setDelivery_mode_id($delivery_mode_id) {
        $this->delivery_mode_id = $delivery_mode_id;
        return $this;
    }

    /**
     * توضیحات
     * @FieldName('توضیحات')
     * @var string
     */
    public $description;

    /**
     * Set توضیحات
     * @param type $description
     * @return DeliveryModeOption
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * وضعیت
     * @FieldName('وضعیت')
     * @var string
     */
    public $status;

    /**
     * Set وضعیت
     * @param type $status
     * @return DeliveryModeOption
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * ساعت شروع
     * @FieldName('ساعت شروع')
     * @var string
     */
    public $time_start;

    /**
     * Set ساعت شروع
     * @param type $time_start
     * @return DeliveryModeOption
     */
    public function setTime_start($time_start) {
        $this->time_start = $time_start;
        return $this;
    }

    /**
     * ساعت پایان
     * @FieldName('ساعت پایان')
     * @var string
     */
    public $time_end;

    /**
     * Set ساعت پایان
     * @param type $time_end
     * @return DeliveryModeOption
     */
    public function setTime_end($time_end) {
        $this->time_end = $time_end;
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
     * @return DeliveryModeOption
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
     * @return DeliveryModeOption
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
        $result->Title = $this->title;
        $result->DeliveryModeID = $this->delivery_mode_id;
        $result->Description = $this->description;
        $result->Status = $this->status;
        $result->TimeStart = $this->time_start;
        $result->TimeEnd = $this->time_end;
        $result->Date = $this->date;


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
            'delivery_mode_id' => 'delivery_mode_id',
            'description' => 'description',
            'status' => 'status',
            'time_start' => 'time_start',
            'time_end' => 'time_end',
            'date' => 'date',
        );
    }

}
