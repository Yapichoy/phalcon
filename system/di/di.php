<?php

$di = new Phalcon\Di\FactoryDefault();
$di->set('view', function (){
    $view = new Phalcon\Mvc\View();
    $view->setViewsDir(APP_PATH . '/views/');
    $view->registerEngines(
        [
            '.twig' => 'Phalcon\Mvc\View\Engine\Volt',
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
        return new Phalcon\Db\Adapter\Pdo\Mysql(
            [
                "host"     => $config->database->host,
                "username" => $config->database->username,
                "password" => $config->database->password,
                "dbname"   => $config->database->name,
            ]
        );
    }
);
$di->set(
    "session",
    function () {
        $session = new Phalcon\Session\Adapter\Files();

        $session->start();

        return $session;
    }
);
$di->set(
    "request",
    "Phalcon\\Http\\Request"
);


// Устанавливаем сервис
$di->set(
    "flash",
    function () {
        return new Phalcon\Flash\Direct ();
    }
);

// Set up the flash session service
$di->set(
    "flashSession",
    function () {
        return new Phalcon\Flash\Session();
    }
);


$di->set(
    "dispatcher",
    function () {
        $eventsManager = new Phalcon\Events\Manager();

        // Плагин безопасности слушает события, инициированные диспетчером
        $eventsManager->attach(
            "dispatch:beforeExecuteRoute",
            new SecurityPlugin()
        );

        // Отлавливаем исключения и not-found исключения, используя NotFoundPlugin
        $eventsManager->attach(
            "dispatch:beforeException",
            new NotFoundPlugin()
        );

        $dispatcher = new Dispatcher();

        // Связываем менеджер событий с диспетчером
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);