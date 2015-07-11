<?php

return new \Phalcon\Config(array(
    'database' => array(
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'admin_ibsngdb',
        'password' => 'a#$#Yohn#Ghbj43535451HYUI#H#J',
        'dbname' => 'admin_ibsngdb',
    ),
    'application' => array(
        'controllersDir' => __DIR__ . '/../controllers/',
        'modelsDir' => __DIR__ . '/../models/',
        'viewsDir' => __DIR__ . '/../views/',
        'baseUri' => 'http://hotspot.livarfars.ir//admin/',
        "hello" => "test",
        "bang" => "he"
    )
        ));
