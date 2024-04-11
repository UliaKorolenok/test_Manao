<?php
session_start();
if ($_SESSION['user']) {
    header('Location: profile.php');
}

require_once 'user.php';
$jsonFile = '../users.json';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $login = strip_tags(trim(urlencode($_POST['login'])));
        $password = strip_tags(trim(urlencode($_POST['password'])));

        $authorization = new Authorization($jsonFile);

        $authorization->authorizeUser($login, $password);
    } else{
        echo('dsdssd');
    }
}
