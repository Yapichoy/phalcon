<?php

use Phalcon\Mvc\Controller;
use Models\User;
class SessionController extends Controller
{
    private function _registerSession($user)
    {
        $this->session->set(
            "auth",
            [
                "id"   => $user->id,
                "name" => $user->name,
            ]
        );
    }
    public function startAction()
    {
        if ($this->request->isPost()) {
            // Получаем данные от пользователя
            $email    = $this->request->getPost("email");
            $password = $this->request->getPost("password");

            // Производим поиск в базе данных
            $user = User::findFirst(
                [
                    "(email = :email: OR username = :email:) AND password = :password:",
                    "bind" => [
                        "email"    => $email,
                        "password" => sha1($password),
                    ]
                ]
            );

            if ($user !== false) {
                $this->_registerSession($user);

                $this->flash->success(
                    "Welcome " . $user->name
                );

                // Перенаправляем на контроллер 'invoices', если пользователь существует
                return $this->dispatcher->forward(
                    [
                        "controller" => "invoices",
                        "action"     => "index",
                    ]
                );
            }

            $this->flash->error(
                "Неверный email/пароль"
            );
        }

        // Снова выдаем форму авторизации
        return $this->dispatcher->forward(
            [
                "controller" => "session",
                "action"     => "index",
            ]
        );
    }
}