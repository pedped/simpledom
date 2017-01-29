<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;

class DeliveryMode extends AtaModel {

    public function initialize() {
        
    }

    public function getSource() {
        return 'delivery_mode';
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
     * @return DeliveryMode
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
     * @return DeliveryMode
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * Description
     * @FieldName('Description')
     * @var string
     */
    public $description;

    /**
     * Set Description
     * @param type $description
     * @return DeliveryMode
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Full Introduction
     * @FieldName('Full Introduction')
     * @var string
     */
    public $full_introduction;

    /**
     * Set Full Introduction
     * @param type $full_introduction
     * @return DeliveryMode
     */
    public function setFull_introduction($full_introduction) {
        $this->full_introduction = $full_introduction;
        return $this;
    }

    /**
     * Min Price
     * @FieldName('Min Price')
     * @var string
     */
    public $min_price;

    /**
     * Set Min Price
     * @param type $min_price
     * @return DeliveryMode
     */
    public function setMin_price($min_price) {
        $this->min_price = $min_price;
        return $this;
    }

    /**
     * Max Price
     * @FieldName('Max Price')
     * @var string
     */
    public $max_price;

    /**
     * Set Max Price
     * @param type $max_price
     * @return DeliveryMode
     */
    public function setMax_price($max_price) {
        $this->max_price = $max_price;
        return $this;
    }

    /**
     * Min Count
     * @FieldName('Min Count')
     * @var string
     */
    public $min_count;

    /**
     * Set Min Count
     * @param type $min_count
     * @return DeliveryMode
     */
    public function setMin_count($min_count) {
        $this->min_count = $min_count;
        return $this;
    }

    /**
     * Max Count
     * @FieldName('Max Count')
     * @var string
     */
    public $max_count;

    /**
     * Set Max Count
     * @param type $max_count
     * @return DeliveryMode
     */
    public function setMax_count($max_count) {
        $this->max_count = $max_count;
        return $this;
    }

    /**
     * Last Update
     * @FieldName('Last Update')
     * @var string
     */
    public $lastupdate;

    /**
     * Set Last Update
     * @param type $lastupdate
     * @return DeliveryMode
     */
    public function setLastupdate($lastupdate) {
        $this->lastupdate = $lastupdate;
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
     * @return DeliveryMode
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * Base Cost
     * @FieldName('Base Cost')
     * @var string
     */
    public $basecost;

    /**
     * Set Base Cost
     * @param type $basecost
     * @return DeliveryMode
     */
    public function setBasecost($basecost) {
        $this->basecost = $basecost;
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
     * @return DeliveryMode
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
     * @return DeliveryMode
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
        $result->Description = $this->description;
        $result->FullIntroduction = $this->full_introduction;
        $result->Status = $this->status;
        
        // get delivery options
        $deliveryOptions = DeliveryModeOption::find(array("delivery_mode_id = :deliverymodeid:", "bind" => array("deliverymodeid" => $this->id)));
        $items = array();
        foreach ($deliveryOptions as $item){
            $items[] = $item->getPublicResponse();
        }
        
        $result->DeliveryOptions = $items;
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
            'description' => 'description',
            'full_introduction' => 'full_introduction',
            'min_price' => 'min_price',
            'max_price' => 'max_price',
            'min_count' => 'min_count',
            'max_count' => 'max_count',
            'lastupdate' => 'lastupdate',
            'status' => 'status',
            'basecost' => 'basecost',
            'date' => 'date',
        );
    }

    public static function GetList() {
        $deliveryOptions = DeliveryMode::find();
        $result = array();
        foreach ($deliveryOptions as $deliveryMode) {
            $result[] = $deliveryMode->getPublicResponse();
        }
        return $result;
    }

}
