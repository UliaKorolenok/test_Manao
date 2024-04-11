<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Тестовое задание</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="project/main.js"></script>
</head>
<?php
session_start();
if ($_SESSION['user']) {
    header('Location: project/profile.php');
} ?>

<body>
    <div class="container-fluid">

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#reg">Регистрация</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#auth">Авторизация</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="reg">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-4">
                            <h2>Регистрация</h2>
                            <form id="registrationForm">
                                <div class="form-group">
                                    <label for="login">Логин:</label>
                                    <input class="form-control" type="text" name="login" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Пароль:</label>
                                    <input class="form-control" type="password" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirmPassword">Повторите пароль:</label>
                                    <input class="form-control" type="password" name="confirmPassword" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input class="form-control" type="text" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Имя:</label>
                                    <input class="form-control" type="text" name="name" required>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <button type="submit" id="submitBtn"class="btn btn-primary">Зарегистрироваться</button>
                                    </div>
                                </div>
                            </form>
                            <noscript>
                                <p>JavaScript выключен. Пожалуйста, включите JavaScript для корректной отправки формы!</p>
                            </noscript>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="auth">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-4">
                            <h2>Авторизация</h2>
                            <form id="authorizationForm">
                                <div class="form-group">
                                    <label for="login">Логин:</label>
                                    <input class="form-control" type="text" name="login" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Пароль:</label>
                                    <input class="form-control" type="password" name="password" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <button type="submit" class="btn btn-primary">Войти</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>