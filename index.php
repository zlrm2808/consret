<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
    <title>Comprobantes de Retención Online - VOG</title>
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
$EMPRESA = ($lines[4]);
$LOGOEMP = "./images/".$EMPRESA."-logo-emp.png";
?>

<body>
    <div class="contenedor-top">
        <div class="logo-vog">
            <img src="./images/VOG-horiz-blue.png" height="70px">
            <h5>Comprobantes de Retención Online</h5>
        </div>
        <div class="logo-empresa">
            <center><a href="http://<?php echo $urlemp ?>" target="blank"><img src="<?php echo $LOGOEMP ?>" height="100px"></a></center>
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

        <center><img src="./images/info.png" height="250px"></center>

    </div>
</body>

</html>