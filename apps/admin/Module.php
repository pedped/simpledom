<?php

namespace Simpledom\Admin;

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
                    'Simpledom\Admin\BaseControllers' => dirname(__DIR__) . '/core/controllers/',
                    'Simpledom\Admin\Controllers' => __DIR__ . '/controllers/',
                    'Simpledom\Core' => dirname(__DIR__) . '/core/',
                    'Simpledom\Core\SiteForms' => dirname(__DIR__) . '/admin/forms/',
                    'Simpledom\Models' => dirname(__DIR__) . '/frontend/models/',
                    'Simpledom\Admin\Models' => __DIR__ . '/models/',
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
            $dispatcher->setDefaultNamespace("Simpledom\Admin\Controllers");
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
                    __DIR__ . '\\component\\',
                    __DIR__ . '\\models\\',
                    __DIR__ . '\\controllers\\',
                    __DIR__ . '\\forms\\',
                    dirname(__DIR__) . '\\core\\',
                    dirname(__DIR__) . '\\core\\class\\',
                    dirname(__DIR__) . '\\core\\class\\smsproviders\\',
                    dirname(__DIR__) . '\\core\\class\\paymentproviders\\',
                    dirname(__DIR__) . '\\core\\element\\',
                    dirname(__DIR__) . '\\core\\interfaces\\',
                    dirname(__DIR__) . '\\core\\controllers\\',
                    dirname(__DIR__) . '\\models\\',
                    dirname(__DIR__) . '\\admin\\forms\\',
                )
        )->register();


        $di->set('profiler', function() {
            return new \Phalcon\Db\Profiler();
        }, true);



        /**
         * Database connection is created based in the parameters defined in the configuration file
         */
        $di->set('db', function () use ($config) {
            return new DbAdapter(array(
                'host' => $config->database->host,
                'username' => $config->database->username,
                'password' => $config->database->password,
                'dbname' => $config->database->dbname
            ));
        });



        $di->set('url', function() {
            $url = new Url();
            $url->setBaseUri('/simpledom/admin/');
            $url->publicurl = "http://localhost/simpledom/";
            return $url;
        });


        //$di['router']->setDefaultNamespace("Simpledom\Admin\Controllers");
    }

}
