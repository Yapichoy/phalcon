<?php

$loader = new Phalcon\Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
        APP_PATH . '/plugins/',
    ]
);
$loader->registerNamespaces(
    [
        "Models"        =>  BASE_PATH."/app/models",
        "Controllers"   =>  BASE_PATH."/app/controllers",
        "Views"         =>  BASE_PATH."/app/views",
        "Plugins"       =>  APP_PATH."/plugins",
    ]
);
$loader->register();

