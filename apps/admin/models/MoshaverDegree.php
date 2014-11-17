<?php

use Simpledom\Core\AtaModel;

class MoshaverDegree extends AtaModel {

    public function getSource() {
        return 'moshaver_degree';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return MoshaverDegree
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
     * @return MoshaverDegree
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     *
     * @param type $parameters
     * @return MoshaverDegree
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
