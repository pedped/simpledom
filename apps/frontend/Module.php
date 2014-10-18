<?php

namespace Simpledom\Frontend;

use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

class Module implements ModuleDefinitionInterface {

    /**
     * Register a specific autoloader for the module
     */
    public function registerAutoloaders() {

        $loader = new Loader();

        $loader->registerNamespaces(
                array(
                    'Simpledom\Core\Classes' => dirname(__DIR__) . '/core/class/',
                    'Simpledom\Frontend\Controllers' => __DIR__ . '/controllers/',
                    'Simpledom\Models' => dirname(__DIR__) . '/admin/models/',
                    'Simpledom\Core\Models' => dirname(__DIR__) . '/core/models/',
                    'Simpledom\Core' => dirname(__DIR__) . '/core/',
                )
        );

        $loader->register();
    }

    /**
     * Register specific services for the module
     */
    public function registerServices($di) {


        $config = require_once 'config/config.php';


        //Registering a dispatcher
        $di->set('dispatcher', function() {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace("Simpledom\Frontend\Controllers");
            return $dispatcher;
        });


        //Registering the view component
        $di->set('view', function() {
            $view = new View();
            $view->setViewsDir(__DIR__ . '/views/');
            return $view;
        });


        $loader = new Loader();

        /**
         * We're a registering a set of directories taken from the configuration file
         */
        $loader->registerDirs(
                array(
                    dirname(__DIR__) . '\\admin\\models\\',
                    __DIR__ . '\\models\\',
                    __DIR__ . '\\forms\\',
                    __DIR__ . '\\controllers\\',
                    dirname(__DIR__) . '\\core\\',
                    dirname(__DIR__) . '\\core\\class\\',
                    dirname(__DIR__) . '\\core\\class\\smsproviders\\',
                    dirname(__DIR__) . '\\core\\class\\paymentproviders\\',
                    dirname(__DIR__) . '\\core\\interfaces\\',
                    dirname(__DIR__) . '\\core\\models\\',
                    dirname(__DIR__) . '\\core\\form\\',
                    dirname(__DIR__) . '\\core\\element\\',
                    dirname(__DIR__) . '\\models\\',
                )
        )->register();


        $di->set('profiler', function() {
            return new \Phalcon\Db\Profiler();
        }, true);


        /**
         * Database connection is created based in the parameters defined in the configuration file
         */
        $di->set('db', function () use ($config, $di) {



            $eventsManager = new \Phalcon\Events\Manager();


            //Get a shared instance of the DbProfiler
            $profiler = $di->getProfiler();

            //Listen all the database events
            $eventsManager->attach('db', function($event, $connection) use ($profiler) {
                if ($event->getType() == 'beforeQuery') {
                    $profiler->startProfile($connection->getSQLStatement());
                }
                if ($event->getType() == 'afterQuery') {
                    $profiler->stopProfile();
                }
            });

            $connection = new DbAdapter(array(
                'host' => $config->database->host,
                'username' => $config->database->username,
                'password' => $config->database->password,
                'dbname' => $config->database->dbname
            ));

            //Assign the eventsManager to the db adapter instance
            $connection->setEventsManager($eventsManager);

            return $connection;
        });



        $di->set('url', function() {
            $url = new Url();
            $url->setBaseUri('/simpledom/');
            return $url;
        });

        // enable debug mode
        $di->set("debug", true);

        $di['router']->setDefaultNamespace("Simpledom\Frontend\Controllers");
    }

}

//namespace Simpledom\Frontend;
//
//use Phalcon\Loader;
//use Phalcon\Mvc\View;
//use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
//use Phalcon\Mvc\ModuleDefinitionInterface;
//
//class Module implements ModuleDefinitionInterface {
//
//    /**
//     * Registers the module auto-loader
//     */
//    public function registerAutoloaders() {
//
//        $loader = new Loader();
//
//        $loader->registerNamespaces(array(
//            'Simpledom\Frontend\Controllers' => __DIR__ . '/controllers/',
//            'Simpledom\Frontend\Models' => __DIR__ . '/models/',
//        ));
//        
//        $loader->registerDirs(array(
//            __DIR__ . '/models/',
//        ));
//
//        $loader->register();
//    }
//
//    /**
//     * Registers the module-only services
//     *
//     * @param Phalcon\DI $di
//     */
//    public function registerServices($di) {
//
//        /**
//         * Read configuration
//         */
//        $config = include __DIR__ . "/config/config.php";
//
//        /**
//         * Setting up the view component
//         */
//        $di['view'] = function () {
//            $view = new View();
//            $view->setViewsDir(__DIR__ . '/views/');
//
//            return $view;
//        };
//
//        /**
//         * Database connection is created based in the parameters defined in the configuration file
//         */
//        $di['db'] = function () use ($config) {
//            return new DbAdapter(array(
//                "host" => $config->database->host,
//                "username" => $config->database->username,
//                "password" => $config->database->password,
//                "dbname" => $config->database->dbname
//            ));
//        };
//    }
//
//}
