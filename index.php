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
      <form class="CenterBlock" id="form_aut_reg" method="POST" action="/">
        <label for="username">Введите логин:</label>
        <input type="text" name="username" value="">
        <label for="password">Введите пароль:</label>
        <input type="password" name="password" value="">

        <?php $day_today = getdate();?>
        <?php SetSelectForm('day_birthday', $day_today['mday'], 31);?>
        <?php SetSelectForm('month_birthday', $day_today['mon'], 12);?>
        <?php SetSelectForm('year_birthday', $day_today['year'], $day_today['year'], 1800 );?>

        <button id="button1" type="submit" >Войти</button>
        <button id="button2" type="submit" >Зарегистрироваться</input>
    </form>
  </body>
</html>                                                                                                                                                                                                                                                                                                                     
