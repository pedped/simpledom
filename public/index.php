<?php

//define("DEBUG_MODE", TRUE);


use Phalcon\Events\Manager;
use Phalcon\Exception;
use Phalcon\Flash\Direct;
use Phalcon\Http\Response\Cookies;
use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Phalcon\Security;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);


putenv("LC_ALL=fa_IR");
setlocale(LC_ALL, "fa_IR");
bindtextdomain('messages', $_SERVER["DOCUMENT_ROOT"] . "/Local/");
textdomain('messages');
bind_textdomain_codeset("messages", 'UTF-8');

try {

    /**
     * Include services
     */
    require __DIR__ . '/../config/services.php';
    require __DIR__ . '/../vendor/autoload.php';

    /**
     * Handle the request
     */
    $application = new Application();

    /**
     * Assign the DI
     */
    $application->setDI($di);


    // Load some items
    // Creates the autoloader
    $loader = new Loader();

    //Set file extensions to check
    $loader->setExtensions(array("php"));


    //Register some namespaces
    $loader->registerNamespaces(
            array(
                "Simpledom\Core" => dirname(__DIR__) . "/apps/core/",
                "Simpledom\Core" => dirname(__DIR__) . "/apps/core/form/",
            //"Simpledom\Core" => dirname(__DIR__) . "/apps/frontend/core/model/",
            )
    );


    // Register some directories
    $loader->registerDirs(
            array(
                dirname(__DIR__) . "/apps/core/class/paymentproviders/",
                dirname(__DIR__) . "/apps/core/interfaces/",
                dirname(__DIR__) . "/apps/admin/models/",
                dirname(__DIR__) . "/apps/core/",
                dirname(__DIR__) . "/apps/core/class/",
                dirname(__DIR__) . "/apps/core/class/smsproviders/",
                dirname(__DIR__) . "/apps/core/controllers/",
                dirname(__DIR__) . "/apps/core/element/",
                dirname(__DIR__) . "/apps/core/form/",
                dirname(__DIR__) . "/apps/core/models/",
                dirname(__DIR__) . "/apps/admin/forms/",
                dirname(__DIR__) . "/apps/frontend/models/",
                dirname(__DIR__) . "/apps/frontend/forms/",
            )
    );

    $eventsManager = new Manager();

    //Listen all the loader events
    $eventsManager->attach('loader', function($event, $loader) {
        if ($event->getType() == 'beforeCheckPath') {
            // var_dump($loader->getCheckedPath());
        }
    });

    $loader->setEventsManager($eventsManager);

    // register autoloader
    $loader->register();


    //Register the flash service with custom CSS classes
    $di->set('flash', function() {
        $flash = new Direct(array(
            'error' => 'alert alert-danger',
            'success' => 'alert alert-success',
            'notice' => 'alert alert-info',
        ));
        return $flash;
    });

    // set cookie
    $di->set('cookies', function() {
        $cookies = new Cookies();
        $cookies->useEncryption(false);
        return $cookies;
    });
//    $di->set('crypt', function() {
//        $crypt = new Phalcon\Crypt();
//        $crypt->setKey('#1dj8$=dp?.ak//j1V$'); //Use your own key!
//        return $crypt;
//    });


    $di->set('security', function() {
        $security = new Security();

        //Set the password hashing factor to 12 rounds
        $security->setWorkFactor(12);

        return $security;
    }, true);



    $di['router']->add("/organ/([0-9]+)/:action/:params", array(
        "controller" => "organ",
        "action" => 2,
        "organid" => 1,
        "params" => 3
            )
    );


    $di['router']->add("/organ/([0-9]+)/", array(
        "controller" => "organ",
        "action" => "dashboard",
        "organid" => 1,
            )
    );


    //==========================================================================
    $di['router']->add("/organ/([0-9]+)/posts/add", array(
        "controller" => "post",
        "action" => "add",
        "organid" => 1,
            )
    );
    $di['router']->add("/organ/([0-9]+)/posts/edit/:params", array(
        "controller" => "post",
        "action" => "edit",
        "organid" => 1,
        "params" => 2,
            )
    );
    $di['router']->add("/organ/([0-9]+)/posts/delete/:params", array(
        "controller" => "post",
        "action" => "delete",
        "organid" => 1,
        "params" => 2,
            )
    );

    // user posts
    $di['router']->add("/organ/([0-9]+)/users/add", array(
        "controller" => "userpost",
        "action" => "add",
        "organid" => 1,
            )
    );
    $di['router']->add("/organ/([0-9]+)/users/edit/:params", array(
        "controller" => "userpost",
        "action" => "edit",
        "organid" => 1,
        "params" => 2,
            )
    );
    $di['router']->add("/organ/([0-9]+)/users/delete/:params", array(
        "controller" => "userpost",
        "action" => "delete",
        "organid" => 1,
        "params" => 2,
            )
    );

    $di['router']->add("/organ/([0-9]+)/permissions/add", array(
        "controller" => "sendpermission",
        "action" => "add",
        "organid" => 1,
            )
    );
    $di['router']->add("/organ/([0-9]+)/permissions/edit/:params", array(
        "controller" => "sendpermission",
        "action" => "edit",
        "organid" => 1,
        "params" => 2,
            )
    );
    $di['router']->add("/organ/([0-9]+)/permissions/delete/:params", array(
        "controller" => "sendpermission",
        "action" => "delete",
        "organid" => 1,
        "params" => 2,
            )
    );

    /**
     * Include modules
     */
    require __DIR__ . '/../config/modules.php';

    echo $application->handle()->getContent();

    //Get the generated profiles from the profiler
    $profiles = $di->get('profiler')->getProfiles();
    if (false && isset($profiles)) {
        foreach ($profiles as $profile) {
            echo "<pre>";
            echo("<b>" . $profile->getSQLStatement() . "</b>");
            echo("<br/><br/>Start Time: " . $profile->getInitialTime());
            echo("<br/>Final Time: " . $profile->getFinalTime());
            echo("<br/>Total Time: " . $profile->getTotalElapsedSeconds());
            echo "</pre><hr/>";
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
} catch (PDOException $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}
