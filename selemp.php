<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
    <title>Seleccionar Empresa</title>
</head>

<?php
    include_once("conexion.php");
    $usuario = $_POST["Usuario"];
    $password = $_POST["Contraseña"];
?>

<body>

    <div class="contenedor-top">
        <div class="logo-vog">
            <img src="./images/VOG-horiz-blue.png" height="70px">
            <h5>Compribantes de Retención Online</h5>
        </div>
        <div class="logo-empresa">

        </div>
        <div class="logo-derecha">
            <img src="./images/fospuca-logo.png" height="100px">
        </div>
    </div>
    <div class="contenedor-mid-sel">
        <div class="izquierdo">

        </div>
        <div class="izquierdo-comp">
            <span>
                Proveedor:<h3>POLITEX DE MARACAY C.A.</h3>
            </span>

        </div>
        <div class="derecho-comp">
            <span>Empresa:
                <select>
                    <option value="">Fospuca Ambiente, C.A.</option>
                    <option value="">Fospuca Baruta, C.A.</option>
                    <option value="">Fospuca Chacao, C.A.</option>
                    <option value="">Fospuca EL Tigre, S.C.S</option>
                    <option value="">Fospuca Internacional, C.A.</option>
                    <option value="">Fospuca Jimenez, C.A.</option>
                    <option value="">Fospuca S. Barcelona, C.A.</option>
                    <option value="">Fospuca San Diego, C.A.</option>
                    <option value="">Fospuca Servicios de Ciudad, C.A</option>
                    <option value="">Fospuca Sotillo, C.A.</option>
                    <option value="">Inversiones Fospuca Baruta, C.A.</option>
                    <option value="">Inversiones Fospuca El Hatillo C.A.</option>
                    <option value="">Inversiones Fospuca Iribarren, C.A.</option>
                    <option value="">Inversiones Fospuca Los Salias, C.A.</option>
                </select>
            </span>
            <br>
            <input type="button" value="Acpetar">
        </div>
        <div class="derecho"></div>
    </div>
</body>

</html>