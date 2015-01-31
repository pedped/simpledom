<?php

namespace Simpledom\Frontend\BaseControllers;

use AtaController;
use BaseTrack;
use Page;
use Phalcon\Mvc\Url;
use Phalcon\Tag;
use Settings;
use Simpledom\Core\Classes\Config;
use stdClass;
use User;

abstract class ControllerBase extends AtaController {

    private $pageTitle = "Title";
    private $metaKeywords = "";
    private $metaDescription = "";

    /**
     * Get User
     * @var User 
     */
    protected $user;

    /**
     *
     * @var \Settings 
     */
    protected $websiteSettings;

    public function getPageTitle() {
        return $this->pageTitle;
    }

    public function getMetaKeywords() {
        return $this->metaKeywords;
    }

    public function getMetaDescription() {
        return $this->metaDescription;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getUser() {
        return $this->user;
    }

    public function setMetaKeywords($metaKeywords) {
        $this->metaKeywords = $metaKeywords;
        return $this;
    }

    public function setMetaDescription($metaDescription) {
        $this->metaDescription = $metaDescription;
        return $this;
    }

    public function setErrors($errors) {
        $this->errors = $errors;
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
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
        return $this->websiteSettings->$title;
    }

    /**
     * Add New Breadcrump page
     * @param type $title
     * @param type $link
     */
    public function AddBreadcrumb($title, $link) {
        $item = new stdClass();
        $item->title = $title;
        $item->link = $link;
        $this->breadcrumb[] = $item; 
    }

    /**
     * show 404 not page for current view
     */
    public function show404() {
        $this->dispatcher->forward(array(
            "controller" => "error",
            "action" => "show404"
        ));
    }

    public function initialize() {
        parent::initialize();

        // define public path
        $publicFolderDirectory = dirname(dirname(dirname(__DIR__))) . "/public/";

        // CSS in the header
        $this->assets
                ->collection('header')
                ->setPrefix('http://amlak.edspace.org/')
                ->addCss('css/bt3/bootstrap.css', true)
                ->addCss('css/app/main.css', true)
                ->addCss('css/website/site.css', true)
                ->addCss('css/app/font-awesome/css/font-awesome.css', true);
//                ->join(true)
//                ->addFilter(new Jsmin())
//                ->setTargetPath($publicFolderDirectory . 'production/cssfile.css')
//                ->setTargetUri('production/cssfile.css');
        //Javascripts in the footer
        $this->assets
                ->collection('footer')
                ->setPrefix('http://amlak.edspace.org/')
                ->addJs('js/jquery/jquery.min.js', true)
                ->addJs('bootstrap/bootstrap.js', true);
//                ->join(true)
//                ->addFilter(new Jsmin())
//                ->setTargetPath($publicFolderDirectory . 'production/jsfiles.js')
//                ->setTargetUri('production/jsfiles.js');
        //Javascripts in the footer
        $this->assets
                ->collection('elementscripts')
                ->setPrefix('http://amlak.edspace.org/');
        $this->assets
                ->collection('elementscss')
                ->setPrefix('http://amlak.edspace.org/');
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
            $this->user = User::findFirst($action->userid);
            $this->view->user = $this->user;
        }

        // set page title
        $this->view->pageTitle = $this->pageTitle;

        $this->websiteSettings = Settings::Get();
        $this->view->websiteSettings = $this->websiteSettings;

        // set title
        Tag::setTitle(" - " . $this->view->websiteSettings->websitename);

        // check if website is offline, show offline message
        if ((bool) $this->view->websiteSettings->offline) {
            // TODO create offline mode
        }

        // check for meta keywords and meta descrption
        $this->view->metaKeywords = $this->getMetaKeywords();
        $this->view->metaDescription = $this->getMetaDescription();

        // check for pages that have to be in header
        $this->view->headerPages = array();
        $this->view->headerPages = Page::find("showinhead = 1");

        // check if we need to add rtl 
        if (intval($this->websiteSettings->rtl) == 1) {
            $this->assets
                    ->collection('header')->addCss("css/bt3/bootstrap-rtl.css")->addCss("css/bt3/custom-rtl.css");
        }

        // save the action
        $action->create();

        // add default page
        $this->AddBreadcrumb("خانه", Config::getPublicUrl());
    }

}
