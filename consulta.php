<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style-cons.css">
    <link rel="stylesheet" href="./css/jquery-ui.css">
    <link rel="stylesheet" href="./css/dataTables.jqueryui.min.css">
    <script src="./js/funciones.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.jqueryui.min.js"></script>
    <title>Consultar Retenciones</title>
</head>

<body>
    <?php
    $file = @fopen('config.ini', "r");
        if ($file) {
            while (!feof($file)) {
                $lines[] = fgets($file, 4096);
            }
            fclose($file);
        }
        $USERBD = ($lines[2]);
        $PASSBD = ($lines[3]);
        $urlemp = ($lines[5]);

    $SERVIDOR = '';

    $file = @fopen('config.cone', "r");
    if ($file) {
        while (!feof($file)) {
            $lines[] = fgets($file, 4096);
        }
        fclose($file);
    }
    $SERVIDOR = ($lines[0]);

    list($dbname, $emp) = explode(',', $_POST['BaseDatos']);
    $rif = $_POST["rif"];
    $prov = $_POST["prov"];
    $hoy = date("Y-m-d");
    $file = fopen("config.cone", "w");
    fwrite($file, TRIM($SERVIDOR) . PHP_EOL);
    fwrite($file, TRIM($dbname).PHP_EOL);
    fwrite($file, TRIM($USERBD).PHP_EOL);
    fwrite($file, TRIM($PASSBD));
    fclose($file);
    ?>

    <div class="contenedor-top">
        <div class="logo-vog">
            <img src="./images/VOG-horiz-blue.png" height="70px"><br>
            <span>Comprobantes de Retención Online </span>
        </div>
        <div class="centro-top">

        </div>
        <div class="logo-empresa">
            <right><a href="http://<?php echo $urlemp ?>" target="blank"><img src="./images/logo-emp.png" height="100px"></a></right>
        </div>
    </div>
    <div class="contenedor-mid1">
        <div class="proveedor">
            <span>Proveedor:</span>
            <span id="prov">
                <h3><?php echo $prov; ?></h3>
            </span>
        </div>
        <div class="empresa">
            <span>Empresa:</span>
            <span id="emp"><b><?php echo $emp; ?></b></span>
        </div>
    </div>
    <div class="contenedor-mid2">
        <div class="fecha-desde">
            <h3>Desde:</h3>
            <br>
            <?php
            echo
            "<input type='date' name='fecha' id='fechaIni' value='" . $hoy . "'>";
            ?>
            <br>
        </div>
        <div class="fecha-hasta">
            <h3>Hasta:</h3>
            <br>
            <?php
            echo
            "<input type='date' name='fecha' id='fechaFin' value='" . $hoy . "'>";
            ?>
        </div>
        <div class="documento">
            <h3>Documento:</h3>
            <br>
            <input type="text" name="documento" id="nrodoc">
        </div>
        <input type="hidden" name="rif" id="rif" value="<?php echo $rif ?>">
        <div class="botones">
            <input type="button" id="buscar" onclick="getValueInput()" value="Buscar">
            <input type="reset" onclick="limpiartabla()" value="Borrar">
            <p id="valueInput"></p>
        </div>
    </div>
    <div class="contenedor-bot">
        <label class="cbArc">ARC
            <input type="checkbox" id="arc" name="arc" onclick="check()">
            <span class="checkmark"></span>
        </label>
    </div>
    <div class="contenedor-tabla">
        <div class="tablaCons" id="tabla">
        </div>
    </div>
</body>

</html>