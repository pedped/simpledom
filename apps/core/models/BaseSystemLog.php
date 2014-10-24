<?php

use Simpledom\Core\AtaModel;

abstract class SystemLogType {

    const Debug = 1;
    const Info = 2;
    const Warning = 3;
    const Error = 4;
    const Fatal = 5;

}

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
     * Type
     * @var string
     */
    public $type;

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

    /**
     * Set type
     * @param type $type
     * @return BaseSystemLog
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function getTypeIcon($includeText = true) {
        $item = "";
        switch ($this->type) {
            case SystemLogType::Debug:
                $item = '<i class="fa fa-bug fa-fw text-muted text-md va-middle"></i>';
                if ($includeText) {
                    $item.= "Debug";
                }
                break;
            case SystemLogType::Info:
                $item = '<i class="fa fa-info fa-fw text-info text-md va-middle"></i>';
                if ($includeText) {
                    $item.= "Info";
                }
                break;
            case SystemLogType::Warning:
                $item = '<i class="fa fa-warning fa-fw text-warning text-md va-middle"></i>';
                if ($includeText) {
                    $item.= "Warning";
                }
                break;
            case SystemLogType::Error:
                $item = '<i class="fa fa-times-circle fa-fw text-danger text-md va-middle"></i>';
                if ($includeText) {
                    $item.= "Error";
                }
                break;
            case SystemLogType::Fatal:
                $item = '<i class="fa fa-ban fa-fw text-danger text-md va-middle"></i>';
                if ($includeText) {
                    $item.= "Fatal";
                }
                break;
        }
        return $item;
    }

    public static function createLog($type, $title, $message, $ip = null) {
        return BaseSystemLog::init($item)->setType($type)->setTitle($title)->setMessage($message)->setIP(isset($ip) ? $ip : $_SERVER["REMOTE_ADDR"])->create();
    }

    public static function CreateLogInfo($title, $message, $ip = null) {
        return BaseSystemLog::createLog(SystemLogType::Info, $title, $message, $ip);
    }

    public static function CreateLogDebug($title, $message, $ip = null) {
        return BaseSystemLog::createLog(SystemLogType::Debug, $title, $message, $ip);
    }

    public static function CreateLogError($title, $message, $ip = null) {
        return BaseSystemLog::createLog(SystemLogType::Error, $title, $message, $ip);
    }

    public static function CreateLogFetal($title, $message, $ip = null) {
        return BaseSystemLog::createLog(SystemLogType::Fatal, $title, $message, $ip);
    }

    public static function CreateLogWarning($title, $message, $ip = null) {
        return BaseSystemLog::createLog(SystemLogType::Warning, $title, $message, $ip);
    }

}
