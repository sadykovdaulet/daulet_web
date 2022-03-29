<?php
session_start();

include 'includes/db.php';
include 'includes/arrays.php';

$students = result_to_array(
    mysqli_query($connection, "select * from students where group_id = {$groups[$_GET['group_i']]['id']}")
);

if (isset($_POST['add_student'])) {
    $query = "INSERT INTO `students` (`id`, `group_id`, `firstName`, `secondName`, `phone`, `email`)
 VALUES (NULL, {$groups[$_GET['group_i']]['id']}, '{$_POST['firstName']}', '{$_POST['secondName']}', '{$_POST['phone']}', '{$_POST['email']}');";
    if (mysqli_query($connection, $query)) {
        unset($_POST);

        header("Location: students.php?group_i={$_GET['group_i']}");
    } else {
        echo mysqli_error($connection);
    }
}

if (isset($_POST['del_student'])) {
    $query = "delete from `students` where id = {$_POST['del_student']}";
    if (mysqli_query($connection, $query)) {
        unset($_POST);

        header("Location: students.php?group_i={$_GET['group_i']}");
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
    <title>Студенты <?php echo $groups[$_GET['group_i']]['name']?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
          crossorigin="anonymous">
</head>
<body>
<div class="container">
    <?php
    include "includes/nav.php";
    ?>
    <div class="row">
        <div class="col">
            <h1>Студенты <?php echo $groups[$_GET['group_i']]['name']?></h1>

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
                foreach ($students as $item) {
                    $id = $item['id'];
                    echo "
                        <tr>
                            <td>{$item['id']}</td>
                            <td>{$item['secondName']}</td>
                            <td>{$item['firstName']}</td>
                            <td>{$item['phone']}</td>
                            <td>{$item['email']}</td>
                            
                            <td> 
                               <form method='get' action='progress.php'>
                                    <button type='submit' name='student_id' value='{$id}' class='btn btn-outline-primary'>
                                   Прогресс</button>
                                </form> 
                              <!--   <a href='progress.php' class='btn btn-outline-primary'>Прогресс</a>-->
                            </td>
                            ";
                    if ($_SESSION['login'] == 'admin') {
                        $id = $item['id'];
                        echo "
                            <td>
                             <form method='post'>
                            <button type='submit' name='del_student' value='{$id}' class='btn btn-sm btn-outline-danger'>x</button>
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
            <legend>Добавить студента в группу</legend>
            
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
                 <button type='submit' class='btn btn-primary' name='add_student'>Сохранить</button>
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
