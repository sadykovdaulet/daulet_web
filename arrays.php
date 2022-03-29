<?php
include 'functions.php';

$groups = result_to_array(
mysqli_query($connection, 'select * from groups')
);

$classes = result_to_array(
mysqli_query($connection, 'select * from classes')
);

$tutors = result_to_array(
mysqli_query($connection, 'select * from tutors')
);

$schedule = result_to_array(
mysqli_query($connection, 'select * from schedule')
);

$lessons = result_to_array(
mysqli_query($connection, 'select * from lessons')
);

$disciplines = result_to_array(
mysqli_query($connection, 'select * from disciplines')
);

$students = result_to_array(
    mysqli_query($connection, 'select * from students')
);

