<?php
session_start();

include 'includes/db.php';
include 'includes/arrays.php';

$student = [];
foreach ($students as $item) {
    if ($item['id'] == $_GET['student_id']) {
        $student = $item;
        break;
    }
}

$results = result_to_array(
    mysqli_query($connection, "select * from progress where student_id = {$student['id']}")
);

function define_discipline($array, $id)
{
    foreach ($array as $item) {
        if ($item['id'] == $id) {
            return $item['name'];
        }
    }
}

if (isset($_POST['add_result'])) {
    $query = "INSERT INTO `progress` (`id`, `student_id`, `discipline_id`, `rating`)
 VALUES (NULL, {$student['id']}, {$_POST['discipline_id']}, {$_POST['rating']});";
    if (mysqli_query($connection, $query)) {
        unset($_POST);

        header("Location: progress.php?student_id={$student['id']}");
    } else {
        echo mysqli_error($connection);
    }
}

if (isset($_POST['del_result'])) {
    $query = "delete from `progress` where id = {$_POST['del_result']} ;";
    if (mysqli_query($connection, $query)) {
        unset($_POST);

        header("Location: progress.php?student_id={$student['id']}");
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
    <title><?php
        echo "{$student['firstName']} {$student['secondName']}"
        ?></title>
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
            <h1><?php
                echo "{$student['firstName']} {$student['secondName']}"
                ?></h1>
            <table class='table'>
                <thead>
                <th>Дисциплина</th>
                <th>Результат</th>
                <th></th>
                </thead>
                <tbody>

                <?php

                foreach ($results as $item) {
                    $id = $item['id'];
                    $discipline_name = define_discipline($disciplines, $item['discipline_id']);
                    echo "
                        <tr>
                            <td>{$discipline_name}</td>
                            <td>{$item['rating']}</td>
  
                            ";
                    if ($_SESSION['login'] == 'admin') {
                        $id = $item['id'];
                        echo "
                            <td>
                             <form method='post'>
                            <button type='submit' name='del_result' value='{$id}' class='btn btn-sm btn-outline-danger'>x</button>
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
         <form method='post' action='#' class='form-inline'>
         <fieldset>
         <legend>Добавить результат</legend>
         
            <select class='form-control' name='discipline_id'>";

        foreach ($disciplines as $discipline) {
            echo "<option value='{$discipline['id']}'>{$discipline['name']}</option>";
        };

        echo " </select>
        
       <input type='number' class='form-control' name='rating' required placeholder='Результат'>


                    <button type='submit' class='btn btn-primary' name='add_result'>Сохранить</button>
                
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
