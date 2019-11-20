<?php
$connect = mysqli_connect('localhost','root','','lessprojectbase');
if (!isset($_COOKIE['user_id'])){

  if(isset($_POST['submit'])){
    $user_username = mysqli_real_escape_string($connect,trim($_POST['username']));
    $user_password = mysqli_real_escape_string($connect,trim($_POST['password']));
    if(!empty($user_username) && !empty($user_password)){
      $query = "SELECT id, login, figure FROM users WHERE login = '$user_username' AND password = SHA('$user_password')";
      $data = mysqli_query($connect,$query);
      if(mysqli_num_rows($data) == 1){
        $row = mysqli_fetch_assoc($data);
        setcookie('user_id',$row['id'], time() + (60 * 60 * 24 * 30));
        setcookie('username',$row['login'], time() + (60 * 60 * 24 * 30));
        setcookie('user_figure',$row['figure'], time() + (60 * 60 * 24 * 30));
        $home_url = 'http://'.$_SERVER['HTTP_HOST'];
        header('Location: '.$home_url);
      }
      else{
        echo "Логин или пароль введены неправильно. Попробуйте снова.";
      }
    }
  }
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
    <?php if(empty($_COOKIE['user_id'])){ ?>
      <form class="CenterBlock" id="form_aut_reg" method="POST" action="/">
        <label for="username">Введите логин:</label>
        <input type="text" name="username" value="">
        <label for="password">Введите пароль:</label>
        <input type="password" name="password" value="">
        <button id="submit" type="submit" name="submit">Войти</button>
        <a href="signup.php">
        <button id="button2" type="button" >Зарегистрироваться</button></a>
        <a href="exit.php">
        <button id="button2" type="button" >Выйти</button></a>
    </form>
  <?php } else { ?>
    <div class="CenterBlock">
      <?php $user_figure = $_COOKIE['user_figure']; ?>
      <div class="UserFigure">
        <?php echo $user_figure; ?>
      </div>
      <a href="exit.php">
      <button id="button2" type="button" >Выйти</button></a>
    </div>

<?php
  }
  ?>
    </body>
</html>                                                                                                                                                                                                                                                                                                                     
