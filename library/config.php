<?php
require_once('functions.php');
//Настройки соединения с БД
$hostname_connect = "localhost";
$database_connect = "lessprojectbase";
$username_connect = "root";
$password_connect = "";
//Соединение с базой данных
$connect = mysqli_connect($hostname_connect, $username_connect, $password_connect, $database_connect) or trigger_error(mysqli_error(),E_USER_ERROR);

$home_url = 'http://'.$_SERVER['HTTP_HOST'];
