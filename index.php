<?php
require_once('library/config.php');
if (!isset($_COOKIE['user_id'])){ # Если пользователь не авторизован, то...
  if(isset($_POST['button_sign'])){ # ...если нажата кнопка "Зарегистрироваться",
    require 'library/signup.php';   # переходим на страницу регистрации
    exit;
  } else {
    require 'library/login.php';    # ...по умолчанию переходим на страницу
    exit;                           # авторизации
  }
}
else{ # Если пользователь авторизован, то показываем ему его число и кнопки + и -
  $user_username = mysqli_real_escape_string($connect,trim($_COOKIE['username']));
  $query = "SELECT figure FROM users WHERE login = '$user_username'";
  $data = mysqli_query($connect,$query);
  $row = mysqli_fetch_assoc($data);
  $user_figure = $row['figure'];
  if(isset($_POST['button_minus'])){
    $user_figure = $user_figure - 1;
  }
  if(isset($_POST['button_plus'])){
    $user_figure = $user_figure + 1;
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
    <?php if(!empty($_COOKIE['user_id'])): ?>
    <div class="wall">
      <?php $user_figure = $_COOKIE['user_figure'];
       ?>
      <div class="UserFigure" align="center">
        <?php
        echo $user_figure;
        ?>
      </div>
      <form class="" action="/" method="post">
        <input type="hidden" name="user_figure" value=<?php echo $user_figure; ?>>
        <button class="button_minus" type="submit" name="button_minus">-</button>
        <button class="button_plus" type="submit" name="button_plus">+</button>
      </form>
      <a href="library/exit.php">
      <button id="button2" type="submit" >Выйти</button></a>
    </div>

<?php
endif;
?>
    </body>
</html>                                                                                                                                                                                                                                                                                                                     
