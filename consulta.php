<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/style-cons.css">
        <link rel="stylesheet" href="./css/tabla.css">
        <script src="js/funciones.js"></script>
        <script src="js/jquery-3.2.1.min.js"></script>
        <title>Consultar Retenciones</title>
    </head>

    <body>
        <?php
        $hoy = date("Y-m-d");
        ?>
        <div class="contenedor-top">
            <div class="logo-vog">
                <img src="./images/VOG-horiz-blue.png" height="70px">
                <span>Comprobantes de Retención Online </span> <br>
            </div>
            <div class="centro-top">

            </div>
            <div class="logo-empresa">
                <right><img src="./images/fospuca-logo.png" height="100px"></right>
            </div>
        </div>
        <div class="contenedor-mid1">
            <div class="proveedor">
                <span>Proveedor:</span>
                <span id="emp"><b>POLYTEX DE MARACAY C.A.</b></span>
            </div>
            <div class="empresa">
                <span>Empresa:</span>
                <span id="emp"><b>Fospuca Chacao C.A.</b></span>
            </div>
        </div>
        <div class="contenedor-mid2">
            <div class="fecha-desde">
                <h3>Desde:</h3>
                <?php
                echo
                "<input type='date' name='fecha' id='fechaIni' value='" . $hoy . "'>";
                ?>
                <br>
            </div>
            <div class="fecha-hasta">
                <h3>Hasta:</h3>
                <?php
                echo
                "<input type='date' name='fecha' id='fechaFin' value='" . $hoy . "'>";
                ?>
            </div>
            <div class="documento">
                <h3>Documento:</h3>
                <input type="text" name="documento" id="documento">
            </div>
            <div class="botones">
                <input type="button" id="buscar" onclick="getValueInput()" value="Buscar">
                <input type="reset" value="Borrar">
                <p id="valueInput"></p>
            </div>
        </div>
        <div class="contenedor-bot">
            <label class="cbArc">ARC
                <input type="checkbox" id="arc" name="arc">
                <span class="checkmark"></span>
            </label>
        </div>
        <div class="contenedor-tabla">
            <div class="tablaCons">
                <?php
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
                WHERE open_p = 'J000123713'
                AND (IMP_nc_open_numntd = '' AND IMP_nc_open_numntc = '')
                AND CONVERT(VARCHAR, IMP_nc_open_feccon, 23) >= '2022-08-08'
                UNION
                SELECT  IMP_nc_open3_numfac AS 'col-1',
                        CONVERT(VARCHAR, IMP_nc_open3_fecdoc, 103) AS 'col-2',
                        CONVERT(VARCHAR, IMP_nc_open3_feccon, 103) AS 'col-3',
                        STR(IMP_nc_open3_porimp,9,2) AS 'col-4',
                        IMP_nc_open3_detimp AS 'col-5',
                        IIF(IMP_nc_open3_detimp != '', 'ISLR','') AS 'col-6'
                FROM IMPP3000
                WHERE open3_p = 'J000123713'
                AND CONVERT(VARCHAR, IMP_nc_open3_feccon, 23) >= '2022-08-08'
                ORDER BY 'COL-3', 'COL-1';"
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
                                <table data-vertable="ver2">
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
                                            <th class="column100 column6" id="column6"  data-column="column6">
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
                            <td class="column100 column1"  id="column0" data-column="column0">
                                    ' . $numrow . '
                                </td>
                                <td class="column100 column1" id="column1" data-column="column1">
                                    ' . $row['col-1'] . '
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
                                    ' . $row['col-6'] . '
                                </td>
                                <td class="column100 column6" id="column5" data-column="column6">
                                    
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
            </div>
        </div>
    </body>

</html>