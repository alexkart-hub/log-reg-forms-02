<?php
$connect = mysqli_connect('localhost','root','','lessprojectbase');
if(isset($_POST['submit'])){
    $username = mysqli_real_escape_string($connect,trim($_POST['username']));
    $password = mysqli_real_escape_string($connect,trim($_POST['password']));
    $password_2 = mysqli_real_escape_string($connect,trim($_POST['password_2']));
    if(!empty($username) && !empty($password) && !empty($password_2) && ($password == $password_2)){
      $query = "SELECT * FROM users WHERE login = '$username'";
      $data = mysqli_query($connect,$query);
      if(mysqli_num_rows($data) == 0){
        $query = "INSERT INTO users (login, password, figure) VALUES ('$username',SHA('$password'),'0')";
        mysqli_query($connect,$query);
        echo "Вы зарегистрированы. Теперь Вы можете входить в систему, используя свои логин и пароль.";
        mysqli_close($connect);
        echo '<a href="index.php"> <button type="button" name="button">Войти</button> </a>';
       exit();
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
  <?php
  function SetSelectForm($name_elements, $day_today, $n_max, $n_min = 1){

    echo '<select class="select_date_'.$name_elements.'" form="form_aut_reg" name="'.$name_elements.'" style="width:70px; margin-left: ">';
      for($n = $n_min; $n <= $n_max; $n++){
        if($n == $day_today){
      echo '<option value='.$n.' selected>'.$n.'</option>';
     } else {
      echo '<option value='.$n.'>'.$n.'</option>';
      }}
    echo '</select>';
  }
  ?>

  <body>
    <?php if(empty($_COOKIE['username'])){ ?>
    <form class="CenterBlock" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
      <label for="username">Введите логин:</label>
      <input type="text" name="username" value="">
      <label for="password">Введите пароль:</label>
      <input type="password" name="password" value="">
      <label for="password">Введите пароль ещё раз:</label>
      <input type="password" name="password_2" value="">

      <?php $day_today = getdate();?>
      <?php SetSelectForm('day_birthday', $day_today['mday'], 31);?>
      <?php SetSelectForm('month_birthday', $day_today['mon'], 12);?>
      <?php SetSelectForm('year_birthday', $day_today['year'], $day_today['year'], 1800 );?>

      <button type="submit" name="submit">Зарегистрироваться</button>
      <a href="index.php">
      <button id="button2" type="button" >Войти</button></a>
    </form>
  <?php }
        else { ?>

  <?php         $home_url = 'http://'.$_SERVER['HTTP_HOST'];
          header('Location: '.$home_url);
     }
  ?>
  </body>
</html>                                                                                                                                                                                                                                                                                                                     
