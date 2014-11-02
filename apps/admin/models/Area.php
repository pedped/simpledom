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
        $this->enable = "1";
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
        return $area->rawQuery("SELECT area.id , area.cityid , area.name , count(*) as total FROM `melkarea` JOIN area ON area.id = melkarea.areaid WHERE melkarea.cityid = ? AND area.enable = 1 GROUP BY area.id ORDER BY total DESC", array(
                    $cityid
        ));
    }

    /**
     * This function will check if we have no area, create new area and return id
     * else, it return the id of current area in city
     * @param type $cityid City iD
     * @param string $name area name
     * @return int ID of area
     */
    public static function GetID($cityid, $name) {
        $area = Area::findFirst(array("cityid = :cityid: AND name = :name: ", "bind" => array("name" => $name, "cityid" => $cityid)));
        if (!$area) {
            // area is not exist
            $area = new Area();
            $area->byuserid = "0";
            $area->cityid = $cityid;
            $area->name = trim($name);
            $area->create();
        }
        return $area->id;
    }

    /**
     * Find IDs with names
     * @param type $cityid
     * @param string|Array $names
     * @return type
     */
    public static function GetMultiID($cityid, $names) {
        $ids = array();
        // explode items
        $items = array();
        if (is_array($names)) {
            $items = $names;
        } else {
            $items = explode(",", $names);
        }


        foreach ($items as $item) {
            $ids[] = Area::GetID($cityid, $item);
        }


        return $ids;
    }

}
