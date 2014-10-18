<?php

namespace Simpledom\Api;

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
                    'Simpledom\Api\Controllers' => __DIR__ . '/controllers/',
                    'Simpledom\Core' => dirname(__DIR__) . '/frontend/core/',
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
            $dispatcher->setDefaultNamespace("Simpledom\Api\Controllers");
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
                    __DIR__ . '\\core\\',
                    __DIR__ . '\\core\\form\\',
                    __DIR__ . '\\core\\element\\',
                    __DIR__ . '\\controllers\\'
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


        $di['router']->setDefaultNamespace("Simpledom\Api\Controllers");
    }

}
