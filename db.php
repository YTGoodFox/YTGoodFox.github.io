<?php // подключение к базе данных для регистрации, авторизации через RedBeanPHP
session_start();
require "libs/rb.php"; // Подключения библиотек RedBeanPHP
R::setup( 'mysql:host=KKOLLEGE;dbname=kusers','root', 'root' ); // Домен, имя базы данных, логин, пароль от таблицы MySQL в PhpMyAdmin

// Подключение к базе данных (для системы тестирования)
define("HOST", "KKOLLEGE"); // Домен
define("USER", "root"); // Логин для PhpMyAdmin
define("PASS", "root"); // Пароль для PhpMyAdmin
define("DB", "kusers"); // Имя базы даных MySQL

// Если нет соединения с БД, тогда выводим:
$db = @mysqli_connect(HOST, USER, PASS, DB) or die("Нет соединеня с БД");

// Если установлена другая кодировка то выводим:
mysqli_set_charset($db, 'utf8') or die('Не установлена кодировка соединения');
?>
