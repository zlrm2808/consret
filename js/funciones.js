function getValueInput() {
    fechaini = $("#fechaIni").val();
    fechafin = $("#fechaFin").val();

    //$('#valueInput').text(fechaini);

    $.post(
        "tabla.php",
        {
            fechaini: fechaini,
        },
        function (data, status) {
            $("#tabla").show();
            $("#tabla").html(data);
        }
    );
}

function limpiartabla() {
    $("#tabla").hide();
}
