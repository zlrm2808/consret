<?php
    header('Content-Type: text/html; charset=utf-8');
    
    $file = @fopen('config.cone', "r");
    if ($file) {
        while (!feof($file)) {
            $lines[] = fgets($file, 4096);
        }
        fclose($file);
    }

    $serverName = trim($lines[0]);
    $dbname = trim($lines[1]);
    $userName = trim($lines[2]);
    $password = trim($lines[3]);

    date_default_timezone_set('America/Caracas');
    $connectionInfo = array("Database" => $dbname,
                            "UID" => $userName,
                            "PWD" => $password,
                            "Encrypt" => true,
                            "TrustServerCertificate" => True);
    $conn = sqlsrv_connect($serverName, $connectionInfo);

    if ($conn) {
    } else {
        echo "Conexión no se pudo establecer.<br />";
        die(print_r(sqlsrv_errors(), true));
    }

?>