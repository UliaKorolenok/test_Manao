<?
namespace App\Authorization;
use App\UserDB\UserDB;

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
