$(function () {

    // ------------------------------------------------------ //
    // For demo purposes, can be deleted
    // ------------------------------------------------------ //

    var stylesheet = $('link#theme-stylesheet');
    $( "<link id='new-stylesheet' rel='stylesheet'>" ).insertAfter(stylesheet);
    var alternateColour = $('link#new-stylesheet');

    if ($.cookie("theme_csspath")) {
        alternateColour.attr("href", $.cookie("theme_csspath"));
    }

    $("#colour").change(function () {

        if ($(this).val() !== '') {

            var theme_csspath = 'css/style.' + $(this).val() + '.css';

            alternateColour.attr("href", theme_csspath);

            $.cookie("theme_csspath", theme_csspath, { expires: 365, path: document.URL.substr(0, document.URL.lastIndexOf('/')) });

        }

        return false;
    });


    // =====================================================
    //      TV SHOWS SLIDER
    // =====================================================

    var swiper = new Swiper('.tv-shows-slider', {
        slidesPerView: 6,
        spaceBetween: 30,
        centeredSlides: true,
        loop: true,
        breakpoints: {
            991: {
               slidesPerView: 4
           },
           565: {
               slidesPerView: 3
           }
        },
    });



    // =====================================================
    //      FEEDS SLIDER
    // =====================================================

    var swiper = new Swiper('.testimonials-slider-1', {
        direction: 'vertical',
        loop: true,
        slidesPerView: 4,
    });

    var swiper = new Swiper('.testimonials-slider-2', {
        direction: 'vertical',
        slidesPerView: 4,
        loop: true
    });


});
