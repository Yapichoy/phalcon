<?php

// Определяем некоторые константы с абсолютными путями
// для использования с локальными ресурасами
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
// ...
require BASE_PATH . '/system/config/config.php';
require BASE_PATH . '/system/loader/loader.php';
require BASE_PATH . '/system/di/di.php';
require BASE_PATH . '/system/application/application.php';

