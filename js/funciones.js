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


$(document).ready(function () {
    $(document).on("click", "#HTML", function () {
        var id = $(this).val();
        var doc = $("#doc" + id).text();
        var tipo = $("#tipo" + id).text();
        //var rif = $("#rif").text();

        var parametros = {
            doc: doc,
            tipo: tipo,
            rif: rif,
        };

        var myRedirect = function (redirectUrl, arg1, arg2, arg3) {
            var form = $(
                '<form action="' +
                redirectUrl +
                '" method="post" target="_blank">' +
                '<input type="text" id="doc" name="doc" value="' +
                doc +
                '"></input>' +
                '<input type="text" id="tipo" name="tipo" value="' +
                tipo +
                '"></input>' +
                '<input type="text" id="rif" name="rif" value="' +
                rif +
                '"></input>' +
                "</form>"
            );
            $("body").append(form);
            $(form).hide();
            $(form).submit();
        };

        switch (tipo) {
            case "IVA":
                $.ajax({
                data: parametros, //datos que se envian a traves de ajax
                url: "./retiva.php", //archivo que recibe la peticion
                type: "post", //método de envio
                cache: false,
                async: true,
                success: function (response) {
                    myRedirect("./retiva.php", doc, tipo, rif);
                },
            });
            break;
            case "ISLR":
                $.ajax({
                data: parametros, //datos que se envian a traves de ajax
                url: "./retislr.php", //archivo que recibe la peticion
                type: "post", //método de envio
                cache: false,
                async: true,
                success: function (response) {
                    myRedirect("./retislr.php", doc, tipo, rif);
                },
            });
            break;
        };
    });
});