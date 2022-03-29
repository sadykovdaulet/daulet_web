<?php
session_start();
include 'db.php';
include 'arrays.php';

$query = "INSERT INTO `schedule`(`id`, `day`, `lesson_id`, `class_id`, `discipline_id`, `group_id`, `tutor_id`)
 VALUES (null,'{$_POST['day']}',{$_POST['lesson_id']},{$_POST['class_id']},{$_POST['discipline_id']},{$_POST['group_id']},{$_POST['tutor_id']})";

if(mysqli_query($connection,$query)){
    $_SESSION['message'] = '<div class="alert-success">Запись успешно добавлена!</div>';
    header('Location: ../schedule.php')     ;
}else{
    echo mysqli_error($connection);
}