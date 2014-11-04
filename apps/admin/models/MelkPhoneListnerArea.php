<?php

use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;

class MelkPhoneListnerArea extends AtaModel {

    public function getSource() {
        return 'melkphonelistnerarea';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return MelkPhoneListnerArea
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Melk Phone Listner ID
     * @var string
     */
    public $melkphonelistnerid;

    /**
     * Set Melk Phone Listner ID
     * @param type $melkphonelistnerid
     * @return MelkPhoneListnerArea
     */
    public function setMelkphonelistnerid($melkphonelistnerid) {
        $this->melkphonelistnerid = $melkphonelistnerid;
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
     * @return MelkPhoneListnerArea
     */
    public function setAreaid($areaid) {
        $this->areaid = $areaid;
        return $this;
    }

    /**
     *
     * @param type $parameters
     * @return MelkPhoneListnerArea
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
