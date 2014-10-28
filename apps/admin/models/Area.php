<?php

use Phalcon\Mvc\Model\Resultset;
use Simpledom\Core\AtaModel;

class Area extends AtaModel {

    public function getSource() {
        return 'area';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return Area
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * City ID
     * @var string
     */
    public $cityid;

    /**
     * Set City ID
     * @param type $cityid
     * @return Area
     */
    public function setCityid($cityid) {
        $this->cityid = $cityid;
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
     * @return Area
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * By User
     * @var string
     */
    public $byuserid;

    /**
     * Set By User
     * @param type $byuserid
     * @return Area
     */
    public function setByuserid($byuserid) {
        $this->byuserid = $byuserid;
        return $this;
    }

    /**
     * Enable
     * @var string
     */
    public $enable;

    /**
     * Set Enable
     * @param type $enable
     * @return Area
     */
    public function setEnable($enable) {
        $this->enable = $enable;
        return $this;
    }

    /**
     *
     * @param type $parameters
     * @return Area
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

    /**
     * Fetch the highest location in each area
     * @param type $cityid
     * @return Resultset
     */
    public static function getHighestArea($cityid) {

        $area = new Area();
        return $area->rawQuery("SELECT area.name , count(*) as total FROM `melkarea` JOIN area ON area.id = melkarea.areaid WHERE melkarea.cityid = ? AND area.enable = 1 GROUP BY area.id ORDER BY total DESC", array(
                    $cityid
        ));
    }

}
