<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "mydb";

$link = mysqli_connect($host, $user, $pass, $db);

if (!$link) {
    die('Ошибка подключения: ' . mysqli_connect_error());
}

return $link;