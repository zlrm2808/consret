<?php

    include_once("conexion.php");

    $usuario = $_POST["Usuario"];
    $password = $_POST["Contraseña"];
    $password2 = $_POST["Contraseña2"];

$sql = ("SELECT PV_MI_idprov,
                PV_MI_nompro
        FROM IMPP0161
        WHERE PV_MI_idprov = '". $usuario ."' ;
        "
);

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    echo "EL RIF INDICADO NO SE ENCUENTRA EN NUESTRA BASE DE DATOS";
    echo $stmt;
    die;
}
else {
    if ($password != $password2) {
        echo "Las contraseñas no coinciden";
    }
    else {
        echo '<script>alert("Registro Exitoso!!)</script>';
        die;
        header("Location: login.html");
        exit();
        $sql = ("INSERT INTO ");
    }
}
?>