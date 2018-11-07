
// Quiz scripts
$(document).ready(function () {
  if (window.location.pathname.indexOf('/quiz/') >= 0) {
    $('form#doQuiz').submit(function (e) {
      e.preventDefault();
      $form = $( this );
      $.ajax({
        url: $form.attr('action'),
        method: $form.attr('method'),
        data: $form.serialize(),
        beforeSend: function () {
          $('#doQuiz').hide('fast');
          $('.loading').show('fast');
        }
      }).done(function (data) {
        window.location.href = data.url
      }).fail(function (data) {
        alert(data.responseJSON.message);
        window.location.reload();
      });
    });
  }
});
