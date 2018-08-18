<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 18.08.2018
 * Time: 22:50
 */

namespace Plugins;
use Phalcon\Acl;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;

class SecurityPlagin
{
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        // Проверяем, установлена ли в сессии переменная "auth" для определения активной роли.
        $auth = $this->session->get("auth");

        if (!$auth) {
            $role = "Guests";
        } else {
            $role = "Users";
        }

        // Получаем активный контроллер/действие от диспетчера
        $controller = $dispatcher->getControllerName();
        $action     = $dispatcher->getActionName();

        // Получаем список ACL
        $acl = $this->getAcl();

        // Проверяем, имеет ли данная роль доступ к контроллеру (ресурсу)
        $allowed = $acl->isAllowed($role, $controller, $action);

        if (!$allowed) {
            // Если доступа нет, перенаправляем его на контроллер "index".
            $this->flash->error(
                "У вас нет доступа к данному модулю"
            );

            $dispatcher->forward(
                [
                    "controller" => "index",
                    "action"     => "index",
                ]
            );

            // Возвращая "false" мы приказываем диспетчеру прервать текущую операцию
            return false;
        }
    }
}