<?php

use Phalcon\Mvc\Controller;
use Models\User;

class UserController extends Controller
{
    public function showAction(){
        $user = User::findFirst(1);
        $this->view->setVar('user', $user);
        $this->view->render('','show');
    }
}