<?php
require_once "db.php"; // Подключение к базе данных
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="=ie=edge">
  <link rel="stylesheet" type="text/css" href="css/Login.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <title>Дистанционная система образования ЧУ ККК </title>
</head>
<body>
  <?php require "blocks/IndexHeader.php"?> <!-- Подключаем Head файл-->
  <a class="btn btn-outline-primary" href="timetable.php">Рассписание</a> <!-- Кнопка рассписание -->
  <a class="btn btn-outline-primary" href="Tests.php">Тестирование</a> <!-- Кнопка тестирование -->
  <a class="btn btn-outline-primary" href="Result.php">Результаты</a> <!-- Кнопка результаты -->
</body>
</html>
