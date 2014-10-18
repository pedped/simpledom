<?php

use Simpledom\Core\AtaModel;

class BaseTransactionType extends AtaModel {

    public function getSource() {
        return 'transactiontype';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BaseTransactionType
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Key
     * @var string
     */
    public $key;

    /**
     * Set Key
     * @param type $key
     * @return BaseTransactionType
     */
    public function setKey($key) {
        $this->key = $key;
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
     * @return BaseTransactionType
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function beforeValidationOnCreate() {
        
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

    /**
     * 
     * @param type $parameters
     * @return TransactionType
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

}
