
// Quiz scripts
$(document).ready(function () {
  if (window.location.pathname.indexOf('/quizzes') >= 0) {
    // Check image width and height
    $('form #coverImage').change(function () {
      var self = this;
      var fr = new FileReader;

      fr.onload = function() {
        var img = new Image;

        img.onload = function() {
          if (! (img.width === 1200 && img.height === 630) ) {
            self.value = '';
            $(self).addClass('is-invalid');
          } else {
            $('#coverImageContainer').attr('src', img.src);
            $(self).removeClass('is-invalid');
          }
        };

        img.src = fr.result;
      };

      fr.readAsDataURL(this.files[0]);

    });

    // Check image width and height
    $('form #templateImage').change(function () {
      var self = this;
      var fr = new FileReader;

      fr.onload = function() {
        var img = new Image;

        img.onload = function() {
          if (! (img.width === 1200 && img.height === 630) ) {
            self.value = '';
            $(self).addClass('is-invalid');
          } else {
            $('#cropper').attr('src', img.src);
            $(self).removeClass('is-invalid');
          }
        };

        img.src = fr.result;
      };

      fr.readAsDataURL(this.files[0]);

    });

    // convert title to slug
    $('form #title').on('change keyup', function () {
      const title = this.value.split('');
      let slug = [];
      title.forEach(function (element) {
        if (/[$-/:-?{-~!"^_`\[\]¿]/.test(element)) {
          element = '';
        } else if(element === ' ') {
          element = '-';
        } else {
          element = element.toLowerCase();
        }

        slug.push(element);
      });

      $('form #slug').val(slug.join(''));
    });

    // Cropper JS
    $('#initCropper').click(function () {
      new Cropper(document.getElementById('cropper'), {
        aspectRatio: 1,
        background: false,
        movable: false,
        rotatable: false,
        zoomable: false,
        crop(event) {
          $('#avatarPositionX').val( parseInt(event.detail.x) );
          $('#avatarPositionY').val( parseInt(event.detail.y) );
          $('#avatarWidth').val( parseInt(event.detail.width) );
          $('#avatarHeight').val( parseInt(event.detail.height) );
        }
      });
    });
  }
});
