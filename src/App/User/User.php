<?php
namespace App\User;

class User
{
    public $login;
    public $password;
    public $email;
    public $name;

    public function __construct($login, $password, $email, $name)
    {
        $this->login = $login;
        $this->password = $this->encryptPassword($password);
        $this->email = $email;
        $this->name = $name;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getName()
    {
        return $this->name;
    }

    private function encryptPassword($password)
    {
        $salt = "Qd;WRdsjRT^&!jre*lS/d";
        return $salt . md5($password);
    }
}