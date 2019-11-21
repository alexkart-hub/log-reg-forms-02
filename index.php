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
else{
  $user_figure = $_COOKIE['user_figure'];
  if(isset($_POST['button_minus'])){
    $user_figure = $_POST['user_figure'] - 1;
  }
if(isset($_POST['button_plus'])){
  $user_figure = $_POST['user_figure'] + 1;
}
$id = $_COOKIE['user_id'];
$query = "UPDATE users SET figure = $user_figure WHERE id = $id";
mysqli_query($connect,$query);

$_COOKIE['user_figure'] = $user_figure;
}
?>
<!DOCTYPE html>
<html lang="ru" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/style.css?.<?php echo time(); ?>">
    <title></title>
  </head>

  <body>
    <?php if(empty($_COOKIE['user_id'])){ ?>
      <form class="CenterBlock full" id="form_aut_reg" method="POST" action="/">
        <label for="username">Введите логин:</label>
        <input type="text" name="username">
        <label for="password">Введите пароль:</label>
        <input type="password" name="password">
        <button id="submit" type="submit" name="submit">Войти</button>
        <a href="signup.php">
        <button id="button1" type="button" >Зарегистрироваться</button></a>
    </form>
  <?php } else { ?>
    <div class="cls">
      <?php $user_figure = $_COOKIE['user_figure'];
       ?>
      <div class="UserFigure" align="center">
        <?php echo $user_figure; ?>
      </div>
      <form class="" action="/" method="post">
        <input type="hidden" name="user_figure" value=<?php echo $user_figure; ?>>
        <button class="button_minus" type="submit" name="button_minus">-</button>
        <button class="button_plus" type="submit" name="button_plus">+</button>
      </form>
      <a href="exit.php">
      <button id="button2" type="button" >Выйти</button></a>
    </div>

<?php
  }
?>
    </body>
</html>                                                                                                                                                                                                                                                                                                                     
