<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/sweetalert.min.js"></script>
    <link rel="stylesheet" href="./css/styles.css">
    <title>Seleccionar Empresa</title>
</head>

<?php

include_once("conexion.php");

$usuario = $_POST["Usuario"];
$password = $_POST["Contraseña"];

$sql = ("DELETE FROM DYNAMICS.DBO.EMPCONSRET WHERE RIF = '".$usuario."';
        DECLARE @rn INT = 1, @dbname varchar(MAX) = '';
        WHILE @dbname IS NOT NULL
        BEGIN
            SET @dbname = (SELECT INTERID FROM (SELECT INTERID, ROW_NUMBER() OVER (ORDER BY INTERID) rn
                FROM DYNAMICS..SY01500 WHERE INTERID NOT IN('PRUEB', 'TWO', 'DESAR', 'TEST','T0001','T0002')) t WHERE rn = @rn);
            IF @dbname <> '' AND @dbname IS NOT NULL
                EXECUTE ('use ['+@dbname+'];
                    INSERT INTO DYNAMICS.dbo.EMPCONSRET 
                    VALUES(	''".$usuario. "'',
                            (SELECT PV_MI_nompro FROM IMPP0161 WHERE PV_MI_idprov = ''" . $usuario . "''),
                            DB_NAME(), 
                            (SELECT CMPNYNAM FROM DYNAMICS.dbo.SY01500 WHERE INTERID = DB_NAME()))
                ');
            SET @rn = @rn + 1;
        END;");

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
} 

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
        echo '<script>alert("Datos Incorrectos","Usuario o Password incorercto","error");
                    window.location.replace("login.html")</script>';
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
    <form action="./consulta.php" method="post">
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
                <span>Empresa:
                    <?php
                    echo '
                    <select name="BaseDatos" id="">';
                    $stmt = sqlsrv_query($conn, $sql);
                    if ($stmt === false) {
                        die(print_r(sqlsrv_errors(), true));
                    } else {
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            echo '<option value ="' . $row["dbname"] . ',' . $row["nomb_emp"] . '">' . $row["nomb_emp"] . '</option>';
                        }
                    }
                    '</select>';
                    ?>
                </span>
                <br>
                <input type="hidden" name="prov" value="<?php echo $Prov; ?>">
                <input type="hidden" name="emp" value="<?php echo $emp; ?>">
                <input type="hidden" name="rif" value="<?php echo $usuario; ?>">
                <input type="submit" value="Acpetar">
            </div>
            <div class="derecho"></div>
        </div>
    </form>
</body>


</html>