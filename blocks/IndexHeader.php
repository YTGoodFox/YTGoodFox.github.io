<!-- Шапка страницы Index -->
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
  <h5 class="my-0 mr-md-auto font-weight-normal">Карагандинский коммерческий колледж</h5>
  <nav class="my-2 my-md-0 mr-md-3">
    <a class="p-2 text-dark" href="http://kcollege.kz/#&panel1-1">Основной сайт</a>
    <a class="p-2 text-dark" href="#">Контакты</a>

    <!-- Запоминание вошедшего пользователя -->
    <?php if (isset($_SESSION['logged_user']) ) : ?>
      Привет, <?php echo $_SESSION['logged_user']; ?>!
      <a class="btn btn-outline-primary" href="logout.php">Выйти</a> <!-- кнопка выйти появляется если пользователь вошёл ранее -->
    <?php else :?>
  <a class="btn btn-outline-primary" href="Login.php">Войти</a> <!-- кнопка войти появляется если пользователь ещё не вошёл в систему -->
    <?php endif; ?>
  </nav>
</div>
