<?php
    date_default_timezone_set('America/Caracas');
    $serverName = "PROGRAMADOR-02";
    $connectionInfo = array("Database" => "DYNAMICS");
    $conn = sqlsrv_connect($serverName, $connectionInfo);

    if ($conn) {
    } else {
        echo "Conexión no se pudo establecer.<br />";
        die(print_r(sqlsrv_errors(), true));
    }
?>