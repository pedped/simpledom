<?php

use Simpledom\Core\AtaModel;

class BaseState extends AtaModel {

    public function getSource() {
        return 'state';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return State
     */
    public function setId($id) {
        $this->id = $id;
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
     * @return State
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     *
     * @param type $parameters
     * @return State
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

}
