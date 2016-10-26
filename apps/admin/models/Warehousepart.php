<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;

class Warehousepart extends AtaModel {

    public function initialize() {
        
    }

    public function getSource() {
        return 'warehousepart';
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
     * @return Warehousepart
     */
    public function setId($id) {
        $this->id = $id;
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
     * @return Warehousepart
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Warehouse Section ID
     * @FieldName('Warehouse Section ID')
     * @var string
     */
    public $warehousesectionid;

    /**
     * Set Warehouse Section ID
     * @param type $warehousesectionid
     * @return Warehousepart
     */
    public function setWarehousesectionid($warehousesectionid) {
        $this->warehousesectionid = $warehousesectionid;
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
     * @return Warehousepart
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
     * @return Warehousepart
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
        $result->Date = $this->date;
        $result->WarehouseSectionID = $this->warehousesectionid;
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
            'date' => 'date',
            'warehousesectionid' => 'warehousesectionid',
            'status' => 'status',
        );
    }

}
