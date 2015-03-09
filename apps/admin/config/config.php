<?php

return new \Phalcon\Config(array(
    'database' => array(
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'mob',
        'password' => '9Uo1zx*69Uo1zx*69Uo1zx*6',
        'dbname' => 'ataalla_mob',
    ),
    'application' => array(
        'controllersDir' => __DIR__ . '/../controllers/',
        'modelsDir' => __DIR__ . '/../models/',
        'viewsDir' => __DIR__ . '/../views/',
        'baseUri' => 'http://www.bargsoft.ir/admin/',
        "hello" => "test",
        "bang" => "he"
    )
        ));
