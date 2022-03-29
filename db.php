    <?php
$connection = mysqli_connect(
'localhost',
'z96715cu_ilya',
'z96715cu_ilya',
'Chizhikov99'
);
//$connection = mysqli_connect(
//    'wz.log',
//    'root',
//    '',
//    'mydb'
//);

if ($connection == false) {
    echo 'Неудалось подключиться к базе данных!<br>';
    echo mysqli_connect_error();
    exit();
}
