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

    $(".preg").on('click', function(e) {
        var target = $(e.target).closest(".preg");
        target.find(".respuesta").slideDown();
    });




});