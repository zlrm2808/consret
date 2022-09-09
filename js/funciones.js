Tabla = "tabla.php";

function check() {
  var isChecked = document.getElementById("arc").checked;
  alert('tom:'+isChecked);
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

  parametros = {
    fechaini: fechaini,
    fechafin: fechafin,
    rif: rif,
    nrodoc: nrodoc,
  };

  $.ajax({        
    //data: parametros, //datos que se envian a traves de ajax
    data: parametros,
    url: Tabla, //archivo que recibe la peticion
    type: "POST", //método de envio
    cache: false,
    async: true,

    success: function (data, status) {
      $("#tabla").show();
      $("#tabla").html(data);
    },
  });
  $("#tabla").html("");
}                             

  /*
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
  */



/*
function getValueInput() {
  fechaini = $("#fechaIni").val();
  fechafin = $("#fechaFin").val();
  rif = $("#rif").val();
  nrodoc = $("#nrodoc").val();

  var parametros = {
    fechaini: fechaini,
    fechafin: fechafin,
    rif: rif,
    nrodoc: nrodoc,
  };
  $.ajax({
    data: parametros, //datos que se envian a traves de ajax
    url: Tabla, //archivo que recibe la peticion
    type: "post", //método de envio
    cache: false,
    async: true,

    beforeSend: function () {
    $("#tabla").remove(); 
    },
    success: function (data, status) {
      $("#tabla").show();
      $("#tabla").html(data);
    },
  });
}

function limpiartabla() {
  $("#tabla").hide();
}
*/
$(document).on("click", "#PDF", function () {
  var id = $(this).val();
  var doc = $("#doc" + id).text();
  var tipo = $("#tipo" + id).text();
  alert(id+ '   ' +doc + tipo );
});

/*
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
    var form = $(
      '<form action="' +
        redirectUrl +
        '" method="post" target="_blank" id="formulario">' +
        '<input type="text" id="doc" name="doc" value="' +doc+ '"></input>' +
        '<input type="text" id="tipo" name="tipo" value="' +tipo+ '"></input>' +
        '<input type="text" id="rif" name="rif" value="' +rif+ '"></input>' +
        '<input type="text" id="fechaini" name="fechaini" value="' +fechaini+'"></input>' +
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
  }
  myRedirect(reqUrl);
  
});
*/
