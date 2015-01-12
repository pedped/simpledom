<?php

return new \Phalcon\Config(array(
    'database' => array(
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'groupcharge',
        'password' => 'GUYHJi76rf#UYf7turt^#G&Y87r6t876rFGI__YGJbjhvy&HD%^tyv',
        'dbname' => 'groupcharge',
    ),
    'application' => array(
        'controllersDir' => __DIR__ . '/../controllers/',
        'modelsDir' => __DIR__ . '/../models/',
        'viewsDir' => __DIR__ . '/../views/',
        'baseUri' => 'http://gc.edspace.org/admin/',
        "hello" => "test",
        "bang" => "he"
    )
        ));
