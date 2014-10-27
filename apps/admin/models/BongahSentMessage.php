<?php

use Simpledom\Core\AtaModel;

class BongahSentMessage extends AtaModel {

    public function getSource() {
        return 'bongahsentmessage';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BongahSentMessage
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
     * @return BongahSentMessage
     */
    public function setBongahid($bongahid) {
        $this->bongahid = $bongahid;
        return $this;
    }

    /**
     * Bongah Title
     * @var string
     */
    public $bongahtitle;

    /**
     * Set Bongah Title
     * @param type $bongahtitle
     * @return BongahSentMessage
     */
    public function setBongahtitle($bongahtitle) {
        $this->bongahtitle = $bongahtitle;
        return $this;
    }

    /**
     * To Phone
     * @var string
     */
    public $tophone;

    /**
     * Set To Phone
     * @param type $tophone
     * @return BongahSentMessage
     */
    public function setTophone($tophone) {
        $this->tophone = $tophone;
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
     * @return BongahSentMessage
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
     * @return BongahSentMessage
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * SMS Message ID
     * @var string
     */
    public $smsmessageid;

    /**
     * Set SMS Message ID
     * @param type $smsmessageid
     * @return BongahSentMessage
     */
    public function setSmsmessageid($smsmessageid) {
        $this->smsmessageid = $smsmessageid;
        return $this;
    }

    /**
     * Received
     * @var string
     */
    public $received;

    /**
     * Set Received
     * @param type $received
     * @return BongahSentMessage
     */
    public function setReceived($received) {
        $this->received = $received;
        return $this;
    }

    /**
     * Bongah Phone
     * @var string
     */
    public $bongahphone;

    /**
     * Set Bongah Phone
     * @param type $bongahphone
     * @return BongahSentMessage
     */
    public function setBongahphone($bongahphone) {
        $this->bongahphone = $bongahphone;
        return $this;
    }

    /**
     * Distance
     * @var string
     */
    public $distance;

    /**
     * Set Distance
     * @param type $distance
     * @return BongahSentMessage
     */
    public function setDistance($distance) {
        $this->distance = $distance;
        return $this;
    }

    /**
     * Type
     * @var string
     */
    public $type;

    /**
     * Set Type
     * @param type $type
     * @return BongahSentMessage
     */
    public function setType($type) {
        $this->type = $type;
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
     * @return BongahSentMessage
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        $this->received = "0";
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

}
