<?php

use Simpledom\Core\AtaModel;

class OrganSentMessage extends AtaModel {

    public function getSource() {
        return 'organ_sentmessage';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return OrganSentMessage
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Organ ID
     * @var string
     */
    public $organid;

    /**
     * Set Organ ID
     * @param type $organid
     * @return OrganSentMessage
     */
    public function setOrganid($organid) {
        $this->organid = $organid;
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
     * @return OrganSentMessage
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
     * @return OrganSentMessage
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Sender Number
     * @var string
     */
    public $sendernumber;

    /**
     * Set Sender Number
     * @param type $sendernumber
     * @return OrganSentMessage
     */
    public function setSendernumber($sendernumber) {
        $this->sendernumber = $sendernumber;
        return $this;
    }

    /**
     * From Number
     * @var string
     */
    public $fromnumber;

    /**
     * Set From Number
     * @param type $fromnumber
     * @return OrganSentMessage
     */
    public function setFromnumber($fromnumber) {
        $this->fromnumber = $fromnumber;
        return $this;
    }

    /**
     * To Number
     * @var string
     */
    public $tonumber;

    /**
     * Set To Number
     * @param type $tonumber
     * @return OrganSentMessage
     */
    public function setTonumber($tonumber) {
        $this->tonumber = $tonumber;
        return $this;
    }

    /**
     * Cost
     * @var string
     */
    public $cost;

    /**
     * Set Cost
     * @param type $cost
     * @return OrganSentMessage
     */
    public function setCost($cost) {
        $this->cost = $cost;
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
     * @return OrganSentMessage
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
