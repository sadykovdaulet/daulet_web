<?php
unset($_SESSION['login']);
unset($_SESSION['message']);

header('Location: ../index.php');
