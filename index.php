<?php
$connect = mysqli_connect('localhost','root','','lessprojectbase');
if (!isset($_COOKIE['user_id'])){
  if(isset($_POST['submit'])){
    $user_username = mysqli_real_escape_string($connect,trim($_POST['username']));
    $user_password = mysqli_real_escape_string($connect,trim($_POST['password']));
    if(!empty($user_username) && !empty($user_password)){
      $query = "SELECT id, login FROM users WHERE login = '$user_username' AND password = SHA('$user_password')";
//echo $query;
      $data = mysqli_query($connect,$query);
      if(mysqli_num_rows($data) == 1){
        $row = mysqli_fetch_assoc($data);
//        print_r($row);
        setcookie('user_id',$row['id'], time() + (60 * 60 * 24 * 30));
        setcookie('username',$row['login'], time() + (60 * 60 * 24 * 30));
        $home_url = 'http://'.$_SERVER['HTTP_HOST'];
        header('Location: '.$home_url);
      }
      else{
        echo "Логин или пароль введены неправильно. Попробуйте снова.";
      }
    }
  }
}
else{
//echo '  <a href="exit.php">  <button type="button" name="button">Выход</button>  </a>';

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
      <button type="submit" name="submit">Вход</button>
      <a href="signup.php">
      <button type="button" name="button">Регистрация</button>
      </a>
    </form>
  <?php }
        else { ?>
          <a href="exit.php">
          <button type="button" name="button">Выход</button>
          </a>

  <?php      }
  ?>
  </body>
</html>                                                                                                                                                                                                                                                                                                                     
