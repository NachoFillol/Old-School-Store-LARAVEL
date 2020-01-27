var newsletterBtn = document.getElementById("newsletter-btn");

var newsletterForm = document.getElementById("newsletter-form");

// Formulario de Comentario de la compra
var commentsForm = document.getElementById("comments-form");
var commentsTextarea = document.getElementById("comments");

commentsForm.onsubmit = function(event) {
    if (commentsTextarea.value.trim() == '') {			// Quitamos antes los espacios vacios
		alert('El campo no puede estar vacio!!!');
		event.preventDefault();
    } else {
        var confirmar = confirm('Está seguro que desea enviar el comentario? Esta acción no se puede deshacer');
        if (confirmar) {
            alert('Gracias por tu comentario!');
        } else {
            event.preventDefault();
        }
    }
}

// newsletterForm.onsubmit = function() {
//     alert('Gracias por suscribirte al Newsletter');
// }