(function($) {
    "use strict"

    ///////////////////////////
    // Scrollspy
    $('body').scrollspy({
        target: '#nav',
        offset: $(window).height() / 2
    });


    ///////////////////////////
    // Btn nav collapse
    $('#nav .nav-collapse').on('click', function() {
        $('#nav').toggleClass('open');
    });

    ///////////////////////////
    // Mobile dropdown
    $('.has-dropdown a').on('click', function() {
        $(this).parent().toggleClass('open-drop');
    });

    ///////////////////////////
    // On Scroll
    $(window).on('scroll', function() {
        var wScroll = $(this).scrollTop();

        // Fixed nav
        wScroll > 1 ? $('#nav').addClass('fixed-nav') : $('#nav').removeClass('fixed-nav');

        // Back To Top Appear
        wScroll > 700 ? $('#back-to-top').fadeIn() : $('#back-to-top').fadeOut();
    });
})(jQuery);
