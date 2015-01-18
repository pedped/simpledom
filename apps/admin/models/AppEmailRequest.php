<?php

use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;

class AppEmailRequest extends AtaModel {

    public function getSource() {
        return 'appemailrequest';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return AppEmailRequest
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * phone
     * @var string
     */
    public $phone;

    /**
     * Set phone
     * @param type $phone
     * @return AppEmailRequest
     */
    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }

    /**
     * email
     * @var string
     */
    public $email;

    /**
     * Set email
     * @param type $email
     * @return AppEmailRequest
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /**
     * date
     * @var string
     */
    public $date;

    /**
     * Set date
     * @param type $date
     * @return AppEmailRequest
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * ip
     * @var string
     */
    public $ip;

    /**
     * Set ip
     * @param type $ip
     * @return AppEmailRequest
     */
    public function setIp($ip) {
        $this->ip = $ip;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:m:s', $this->date);
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
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

    /**
     *
     * @param type $parameters
     * @return AppEmailRequest
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
