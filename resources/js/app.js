import './bootstrap';



// Disparaître le message de succès après 2 secondes
setTimeout(function () {
    $('#successMessage').fadeOut('slow');
}, 2000);

// Disparaître le message d'erreur après 2 secondes
setTimeout(function () {
    $('#errorMessage').fadeOut('slow');
}, 2000);
// *****************************************************************




// ********************************************** ETOILES DES COMMENTAIRES 
$(document).ready(function () {
    $('.star').click(function () {
        var indexCliqué = $(this).data("index");
        $('#note').val(indexCliqué);

        // Style : "Vider" toutes les étoiles.. de ce groupe
        $(this).parent().find('.star').addClass('stargrey').removeClass('yellow');

        // Style : "Remplir" le bon nombre d'étoiles
        for (var i = 0; i <= indexCliqué; i++) {
            var etoile = $(this).parent().find('.star[data-index=' + i + ']');
            etoile.addClass('yellow').removeClass('stargrey');
        }
    });
});

// ********************************************** FIN ETOILES DES COMMENTAIRES 



// ********************************************** HOVER DES ETOILES 
$(document).ready(function () {
    $('.star').hover(function () {
        var indexHover = $(this).data("hover");

        $(this).parent().find('.star').addClass('stargrey').removeClass('star_hover');

        for (var i = 0; i <= indexHover; i++) {
            var etoile = $(this).parent().find('.star[data-hover=' + i + ']');
            etoile.addClass('star_hover').removeClass('stargrey');
        }
    });
    $('.stars').mouseleave(function () {
        $(this).find('.star').addClass('stargrey').removeClass('star_hover');
    });
});

// ********************************************** FIN HOVER DES ETOILES 
