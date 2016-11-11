<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;
use Simpledom\Core\AtaForm;

abstract class AtaController extends Controller {

    public function initialize() {


        // check if we have one tiem token,
        // one time token can be used in mobile device and broswer comminication,
        // one time tokens will used only one time and after loadiding session,
        // one time token will be destoryed
        if ($this->request->has("ottoken")) {
            // get one time token
            $oneTimeTokenByUser = $this->request->get("ottoken", "string");

            // check if one time token is in database
            $oneTimeToken = OneTimeToken::findFirst(array("token = :token:", "bind" => array("token" => $oneTimeTokenByUser)));
            if ($oneTimeToken != FALSE) {
                // person who opened website has valid one time token
                $user = User::findWithUserID($oneTimeToken->userid);
                if ($user != FALSE) {

                    // user founded and is valid, we have to hide session
                    $user->setSession($this);

                    // now we have to delete one time token
                    $oneTimeToken->delete();
                }
            }
        }




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
        return count($this->errors) == 0;
    }

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

    /**
     * this function will 
     * @param Dispatcher $dispatcher
     * @return boolean
     */
    public function beforeExecuteRoute($dispatcher) {

//        //Parse the annotations in the method currently executed
//        $annotations = $this->annotations->getMethod(
//                $dispatcher->getActiveController(), $dispatcher->getActiveMethod()
//        );
//
//        //Check if the method has an annotation 'Cache'
//        if (!$this->session->has("userid") && $annotations->has('Cache')) {
//
//            //The method has the annotation 'Cache'
//            $annotation = $annotations->get('Cache');
//
//            //Get the lifetime
//            $lifetime = $annotation->getNamedArgument('lifetime');
//
//            $options = array('lifetime' => $lifetime);
//
//            //Check if there is an user defined cache key
//            if ($annotation->hasNamedArgument('key')) {
//                $options['key'] = $annotation->getNamedParameter('key');
//            } else {
//                // we have to create cache key
//                $cacheKey = $this->createCacheKey($dispatcher);
//
//                // set key
//                $options['key'] = $cacheKey;
//            }
//
//            //Enable the cache for the current method
//            $this->view->cache($options);
//        }
    }

    /**
     * create cache key
     * @param Dispatcher $dispatcher
     */
    private function createCacheKey($dispatcher) {

        $uniqueKey = array();
        foreach ($dispatcher->getParams() as $key => $value) {
            if (is_scalar($value)) {
                $uniqueKey[] = $key . ':' . $value;
            } else {
                if (is_array($value)) {
                    $uniqueKey[] = $key . ':[' . self::_createKey($value) . ']';
                }
            }
        }

        // join parameter string
        $parameterString = join(',', $uniqueKey);

        // create full string
        $key = md5($dispatcher->getDI()->get("url")->getBaseUri()) . $dispatcher->getControllerName() . "_" . $dispatcher->getActionName() . $parameterString;

        // return string
        return $key;
    }

}
