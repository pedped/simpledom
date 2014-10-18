<?php

use Simpledom\Core\AtaModel;

class BaseEmailTemplate extends AtaModel {

    public function getSource() {
        return 'email_template';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Name
     * @var string
     */
    public $name;

    /**
     * Template
     * @var string
     */
    public $template;

    /**
     * Validations and business logic
     */
    public function validation() {
        /**
         *                         $this->validate(
         *                                 new Email(
         *                                 array(
         *                             'field' => 'email',
         *                             'required' => true,
         *                                 )
         *                                 )
         * *                         );
         *                         if ($this->validationHasFailed() == true) {
         *                             return false;
         *                         }
         */
        return true;
    }

    public function beforeValidationOnCreate() {
        //$this->date = time();
        //$this->delete = 0;
    }

    //public function getDate() {
    //    return date('Y-m-d H:m:s', $this->date);
    //}

    public function getPublicResponse() {
        
    }

    /**
     *
     * @var string
     */
    public $parameters;

    /**
     *
     * @var ArrayObject
     */
    private $receivers;

    /**
     * Method to set the value of field name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Method to set the value of field template
     *
     * @param string $template
     * @return $this
     */
    public function setTemplate($template) {
        $this->template = $template;

        return $this;
    }

    /**
     * Method to set the value of field parameters
     *
     * @param string $parameters
     * @return $this
     */
    public function setParameters($parameters) {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Returns the value of field template
     *
     * @return string
     */
    public function getTemplate() {
        return $this->template;
    }

    /**
     * Returns the value of field parameters
     *
     * @return string
     */
    public function getParameters() {
        return $this->parameters;
    }

    /**
     * 
     * @param type $parameters
     * @return BaseEmailTemplate
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }


}
