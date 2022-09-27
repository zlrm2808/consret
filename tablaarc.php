<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/jquery-ui.css">
    <link rel="stylesheet" href="./css/dataTables.jqueryui.min.css">
    <script src="./js/funciones.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.jqueryui.min.js"></script>
    <title>Consultar Retenciones</title>
</head>

<body>
    <?php
    $fechaini = $_POST["fechaini"];
    $fechafin = $_POST["fechafin"];
    $rifProv = $_POST["rif"];
    $nrodoc = $_POST["nrodoc"];
    $yearini = substr($fechaini,0,4);
    $yearfin = substr($fechafin,0,4);
    
    include_once("conexion.php");

    // Con esta Consulta ubico las filas de todas las retenciones

    $sql = ("SELECT RIGHT(LTRIM(RTRIM(IMP_nc_open3_period)),4) AS 'COL-1',
                    CONCAT('31-12-',RIGHT(LTRIM(RTRIM(IMP_nc_open3_period)),4)) AS 'COL-2',
                    UPPER(CMPNYNAM) AS 'COL-3',
                    'ARCV' AS 'COL-4'
            FROM IMPP3000
            INNER JOIN DYNAMICS.dbo.SY01500 on INTERID = DB_NAME()
            WHERE open3_p = '" . $rifProv . "'
            AND RIGHT(LTRIM(RTRIM(IMP_nc_open3_period)),4) BETWEEN '" . $yearini ."' AND '" . $yearfin . "'
            GROUP BY RIGHT(LTRIM(RTRIM(IMP_nc_open3_period)),4),CONCAT('31-12-',RIGHT(LTRIM(RTRIM(IMP_nc_open3_period)),4)),UPPER(CMPNYNAM)"
    );
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $table = '<div class="limiter">
    <span hidden id="rif" value="' . $rifProv . '">' . $rifProv . '</span>
                    <div>
                        <div>
                            <div>
                                <table id="tabla1" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                <center>#</center>
                                            </th>
                                            <th>
                                                <center>Nro. de Documento</center>
                                            </th>
                                            <th>
                                                <center>Fecha Documento</center>
                                            </th>
                                            <th>
                                                <center>Fecha Registro</center>
                                            </th>
                                            <th>
                                                <center>% de Retención</center>
                                            </th>
                                            <th>
                                                <center>Tipo</center>
                                            </th>
                                            <th>
                                                <center>Imprimir</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                ';

    $numrow = 1;
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $table .= '
                        <tr>
                            <td>
                                <center>' . $numrow . '</center>
                            </td>
                            <td>
                                <center>' . $row['COL-1'] . '<span hidden id="doc' . $numrow . '">' . $row['COL-1'] . '</span></center>
                            </td>
                            <td>
                                <center>' . $row['COL-2'] . '</center>
                            </td>
                            <td>
                                <center>---</center>
                            </td>
                            <td>
                                <center>---</center>
                            </td>
                            <td>
                                <center>' . $row['COL-4'] .  '<span hidden id="tipo' . $numrow . '">' . $row['COL-4'] . '</span></center>
                            </td>
                            <td>
                                <center>
                                <input type="image" id="HTML" src="./images/html.png" height="25" width="25" title="Imprimir Comprobante HTML" value="' . $numrow . '" onclick="html(' . $numrow . ');">
                                <input type="image" id="PDF" src="./images/pdf.jpg" height="25" width="25" title="Imprimir Comprobante PDF" value="' . $numrow . '" onclick="pdf(' . $numrow . ');">
                                </center>
                            </td>
                    </tr>
                    ';
        $numrow++;
    }
    $table .= '         </tbody>
                        <tfoot>
                            <tr>
                                <th>
                                    <center>#</center>
                                </th>
                                <th>
                                    <center>Nro. de Documento</center>
                                </th>
                                <th>
                                    <center>Fecha Documento</center>
                                </th>
                                <th>
                                    <center>Fecha Registro</center>
                                </th>
                                <th>
                                    <center>% de Retención</center>
                                </th>
                                <th>
                                    <center>Tipo</center>
                                </th>
                                <th>
                                    <center>Imprimir</center>
                                </th>
                            </tr>
                        </foot>
                        </table>
                    </div>
                </div>
            </div>
        </div>';
    echo $table;

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
    ?>
</body>