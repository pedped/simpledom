<?php

return new \Phalcon\Config(array(
    'database' => array(
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'amlakgostar',
        'password' => 'i6T5*jc8#4i6T5*jc8',
        'dbname' => 'amlakgostar',
    ),
    'application' => array(
        'controllersDir' => __DIR__ . '/../controllers/',
        'modelsDir' => __DIR__ . '/../models/',
        'viewsDir' => __DIR__ . '/../views/',
        'baseUri' => 'http://amlak.edspace.org/'
    )
        ));
