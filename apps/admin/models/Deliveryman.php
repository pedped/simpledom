<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;

class Deliveryman extends AtaModel {

    public function initialize() {
        
    }

    public function getSource() {
        return 'deliveryman';
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
     * @return Deliveryman
     */
    public function setId($id) {
        $this->id = $id;
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
     * @return Deliveryman
     */
    public function setWorkerid($workerid) {
        $this->workerid = $workerid;
        return $this;
    }

    /**
     * Warehouse ID
     * @FieldName('Warehouse ID')
     * @var string
     */
    public $warehouseid;

    /**
     * Set Warehouse ID
     * @param type $warehouseid
     * @return Deliveryman
     */
    public function setWarehouseid($warehouseid) {
        $this->warehouseid = $warehouseid;
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
     * @return Deliveryman
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     *
     * @param type $parameters
     * @return Deliveryman
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        
    }

    public function beforeValidationOnSave() {
        
    }

    public function afterFetch() {
        
    }

    public function getPublicResponse() {

        $result = new stdClass();
        $result->ID = $this->id;
        $result->WorkerID = $this->workerid;
        $result->WarehouseID = $this->warehouseid;
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
            'workerid' => 'workerid',
            'warehouseid' => 'warehouseid',
            'status' => 'status',
        );
    }

}
