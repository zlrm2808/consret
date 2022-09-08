chkselect = "NO";

function check() {
    var isChecked = document.getElementById("arc").checked;
    if (isChecked) {
        chkselect = "SI";
    } else {
        chkselect = "NO";
    }
}

function getValueInput() {
    fechaini = $("#fechaIni").val();
    fechafin = $("#fechaFin").val();
    rif = $("#rif").val();
    nrodoc = $("#nrodoc").val();

    switch (chkselect) {
        case "SI":
            Tabla = "tablaarc.php";
            break;
        case "NO":
            Tabla = "tabla.php";
            break;
    }
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

$(document).ready(function () {
    $(document).on("click", "#HTML", function () {
        var id = $(this).val();
        var fechaini = $("#fechaIni").val();
        var doc = $("#doc" + id).text();
        var tipo = $("#tipo" + id).text();

        var parametros = {
            doc: doc,
            tipo: tipo,
            rif: rif,
            fechaini: fechaini,
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

        var myRedirect = function (redirectUrl, arg1, arg2, arg3, arg4) {
            var form = $(
                '<form action="' +
                redirectUrl +
                '" method="post" target="_blank">' +
                '<input type="text" id="doc" name="doc" value="' + doc + '"></input>' +
                '<input type="text" id="tipo" name="tipo" value="' + tipo + '"></input>' +
                '<input type="text" id="rif" name="rif" value="' + rif + '"></input>' +
                '<input type="text" id="fechaini" name="fechaini" value="' + fechaini + '"></input>' +
                "</form>"
            );
            $("body").append(form);
            $(form).hide();
            $(form).submit();
        };

        $.ajax({
            data: parametros, //datos que se envian a traves de ajax
            url: reqUrl, //archivo que recibe la peticion
            type: "post", //método de envio
            cache: false,
            async: true,

            success: function (response) {
                switch (tipo) {
                    case "IVA":
                        myRedirect(reqUrl, parametros);
                        break;
                    case "ISLR":
                        myRedirect(reqUrl, parametros);
                        break;
                    case "ARCV":
                        myRedirect(reqUrl, parametros);
                        break;
                }

            },
        });
    });
});
