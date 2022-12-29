$(document).ready(function () {

    //El body de la página tiene que teñen por lo menos en alto de la pantalla
    $('body').css('min-height', screen.height + 'px');

    //Evento click en las secciones del index, las secciones funcionarán como enlaces
    $('#index .general.categories, #index .general.products, #index .general.export, #index .general.profile').on('click', function (event) {
        event.preventDefault();
        var url = $(this).data('target');
        location.replace(url);
    });

    //Evento click en las secciones de extras, las secciones funcionarán como enlaces
    $('#extras .general.categories, #extras .general.products, #extras .general.prestashop, #extras .general.wordpress').on('click', function (event) {
        event.preventDefault();
        var url = $(this).data('target');
        downloadExtras(url);
    });

    //Uso de la biblioteca cpLightimg en las imágenes
    $('#categories .card-img-top, #products .card-img-top, #show img').on("click", function () {
        $(this).cpLightimg();
    });

});

//Se hace uso de un iframe oculto para descargar los archivos en la web de extras
function downloadExtras(url) {
    document.getElementById('iframe_extras').src = url;
}