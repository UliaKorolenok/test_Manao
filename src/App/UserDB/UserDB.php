<?
namespace App\UserDB;

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