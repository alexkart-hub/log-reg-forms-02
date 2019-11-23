<?php
require_once('config.php');
if (isset($_COOKIE['user_id'])){ # Если пользователь авторизован,
  header('Location: '.$home_url); # то переадресуем его на главную страницу
  exit;
}
if(isset($_POST['button_to_sign'])){
  require 'library/signup.php';
  exit;
}

if(isset($_POST['button_in'])){
    $user_username = mysqli_real_escape_string($connect,trim($_POST['username']));
    $user_password = $_POST['password'];
    if(!empty($user_username) && !empty($user_password)){
      $query = "SELECT id, login, password, figure FROM users WHERE login = '$user_username'";
      $data = mysqli_query($connect,$query);
      if(mysqli_num_rows($data) == 1){
        $row = mysqli_fetch_assoc($data);
        if(password_verify ( $user_password , $row['password'] )){
        setcookie('user_id',$row['id'], time() + (60 * 60 * 24 * 30));
        setcookie('username',$row['login'], time() + (60 * 60 * 24 * 30));
        header('Location: '.$home_url);
      }
      else{
        echo "Пароль введен неправильно. Попробуйте снова.";
      }
    }
      else{
        echo "Пользователь с таким логином не найден.";
    }

  }
}
  ?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="/css/style.css">
      <title></title>
    </head>
    <body>
      <form class="CenterBlock full" id="form_aut_reg" method="POST" action="/">
        <label for="username">Введите логин:</label>
        <input type="text" name="username">
        <label for="password">Введите пароль:</label>
        <input type="password" name="password">
        <button type="submit" name="button_in">Войти</button>
        <button type="submit" name="button_to_sign">Зарегистрироваться</button>
    </form>
    </body>
  </html>
