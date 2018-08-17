<?php
use Phalcon\Config\Adapter\Ini as ConfigIni;
use Phalcon\Loader;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcone\Db\Adapter\Pdo\Mysql as DbAdapter;
// Определяем некоторые константы с абсолютными путями
// для использования с локальными ресурасами
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
// ...
$config = new ConfigIni(
    APP_PATH . "/config/config.ini"
);
$loader = new Loader();
require BASE_PATH . '/web/router.php';
$di = new FactoryDefault();
$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
    ]
);
$loader->register();
// Register Volt as a service
/*$di->set(
    'voltService',
    function ($view, $di) {
        $volt = new Volt($view, $di);
        $volt->setOptions(
            [
                'compiledPath'      => '../app/compiled-templates/',
                'compiledExtension' => '.compiled',
            ]
        );
        return $volt;
    }
);*/

$di->set('view', function (){
   $view = new View();
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
       $url = new UrlProvider();
        $url->setBaseUri('/');
        return $url;
    });

// Настраиваем сервис для работы с БД
$di->set(
    "db",
    function () {
        return new DbAdapter(
            [
                "host"     => "localhost",
                "username" => "root",
                "password" => "secret",
                "dbname"   => "test_db",
            ]
        );
    }
);
$application = new Application($di);

try {
    // Handle the request
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}