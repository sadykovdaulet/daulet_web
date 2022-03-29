<?php

session_start();
include_once 'db.php';
include 'functions.php';

if (isset($_POST['ok'])) {

    if (!empty($_POST['login'])) {
        $result = mysqli_query($connection,
            "select password from users where login = '{$_POST['login']}'");
        $result = result_to_array($result);
        if ($result[0]['password'] == $_POST['password']) {
            $_SESSION['login'] = $_POST['login'];
            unset($_SESSION['message']);
            header('Location: schedule.php');

        } else {
            $_SESSION['message'] = "<div class='alert-danger'>Неправильный логин или пароль</div>";
            header('Location: index.php');
        }
    }
}

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Авторизация</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <div class="row vh-100 align-content-center" >
        <div class="col"></div>
        <div class="col">
            <form method="POST" class="form-group">
                <fieldset>
                    <legend>Авторизация</legend>
                    <?php
                    echo $_SESSION['message'];
                    ?>
                    <label>
                        <input class="form-control" type="text" placeholder="login" name="login">
                    </label>
                    <label>
                        <input class="form-control" type="password" placeholder="password" name="password">
                    </label>
                    <label>
                        <input type="submit" class="btn btn-outline-primary" value="Вход" name="ok">
                    </label>
                </fieldset>
            </form>
        </div>
        <div class="col"></div>
    </div>
</div>
</body>
</html>





