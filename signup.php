<?php
$connect = mysqli_connect('localhost','root','','lessprojectbase');
if(isset($_POST['submit'])){
    $username = mysqli_real_escape_string($connect,trim($_POST['username']));
    $password = mysqli_real_escape_string($connect,trim($_POST['password']));
    $password_2 = mysqli_real_escape_string($connect,trim($_POST['password_2']));
    if(!empty($username) && !empty($password) && !empty($password_2) && ($password == $password_2)){
      $query = "SELECT * FROM users WHERE login = '$username'";
//      echo $query;
      $data = mysqli_query($connect,$query);
      if(mysqli_num_rows($data) == 0){
        $query = "INSERT INTO users (login, password) VALUES ('$username',SHA('$password'))";
        mysqli_query($connect,$query);
        echo "Вы зарегистрированы. Теперь Вы можете входить в систему, используя свои логин и пароль.";
        mysqli_close($connect);
        echo '<a href="index.php"> <button type="button" name="button">На главную</button> </a>';
//        exit();
      } else {
        echo "Пользователь с таким логином уже существует!";
      }
    }
} else {
//    echo 'No';
}
?>
<!DOCTYPE html>
<html lang="ru" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/style.css">
    <title></title>
  </head>
  <body>
    <?php if(empty($_COOKIE['username'])){ ?>
    <form class="CenterBlock" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
      <label for="username">Введите логин:</label>
      <input type="text" name="username" value="">
      <label for="password">Введите пароль:</label>
      <input type="password" name="password" value="">
      <label for="password">Введите пароль ещё раз:</label>
      <input type="password" name="password_2" value="">
      <button type="submit" name="submit">Зарегистрироваться</button>
    </form>
  <?php }
        else { ?>

  <?php         $home_url = 'http://'.$_SERVER['HTTP_HOST'];
          header('Location: '.$home_url);
     }
  ?>
  </body>
</html>                                                                                                                                                                                                                                                                                                                     
