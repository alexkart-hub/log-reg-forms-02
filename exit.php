<?php
$connect = mysqli_connect('localhost','root','','lessprojectbase');
$query = "INSERT INTO users (figure) VALUES ('$user_figure')";
mysqli_query($connect,$query);
unset($_COOKIE['user_id']);
unset($_COOKIE['username']);
setcookie('user_id','',-1,'/');
setcookie('username','',-1,'/');
$home_url = 'http://'.$_SERVER['HTTP_HOST'];
header('Location: '.$home_url);
