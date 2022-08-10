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
        date_default_timezone_set('America/Caracas');
        $serverName = "PROGRAMADOR-02";
        $connectionInfo = array("Database" => "F2099");
        $conn = sqlsrv_connect($serverName, $connectionInfo);

        if ($conn) {
            echo "Conexión establecida.<br />";
        } else {
            echo "Conexión no se pudo establecer.<br />";
            die(print_r(sqlsrv_errors(), true));
        }

        $sql = ("SELECT CONVERT(VARCHAR, IMP_nc_open_feccon, 103) AS Fecha_Emision,
                        IMP_nc_open_numfac,
                        IMP_nc_open_nreten
                FROM IMPP2001
                INNER JOIN DYNAMICS.dbo.SY01500 on INTERID = DB_NAME() 
                "
                );
        $stmt = sqlsrv_query($conn, $sql);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $table = '
            <table border=1>
                <tr>
                    <th><h2>Fecha de Emisión</h2></th>
                    <th><h2>Numero de Factura</h2></th>
                    <th><h2>Numero de Comprobante</h2></th>
                </tr>
            ';

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $table .= '
            <tr>
                <td>' . $row["Fecha_Emision"] . '</td>
                <td>' . $row["IMP_nc_open_numfac"] . '</td>
                <td>' . $row["IMP_nc_open_nreten"] . '</td>
            </tr>';
        }
        $table .= '</table>';
        echo $table;
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);    
    ?>
</body>

</html>