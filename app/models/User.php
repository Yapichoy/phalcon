<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 18.08.2018
 * Time: 14:59
 */

namespace Models;
use Phalcon\Mvc\Model;
class User extends Model
{
    public $id;
    public $login;
    public $password;
    public $email;

    public function initialize(){
        $this->setSource('users');
    }

}