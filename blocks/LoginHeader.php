<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
  <h5 class="my-0 mr-md-auto font-weight-normal">Карагандинский коммерческий колледж</h5>
  <nav class="my-2 my-md-0 mr-md-3">
  </nav>
  <?php if (isset($_SESSION['logged_user']) ) : ?>
    <a class="btn btn-outline-primary" href="/">Вернуться на главную</a>
  <?php else :?>
    <a class="p-2 text-dark">Вы не авторизованны!</a>
  <?php endif; ?>
</div>
