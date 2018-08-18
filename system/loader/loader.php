<?php

$loader = new Phalcon\Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
    ]
);
$loader->registerNamespaces(
    [
        "Models"        =>  BASE_PATH."/app/models",
        "Controllers"   =>  BASE_PATH."/app/controllers",
        "Views"         =>  BASE_PATH."app/views",
    ]
);
$loader->register();

