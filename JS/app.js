$(document).ready(function() {
    function cargarPreguntas() {
        $("#seccionPreguntas").load("./busqueda.php", function() {
            console.log("Preguntas cargadas con exito");
        });
    }

    cargarPreguntas();

    $("#busqueda").keyup(function() {
        var filtro = $("#busqueda").val();
        $.post("./busqueda.php", {
            sugerencia: filtro
        }, function(data, status) {
            $("#seccionPreguntas").html(data);
        });
    });

    $(document).on('click', '.preg', function() {
        var padre = $(this);
        padre.find('.respuesta').slideToggle();
    })



});