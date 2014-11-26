<?php

use Simpledom\Core\AtaModel;

class BongahSentMelk extends AtaModel {

    public function getSource() {
        return 'bongahsentmelk';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BongahSentMelk
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
     * @return BongahSentMelk
     */
    public function setBongahid($bongahid) {
        $this->bongahid = $bongahid;
        return $this;
    }

    /**
     * Melk Phone Listner
     * @var string
     */
    public $melkphonelistnerid;

    /**
     * Set Melk Phone Listner
     * @param type $melkphonelistnerid
     * @return BongahSentMelk
     */
    public function setMelkphonelistnerid($melkphonelistnerid) {
        $this->melkphonelistnerid = $melkphonelistnerid;
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
     * @return BongahSentMelk
     */
    public function setMelkid($melkid) {
        $this->melkid = $melkid;
        return $this;
    }

    /**
     * Message
     * @var string
     */
    public $message;

    /**
     * Set Message
     * @param type $message
     * @return BongahSentMelk
     */
    public function setMessage($message) {
        $this->message = $message;
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
     * @return BongahSentMelk
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
     * @return BongahSentMelk
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
