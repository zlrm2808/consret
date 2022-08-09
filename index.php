<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Retenciones</title>
</head>

<body>
    <?php
    $serverName = "PROGRAMADOR-02";
    $connectionInfo = array("Database" => "F2099");
    $conn = sqlsrv_connect($serverName, $connectionInfo);

    if ($conn) {
        echo "Conexión establecida.<br />";
    } else {
        echo "Conexión no se pudo establecer.<br />";
        die(print_r(sqlsrv_errors(), true));
    }

    $sql = (
            "SELECT open_p,
                    IMP_nc_open_nompro 
            FROM IMPP2001 
            WHERE IMP_nc_open_ncompr = 'CPP22-0000729'"
            );
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Make the first (and in this case, only) row of the result set available for reading.
    if (sqlsrv_fetch($stmt) === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Get the row fields. Field indices start at 0 and must be retrieved in order.
    // Retrieving row fields by name is not supported by sqlsrv_get_field.
    $rif = sqlsrv_get_field($stmt, 0);
    $prov = sqlsrv_get_field($stmt, 1);
    echo "$rif ";
    echo "<br>";
    echo "$prov ";
    ?>
</body>

</html>