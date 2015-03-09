<?php

namespace Simpledom\Admin\BaseControllers;

use AtaController;
use BaseContact;
use Phalcon\Mvc\Dispatcher;
use Settings;
use User;

abstract class ControllerBase extends AtaController {

    /**
     * Get User
     * @var User 
     */
    protected $user;

    public function initialize() {
        parent::initialize();
        putenv("LC_ALL=en_Us");
        setlocale(LC_ALL, "en_Us");
        bindtextdomain('messages', $_SERVER["DOCUMENT_ROOT"] . "/Local/");
        textdomain('messages');
        bind_textdomain_codeset("messages", 'UTF-8');

        // check if user is loged in and is super admin
        if ($this->session->get("userid", -1) > 0) {
            // get the user to know he is admin
            $userid = $this->session->get("userid");
            $user = User::findFirst($userid);
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
                ->setPrefix('http://www.bargsoft.ir/')
                ->addCss('css/bt3/bootstrap.css', true)
                ->addCss('css/app/main.css', true);

        //Javascripts in the footer
        $this->assets
                ->collection('footer')
                ->setPrefix('http://www.bargsoft.ir/')
                ->addJs('js/jquery/jquery.min.js', true)
                ->addJs('bootstrap/bootstrap.js', true);


        //Javascripts in the footer
        $this->assets
                ->collection('elementscripts')
                ->setPrefix('http://www.bargsoft.ir/');
        $this->assets
                ->collection('externalscripts');


        $this->view->pfurl = "http://www.bargsoft.ir/";

        // set default page title
        $this->setTitle("Dashboard");


        // load messages
        $contacts = BaseContact::find(array(
                    "limit" => 5,
                    "order" => "date DESC"
        ));
        $this->view->lastMessages = $contacts;
        $this->view->newMessageCount = BaseContact::count(array(
                    'seen = 0'
        ));

        $this->view->totalContactsUnanswered = BaseContact::count("reply IS NULL");

        if ($this->session->has("userid")) {
            $this->user = User::findFirst($this->session->get("userid"));
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
        parent::beforeExecuteRoute($dispatcher);
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

}
