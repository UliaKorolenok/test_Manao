<?php

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

class UserDB
{
    private $jsonFile;
    private $users;

    public function __construct($jsonFile)
    {
        $this->jsonFile = $jsonFile;
        $this->loadUsers();
    }

    public function loadUsers()
    {
        if (file_exists($this->jsonFile)) {
            return $this->users = json_decode(file_get_contents($this->jsonFile), true);
        } else {
            return $this->users = [];
        }
    }

    private function saveUsers()
    {
        file_put_contents($this->jsonFile, json_encode($this->users));
    }

    public function createUser($user)
    {
        $login = $user->getLogin();
        if (!isset($this->users[$login])) {
            $this->users[$login] = [
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'name' => $user->getName()
            ];
            $this->saveUsers();
            return true;
        }
        return false;
    }


    public function getUser($login)
    {
        if (isset($this->users[$login])) {
            return $this->users[$login];
        }
        return null;
    }


    public function updateUser($login, $email, $password, $name)
    {
        if (isset($this->users[$login])) {
            $this->users[$login] = [
                'email' => $email,
                'password' => $password,
                'role' => $name
            ];
            $this->saveUsers();
            return true;
        }
        return false;
    }

    public function deleteUser($login)
    {
        if (isset($this->users[$login])) {
            unset($this->users[$login]);
            $this->saveUsers();
            return true;
        }
        return false;
    }
}

class Registration
{

    private $db;
    public function __construct($jsonFile)
    {
        $this->db = new UserDB($jsonFile);
    }

    public function registerUser($login, $password, $confirmPassword, $email, $name)
    {
        $errors = $this->validateRegistration($login, $password, $confirmPassword, $email, $name);

        if (!empty($this->db->getUser($login))) {
            $errors["login"] = "Пользователь с данным логином уже существует!";
        }

        if (!empty($this->db->loadUsers())) {
            foreach ($this->db->loadUsers() as $user) {
                if ($user['email'] === $email) {
                    $errors["email"] = "Пользователь с данным email уже существует!";
                }
            }
        }

        if (empty($errors)) {
            $response['success'] = true;
            $newUser = new User($login, $password, $email, $name);
            $this->db->createUser($newUser);
        } else {
            $response['success'] = false;
            $response['errors'] = $errors;
        }



        echo json_encode($response);
    }


    private function validateRegistration($login, $password, $confirmPassword, $email, $name)
    {
        $errors = array();
        if (mb_strlen($login) < 6) {
            $errors["login"] = "Логин должен содержать минимум 6 символов!";
        }
        if (preg_match('/\s/', $login)) {
            $errors["login"] = "Логин не должен содержать пробелов!";
        }
        if (mb_strlen($password) < 6) {
            $errors["password"] = "Пароль должен содержать минимум 6 символов!";
        } else {
            if (!preg_match('/^[a-zA-Z0-9]+$/', $password)) {
                $errors["password"] = "Пароль должен состоять из латинских букв и цифр!";
            }
            if (!preg_match('/\d/', $password)) {
                $errors["password"] = "Пароль должен содержать цифры!";
            }
            if (preg_match('/^[a-zA-Z]+$/', $password)) {
                $errors["password"] = "Пароль должен содержать буквы!";
            }
        }
        if (strcmp($password, $confirmPassword) != 0) {
            $errors["confirmPassword"] = "Пароли не совпадают!";
        }
        if (mb_strlen($name) < 2) {
            $errors["name"] = "Имя должно содержать минимум 2 символа!";
        }

        if (mb_strlen($name) > 20) {
            $errors["name"] = "Количество символов не должно превышать 20!";
        }
        if (!preg_match('/^[a-zA-Z]+$/u', $name)) {
            $errors["name"] = "Имя должно содержать только буквы!";
        }
        if (!preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $email)) {
            $errors["email"] = "Email введён неверно!";
        }
        return $errors;
    }
}


class Authorization
{

    private $db;
    public function __construct($jsonFile)
    {
        $this->db = new UserDB($jsonFile);
    }

    public function authorizeUser($login, $password)
    {
        $salt = "Qd;WRdsjRT^&!jre*lS/d";
        $user = $this->db->getUser($login);

        if (empty($this->db->getUser($login))) {
            $errors["login"] = "Пользователя с данным логином не существует!";
        } else {
            if ($user['password'] != $salt . md5($password)) {
                $errors["password"] = "Введен неверный пароль!";
            }
        }

        if (empty($errors)) {
            $response['success'] = true;

            $this->setSession($user, $login);
        } else {
            $response['success'] = false;
            $response['errors'] = $errors;
        }

        echo json_encode($response);
    }
    private function setSession($user, $login)
    {
        session_start();
        $_SESSION['user'] = [
            'login' => $login,
            'email' => $user['email'],
            'name' => $user['name']
        ];
    }
}
