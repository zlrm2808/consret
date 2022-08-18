function getValueInput() {
    fechaini = $("#fechaIni").val();
    fechaFin = $("#fechaFin").val();

    //$("#valueInput").text(fechaFin);   

    $.post("tabla.php", {
        fechaini: fechaini
    },
}

function limpiartabla() {
    $('#tabla').hide();
}
