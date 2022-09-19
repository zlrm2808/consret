<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
    <title>Compribantes de Retención Online - VOG</title>
</head>
<?php
$file = @fopen('config.ini', "r");
if ($file) {
    while (!feof($file)) {
        $lines[] = fgets($file, 4096);
    }
    fclose($file);
}
$urlemp = ($lines[5]);
?>

<body>
    <div class="contenedor-top">
        <div class="logo-vog">
            <img src="./images/VOG-horiz-blue.png" height="70px">
            <h5>Compribantes de Retención Online</h5>
        </div>
        <div class="logo-empresa">
            <center><a href="http://<?php echo $urlemp ?>" target="blank"><img src="./images/logo-emp.png" height="100px"></a></center>
        </div>
        <div class="login">
            <a href="./login.php">Iniciar Sesión</a>
        </div>
    </div>
    <div class="contenedor-mid">
        <div class="izquierdo">

        </div>
        <div class="descripcion">
            <p>VOG Comprobantes de Retención Online es una Aplicación WEB que le permite la
                Impresión electrónica de sus comprobantes de retención de impuesto (IVA, ISLR,
                Adicionales), evitando el traslado físico para retirarlos y agilizando los tiempos
                de entrega</p>
        </div>
        <div class="derecho">

        </div>
    </div>
    <div class="contenedor-bot">

        <img src="./images/Leyenda.png" width="100%">

    </div>
</body>

</html>