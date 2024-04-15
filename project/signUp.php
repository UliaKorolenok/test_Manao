<?php
session_start();
if ($_SESSION['user']) {
    header('Location: /project/profile.php');
}

require_once  '../vendor/autoload.php';

use App\Registration\Registration;

$jsonFile = '../users.json';

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $login = strip_tags(trim(htmlspecialchars($_POST['login'])));
        $password = strip_tags(trim(htmlspecialchars($_POST['password'])));
        $confirmPassword = strip_tags(trim(htmlspecialchars($_POST['confirmPassword'])));
        $email = strip_tags(trim(htmlspecialchars($_POST['email'])));
        $name = strip_tags(trim(htmlspecialchars($_POST['name'])));
        $registration = new Registration($jsonFile);
        $registration->registerUser($login, $password, $confirmPassword, $email, $name);
    }
}
