<?php

return new \Phalcon\Config(array(
    'database' => array(
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'atamoshavereh',
        'password' => 'm2i9kQ~8m2i9kQ~8',
        'dbname' => 'ataalla_moshaverehdb',
    ),
    'application' => array(
        'controllersDir' => __DIR__ . '/../controllers/',
        'modelsDir' => __DIR__ . '/../models/',
        'viewsDir' => __DIR__ . '/../views/',
        'baseUri' => 'http://www.moshavereh.co/'
    )
        ));
