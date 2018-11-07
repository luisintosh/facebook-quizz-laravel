
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('../theme/showtracker/vendor/jquery.cookie/jquery.cookie');
window.Swiper = require('../theme/showtracker/vendor/swiper/js/swiper');
require('./libs/jquery.restfulizer');
window.Dropzone = require('./libs/dropzone/dropzone');
require('summernote/dist/summernote-bs4.min');
require('./libs/infinite-scroll.pkgd');
window.Cropper = require('cropperjs/dist/cropper');

// Page scripts
require('./scripts/quizzes');
require('./scripts/loadMoreQuizzes');
require('./scripts/quiz');

// Init jquery plugins
$(document).ready(function () {
  // Datatables
  $('.dt').DataTable();
  // WYSIWYG Editor
  $('.form-group.htmlEditor textarea').summernote({
    height: 300
  });
});
