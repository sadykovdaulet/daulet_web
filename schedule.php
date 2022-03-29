<?php
session_start();
if (!$_SESSION['login']) {
    header('Location: index.php');
}
if (isset($_SESSION['login'])) {
    if ($_POST['logout']) {
        unset($_SESSION['login']);
        header('Location: index.php');
    }
}

include 'includes/db.php';
include 'includes/arrays.php';

function construct_query($day, $lesson_id, $class_id, $discipline_id, $group_id, $tutor_id)
{
    $from = 'schedule';
    $where = '';
    if ($day) {
        $str = "= '" . $day . "'";
        $where = 'where day ' . $str;
    }

    if ($lesson_id) {
        $str = '= ' . $lesson_id;
        $where ? $and = 'and ' : $and = 'where ';
        $where .= $and . 'lesson_id ' . $str;
    }
    if ($class_id) {
        $str = '= ' . $class_id;
        $where ? $and = 'and ' : $and = 'where ';
        $where .= $and . 'class_id ' . $str;
    }
    if ($discipline_id) {
        $str = '= ' . $discipline_id;
        $where ? $and = 'and ' : $and = 'where ';
        $where .= $and . 'discipline_id ' . $str;
    }
    if ($group_id) {
        $str = '= ' . $group_id;
        $where ? $and = 'and ' : $and = 'where ';
        $where .= $and . 'group_id ' . $str;
    }
    if ($tutor_id) {
        $str = '= ' . $tutor_id;
        $where ? $and = 'and ' : $and = 'where ';
        $where .= $and . 'tutor_id ' . $str;
    }

    return "select * from {$from} {$where}";
}

$schedule = result_to_array(
        mysqli_query($connection, construct_query(
                $_GET['day'],
                $_GET['lesson_id'],
                $_GET['class_id'],
                $_GET['discipline_id'],
                $_GET['group_id'],
                $_GET['tutor_id']
        ))
);

?>
    <!doctype html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Расписание</title>
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
                <h1>Расписание</h1>
                <? echo $_SESSION['message'];
                unset($_SESSION['message'])
                ?>

                <table class='table'>
                    <thead>
                    <th>№</th>
                    <th>Дата</th>
                    <th>Начало</th>
                    <th>Аудитория</th>
                    <th>Дисциплина</th>
                    <th>Группа</th>
                    <th>Преподаватель</th>

                    </thead>
                    <tbody>
                    <tr>
                        <form action="includes/filter.php" method="post" id="filterForm">
                            <th>Фильтр</th>
                            <td>
                                <select name="day" class="form-control">
                                    <option value=""></option>
                                    <?php
                                    $days = result_to_array(
                                        mysqli_query($connection, "select distinct day from schedule order by day")
                                    );
                                    //                            print_r($days);
                                    foreach ($days as $item) {
                                        echo "
                                <option>{$item['day']}</option>
                                ";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" name="lesson_id">
                                    <option value=""></option>
                                    <?php
                                    foreach ($lessons as $lesson) {
                                        echo "<option value=" . $lesson['id'] . ">{$lesson['beginning']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select type="" class="form-control" name="class_id">
                                    <option value=""></option>
                                    <?php
                                    foreach ($classes as $class) {
                                        echo "<option value='{$class['id']}'>{$class['place']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select type="" class="form-control" name="discipline_id">
                                    <option value=""></option>
                                    <?php
                                    foreach ($disciplines as $discipline) {
                                        echo "<option value='{$discipline['id']}'>{$discipline['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select type="" class="form-control" name="group_id">
                                    <option value=""></option>
                                    <?php
                                    foreach ($groups as $group) {
                                        echo "<option value='{$group['id']}'>{$group['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select type="" class="form-control" name="tutor_id">
                                    <option value=""></option>
                                    <?php
                                    foreach ($tutors as $tutor) {
                                        echo "<option value='{$tutor['id']}'>{$tutor['secondName']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary">▼</button>
                            </td>
                        </form>
                    </tr>

                    <?php
                    foreach ($schedule as $item) {

                        echo "
                        <tr>
                            <td>{$item['id']}</td>
                            <td>{$item['day']}</td>
                            <td>{$lessons[$item['lesson_id']-1]['beginning']}</td>
                            <td>{$classes[$item['class_id']-1]['place']}</td>
                            <td>{$disciplines[$item['discipline_id']-1]['name']}</td>
                            <td>{$groups[$item['group_id']-1]['name']}</td>
                            <td>{$tutors[$item['tutor_id']-1]['secondName']}</td>";
                        if ($_SESSION['login'] == 'admin') {
                            $id = $item['id'];
                            echo "
                            <td>
                             <form method='post' action='includes/deleteItem.php'>
                            <button type='submit' name='del' value='{$id}' class='btn btn-sm btn-outline-danger'>x</button>
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
            include 'includes/addItemForm.php';
        }
        ?>

    </div>
    </body>
    </html>

<?php

