<?php
session_start();

if (!$_SESSION['login']) {
    header('Location: index.php');
}

include 'includes/db.php';

if (isset($_POST['group_name'])) {
    $query = "insert into groups(`id`,`name`) values (null, '{$_POST['group_name']}')";
    if (mysqli_query($connection, $query)) {
        unset($_POST['group_name']);

        header('Location: groups.php');
    } else {
        echo mysqli_error($connection);
    }
}

if (isset($_POST['del_group'])) {
    $query = "delete from groups where id = {$_POST['del_group']}";
    if (mysqli_query($connection, $query)) {
        unset($_POST['del_group']);

    } else {
        echo mysqli_error($connection);
    }
}

include 'includes/arrays.php';
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Группы</title>
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
            <h1>Группы</h1>

            <table class='table'>
                <thead>
                <th>№</th>
                <th>Группа</th>
                <th>Студенты</th>
                <th></th>
                </thead>
                <tbody>

                <?php
                $i = 0;
                foreach ($groups as $item) {
                    $id = $item['id'];
                    echo "
                        <tr>
                            <td>{$item['id']}</td>
                            <td>{$item['name']}</td>
                            <td> 
                                <form method='get' action='students.php'>
                                    <button type='submit' name='group_i' value='{$i}' class='btn btn-outline-primary'>
                                    Студенты</button>
                                </form>
                            </td>
                            ";
                    if ($_SESSION['login'] == 'admin') {
                        $id = $item['id'];
                        echo "
                            <td>
                             <form method='post'>
                            <button type='submit' name='del_group' value='{$id}' class='btn btn-sm btn-outline-danger'>x</button>
                             </form>
                            </td>
                            ";
                    }
                    echo "</tr>
                ";
                $i++;
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
         <form method='post' action='#'>
         <fieldset>
         <legend>Добавить группу</legend>
         <div class='form-group'>
         <input type='text' class='form-control' name='group_name' required placeholder='Название'>
</div>
<div class='form-group'>
                    <button type='submit' class='btn btn-primary'>Сохранить</button>
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
<?php
