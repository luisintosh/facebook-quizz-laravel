
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
    }
});
