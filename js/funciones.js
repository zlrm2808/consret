Tabla = "tabla.php";
//var form = $('<form></form>');
//$("body").append(form);

function check() {
    var isChecked = document.getElementById("arc").checked;
    if (isChecked) {
        Tabla = "tablaarc.php";
    } else {
        Tabla = "tabla.php";
    }
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
        function (data, status) {
            $("#tabla").show();
            $("#tabla").html(data);
        }
    );
};

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

$(document).on("click", "#HTML", function () {
    var id = $(this).val();
    var fechaini = $("#fechaIni").val();
    var doc = $("#doc" + id).text();
    var tipo = $("#tipo" + id).text();

    var myRedirect = function (redirectUrl) {
        /*
        form.setAttribute("method","post");
        form.setAttribute("action", redirectUrl);
        form.setAttribute("target", "_blank");
        form.empty();
        form.append('<input type="text" id="doc" name="doc" value="' + doc + '"></input>');
        form.append('<input type="text" id="tipo" name="tipo" value="' + tipo + '"></input>');
        form.append('<input type="text" id="rif" name="rif" value="' + rif + '"></input>');
        form.append('<input type="text" id="fechaini" name="fechaini" value="' + fechaini + '"></input>');
        form.submit();
        */

        
        var form = $(
            '<form action="'+redirectUrl+'" method="post" target="_blank" id="formulario">' +
            '<input type="text" id="doc" name="doc" value="' + doc + '"></input>' +
            '<input type="text" id="tipo" name="tipo" value="' + tipo + '"></input>' +
            '<input type="text" id="rif" name="rif" value="' + rif + '"></input>' +
            '<input type="text" id="fechaini" name="fechaini" value="' + fechaini + '"></input>' +
            "</form>"
        );
        $("body").append(form);
        $(form).hide();
        $(form).submit();
        form.empty();
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
    }
    myRedirect(reqUrl);
});