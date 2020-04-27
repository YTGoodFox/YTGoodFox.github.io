<?php require "db.php"; // подключение к базе данных для регистрации, авторизации через RedBeanPHP
unset($_SESSION['logged_user']); // Завершаем ссесию пользователя
header('Location:/'); // перебрасываем на главную страницу
?>
