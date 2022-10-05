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

    include_once("conexion.php");

    // Con esta Consulta ubico las filas de todas las retenciones

    $sql = ("SELECT IMP_nc_open_numfac as 'col-1',
                        CONVERT(VARCHAR, IMP_nc_open_fecdoc, 103) AS 'col-2',
                        CONVERT(VARCHAR, IMP_nc_open_feccon, 103) AS 'col-3',
                        CASE
                            WHEN IMP_porcrete_alicgene != 0 THEN STR(ABS(IMP_porcrete_alicgene),9,2)
                            WHEN IMP_porcrete_alicreduc != 0 THEN STR(ABS(IMP_porcrete_alicreduc),9,2)
                            WHEN IMP_porcrete_alicadic != 0 THEN STR(ABS(IMP_porcrete_alicadic),9,2)
                        END AS 'col-4',
                        '' AS 'col-5',
                        IIF(IMP_nc_open_numntd = '' AND IMP_nc_open_numntc = '', 'IVA','') AS 'col-6'
                FROM IMPP2001
                WHERE open_p = '" . $rifProv . "'
                AND (IMP_nc_open_numntd = '' AND IMP_nc_open_numntc = '')
                AND CONVERT(VARCHAR, IMP_nc_open_feccon, 23) >= '" . $fechaini . "'
                AND CONVERT(VARCHAR, IMP_nc_open_feccon, 23) <= '" . $fechafin . "'
                AND IMP_nc_open_numfac LIKE '%" . $nrodoc . "%'
                UNION
                SELECT IMP_nc_hist_numfac as 'col-1',
                        CONVERT(VARCHAR, IMP_nc_hist_fecdoc, 103) AS 'col-2',
                        CONVERT(VARCHAR, IMP_nc_hist_feccon, 103) AS 'col-3',
                        CASE
                            WHEN IMP_porcrete_alicgene != 0 THEN STR(ABS(IMP_porcrete_alicgene),9,2)
                            WHEN IMP_porcrete_alicreduc != 0 THEN STR(ABS(IMP_porcrete_alicreduc),9,2)
                            WHEN IMP_porcrete_alicadic != 0 THEN STR(ABS(IMP_porcrete_alicadic),9,2)
                        END AS 'col-4',
                        '' AS 'col-5',
                        IIF(IMP_nc_hist_numntd = '' AND IMP_nc_hist_numntc = '', 'IVA','') AS 'col-6'
                FROM IMPP2201
                WHERE hist_p = '" . $rifProv . "'
                AND (IMP_nc_hist_numntd = '' AND IMP_nc_hist_numntc = '')
                AND CONVERT(VARCHAR, IMP_nc_hist_feccon, 23) >= '" . $fechaini . "'
                AND CONVERT(VARCHAR, IMP_nc_hist_feccon, 23) <= '" . $fechafin . "'
                AND IMP_nc_hist_numfac LIKE '%" . $nrodoc . "%'
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
                AND IMP_nc_open3_numfac LIKE '%" . $nrodoc . "%'
                UNION
                SELECT  IMP_nc_hist3_numfac AS 'col-1',
                        CONVERT(VARCHAR, IMP_nc_hist3_fecdoc, 103) AS 'col-2',
                        CONVERT(VARCHAR, IMP_nc_hist3_feccon, 103) AS 'col-3',
                        STR(IMP_nc_hist3_porimp,9,2) AS 'col-4',
                        IMP_nc_hist3_detimp AS 'col-5',
                        IIF(IMP_nc_hist3_detimp != '', 'ISLR','') AS 'col-6'
                FROM IMPP3200
                WHERE hist3_p = '" . $rifProv . "'
                AND CONVERT(VARCHAR, IMP_nc_hist3_feccon, 23) >= '" . $fechaini . "'
                AND CONVERT(VARCHAR, IMP_nc_hist3_feccon, 23) <= '" . $fechafin . "'
                AND IMP_nc_hist3_numfac LIKE '%" . $nrodoc . "%'
                UNION
                SELECT  IMP_gene_numdoc AS 'col-1',
                        CONVERT(VARCHAR,IMP_gene_fecdoc,103) AS 'col-2',
                        CONVERT(VARCHAR,IMP_gene_feccon,103) AS 'col-3',
                        STR(SUM(IMP_gene_porimp),9,2) AS 'col-4',
                        MAX(IMP_gene_detimp) AS 'col-5',
                        'ADC' AS 'col-6'
                FROM IMPP4000
                WHERE IMP_gene_idprov = '" . $rifProv . "'
                AND CONVERT(VARCHAR,IMP_gene_feccon,23) >= '" . $fechaini . "' 
                AND CONVERT(VARCHAR,IMP_gene_feccon,23) <= '" . $fechafin . "'
                AND IMP_gene_numdoc LIKE '%" . $nrodoc ."%'
                GROUP BY IMP_gene_numdoc,IMP_gene_fecdoc,IMP_gene_feccon
                UNION
                SELECT  IMP_gene_numdoch AS 'col-1',
                        CONVERT(VARCHAR,IMP_gene_fecdoch,103) AS 'col-2',
                        CONVERT(VARCHAR,IMP_gene_fecconh,103) AS 'col-3',
                        STR(SUM(IMP_gene_porimph),9,2) AS 'col-4',
                        MAX(IMP_gene_detimph) AS 'col-5',
                        'ADC' AS 'col-6'                        
                FROM IMPP4100
                WHERE IMP_gene_idprovh = '" . $rifProv . "'
                AND CONVERT(VARCHAR,IMP_gene_fecconh,23) >= '" . $fechaini . "' 
                AND CONVERT(VARCHAR,IMP_gene_fecconh,23) <= '" . $fechafin . "'
                AND IMP_gene_numdoch LIKE '%" . $nrodoc . "%'
                GROUP BY IMP_gene_numdoch,IMP_gene_fecdoch,IMP_gene_fecconh
                UNION
                SELECT  IMP_gene_numdoc AS 'col-1',
                        CONVERT(VARCHAR,IMP_gene_fecdoc,103) AS 'col-2',
                        CONVERT(VARCHAR,IMP_gene_feccon,103) AS 'col-3',
                        STR(SUM(IMP_gene_porimp),9,2) AS 'col-4',
                        MAX(IMP_gene_detimp) AS 'col-5',
                        'MUN' AS 'col-6'
                FROM IMPP4000
                WHERE IMP_gene_idprov = '" . $rifProv . "'
                AND CONVERT(VARCHAR,IMP_gene_feccon,23) >= '" . $fechaini . "' 
                AND CONVERT(VARCHAR,IMP_gene_feccon,23) <= '" . $fechafin . "'
                AND IMP_gene_numdoc LIKE '%" . $nrodoc ."%'
                GROUP BY IMP_gene_numdoc,IMP_gene_fecdoc,IMP_gene_feccon
                UNION
                SELECT  IMP_gene_numdoch AS 'col-1',
                        CONVERT(VARCHAR,IMP_gene_fecdoch,103) AS 'col-2',
                        CONVERT(VARCHAR,IMP_gene_fecconh,103) AS 'col-3',
                        STR(SUM(IMP_gene_porimph),9,2) AS 'col-4',
                        MAX(IMP_gene_detimph) AS 'col-5',
                        'MUN' AS 'col-6'                        
                FROM IMPP4100
                WHERE IMP_gene_idprovh = '" . $rifProv . "'
                AND CONVERT(VARCHAR,IMP_gene_fecconh,23) >= '" . $fechaini . "' 
                AND CONVERT(VARCHAR,IMP_gene_fecconh,23) <= '" . $fechafin . "'
                AND IMP_gene_numdoch LIKE '%" . $nrodoc . "%'
                GROUP BY IMP_gene_numdoch,IMP_gene_fecdoch,IMP_gene_fecconh
                ORDER BY 'col-1', 'col-3', 'col-6'");
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $table = '<div class="limiter" >
    <span hidden id="rif" value="'. $rifProv.'">' . $rifProv . '</span>
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
                                <center>' . $row['col-1'] . '<span hidden id="doc' . $numrow . '">' . $row['col-1'] . '</span></center>
                            </td>
                            <td>
                                <center>' . $row['col-2'] . '</center>
                            </td>
                            <td>
                                <center>' . $row['col-3'] . '</center>
                            </td>
                            <td>
                                <center>' . $row['col-4'] . '</center>
                            </td>
                            <td>
                                <center>' . $row['col-6'] .  '<span hidden id="tipo' . $numrow . '">' . $row['col-6'] . '</span></center>
                            </td>
                            <td>
                                <center>
                                <input type="image" id="HTML" src="./images/html.png" height="25" width="25" title="Imprimir Comprobante HTML" value="' . $numrow . '" onclick="html(' . $numrow . ');">
                                <input type="image" id="PDF" src="./images/pdf.jpg" height="25" width="25" title="Imprimir Comprobante PDF" value="' . $numrow . '" onclick="pdf('. $numrow. ');">
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