$(document).ready(function() {
    $('.menuTrigger').click(function(e) {
        e.preventDefault();
        if($(this).hasClass('active')) {
            $(this).removeClass('active');
            $(this).children('span').toggleClass('fa-bars fa-times');
            $('.navigation-bar').removeClass('active');
        }
        else {
            $(this).addClass('active');
            $(this).children('span').toggleClass('fa-bars fa-times');
            $('.navigation-bar').addClass('active');
        }
    });
});
