<?php
require_once "db.php"; // Подключение к базе данных
require_once "functions.php"; // Подключение файла с функциями

if( isset($_POST['test']) ){
  $test = (int)$_POST['test'];
  unset($_POST['test']);
  $result = get_correct_answers($test);
  if( !is_array($result) ) exit('Ошибка');

  // Данные теста
  $test_all_data = get_test_data($test);

  // 1- Массив Вопрос/ответы 2- Правильные ответы 3- Ответы пользователя
  $test_all_data_result = get_test_data_result($test_all_data, $result, $_POST);
  echo print_result($test_all_data_result);
  die;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="=ie=edge">
  <link rel="stylesheet" type="text/css" href="css/Login.css">
  <link rel="stylesheet" type="text/css" href="css/test.css"> <!-- Стили для тестов -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <title>Тесты ЧУ ККК</title>
</head>

<body>
  <?php
  // Подключаем Head файл
  require "blocks/TestHeader.php";

  // Получение списока тестов
  $tests = get_tests();

  if( isset($_GET['test']) ){
    $test_id = (int)$_GET['test'];
    $test_data = get_test_data($test_id);

    if(!$test_data = get_test_data($test_id)){
      exit('Тест не найден!');
    }

    if ( is_array($test_data) ){
      $count_questions = count($test_data);
      $pagination = pagination($count_questions, $test_data);
    }
  }

  ?>
  <!-- Вывод тестов на страницу -->
  <div class="wrap">
  <?php if( $tests ): ?>
      <h3 class="my-0 mr-md-auto font-weight-normal">Варианты тестов</h3>
      <?php foreach($tests as $test): ?>
        <p><a class="btn btn-outline-primary" href="?test=<?=$test['id']?>"><?=$test['test_name']?></a></p>
      <?php endforeach; ?>

      <!-- Если тест есть и на него нажали, тогда будем выводить -->
      <br><hr><br>
      <div class="content">
        <?php if( isset($test_data) ):  ?>
            <p>Всего вопросов: <?=$count_questions?></p>
            <?=$pagination?>
            <span class="none" id="test-id"><?=$test_id?></span>


            <!-- Получаем каждый конкретный вопрос + ответы -->
            <div class= "test-data">
              <h6 class="my-0 mr-md-auto font-weight-normal">Вывод вопросов и ответов</h6>
              <?php foreach($test_data as $id_question => $item): ?>

                  <div class="question" data-id="<?=$id_question?>" id="question-<?=$id_question?>">
                    <?php foreach($item as $id_answer => $answer): // проходимся по массиву вопрос-ответы ?>

                      <?php if( !$id_answer ): // Выводим вопрос ?>
                        <p class="q"><?=$answer?></p>
                      <?php else: // Выводим варианты ответов ?>

<p class="a">
    <input type="radio" id="answer-<?=$id_answer?>" name="question-<?=$id_question?>" value="<?=$id_answer?>">
    <label for="answer-<?=$id_answer?>"><?=$answer?></label>
</p>

                      <?php endif; // $id_answer ?>

                    <?php endforeach; //$item ?>
                  </div> <!-- .question -->

              <?php endforeach; // $test_data ?>

            </div> <!-- .test-data -->

            <div class="buttons">
              <button class="center btn btn-outline-primary" id="btn">Закончить тест</button>
            </div>

        <?php else: // isset($test_data) ?>
          <h6 class="my-0 mr-md-auto font-weight-normal">Выберите тест</h6>
        <?php endif; //isset($test_data) ?>

      </div> <!-- .content -->

    <?php else: // $tests ?>
      <h3 class="my-0 mr-md-auto font-weight-normal">Нет тестов</h3>
    <?php endif; // $tests ?>
  </div> <!-- стиль .wrap -->

<!-- Подключаем библиотеку jquery и java скрипты -->
  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script src="js/scripts.js"></script>
</body>
</html>
