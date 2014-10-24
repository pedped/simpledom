<?php

use Phalcon\Mvc\Controller;
use Simpledom\Core\AtaForm;

abstract class AtaController extends Controller {

    /**
     * this function will validate read, delete, remove, Saccess
     */
    protected abstract function ValidateAccess($id);

    private function log($type, $title, $message, $ip = null) {
        return BaseSystemLog::init($item)->setType($type)->setTitle($title)->setMessage($message)->setIP($ip)->create();
    }

    protected function LogInfo($title, $message, $ip = null) {
        return $this->log(SystemLogType::Info, $title, $message, $ip);
    }

    protected function LogDebug($title, $message, $ip = null) {
        return $this->log(SystemLogType::Debug, $title, $message, $ip);
    }

    protected function LogError($title, $message, $ip = null) {
        return $this->log(SystemLogType::Error, $title, $message, $ip);
    }

    protected function LogFetal($title, $message, $ip = null) {
        return $this->log(SystemLogType::Fatal, $title, $message, $ip);
    }

    protected function LogWarning($title, $message, $ip = null) {
        return $this->log(SystemLogType::Warning, $title, $message, $ip);
    }

    /**
     * This function will check if usre is logged in add user new user log
     * @param type $message
     */
    public function AddUserLog($message) {
        // check if the user logged in to the system, log home page visit
        if ($this->session->has("userid")) {
            BaseUserLog::byUserID($this->session->get("userid"))->setAction($message)->create();
        }
    }

    /**
     * this function will handle form scripts
     * @param AtaForm $fr
     */
    protected function handleFormScripts($fr) {

        $loadedScripts = array();
        foreach ($fr->getElements() as $element) {
            try {
                if (method_exists($element, "getScriptnames")) {

                    // load internal scripts
                    $scripts = $element->getScriptnames();
                    foreach ($scripts as $scriptname) {
                        if (!isset($loadedScripts[$scriptname])) {
                            $loadedScripts[$scriptname] = $scriptname;
                            $this->assets
                                    ->collection('elementscripts')->addJs($scriptname, true);
                        }
                    }

                    // Load External Javascripts
                    $externalscripts = $element->getExternalScriptNames();
                    foreach ($externalscripts as $scriptname) {
                        if (!isset($loadedScripts[$scriptname])) {
                            $loadedScripts[$scriptname] = $scriptname;
                            $this->assets
                                    ->collection('externalscripts')->addJs($scriptname, true);
                        }
                    }

                    // Load CSS
                    $CSSes = $element->getCssnames();
                    foreach ($CSSes as $cssname) {
                        if (!isset($loadedScripts[$cssname])) {
                            $loadedScripts[$cssname] = $cssname;
                            $this->assets
                                    ->collection('elementscss')->addCss($cssname, true);
                        }
                    }
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
    }

}
