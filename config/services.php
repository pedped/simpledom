<?php

/**
 * Services are globally registered in this file
 */
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Session\Adapter\Files as SessionAdapter;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * Registering a router
 */
$di['router'] = function () {

    $router = new Router();

    $router->setDefaultModule("frontend");
    //$router->setDefaultNamespace("Simpledom\Frontend\Controllers");


    $router->add('/', array(
        'module' => "frontend",
        'action' => "index",
        'params' => "index"
    ));


    $router->add('/admin', array(
        'module' => "admin",
        'action' => "index",
        'params' => "index"
    ));

    $router->add('/admin/', array(
        'module' => "admin",
        'action' => "index",
        'params' => "index"
    ));

    $router->add('/admin/:controller', array(
        'module' => "admin",
        'controller' => 1,
        'action' => "index"
    ));

    $router->add('/admin/:controller/:action/', array(
        'module' => "admin",
        'controller' => 1,
        'action' => 2
    ));

    $router->add('/admin/:controller/:action/:params', array(
        'module' => "admin",
        'controller' => 1,
        'action' => 2,
        'params' => 3
    ));

    // API REQUESTS
    $router->add('/', array(
        'module' => "frontend",
        'action' => "index",
        'params' => "index"
    ));


    $router->add('/api', array(
        'module' => "api",
        'action' => "index",
        'params' => "index"
    ));

    $router->add('/api/', array(
        'module' => "api",
        'action' => "index",
        'params' => "index"
    ));

    $router->add('/api/:controller', array(
        'module' => "api",
        'controller' => 1,
        'action' => "index"
    ));

    $router->add('/api/:controller/:action/', array(
        'module' => "api",
        'controller' => 1,
        'action' => 2
    ));

    $router->add('/api/:controller/:action/:params', array(
        'module' => "api",
        'controller' => 1,
        'action' => 2,
        'params' => 3
    ));


    return $router;
};

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di['url'] = function () {
    $url = new UrlResolver();
    $url->setBaseUri('/simpledom/');

    return $url;
};

/**
 * Start the session the first time some component request the session service
 */
$di['session'] = function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
};



//try {
//
//    // Create an application
//    $application = new Application($di);
//
//    // Register the installed modules
//    $application->registerModules(
//            array(
//                'frontend' => array(
//                    'className' => 'Simpledom\Frontend\Module',
//                    'path' => '../apps/frontend/Module.php',
//                ),
//                'admin' => array(
//                    'className' => 'Simpledom\Admin\Module',
//                    'path' => '../apps/admin/Module.php',
//                )
//            )
//    );
//
//
//    //Handle the request
//    echo $application->handle()->getContent();
//} catch (Exception $e) {
//   // var_dump($e->getMessage());
//}