<?php

use Simpledom\Core\AtaModel;

class BaseSystemLog extends AtaModel {

    public function getSource() {
        return 'systemlog';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Title
     * @var string
     */
    public $title;

    /**
     * IP
     * @var string
     */
    public $ip;

    /**
     * Message
     * @var string
     */
    public $message;

    /**
     * Date
     * @var string
     */
    public $date;

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
        $this->date = time();
        //$this->delete = 0;
    }

    public function getDate() {
        return date('Y-m-d H:m:s', $this->date);
    }

    public function getPublicResponse() {
        
    }

    /**
     * 
     * @return BaseSystemLog
     */
    public static function init(&$item) {
        $item = new BaseSystemLog();
        return $item;
    }

    /**
     * Set Title
     * @param type $title
     * @return BaseSystemLog
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * Set Message
     * @param type $message
     * @return BaseSystemLog
     */
    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    /**
     * Set ip
     * @param type $ip
     * @return BaseSystemLog
     */
    public function setIP($ip) {
        $this->ip = $ip;
        return $this;
    }

}
