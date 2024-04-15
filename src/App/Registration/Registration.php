<?
namespace App\Registration;
use App\UserDB\UserDB;
use App\User\User;

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
