<?php
require_once 'config.php';
unset($_COOKIE['user_id']);
unset($_COOKIE['username']);
unset($_COOKIE['user_figure']);
setcookie('user_id','',-1,'/');
setcookie('username','',-1,'/');
setcookie('user_figure','',-1,'/');
//$home_url = 'http://'.$_SERVER['HTTP_HOST'];
header('Location: '.$home_url);
