<?php

use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;

class BaseContact extends AtaModel {

    public function getSource() {
        return "contact";
    }

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $section;

    /**
     *
     * @var string
     */
    public $message;

    /**
     *
     * @var string
     */
    public $reply;

    /**
     *
     * @var string
     */
    public $delete;

    /**
     *
     * @var int
     */
    public $date;

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
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        $this->delete = 0;
    }

    public function isReplied() {
        return isset($this->reply) && strlen($this->reply) > 0 ? true : false;
    }

    public function getDate() {
        return date("Y-m-d H:m:s", $this->date);
    }

    /**
     * 
     * @param type $parameters
     * @return BaseContact
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function getPublicResponse() {
        
    }

}
