<?php
// Создания маршрутизатора
$router = new \Phalcon\Mvc\Router();

//Его определение
$router->add(
    "/admin/users/my-profile",
    array(
        "controller" => "index",
        "action"     => "profile",
    )
);
$router->handle();
