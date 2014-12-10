<?php

use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;

class BaseOpinion extends AtaModel {

    public function getSource() {
        return 'opinion';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BaseOpinion
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * User ID
     * @var string
     */
    public $userid;

    /**
     * Set User ID
     * @param type $userid
     * @return BaseOpinion
     */
    public function setUserid($userid) {
        $this->userid = $userid;
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
     * @return BaseOpinion
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Email
     * @var string
     */
    public $email;

    /**
     * Set Email
     * @param type $email
     * @return BaseOpinion
     */
    public function setEmail($email) {
        $this->email = $email;
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
     * @return BaseOpinion
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
     * @return BaseOpinion
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * fetch the Citys of this model based on date
     * @return City
     */
    public function getCity() {
        return City::findFirst(array("id = :id:", "bind" => array("id" => $this->id)));
    }

    /**
     * Rating
     * @var string
     */
    public $rate;

    /**
     * Set Rating
     * @param type $rate
     * @return BaseOpinion
     */
    public function setRate($rate) {
        $this->rate = $rate;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:i:s', $this->date);
    }

    /**
     * Validations and business logic
     */
    public function validation() {

        $this->validate(
                new Email(
                array(
            'field' => 'email',
            'required' => true,
                )
                )
        );
        if ($this->validationHasFailed() == true) {
            return false;
        }


        return true;
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

}
