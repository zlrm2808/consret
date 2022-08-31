function getValueInput() {
    fechaini = $("#fechaIni").val();
    fechafin = $("#fechaFin").val();
    rif = $("#rif").val();

    //$('#valueInput').text(fechaini);

    $.post(
        "tabla.php",
        {
            fechaini: fechaini,
            fechafin: fechafin,
            rif: rif,
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

$(document).on("click", "#imprime", function () {
    var id = $(this).val();
    var doc = $("#doc" + id).text();
    var tipo = $("#tipo" + id).text();
    alert(doc+tipo);
});
