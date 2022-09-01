<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="./css/tabla.css"> -->
    <link rel="stylesheet" href="./css/jquery-ui.css">
    <link rel="stylesheet" href="./css/jqueryui.min.css">
    <script src="./js/funciones.js"></script>
    <title>Consultar Retenciones</title>
</head>

<body>
    <?php
    $fechaini = $_POST["fechaini"];
    $fechafin = $_POST["fechafin"];
    $rifProv = $_POST["rif"];

    include_once("conexion.php");
    // Con esta Consulta saco el encabezado de las retencionesbtanto de IVA como de ISLR

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

    $html = '<a href="#">HTML</a>';
    $pdf = '<a href="#">PDF</a>';

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $ncomp = $row["0"];
        $fecha = $row["1"];
        $rzsoc = $row["2"];
        $rif = $row["3"];
        $perdf = $row["4"];
        $dir1 = $row["5.1"];
        $dir2 = $row["5.2"];
        $dir3 = $row["5.3"];
        $nempr = $row["6"];
        $rempr = $row["7"];
    }

    // Con esta Consulta ubico las filas de todas las retenciones

    $sql = ("SELECT IMP_nc_open_numfac as 'col-1',
                        CONVERT(VARCHAR, IMP_nc_open_fecdoc, 103) AS 'col-2',
                        CONVERT(VARCHAR, IMP_nc_open_feccon, 103) AS 'col-3',
                        STR(ABS(IMP_porcrete_alicgene),9,2) AS 'col-4',
                        '' AS 'col-5',
                        IIF(IMP_nc_open_numntd = '' AND IMP_nc_open_numntc = '', 'IVA','') AS 'col-6'
                FROM IMPP2001
                WHERE open_p = '" . $rifProv . "'
                AND (IMP_nc_open_numntd = '' AND IMP_nc_open_numntc = '')
                AND CONVERT(VARCHAR, IMP_nc_open_feccon, 23) >= '" . $fechaini . "'
                AND CONVERT(VARCHAR, IMP_nc_open_feccon, 23) <= '" . $fechafin . "'
                UNION
                SELECT  IMP_nc_open3_numfac AS 'col-1',
                        CONVERT(VARCHAR, IMP_nc_open3_fecdoc, 103) AS 'col-2',
                        CONVERT(VARCHAR, IMP_nc_open3_feccon, 103) AS 'col-3',
                        STR(IMP_nc_open3_porimp,9,2) AS 'col-4',
                        IMP_nc_open3_detimp AS 'col-5',
                        IIF(IMP_nc_open3_detimp != '', 'ISLR','') AS 'col-6'
                FROM IMPP3000
                WHERE open3_p = '" . $rifProv . "'
                AND CONVERT(VARCHAR, IMP_nc_open3_feccon, 23) >= '" . $fechaini . "'
                AND CONVERT(VARCHAR, IMP_nc_open3_feccon, 23) <= '" . $fechafin . "'
                ORDER BY 'COL-1', 'COL-3';"
    );
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $table = '<div class="limiter">
                    <div class="container-table100">
                        <div class="wrap-table100">
                            <div class="table100 ver2 m-b-110">
                                <table id="tabla" class="display" style="width:100%" data-vertable="ver2">
                                    <thead>
                                        <tr class="row100 head">
                                            <th class="column100 column0" id="column0" data-column="column0">
                                                #
                                            </th>
                                            <th class="column100 column1" id="column1"  data-column="column1">
                                                Nro. de Documento
                                            </th>
                                            <th class="column100 column2" id="column2"  data-column="column2">
                                                Fecha Documento
                                            </th>
                                            <th class="column100 column3" id="column3"  data-column="column3">
                                                Fecha Registro
                                            </th>
                                            <th class="column100 column4" id="column4"  data-column="column4">
                                                % de Retención
                                            </th>
                                            <th class="column100 column5" id="column5"  data-column="column5">
                                                Tipo
                                            </th>
                                            <th colspan="2" class="column100 column6" id="column6"  data-column="column6">
                                                Imprimir
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                ';

    $numrow = 1;

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $table .= '
                        <tr class="row100">
                            <td class="column100 column0"  id="column0" data-column="column0">
                                    ' . $numrow . '
                                </td>
                                <td class="column100 column1" id="column1" data-column="column1">
                                    ' . $row['col-1'] . '<span hidden id="doc' . $numrow . '">' . $row['col-1'] . '</span>
                                </td>
                                <td class="column100 column2" id="column2" data-column="column2">
                                    ' . $row['col-2'] . '
                                </td>
                                <td class="column100 column3" id="column3" data-column="column3">
                                    ' . $row['col-3'] . '
                                </td>
                                <td class="column100 column4" id="column4" data-column="column4">
                                    ' . $row['col-4'] . '
                                </td>
                                <td class="column100 column5" id="column5"data-column="column5">
                                    ' . $row['col-6'] .  '<span hidden id="tipo' . $numrow . '">' . $row['col-6'] . '</span>
                                </td>
                                <td class="column100 column6" id="column5" data-column="column6">
                                    <button type="button" id="imprime" value="' . $numrow . '">HTML</button>
                                </td>
                                <td class="column100 column7" id="column5" data-column="column6">
                                    ' . $pdf . '
                                </td>
                        </tr>
                    ';
        $numrow++;
    }
    $table .= '         </tbody>
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