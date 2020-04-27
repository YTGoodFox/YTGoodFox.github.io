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
  <title>Регистрация в дистанционной системе образования ЧУ ККК</title>
 </head>

 <body>
     <?php
     require "blocks/RegistrationHeader.php" // Подключаем Head файл
     ?>

  <?php
   $data = $_POST ;
   if (isset($data['do_signup']))
   {
     if(trim($data['password_2']) != $data['password'])
        {
          $errors[] = 'Повторный пароль введён не верно';
        }
    if(R::count('users',"login = ?", array($data['login'])) > 0 )
        {

          $errors[] = 'Пользователь с  таким логином уже существует';
        }
    if(R::count('users',"email = ?", array($data['email'])) > 0 )
        {
          $errors[] = 'Пользователь с  таким email уже существует';
        }
    if(empty($errors))
        {
       // всё ок, продолжаем регистрацию
            $user = R::dispense('users');
            $user->login = $data['login'];
            $user->group = $data['group'];
            $user->email = $data['email'];
            $user->password = password_hash($data['password'],PASSWORD_DEFAULT);
            R::store($user);

            echo '<div class="alert alert-success" role="alert">Вы успешно зареги стрированны</div><hr>';
        } else
                {
                  echo '<div class="alert alert-danger" role="alert">'.array_shift($errors).'</div><hr>';
                }
   }
   ?>

<form class="form-signin" action="/registration.php" method="post">
  <h2>Регистрация</h2>
  <p>
    <!--Ввод Логина-->
    <input type="text" name="login" class="form-control" value="<?php echo @$data['login'];?>" placeholder="Логин" required>

    <!--Ввод Email-->
    <input type="email" name="email" value="<?php echo @$data['email'];?>" class="form-control" placeholder="Email" required>

    <!--Ввод Группы-->
    <input type="group" name="group" value="<?php echo @$data['group'];?>" class="form-control" placeholder="Группа(форма записи к примеру: БУХ-19)" required>

    <!--Ввод пароля-->
    <input type="password" name="password" value="<?php echo @$data['password'];?>" class="form-control" placeholder="Пароль" required>

    <!--Повторный ввод пароля-->
    <input type="password" name="password_2" value="<?php echo @$data['password_2'];?>" class="form-control" placeholder="Повторите пароль" required>

    <!--Ввод Кнопка зарегестрироваться-->
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="do_signup">Зарегистрироваться</button>
  </p>
</form>
