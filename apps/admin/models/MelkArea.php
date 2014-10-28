<?php

use Phalcon\Mvc\Model\Resultset;
use Simpledom\Core\AtaModel;

class MelkArea extends AtaModel {

    public function getSource() {
        return 'melkarea';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return MelkArea
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Melk ID
     * @var string
     */
    public $melkid;

    /**
     * Set Melk ID
     * @param type $melkid
     * @return MelkArea
     */
    public function setMelkid($melkid) {
        $this->melkid = $melkid;
        return $this;
    }

    /**
     * Area ID
     * @var string
     */
    public $areaid;

    /**
     * Set Area ID
     * @param type $areaid
     * @return MelkArea
     */
    public function setAreaid($areaid) {
        $this->areaid = $areaid;
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
     * @return MelkArea
     */
    public function setCityid($cityid) {
        $this->cityid = $cityid;
        return $this;
    }

    /**
     * By User ID
     * @var string
     */
    public $byuserid;

    /**
     * Set By User ID
     * @param type $byuserid
     * @return MelkArea
     */
    public function setByuserid($byuserid) {
        $this->byuserid = $byuserid;
        return $this;
    }

    /**
     * IP
     * @var string
     */
    public $ip;

    /**
     * Set IP
     * @param type $ip
     * @return MelkArea
     */
    public function setIp($ip) {
        $this->ip = $ip;
        return $this;
    }

    /**
     * Date
     * @var string
     */
    public $date;

    /**
     * Set Date
     * @param type $date
     * @return MelkArea
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
     * @return MelkArea
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }


}
