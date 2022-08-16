<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style-cons.css">
    <title>Document</title>
</head>

<body>
    <?php
    $hoy = date("Y-m-d");
    ?>
    <div class="contenedor-top">
        <div class="logo-vog">
            <img src="./images/VOG-horiz-blue.png" height="70px">
            <span>Comprobantes de Retención Online </span> <br>
        </div>
        <div class="centro-top">

        </div>
        <div class="logo-empresa">
            <right><img src="./images/fospuca-logo.png" height="100px"></right>
        </div>
    </div>
    <div class="contenedor-mid1">
        <div class="proveedor">
            <span>Proveedor:</span>
            <span id="emp"><b>POLYTEX DE MARACAY C.A.</b></span>
        </div>
        <div class="empresa">
            <span>Empresa:</span>
            <span id="emp"><b>Fospuca Chacao C.A.</b></span>
        </div>
    </div>
    <div class="contenedor-mid2">
        <div class="fecha-desde">
            <h3>Desde:</h3>
            <?php
            echo
            "<input type='date' name='fecha' id='fecha' value='" . $hoy . "'>";
            ?>
            <br>
        </div>
        <div class="fecha-hasta">
            <h3>Hasta:</h3>
            <?php
            echo
            "<input type='date' name='fecha' id='fecha' value='" . $hoy . "'>";
            ?>
        </div>
        <div class="documento">
            <h3>Documento:</h3>
            <input type="text" name="documento" id="documento">
        </div>
        <div class="botones">
            <input type="submit" value="Buscar">
            <input type="reset" value="Borrar">
        </div>
    </div>
    <div class="contenedor-bot">
        <label class="cbArc">ARC
            <input type="checkbox" id="arc" name="arc">
            <span class="checkmark"></span>
        </label>
    </div>

</body>

</html>