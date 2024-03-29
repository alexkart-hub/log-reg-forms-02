<?php
if (!isset($_COOKIE['user_id'])){ #Если пользователь не авторизован, то предлагаем зарегистрироваться
  if(isset($_POST['button_sign'])){ #Если нажата кнопка "Зарегистрироваться" в форме регистрации
      # Экранируем данные для передачи в базу данных
      $username = mysqli_real_escape_string($connect,trim($_POST['username']));
      $password = mysqli_real_escape_string($connect,trim($_POST['password']));
      $password_2 = mysqli_real_escape_string($connect,trim($_POST['password_2']));
      #Переводим дату рождения в подхлдящий формат
      $user_birthday_string = (string) ''.$_POST['year_birthday'].'-'.$_POST['month_birthday'].'-'.$_POST['day_birthday'];
      $user_birthday = date_create($user_birthday_string);
      #Определяем границы дат, вне пределов которых нельзя регистрироваться
      $day_today = getdate();
      $date_1_string = (string) $day_today['year'].'-'.$day_today['mon'].'-'.$day_today['mday'];
      $date_2_string = (string) $day_today['year'].'-'.$day_today['mon'].'-'.$day_today['mday'];
      $date_1 = date_create($date_1_string);
      $date_2 = date_create($date_2_string);
      date_sub($date_1, date_interval_create_from_date_string('150 years'));
      date_sub($date_2, date_interval_create_from_date_string('5 years'));
      #Проверяем дату рождения на соответствие условиям
      if ($user_birthday < $date_1){ # Если старше 150 лет
        echo 'Too old!';
      }
      elseif($user_birthday > $date_2){ # Если младше 5 лет
        echo 'Too young!';
      }
      else{ # Если возраст соответствует, то регистрируем

      if(!empty($username) && !empty($password) && !empty($password_2) &&
      ($password == $password_2)){ # Если все поля заполнены, то регистрируем
        # Проверяем в базе данных наличие пользователя с введённым логином
        $query = "SELECT * FROM users WHERE login = '$username'";
        $data = mysqli_query($connect,$query);
        if(mysqli_num_rows($data) == 0){ # Если такого пользователя нет, то регистрируем
          $password_hash = password_hash($password, PASSWORD_DEFAULT);
          $query = "INSERT INTO users (login, password, figure, birthday) VALUES ('$username','$password_hash','0','$user_birthday_string')";
          mysqli_query($connect,$query);
          # Проверяем в базе данных наличие вновь зарегистрированного пользователя
          $query = "SELECT id, login FROM users WHERE login = '$username'";
          $data = mysqli_query($connect,$query);
          if(mysqli_num_rows($data) == 1){ # Если регистрация прошла успешно, авторизуем пользователя
            $row = mysqli_fetch_assoc($data);
            setcookie('user_id',$row['id'], time() + (60 * 60 * 24 * 30));
            setcookie('username',$row['login'], time() + (60 * 60 * 24 * 30));
          }
          header('Location: '.$home_url);
          exit;
        } else {  # if(mysqli_num_rows($data) == 0)
                  # Если в базе данных уже есть такой логин, то не регистрируем
          echo "Пользователь с таким логином уже существует!";
        }
      }
      # if(!empty($username) && !empty($password) && !empty($password_2) &&
      # ($password == $password_2))
      # Если не заполнены все поля формы регистрации, то появляется эта надпись
      echo 'Необходимо заполнить все поля и установить корректную дату рождения!';
    }
  }
} else { # if (!isset($_COOKIE['user_id']))
         # Если пользователь авторизован, то переадресовываем его на главную страницу
          require_once('config.php');
          header('Location: '.$home_url);
          echo $home_url;
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
    <?php if(empty($_COOKIE['username'])){ # Если пользователь не авторизован ?>
    <form class="CenterBlock full" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
      <label for="username">Введите логин:</label>
      <input type="text" name="username">
      <label for="password">Введите пароль:</label>
      <input type="password" name="password">
      <label for="password">Введите пароль ещё раз:</label>
      <input type="password" name="password_2">

      <label for="birthday">Введите дату рождения:</label>
      <?php $day_today = getdate();?>
      <?php SetSelectForm('day_birthday', $day_today['mday'], 31);?>
      <?php SetSelectForm('month_birthday', $day_today['mon'], 12);?>
      <?php SetSelectForm('year_birthday', $day_today['year'], $day_today['year'], 1800 );?>

      <button id="button_sign" type="submit" name="button_sign">Зарегистрироваться</button>
      <a href=<? echo $home_url;?>>
      <button id="button3" type="button" >Войти</button></a>
    </form>
  <?php }
  ?>
  </body>
</html>                                                                                                                                                                                                                                                                                                                     
