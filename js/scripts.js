$(function() {

  $('.test-data' ).find('div:first').show();

  $('.pagination a').on('click', function(){
      if( $(this).attr('class') == 'nav-active' ) return false;

      // ссыла на текст вкладки для показа
      var link = $(this).attr('href');

      // ссылка на  текст пока что активной вкладки
      var prevActive = $('.pagination > a.nav-active').attr('href');

      // удаляем класс активной ссылки
      $('.pagination > a.nav-active').removeClass('nav-active');

      // Добавляем класс активной вкладки
      $(this).addClass('nav-active');

      // Скрываем-показываем вопросы
      $(prevActive).fadeOut(100, function(){
        $(link).fadeIn(100);
      });

    return false;
  });

  $('#btn').click(function(){
    var test = +$('#test-id').text();
    var res = {'test':test};

    $('.question').each(function(){
      var id = $(this).data('id');
      res[id] = $('input[name=question-' + id + ']:checked').val();
    });

    $.ajax({
      url: 'Tests.php',
      type: 'POST',
      data: res,
      success: function(html){
        $('.content').html(html);
      },
      error: function(){
        alert('Ошбка!');
      }
    });
  });

});
