<?php

namespace Simpledom\Frontend\Controllers;

use BaseTrack;
use BaseUser;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Url;
use Phalcon\Tag;
use Phalcon\Validation\Exception;
use Simpledom\Core\AtaForm;
use Simpledom\Models\Settings;

class ControllerBase extends Controller {

    private $pageTitle = "Title";
    protected $errors;

    /**
     * Get User
     * @var BaseUser 
     */
    protected $user;

    public function getPageTitle() {
        return $this->pageTitle;
    }

    public function setPageTitle($pageTitle) {
        $this->pageTitle = $pageTitle;
        Tag::prependTitle($this->getPageTitle());
    }

    /**
     * this function will get website settings
     * @param type $title
     * @return string
     */
    public function getSettings($title) {

        return $title;
    }

    public function initialize() {
        // CSS in the header
        $this->assets
                ->collection('header')
                ->setPrefix('http://localhost/simpledom/')
                ->addCss('css/bt3/bootstrap.css', true)
                ->addCss('css/app/main.css', true);


        //Javascripts in the footer
        $this->assets
                ->collection('footer')
                ->setPrefix('http://localhost/simpledom/')
                ->addJs('js/jquery/jquery.min.js', true)
                ->addJs('bootstrap/bootstrap.js', true);


        //Javascripts in the footer
        $this->assets
                ->collection('elementscripts')
                ->setPrefix('http://localhost/simpledom/');
        $this->assets
                ->collection('externalscripts');


        // we have to track user action right there
        $action = new BaseTrack();
        $action->date = time();
        $action->agent = $this->request->getUserAgent();
        $action->ip = $_SERVER['REMOTE_ADDR'];
        $action->parameters = json_encode($_REQUEST);
        $url = new Url();
        $action->url = $url->getBaseUri();

        if ($this->session->has("userid")) {
            $action->userid = $this->session->get("userid");
            $this->user = BaseUser::findFirst($action->userid);
        }

        // set page title
        $this->view->pageTitle = $this->pageTitle;

        $this->view->websiteSettings = Settings::Get();

        // set title
        Tag::setTitle(" - " . $this->view->websiteSettings->websitename);

        // check if website is offline, show offline message
        if ((bool) $this->view->websiteSettings->offline) {
            // TODO create offline mode
        }


        // save the action
        $action->create();
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
