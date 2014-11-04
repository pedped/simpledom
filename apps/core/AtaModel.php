<?php

namespace Simpledom\Core;

use BaseSystemLog;
use Phalcon\DI\FactoryDefault;
use Phalcon\DiInterface;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
use Simpledom\Frontend\BaseControllers\ControllerBase;

abstract class AtaModel extends Model {

    /**
     * Get DI
     * @return DiInterface
     */
    public function getDI() {
        return FactoryDefault::getDefault();
    }

    abstract function getPublicResponse();

    public function getMessagesAsLines() {
        $result = array();
        foreach ($this->getMessages() as $message) {
            $result[] = $message;
        }
        return implode("\n", $result);
    }

    /**
     * Create Custom Query
     * @param type $sql
     * @param type $params
     * @return Simple
     */
    public function rawQuery($sql, $params = null) {
        return new Resultset(null, $this, $this->getReadConnection()->query($sql, $params));
    }

    public function generateRandomString($length = 10) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    public function generateRandomNumber($length = 10) {

        $characters = '123456789';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    /**
     * 
     * @param ControllerBase $controller
     */
    public function showErrorMessages($controller) {
        foreach ($this->getMessages() as $message) {
            $controller->flash->error($message);
        }
    }

    /**
     * 
     * @param ControllerBase $controller
     */
    public function showSuccessMessages($controller, $message) {
        $controller->flash->success($message);
    }

    private function log($type, $title, $message, $ip = null) {
        return BaseSystemLog::createLog($type, $title, $message, $ip);
    }

    protected function LogInfo($title, $message, $ip = null) {
        return $this->log(2, $title, $message, $ip);
    }

    protected function LogDebug($title, $message, $ip = null) {
        return $this->log(1, $title, $message, $ip);
    }

    protected function LogError($title, $message, $ip = null) {
        return $this->log(4, $title, $message, $ip);
    }

    protected function LogFetal($title, $message, $ip = null) {
        return $this->log(5, $title, $message, $ip);
    }

    protected function LogWarning($title, $message, $ip = null) {
        return $this->log(3, $title, $message, $ip);
    }

}
