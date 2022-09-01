function getValueInput() {
    fechaini = $("#fechaIni").val();
    fechafin = $("#fechaFin").val();
    rif = $("#rif").val();
    nrodoc = $("#nrodoc").val();

    //$('#valueInput').text(fechaini);

    $.post(
        "tabla.php",
        {
            fechaini: fechaini,
            fechafin: fechafin,
            rif: rif,
            nrodoc: nrodoc,
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



$(document).on("click", "#PDF", function () {
    var id = $(this).val();
    var doc = $("#doc" + id).text();
    var tipo = $("#tipo" + id).text();
    alert(doc + tipo);
});

$(document).ready(function () {
    $("#tabla1").DataTable({
        language: {
            url: "./json/spanish-datatables.json",
        },
    });
});

/*
$(document).on("click", "#HTML", function () {
    var id = $(this).val();
    var doc = $("#doc" + id).text();
    var tipo = $("#tipo" + id).text();


    var parametros = {
        doc: doc,
        tipo: tipo,
        rif: rif,
    };

    // });
    $.ajax({
        data: parametros, //datos que se envian a traves de ajax
        url: "./retencion.php", //archivo que recibe la peticion
        type: "post", //método de envio
        cache: false,
        async: true,

        success: function (response) {
            location.href = "./retencion.php?doc=" + doc + "&tipo=" + tipo + "&rif=" + rif;
        },
    });
    */