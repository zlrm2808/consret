<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./librerias/bootstrap/bootstrap.min.css">
    <title>Consultar Retenciones</title>
</head>

<body>
    <div id="tablaDatatable">
        <?php
        date_default_timezone_set('America/Caracas');
        $serverName = "PROGRAMADOR-02";
        $connectionInfo = array("Database" => "F5618");
        $conn = sqlsrv_connect($serverName, $connectionInfo);

        if ($conn) {
            echo "Conexión establecida.<br />";
        } else {
            echo "Conexión no se pudo establecer.<br />";
            die(print_r(sqlsrv_errors(), true));
        }

        // Con esta Consulta sao el encabezado de las retenciones

        $sql = ("SELECT TOP 1
                        IMP_nc_open_nreten as '0',
                        CONVERT(VARCHAR, IMP_nc_open_feccon, 103) AS '1',
                        CMPNYNAM AS '2',
                        TAXREGTN AS '3',
                        CONCAT('AÑO: ',RIGHT(TRIM(IMP_nc_open_period),4),'    MES: ',SUBSTRING(IMP_nc_open_period,5,2)) AS '4',
                        TRIM(ADDRESS1) AS '5.1',
                        TRIM(ADDRESS2) AS '5.2',
                        CONCAT(TRIM(ADDRESS3),', ',TRIM(CITY),', ',TRIM(STATE)) AS '5.3',
                        IMP_nc_open_nompro AS '6',
                        open_p as '7'
                FROM IMPP2001
                INNER JOIN DYNAMICS.dbo.SY01500 on INTERID = DB_NAME() 
                WHERE open_p = 'J000123713'
                AND CONVERT(VARCHAR, IMP_nc_open_feccon, 23) >= '2022-01-01';
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
                <table border=0>
                    <tr>
                        <th><h2>Numero de Comprobante</h2></th>
                        <th><h2>Numero de Factura</h2></th>
                        <th><h2>Fecha de Documento</h2></th>
                        <th><h2>Fecha de Emisión</h2></th>
                    </tr>
                ';

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $table .= '
                <tr>
                    <td>' . $row["1"] . '</td>                    
                    <td>' . $row["IMP_nc_open_numfac"] . '</td>
                    <td>' . $row["Fecha_Documen"] . '</td>
                    <td>' . $row["Fecha_Emision"] . '</td>
                </tr>';
        }
        $table .= '</table>';
        echo $table;
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
        ?>
    </div>
</body>

</html>