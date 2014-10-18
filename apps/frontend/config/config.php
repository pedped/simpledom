<?php

return new \Phalcon\Config(array(
    'database' => array(
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'melkyab',
        'password' => '8&4m0eIu8&4m0eIu',
        'dbname' => 'melkyab',
    ),
    'application' => array(
        'controllersDir' => __DIR__ . '/../controllers/',
        'modelsDir' => __DIR__ . '/../models/',
        'viewsDir' => __DIR__ . '/../views/',
        'baseUri' => 'http://melk.edspace.org/'
    )
        ));
