$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $(".wrapper").toggleClass("toggled");
});

$(document).ready(function(){
    //$('#page-content-wrapper').toggleClass('hidden').addClass('fadeInLeft');
    $('[data-toggle="tooltip"]').tooltip();
    $('select[multiple="multiple"]').chosen({
        no_results_text: "Žiadné výsledky nevyhovujú kritériam vyhľadávania ...",
        width: "100%",
        placeholder_text_multiple: "Vyberte jednu alebo viacero možností ..."
    });
});

function throwAllert(element) {
   swal({
        title: "Ste si istý vykonaním tejto akcie?",
        text: "Táto akcia je nenavratná!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ano zmazať!",
        closeOnConfirm: true
    }, function(){
       window.location.href = $(element).attr('href');
   });

    return false;
}
