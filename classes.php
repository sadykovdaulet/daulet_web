<?php
session_start();

include 'includes/db.php';
include 'includes/arrays.php';

//$students = result_to_array(
//    mysqli_query($connection, "select * from students where group_id = {$groups[$_GET['group_i']]['id']}")
//);

if (isset($_POST['add_class'])) {
    $query = "INSERT INTO `classes` (`id`, `place`, `capacity`) VALUES (NULL, '{$_POST['class_place']}', {$_POST['class_capacity']});";
    if (mysqli_query($connection, $query)) {
        unset($_POST);

        header("Location: classes.php");
    } else {
        echo mysqli_error($connection);
    }
}

if (isset($_POST['del_class'])) {
    $query = "delete from `classes` where id = {$_POST['del_class']}";
    if (mysqli_query($connection, $query)) {
        unset($_POST);

        header("Location: classes.php");
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
    <title>Аудитории</title>
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
            <h1>Аудитории</h1>

            <table class='table'>
                <thead>
                <th>Аудитория</th>
                <th>Вместимость</th>
                <th></th>
                </thead>
                <tbody>

                <?php
                foreach ($classes as $item) {
                    $id = $item['id'];
                    echo "
                        <tr>
                           
                            <td>{$item['place']}</td>
                            <td>{$item['capacity']}</td>
                         
                            ";
                    if ($_SESSION['login'] == 'admin') {
                        $id = $item['id'];
                        echo "
                            <td>
                             <form method='post'>
                            <button type='submit' name='del_class' value='{$id}' class='btn btn-sm btn-outline-danger'>x</button>
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
         <form method='post' class=''>
         <fieldset>
            <legend>Добавить аудиторию</legend>
            
             <div class='form-group'>           
             <input type='text' class='form-control' name='class_place' required placeholder='Аудитория'>
             </div>
             
               <div class='form-group'>
             <input type='number' class='form-control' name='class_capacity' required placeholder='Вместимость'>
             </div>
            
             <div class='form-group'>
                 <button type='submit' class='btn btn-primary' name='add_class'>Сохранить</button>
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
