Tabla = "tabla.php";

function check() {
    var isChecked = document.getElementById("arc").checked;
    if (isChecked) {
        Tabla = "tablaarc.php";
    } else {
        Tabla = "tabla.php";
    }
}

function limpiartabla() {
    $("#tabla").hide();
}

function getValueInput() {
    fechaini = $("#fechaIni").val();
    fechafin = $("#fechaFin").val();
    rif = $("#rif").val();
    nrodoc = $("#nrodoc").val();

    $.post(
        Tabla,
        {
            fechaini: fechaini,
            fechafin: fechafin,
            rif: rif,
            nrodoc: nrodoc,
        },
        function (data) {
            $("#tabla").html(data);
            $("#tabla").show();
        }
    );
}

function pdf(id) {
    var fechaini = $("#fechaIni").val();
    var doc = $("#doc" + id).text();
    var tipo = $("#tipo" + id).text();

    var myRedirect = function (redirectUrl) {
        var form = $(
            '<form action="'+redirectUrl+'" method="post" target="_blank" id="formulario">' +
            '<input type="text" id="doc" name="doc" value="'+doc+'"></input>' +
            '<input type="text" id="tipo" name="tipo" value="'+tipo+'"></input>' +
            '<input type="text" id="rif" name="rif" value="'+rif+'"></input>' +
            '<input type="text" id="fechaini" name="fechaini" value="'+fechaini+'"></input>' +
            "</form>"
        );
        $("body").append(form);
        $(form).hide();
        $(form).submit();
    };

    switch (tipo) {
        case "IVA":
            reqUrl = "./retivapdf.php";
            break;
        case "ISLR":
            reqUrl = "./retislrpdf.php";
            break;
        case "ARCV":
            reqUrl = "./retarcvpdf.php";
            break;
        case "IRM":
            reqUrl = "./retirmpdf.php";
            break;
        case "RETAG":
            reqUrl = "./retagpdf.php";
            break;
    }
    myRedirect(reqUrl);
}

$(document).ready(function () {
    $("#tabla1").DataTable({
        language: {
            url: "./json/spanish-datatables.json",
        },
    });
});

function html(id) {
    var fechaini = $("#fechaIni").val();
    var doc = $("#doc" + id).text();
    var tipo = $("#tipo" + id).text();

    var myRedirect = function (redirectUrl) {
        var form = $(
            '<form action="'+redirectUrl+'" method="post" target="_blank" id="formulario">'+
            '<input type="text" id="doc" name="doc" value="'+doc+'"></input>' +
            '<input type="text" id="tipo" name="tipo" value="'+tipo+'"></input>' +
            '<input type="text" id="rif" name="rif" value="'+rif+'"></input>' +
            '<input type="text" id="fechaini" name="fechaini" value="'+fechaini+'"></input>' +
            "</form>"
        );
        $("body").append(form);
        $(form).hide();
        $(form).submit();
    };

    switch (tipo) {
        case "IVA":
            reqUrl = "./retiva.php";
            break;
        case "ISLR":
            reqUrl = "./retislr.php";
            break;
        case "ARCV":
            reqUrl = "./retarcv.php";
            break;
        case "IRM":
            reqUrl = "./retirm.php";
            break;
        case "RETAG":
            reqUrl = "./retag.php";
            break;
    }
    myRedirect(reqUrl);
}
