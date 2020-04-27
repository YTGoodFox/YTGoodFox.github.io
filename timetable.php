<?php
require "db.php"; // Подключение к базе данных
 ?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="=ie=edge">
  <link rel="stylesheet" type="text/css" href="css/Login.css">
  <link rel="stylesheet" type="text/css" href="css/button.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <title>Рассписание пар для студентов ЧУ ККК</title>
</head>

<body>
  <form method="post" enctype="multipart/form-data">
  <p>  <label for="uploadbtn" class="button15">Загрузить файл</label> <!-- Кнопка загрузить файл -->
    <input style="opacity: 0; z-index: -1;" type="file" name="picture" id="uploadbtn">
    <button type="submit" class="button15">Отправить</button> </p> <!-- Кнопка отправить -->

        <?php
        // Папка в которой будет лежать картинка
        $path = 'uploads/';

        // Массив допустимых значений типа файла
        $types = array('image/gif', 'image/png', 'image/jpeg');

        // Максимальный размер файла
        $size = 8192000;

        // Обработка запроса
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
         // Проверяем тип файла
         if (!in_array($_FILES['picture']['type'], $types))
         die('<div class="alert alert-danger" role="alert">Запрещённый тип файла. <a href="?">Попробовать другой файл?</a></div><hr>');

         // Проверяем размер файла
         if ($_FILES['picture']['size'] > $size)
         die('<div class="alert alert-danger" role="alert">Слишком большой размер файла. <a href="?">Попробовать другой файл?</a></div><hr>');

         // Загрузка файла и вывод сообщения
          if (!@copy($_FILES['picture']['tmp_name'], $path . $_FILES['picture']['name']))
          echo '<div class="alert alert-danger" role="alert">Что-то пошло не так</div><hr>';
          else
          echo '<div class="alert alert-success" role="alert">Изображение загружено</div><hr>';
        }
          ?>
<p>
    <img src="uploads/image.png"> <!-- Загрузка картинки, надо поработать над её отображением ии выводом -->
</p>
  </form>
</body>
</html>
