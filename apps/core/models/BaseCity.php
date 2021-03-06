<?php

use Simpledom\Core\AtaModel;

class BaseCity extends AtaModel {

    public function getSource() {
        return 'city';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return City
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * State ID
     * @var string
     */
    public $stateid;

    /**
     * Set State ID
     * @param type $stateid
     * @return City
     */
    public function setStateid($stateid) {
        $this->stateid = $stateid;
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
     * @return City
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public $captial;

    /**
     *
     * @param type $parameters
     * @return City
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

    public function getStateCitiesIDWithComma() {
        $cities = City::find(array("stateid = :stateid:", "bind" => array("stateid" => $this->stateid)));
        $items = array();
        foreach ($cities as $city) {
            $items[] = $city->id;
        }
        return implode(",", $items);
    }

    public function getStateCitiesWithComma() {
        $cities = City::find(array("stateid = :stateid:", "bind" => array("stateid" => $this->stateid)));
        $items = array();
        foreach ($cities as $city) {
            $items[] = $city->name;
        }
        return implode(",", $items);
    }

}
