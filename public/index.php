<?php

$_SERVER["REMOTE_ADDR"] = $_SERVER["HTTP_X_REAL_IP"];

//define("DEBUG_MODE", TRUE);
define("EMPTYCOLUMN", "<UNDEFINED>");


define("CITY_SHIRAZ", 1);


define("PRODUCT_STATUS_ACTIVE", 1);
define("PRODUCT_STATUS_DIACTIVE", 0);
define("PRODUCT_STATUS_OUTOFSTOCK", 2);

define("INVOICESTATUS_REQUESTED", 1);
define("INVOICESTATUS_PROCCESSINGINWAREHOUSE", 2);
define("INVOICESTATUS_PACAKING", 3);
define("INVOICESTATUS_SENDING", 4);
define("INVOICESTATUS_RECEIVED", 5);
define("INVOICESTATUS_CANCELLEDBYUSER", 6);
define("INVOICESTATUS_CANCELEDBYCENTER", 7);


define("PROMOTION_PRODUCT_STATUS_SUSSPEND", 0);
define("PROMOTION_PRODUCT_STATUS_ACTIVE", 1);
define("PROMOTION_PRODUCT_STATUS_FINISHED", 2);

define("DELIVERYTIMEMODE_UNDERONEHOUR", 1);
define("DELIVERYTIMEMODE_UNDERFOURHOURS", 2);


define("PROMOTION_STATUS_ACTIVE", 1);
define("PROMOTION_STATUS_SUSSPEND", 0);
define("PROMOTION_STATUS_FINISHEDBYTOTALORDER", 2);
define("PROMOTION_STATUS_FINISHEDBYDATE", 3);


define("INVOICEUSERSTATUS_REQUESTED", 1);


use Phalcon\Events\Manager;
use Phalcon\Exception;
use Phalcon\Flash\Direct;
use Phalcon\Http\Response\Cookies;
use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Phalcon\Security;
use Phalcon\Cache\Frontend\Output as OutputFrontend;
use Phalcon\Cache\Backend\Memcache as MemcacheBackend;

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
    
    
    
    
      //Database Information
    $db_host = "localhost"; //Host address (most likely localhost)
    $db_name = "avoocado"; //Name of Database
    $db_user = "avoocado"; //Name of database user
    $db_pass = "iHjFVuYzltnLlhVC"; //Password for database user

    /* Create a new mysqli object with database connection parameters */
    $mysqliu = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $mysqliu->set_charset('utf8mb4');

    GLOBAL $mysqliu;

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


    //Set the views cache service
    $di->set('viewCache', function() {

        //Cache data for one day by default
        $frontCache = new OutputFrontend(array(
            "lifetime" => 86400
        ));

        //Memcached connection settings
        $cache = new MemcacheBackend($frontCache, array(
            "host" => "localhost",
            "port" => "11211"
        ));

        return $cache;
    });

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
