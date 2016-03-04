$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $(".wrapper").toggleClass("toggled");
});

$(document).ready(function(){
    $('#page-content-wrapper').toggleClass('hidden').addClass('fadeInLeft');
    $('[data-toggle="tooltip"]').tooltip();
});
