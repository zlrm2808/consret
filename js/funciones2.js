Tabla = "tabla.php";

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
    $("#tabla111").DataTable({
        language: {
            url: "./json/spanish-datatables.json",
        },
    });
});

$(document).on("click", "#HTML", function () {
    var id = $(this).val();
    var doc = $("#doc" + id).text();
    var tipo = $("#tipo" + id).text();
    var fechaini = $("#fechaIni").val();
    var rif = (rif = $("#rif").val());    

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
    var myRedirect = function (redirectUrl) {
        var form = document.getElementById('formulario');
        datos = (id, doc, tipo, fechaini, rif);

        //fetch(
            //"consulta.php",
            $.ajax({
                data: datos, //datos que se envian a traves de ajax
                url: $("#formulario"), //archivo que recibe la peticion
                type: "post", //método de envio
                cache: false,
                async: true,
            })
        //);
        $("#fdoc").val(doc);
        $("#ftipo").val(tipo);
        $("#frif").val(rif);
        form.submit();
    };
    myRedirect(reqUrl);

});