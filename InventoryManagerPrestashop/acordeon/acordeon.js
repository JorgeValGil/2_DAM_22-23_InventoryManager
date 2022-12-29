$(function () {
    $('dl.acordeonInterno > dd').not('dt.activo + dd').hide();
    $('dl.acordeonInterno > dt').click(function () {
        if ($(this).hasClass('activo')) {
            $(this).removeClass('activo');
            $(this).next().slideUp();
        } else {
            $('dl.acordeonInterno dt').removeClass('activo');
            $(this).addClass('activo');
            $('dl.acordeonInterno dd').slideUp();
            $(this).next().slideDown();
        }
    });
    $('dl.acordeon > dd').not('dt.activo + dd').hide();
    $('dl.acordeon > dt').click(function () {
        if ($(this).hasClass('activo')) {
            $(this).removeClass('activo');
            $(this).next().slideUp();
        } else {
            $('dl dt').removeClass('activo');
            $(this).addClass('activo');
            $('dl dd').slideUp();
            $(this).next().slideDown();
        }
    });
});
