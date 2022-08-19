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

$sql = ("SELECT Usuario,
                    Pass
            FROM USRCONSRET
            WHERE Usuario = '" . $usuario . "' ;
            "
);

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if (($row['Usuario'] == $usuario) && ($row['Pass'] == $password)) {
    } else {
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
        echo '<script>alert("Usuario o Password incorercto")</script>';
        echo '<script>window.location.replace("login.html")</script>';
    }
}

$sql = ("SELECT nomp_prov,
                    nomb_emp,
                    dbname
            FROM EMPCONSRET
            WHERE RIF = '" . $usuario . "'");

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $Prov = $row['nomp_prov'];
}
sqlsrv_free_stmt($stmt);
?>

<body>
    <form action="./consulta.php">
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
                <?php
                echo
                '<span>
                    Proveedor:<h3>' . $Prov . '</h3>
                </span>'
                ?>

            </div>
            <div class="derecho-comp">
                <form action="./consulta.php" method="post">
                    <span>Empresa:
                        <?php
                        echo '
                        <select name="BaseDatos" id="">';
                        $stmt = sqlsrv_query($conn, $sql);
                        if ($stmt === false) {
                            die(print_r(sqlsrv_errors(), true));
                        } else {
                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                echo '<option name="BaseDatos" id="BaseDatos" value="' . $row["dbname"] . '">' . $row["nomb_emp"] . '</option>';
                            }
                        }
                        '</select>';
                        ?>
                    </span>
                </form>
                <br>
                <input type="submit" value="Acpetar">
            </div>
            <div class="derecho"></div>
        </div>
    </form>
</body>



</html>