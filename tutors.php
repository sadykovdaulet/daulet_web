<?php
session_start();
include 'includes/db.php';
include 'includes/arrays.php';


if (isset($_POST['add_tutor'])) {
    $query = "INSERT INTO `tutors` (`id`, `firstName`, `secondName`, `phone`, `email`)
 VALUES (NULL, '{$_POST['firstName']}', '{$_POST['secondName']}', '{$_POST['phone']}', '{$_POST['email']}');";
    if (mysqli_query($connection, $query)) {
        unset($_POST);

        header("Location: tutors.php");
    } else {
        echo mysqli_error($connection);
    }
}

if (isset($_POST['del_tutor'])) {
    $query = "delete from `tutors` where id = {$_POST['del_tutor']}";
    if (mysqli_query($connection, $query)) {
        unset($_POST);

        header("Location: tutors.php");
    } else {
        echo mysqli_error($connection);
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
    <title>Преподаватели</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
          crossorigin="anonymous">
</head>
<body>
<div class="container">
    <?php
    include 'includes/nav.php';
    ?>

    <div class="row">
        <div class="col">
            <h1>Преподаватели</h1>
            <table class='table'>
                <thead>
                <th>№</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Телефон</th>
                <th>Email</th>
                <th></th>
                <th></th>
                </thead>
                <tbody>

                <?php
                foreach ($tutors as $item) {
                    $id = $item['id'];
                    echo "
                        <tr>
                            <td>{$item['id']}</td>
                            <td>{$item['secondName']}</td>
                            <td>{$item['firstName']}</td>
                            <td>{$item['phone']}</td>
                            <td>{$item['email']}</td>
       
                            ";
                    if ($_SESSION['login'] == 'admin') {
                        $id = $item['id'];
                        echo "
                            <td>
                             <form method='post'>
                            <button type='submit' name='del_tutor' value='{$id}' class='btn btn-sm btn-outline-danger'>x</button>
                             </form>
                            </td>
                            ";
                    }
                    echo "</tr>
                ";

                }

                ?>
                </tbody>
            </table>


        </div>
    </div>
    <?php
    if ($_SESSION['login'] == 'admin') {
        echo "
         <div class='row'>
         <div class='col col-10 col-sm-6'>
         <form method='post'>
         <fieldset>
            <legend>Добавить преподавателя</legend>
            
             <div class='form-group'>           
             <input type='text' class='form-control' name='secondName' required placeholder='Фамилия'>
             </div>
             
               <div class='form-group'>
             <input type='text' class='form-control' name='firstName' required placeholder='Имя'>
             </div>
             
               <div class='form-group'>
             <input type='tel' class='form-control' name='phone' required placeholder='Телефон'>
             </div>
             
               <div class='form-group'>
             <input type='email' class='form-control' name='email' required placeholder='Email'>
             </div>
             
             <div class='form-group'>
                 <button type='submit' class='btn btn-primary' name='add_tutor'>Сохранить</button>
             </div>
             
         </fieldset>
         </form>
         </div>
         </div>
         ";
    }
    ?>

</div>
</body>
</html>

