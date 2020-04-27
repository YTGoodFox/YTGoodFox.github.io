<?php
// Распечатка массива
function print_arr($arr){
  echo '<pre>'  . print_r($arr, true)  . '</pre>';
}

// Получение списка тестов
function get_tests(){
  global $db;
  $ulogin = null;
  if(isset($_SESSION['logged_user'])) {
    $ulogin = $_SESSION['logged_user'];
  }
  $query = "SELECT t.*
    FROM
      test AS t
    LEFT JOIN users AS u
      ON u.login = '$ulogin'
    WHERE
      t.enable = '1'
    AND
      t.GroupId = u.group";
  $res = mysqli_query($db, $query);
  if(!$res) return false;
  $data = array();
  while($row = mysqli_fetch_assoc($res)){
    $data[] = $row;
    }
  return $data;

}

// Получение данных теста
function get_test_data($test_id){
  if( !$test_id ) return;
  $ulogin = null;
  if(isset($_SESSION['logged_user'])) {
    $ulogin = $_SESSION['logged_user'];
  }
  global $db;
  $query = "SELECT q.question, q.parent_test, a.id, a.answer, a.parent_question, u.group
    FROM questions q
      LEFT JOIN answers a
        ON q.id = a.parent_question
      LEFT JOIN test
        ON test.id = q.parent_test
      INNER JOIN users u
        ON u.group = test.GroupId
            WHERE q.parent_test = $test_id AND test.enable = '1' AND u.login = '$ulogin'";
  $res = mysqli_query($db, $query);
  $data = null;
  while ($row = mysqli_fetch_assoc($res)) {
    if( !$row['parent_question'] ) return false;
    $data[$row['parent_question']][0]= $row['question'];
    $data[$row['parent_question']][$row['id']] = $row['answer'];
  }
  return $data;
}

// Получение id вопрос-ответы
function get_correct_answers($test){
  if( !$test ) return false;
  global $db;
  $query = "SELECT q.id AS question_id, a.id AS answer_id
      FROM questions q
      LEFT JOIN answers a
        ON q.id = a.parent_question
      LEFT JOIN test
        ON test.id = q.parent_test
          WHERE q.parent_test = $test AND a.correct_answer = '1' AND test.enable = '1'";
  $res = mysqli_query($db, $query);
  $data = null;
  while($row = mysqli_fetch_assoc($res)){
    $data[$row['question_id']] = $row['answer_id'];
  }
  return $data;
}

// Строим пагинацию
function pagination($count_questions, $test_data){
  $keys = array_keys($test_data);
  $pagination = '<div class="pagination">';
  for($i = 1; $i <= $count_questions; $i++){
    $key = array_shift($keys);
    if($i == 1){
      $pagination .= '<a class="nav-active" href="#question-' . $key . '">' .  $i  . '</a>';
    }else {
      $pagination .= '<a href="#question-' . $key . '">' .  $i  . '</a>';
    }
  }
  $pagination .= '</div>';
  return $pagination;
}

//Итоги: 1- Массив Вопрос/ответы 2- Правильные ответы 3- Ответы пользователя
function get_test_data_result($test_all_data, $result){

 // Заполняем массив $test_all_data правильными ответами и данными о неотвеченных вопросах
 foreach ($result as $q => $a){
   $test_all_data[$q]['correct_answer'] = $a;

   // Добавим в массив данные о неотвеченных вопросах
   if( !isset($_POST[$q]) ){
     $test_all_data[$q]['incorrect_answer'] = 0;
   }
 }

 // Добавим неверный ответ если таковой был
 foreach ($_POST as $q => $a) {

   // Удалим из $_POST "левые" значения вопросов
   if( !isset($test_all_data[$q]) ){
     unset($_POST[$q]);
     continue;
   }

   // Если есть "левые" значения ответов
   if( !isset($test_all_data[$q][$a]) ){
      $test_all_data[$q]['incorrect_answer'] = 0;
     continue;
   }

   // Добавляем неверный ответ
   if( $test_all_data[$q]['correct_answer'] != $a ){
     $test_all_data[$q]['incorrect_answer'] = $a;
   }
 }
 return $test_all_data;
}

// Печать результатов
function print_result($test_all_data_result){

  // Переменные результатов
  $all_count = count($test_all_data_result); // Количество вопросов
  $correct_answer_count = 0; // Количество верных ответов
  $incorrect_answer_count = 0; // Количество неверных ответов
  $percent = 0; // Процент верных ответов
  $rating = 0; // Оценка

  // Подсчёт результатов
  foreach ($test_all_data_result as $item) {
    if( isset($item['incorrect_answer']) ) $incorrect_answer_count++;
  }
  $correct_answer_count = $all_count - $incorrect_answer_count;
  $percent = round ( ($correct_answer_count / $all_count * 100), 2);
  if ( $percent >=50 && $percent <=74 ){
      $rating = 3;
    } elseif ( $percent >=75 && $percent <= 84){
        $rating = 4;
      } else ( $percent >=85 && $percent <=100){
          $rating = 5
        };

  if( $percent <50 )return 'Вы набрали менее 50%, попробуйте пройтии тест заного';

  // Вывод результатов
  $print_res = '<div class="questions">';
      $print_res .= '<div class="count-res">';
        $print_res .= "<p>Всего вопросов: <b>{$all_count}</b></p>";
        $print_res .= "<p>Из них отвечено верно: <b>{$correct_answer_count}</b></p>";
        $print_res .= "<p>Из них отвечено неверно: <b>{$incorrect_answer_count}</b></p>";
        $print_res .= "<p>% верных ответов: <b>{$percent}</b></p>";
        $print_res .= "<p>Ваша оценка: <b>{$rating}</b></p>";
      $print_res .= '</div>';

       // получаем логин
      if(isset($_SESSION['logged_user'])) {
        $ulogin = $_SESSION['logged_user'];
      }

      // Получаем название теста
      $test_name = "SELECT test_name FROM test WHERE id='$test_id'";

 // Отправляем данные в таблицу Результаты
 $res = "INSERT INTO result ('test_name', 'login', 'rating')
              VALUES ('$test_id', '$ulogin', '$rating')";
if (mysqli_query($db, $res)) {
      echo "Новая запись создана";
} else {
      echo "Ошибка: " . $sql . "<br>" . mysqli_error($db);
}
mysqli_close($db);

      // Вывод теста
      foreach ($test_all_data_result as $id_question => $item) { // Получаем вопрос + ответы
        $correct_answer = $item['correct_answer'];
        $incorrect_answer = null;
        if ( isset($item['incorrect_answer']) ) {
          $incorrect_answer = $item['incorrect_answer'];
          $class = 'question-res error';
        }else {
          $class = 'question-res ok';
        }
        $print_res .= "<div class='$class'>";
        foreach ($item as $id_answer => $answer) { // Проходимся по массиву ответов
          if( $id_answer === 0 ){

            // Вопросы
          $print_res .= "<p class='q'>$answer</p>";
        }elseif (is_numeric($id_answer) ) {

          // Ответ
          if( $id_answer == $correct_answer ){

            // Если это верный ответ
            $class = 'a ok2';
          }elseif ( $id_answer == $incorrect_answer ) {

            // Если это не верный ответ
             $class = 'a error2';
           }else {
             $class = 'a';
           }
           $print_res .= "<p class='$class'>$answer</p>";
          }
        }
        $print_res .= '</div>'; // .question-res
      }
  $print_res .= '</div>'; // .question
return $print_res;
}
 ?>
