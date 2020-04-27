<?php
require "db.php"; // подключение к базе данных для регистрации, авторизации через RedBeanPHP
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="=ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/Login.css">
  <title>Авторизация в дистанционной системе образования ЧУ ККК</title>
 </head>

 <body>
<?php
require "blocks/LoginHeader.php" // Подключаем Head файл
?>

<?php
     $data = $_POST;
     if(isset($data['do_login']))
     {
       $errors = array();
       $user = R::findOne('users','login = ?', array($data['login']));
       if($user)
          {

              // логин существует
              if(password_verify($data['password'], $user->password))
                  {
                    // Всё хорошо, логиним пользователя
                    $_SESSION['logged_user'] = $user;
                    $_SESSION['logged_user'] = $_POST['login'];
                    echo '<meta http-equiv="refresh" content="1; URL=index.php" />';
                  } else {
                            {
                              $errors[] = 'Не правильно введён пароль!';
                            }
                         }
          } else {
                    $errors[] = 'Пользователь с таким логином не найден!';
                 }
                if( ! empty($errors))
                  {
                    echo '<div class="alert alert-danger" role="alert">'.array_shift($errors).'</div><hr>';
                  }
    }
?>

<form class="form-signin" action="login.php" method="POST">
<h2>Авторизация</h2>
  <p>
      <!--Ввод Логина-->
      <input type="text" name="login" class="form-control" value="<?php echo @$data['login'];?>" placeholder="Логин" required>

      <!--Ввод Пароля-->
      <input type="password" name="password" class="form-control" value="<?php echo @$data['password'];?>" placeholder="Пароль" required>

      <!--Ввод Кнопка войти-->
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="do_login">Войти</button>
    </p>
</body>
</html>
