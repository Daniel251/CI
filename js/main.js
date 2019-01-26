$( document ).ready(function() {
    $('a[href^="#"]').on('click', function(event) {

        var target = $( $(this).attr('href') );

        if( target.length ) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top
            }, 1000);
        }
    });
		/* Video */
    $('#nav-icon').click(function(e){
        $(this).toggleClass('open');
        e.preventDefault();
        $('.menu').toggleClass('slide-down');
	});
    $('.menu').on('click', function() {
	   $('.menu').removeClass('slide-down');
        $('#nav-icon').toggleClass('open');
    });
    $( '.swipebox-video' ).swipebox();
});