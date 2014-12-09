<?php

use Phalcon\Mvc\Controller;
use Simpledom\Core\AtaForm;

abstract class AtaController extends Controller {

    public function initialize() {
        // check for the user session, if user has any save cookie, check for the user
        if (!$this->session->has("userid") && $this->cookies->has("rm")) {
            // try to get user cookei
            try {
                $rememberCookie = $this->cookies->get("rm")->getValue();
                $rememberCookieUser = intval($this->cookies->get("rmuser")->getValue());


                // check for session
                if (Session::hasSession($rememberCookie, $rememberCookieUser)) {
                    // we have to set user cookie
                    $user = User::findFirst(array("userid = :userid:", "bind" => array("userid" => $rememberCookieUser)));

                    // check if we have user
                    if ($user) {
                        // set user session
                        $user->setSession($this);
                    }
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
                die();
            }
        }
    }

    /**
     * hold the errors about controller
     * @var ArrayObject 
     */
    protected $errors = array();

    /**
     * this function will check if we have any error
     * @return type
     */
    protected function hasError() {
        return count($this->errors) > 0;
    }

    /**
     * this function will validate read, delete, remove, Saccess
     */
    protected abstract function ValidateAccess($id);

    private function log($type, $title, $message, $ip = null) {
        return BaseSystemLog::init($item)->setType($type)->setTitle($title)->setMessage($message)->setIP($ip)->create();
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
