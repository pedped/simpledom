<?php

namespace Simpledom\Admin\BaseControllers;

use AtaController;
use BaseContact;
use BaseUser;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Tag;
use Settings;

abstract class ControllerBase extends AtaController {

    /**
     * Errors holder
     * @var Array 
     */
    public $errors = array();

    /**
     * Get User
     * @var BaseUser 
     */
    protected $user;

    public function initialize() {

        // check if user is loged in and is super admin
        if ($this->session->get("userid", -1) > 0) {
            // get the user to know he is admin
            $userid = $this->session->get("userid");
            $user = BaseUser::findFirst($userid);
            if (!$user->isSuperAdmin()) {
                // invalid request
                die("You are not authrized to see this page");
            }
        } else {
            // invalid request
            die("You are not authrized to see this page");
        }


        // CSS in the header
        $this->assets
                ->collection('header')
                ->setPrefix('http://melk.edspace.org/')
                ->addCss('css/bt3/bootstrap.css', true)
                ->addCss('css/app/main.css', true);

        //Javascripts in the footer
        $this->assets
                ->collection('footer')
                ->setPrefix('http://melk.edspace.org/')
                ->addJs('js/jquery/jquery.min.js', true)
                ->addJs('bootstrap/bootstrap.js', true);


        $this->view->pfurl = "http://melk.edspace.org/";

        // set default page title
        $this->setTitle("Dashboard");


        // load messages
        $contacts = BaseContact::find(array(
                    "limit" => 5,
                    "order" => "date DESC"
        ));
        $this->view->lastMessages = $contacts;

        $this->view->totalContactsUnanswered = BaseContact::count("reply IS NULL");

        if ($this->session->has("userid")) {
            $this->user = BaseUser::findFirst($this->session->get("userid"));
            $this->view->loggedInUser = $this->user;
        }


        $this->view->websiteSettings = Settings::Get();

        // check if website is offline, show offline message
        if ((bool) $this->view->websiteSettings->offline) {
            $this->flash->notice("<h3 style='margin-top: 0px;margin-bottom: 0px;'>Attention!</h3>website is in offline mode");
        }
    }

    protected function setTitle($title) {
        $this->view->formTitle = $title;
    }

    /**
     * this function will 
     * @param Dispatcher $dispatcher
     * @return boolean
     */
    public function beforeExecuteRoute($dispatcher) {
        // This is executed before every found action
        if ($dispatcher->getActionName() == 'save') {

            $this->flash->error("You don't have permission to save posts");

            $this->dispatcher->forward(array(
                'controller' => 'home',
                'action' => 'index'
            ));

            return false;
        }
    }

    /**
     *  this function will run after every action
     * @param Dispatcher $dispatcher
     */
    public function afterExecuteRoute($dispatcher) {
        // Executed after every found action
        // check if we have any error, show the erros
        if (isset($this->errors) && count($this->errors) > 0) {
            $this->flash->error(implode("\r\n", $this->errors));
        }
    }

    /**
     * this function will handle form scripts
     * @param AtaForm $fr
     */
    public function handleFormScripts($fr) {

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


                    $externalscripts = $element->getExternalScriptNames();
                    foreach ($externalscripts as $scriptname) {
                        if (!isset($loadedScripts[$scriptname])) {
                            $loadedScripts[$scriptname] = $scriptname;
                            $this->assets
                                    ->collection('externalscripts')->addJs($scriptname, true);
                        }
                    }
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
    }

}
