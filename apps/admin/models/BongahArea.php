<?php

use Simpledom\Core\AtaModel;

class BongahArea extends AtaModel {

    public function getSource() {
        return 'bongaharea';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BongahArea
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Bongah ID
     * @var string
     */
    public $bongahid;

    /**
     * Set Bongah ID
     * @param type $bongahid
     * @return BongahArea
     */
    public function setBongahid($bongahid) {
        $this->bongahid = $bongahid;
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
     * @return BongahArea
     */
    public function setAreaid($areaid) {
        $this->areaid = $areaid;
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
     * @return BongahArea
     */
    public function setEnable($enable) {
        $this->enable = $enable;
        return $this;
    }

    /**
     *
     * @param type $parameters
     * @return BongahArea
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
