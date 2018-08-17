<?php
$di->set('router',function (){
// Создания маршрутизатора
    $router = new \Phalcon\Mvc\Router();
    $router->removeExtraSlashes(true);
//Его определение
    $router->add("/","Index::index");
    $router->add("/admin/users/my-profile", "Index::profile");
    return $router;
});

