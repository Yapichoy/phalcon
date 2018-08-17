<?php

$di = new Phalcon\Di\FactoryDefault();
$di->set('view', function (){
    $view = new Phalcon\Mvc\View();
    $view->setViewsDir(APP_PATH . '/views/');
    $view->registerEngines(
        [
            '.phtml' => 'Phalcon\Mvc\View\Engine\Volt',
        ]
    );
    return $view;
});
$di->set('url',
    function (){
        $url = new Phalcon\Mvc\Url();
        $url->setBaseUri('/');
        return $url;
    });
$di->set('router',function () {
    // Создания маршрутизатора
    $router = new \Phalcon\Mvc\Router();
    $router->removeExtraSlashes(true);
    require BASE_PATH . '/web/router.php';
    return $router;
});
// Настраиваем сервис для работы с БД
$di->set(
    "db",
    function () use ($config) {
        return new Phalcone\Db\Adapter\Pdo\Mysql(
            [
                "host"     => $config->database->host,
                "username" => $config->database->username,
                "password" => $config->database->password,
                "dbname"   => $config->database->name,
            ]
        );
    }
);