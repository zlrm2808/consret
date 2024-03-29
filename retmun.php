<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./images/icons/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./css/retenciones.css">
    <title>Documento de MUN</title>
</head>

<body>
    <?php
    $hoy = date("d/m/Y");
    $doc = $_POST["doc"];
    $tipo = $_POST["tipo"];
    $rif = $_POST["rif"];
    $EMPRESA = $_POST["EMPRESA"];
    $LOGORET = './images/' . $EMPRESA . '-logo-ret.png';
    $FIRMA  = './images/' . $EMPRESA . '-FirmaySello.png';

    include_once("conexion.php");

    // Con esta Consulta saco el encabezado de las retenciones

    $sql = ("SELECT TOP 1
    IMP_gene_corr as '0',
    CONVERT(VARCHAR, IMP_gene_feccon, 103) AS '1',
    UPPER(CMPNYNAM) AS '2',
    CO_MI_rif000 AS '3',
    CONCAT('Año: ',LEFT(CONVERT(VARCHAR,IMP_gene_fecdoc,23),4),'  Mes: ',
	CASE
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=1 THEN 'Enero'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=2 THEN 'Febreo'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=3 THEN 'Marzo'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=4 THEN 'Abril'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=5 THEN 'Mayo'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=6 THEN 'Junio'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=7 THEN 'Julio'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=8 THEN 'Agosto'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=9 THEN 'Septiembre'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=10 THEN 'Octubre'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),5,2)=11 THEN 'Noviembre'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),5,2)=12 THEN 'Diciembre'
	END) AS '4',
    UPPER(LTRIM(RTRIM(ADDRESS1))) AS '5.1',
    UPPER(LTRIM(RTRIM(ADDRESS2))) AS '5.2',
    UPPER(CONCAT(LTRIM(RTRIM(ADDRESS3)),', ',LTRIM(RTRIM(CITY)),', ',LTRIM(RTRIM(STATE)))) AS '5.3',
    UPPER(IMP_gene_nompro) AS '6',
    IMP_gene_rif000 as '7',
	UPPER(LTRIM(RTRIM(PV_MI_direc1))) as '8.1',
	UPPER(LTRIM(RTRIM(PV_MI_direc2))) as '8.2',
    IIF(PV_MI_direc3 ='',UPPER(CONCAT(LTRIM(RTRIM(PV_MI_ciudad)),', EDO. ',LTRIM(RTRIM(PV_MI_estado)))), UPPER(CONCAT(LTRIM(RTRIM(PV_MI_direc3)),'-',LTRIM(RTRIM(PV_MI_ciudad)),', ',LTRIM(RTRIM(PV_MI_estado))))) AS '8.3',
	CO_MI_nit000 as '9',
	PV_MI_nit000 as '10',
    IMP_gene_njrnent as '11'
    FROM IMPP4000
    INNER JOIN DYNAMICS.dbo.SY01500 on INTERID = DB_NAME()
    INNER JOIN IMPC0001 on CO_MI_idcomp = DB_NAME()
	INNER JOIN IMPP0161 on PV_MI_rif000 = IMP_gene_idprov
    WHERE IMP_gene_idprov =  '" . $rif . "'
    AND IMP_gene_numdoc = '" . $doc . "'
    UNION
    SELECT TOP 1
    IMP_gene_corrh as '0',
    CONVERT(VARCHAR, IMP_gene_fecconh, 103) AS '1',
    UPPER(CMPNYNAM) AS '2',
    CO_MI_rif000 AS '3',
    CONCAT('Año: ',LEFT(CONVERT(VARCHAR,IMP_gene_fecdoch,23),4),'  Mes: ',
	CASE
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoch,23),6,2)=1 THEN 'Enero'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoch,23),6,2)=2 THEN 'Febreo'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoch,23),6,2)=3 THEN 'Marzo'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoch,23),6,2)=4 THEN 'Abril'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoch,23),6,2)=5 THEN 'Mayo'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoch,23),6,2)=6 THEN 'Junio'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoch,23),6,2)=7 THEN 'Julio'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoch,23),6,2)=8 THEN 'Agosto'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoch,23),6,2)=9 THEN 'Septiembre'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoch,23),6,2)=10 THEN 'Octubre'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoch,23),5,2)=11 THEN 'Noviembre'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoch,23),5,2)=12 THEN 'Diciembre'
	END) AS '4',
    UPPER(LTRIM(RTRIM(ADDRESS1))) AS '5.1',
    UPPER(LTRIM(RTRIM(ADDRESS2))) AS '5.2',
    UPPER(CONCAT(LTRIM(RTRIM(ADDRESS3)),', ',LTRIM(RTRIM(CITY)),', ',LTRIM(RTRIM(STATE)))) AS '5.3',
    UPPER(IMP_gene_nomproh) AS '6',
    IMP_gene_rif000h as '7',
	UPPER(LTRIM(RTRIM(PV_MI_direc1))) as '8.1',
	UPPER(LTRIM(RTRIM(PV_MI_direc2))) as '8.2',
    IIF(PV_MI_direc3 ='',UPPER(CONCAT(LTRIM(RTRIM(PV_MI_ciudad)),', EDO. ',LTRIM(RTRIM(PV_MI_estado)))), UPPER(CONCAT(LTRIM(RTRIM(PV_MI_direc3)),'-',LTRIM(RTRIM(PV_MI_ciudad)),', ',LTRIM(RTRIM(PV_MI_estado))))) AS '8.3',
	CO_MI_nit000 as '9',
	PV_MI_nit000 as '10',
    IMP_gene_njrnenth as '11'
    FROM IMPP4100
    INNER JOIN DYNAMICS.dbo.SY01500 on INTERID = DB_NAME()
    INNER JOIN IMPC0001 on CO_MI_idcomp = DB_NAME()
	INNER JOIN IMPP0161 on PV_MI_rif000 = IMP_gene_idprovh
    WHERE IMP_gene_idprovh =  '" . $rif . "'
    AND IMP_gene_numdoch = '" . $doc . "'");
    
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
        $rifEmp = $row["3"];
        $perdf = $row["4"];
        $dir1 = $row["5.1"];
        $dir2 = $row["5.2"];
        $dir3 = $row["5.3"];
        $nempr = $row["6"];
        $rifp = $row["7"];
        $dirP1 = $row["8.1"];
        $dirP2 = $row["8.2"];
        $dirP3 = $row["8.3"];
        $licae = $row["9"];
        $licae2 = $row["10"];
        $noper = $row["11"];
    }
    ?>
    <div class="paginaHorizontal">
        <table border='0' style="width:100%; height:60px;">
            <tr>
                <td width='200'>
                    <img src="<?php echo $LOGORET ?>" width="205" height="72" border="0" alt="">
                </td>
                <td valign='top' align='center'>
                    <h4>COMPROBANTE DE RETENCIÓN MUNICIPAL ALCALDIA DE GIRARDOT</h4>
                </td>
                <td valign='top' align='right' width='100'>
                    <a href="#" onclick="javascript:window.print()"><img src="./images/print.png" width="25" height="25"></a>
                </td>
            </tr>
        </table>
        <table border='0' style="width:100%; height:60px;">
            <tr>
                <td style="width:200px;">
                    <h5>Datos de la Transacción:</h5>
                </td>
                <td style="width:500px;">
                    <h5></h5>
                </td>
            </tr>
            <tr>
                <td style="width:200px;">Periodo Fiscal:</td>
                <td style="width:400px;">Nº del Comprobante</td>
            </tr>
            <tr>
                <td style="width:200px; font-weight: normal;"><?php echo $perdf ?></td>
                <td style="width:500px; font-weight: normal"><?php echo $ncomp ?></td>
            </tr>
            <tr>
                <td style="width:200px;">Fecha de Emisión:</td>
                <td style="width:500px;">Nº de la Operación de la Contabilidad de la Empresa</td>
            </tr>
            <tr>
                <td style="width:200px; font-weight: normal;"><?php echo $fecha ?></td>
                <td style="width:500px; font-weight: normal"><?php echo number_format($noper, 0, ',', '.') ?></td>
            </tr>
        </table>
        <table border='0' style="width:100%; height:60px;">
            <td style="width:45%;">
                <h5>Datos de Identificacion del Agente de Retención</h5>
            </td>
            <td style="width:5%;">&nbsp;</td>
            <td style="width:45%;">
                <h5>Datos de Identificacion del Sujeto Retenido</h5>
            </td>
            </thead>
            <tbody>
                <tr>
                    <td style="width:500px;"><b>Nombre o Razón Social:</b></td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px;"><b>Nombre o Razón Social:</b></td>
                </tr>
                <tr>
                    <td style="width:500px; font-weight: normal;"><?php echo utf8_encode($rzsoc) ?></td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px; font-weight: normal"><?php echo $nempr ?></td>
                </tr>
                <tr>
                    <td style="width:500px;"><b>Nº de Licencia de Actividades Económicas:</b></td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px;"><b>Nº de Licencia del Sujeto Retenido:</b></td>
                </tr>
                <tr>
                    <td style="width:500px; font-weight: normal;"><?php echo $licae ?></td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px; font-weight: normal"><?php echo $licae2 ?></td>
                </tr>
                <tr>
                    <td style="width:500px;"><b>Nº de Registro de Información Fiscal:</b></td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px;"><b>Nº de Registro de Información Fiscal:</b></td>
                </tr>
                <tr>
                    <td style="width:500px; font-weight: normal;"><?php echo $rifEmp ?></td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px; font-weight: normal"><?php echo $rifp ?></td>
                </tr>
                <tr>
                    <td style="width:500px;"><b>Dirección Fiscal:</b></td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px;"><b>Dirección Fiscal:</b></td>
                </tr>
                <tr>
                    <td style="width:500px; font-weight: normal;"><?php echo utf8_encode($dir1) ?></td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px; font-weight: normal;"><?php echo utf8_encode($dirP1) ?></td>
                </tr>
                <tr>
                    <td style="width:500px; font-weight: normal;"><?php echo utf8_encode($dir2) ?></td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px; font-weight: normal;"><?php echo utf8_encode($dirP2) ?></td>
                </tr>
                <tr>
                    <td style="width:500px; font-weight: normal;"><?php echo utf8_encode($dir3) ?></td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px; font-weight: normal;"><?php echo utf8_encode($dirP3) ?></td>
                </tr>
                <tr>
                    <td style="width:500px; ">&nbsp;</td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px;">&nbsp;</td>
                </tr>
            </tbody>
            <?php
            $sql = ("SELECT CONVERT(VARCHAR, IMP_gene_fecdoc, 103) AS 'COL-1',
                            IMP_gene_numdoc AS 'COL-2',
                            IMP_gene_ncontr AS 'COL-3',
                            IMP_gene_numntd AS 'COL-4',
                            IMP_gene_numntc AS 'COL-5',
                            IMP_nc_open3_numfaf AS 'COL-6',
                            IMP_gene_acteco AS 'COL-7',
                            IMP_gene_basimp AS 'COL-8',
                            IMP_gene_porimp AS 'COL-9',
                            IMP_gene_monimp AS 'COL-10'
                    FROM IMPP4000
                    LEFT JOIN IMPP3000 ON IMP_nc_open3_numdoc = IMP_gene_numdoc
                    WHERE IMP_gene_idprov = '" . $rif . "'
                    AND IMP_gene_numdoc = '" . $doc . "'
                    UNION
                    SELECT CONVERT(VARCHAR, IMP_gene_fecdoch, 103) AS 'COL-1',
                            IMP_gene_numdoch AS 'COL-2',
                            IMP_gene_ncontrh AS 'COL-3',
                            IMP_gene_numntdh AS 'COL-4',
                            IMP_gene_numntch AS 'COL-5',
                            IMP_nc_hist3_numfaf AS 'COL-6',
                            IMP_gene_actecoh AS 'COL-7',
                            IMP_gene_basimph AS 'COL-8',
                            IMP_gene_porimph AS 'COL-9',
                            IMP_gene_monimph AS 'COL-10'
                    FROM IMPP4100
                    LEFT JOIN IMPP3200 ON IMP_nc_hist3_numdoc = IMP_gene_numdoch
                    WHERE IMP_gene_idprovh = '" . $rif . "'
                    AND IMP_gene_numdoch = '" . $doc . "'
                    UNION
                    SELECT CONVERT(VARCHAR, IMP_gene_fecdoc, 103) AS 'COL-1',
                            '' AS 'COL-2',
                            IMP_gene_ncontr AS 'COL-3',
                            IMP_gene_numntd AS 'COL-4',
                            IMP_gene_numntc AS 'COL-5',
                            IMP_nc_open3_numfaf AS 'COL-6',
                            IMP_gene_acteco AS 'COL-7',
                            IMP_gene_basimp AS 'COL-8',
                            IMP_gene_porimp AS 'COL-9',
                            IMP_gene_monimp AS 'COL-10'
                    FROM IMPP4300
                    LEFT JOIN IMPP3000 ON IMP_nc_open3_numdoc = IMP_gene_numdoc
                    WHERE IMP_gene_idprov = '" . $rif . "'
                    AND IMP_gene_numfaf = '" . $doc . "'");

            $stmt = sqlsrv_query($conn, $sql);
            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }
            ?>
            <tfoot>
                <table border='1' style='border-collapse: collapse' align='center' width='100%'>
                    <thead>
                        <th>Fecha de Documento</th>
                        <th>Nº de Documento</th>
                        <th style="width: 10%;">Nº de Control</th>
                        <th>Nº de ND</th>
                        <th>Nº de NC</th>
                        <th>Nº de Doc. Afectado</th>
                        <th>Actividad Económica Realizada</th>
                        <th>Base Imponible</th>
                        <th>Alicuota Aplicada</th>
                        <th>Impuesto Municipal Ret</th>
                    </thead>
                    <tbody>
                        <?php
                        $numrow = 1;
                        //Totales
                        $totret = 0;
                        $tableIva = '';
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            if($row['COL-4'] != '                     '){
                                $row['COL-2'] = '';
                            }
                            else
                            {
                                $row['COL-6'] = '';
                            }
                            $tableIva .= '
                        <tr>
                            <td width="8%" style="font-weight: normal;">' . $row['COL-1'] . '</td>
                            <td width="8%" style="font-weight: normal;">' . $row['COL-2'] . '</td>
                            <td width="8%" style="font-weight: normal;">' . $row['COL-3'] . '</td>
                            <td width="8%" style="font-weight: normal;">' . $row['COL-4'] . '</td>
                            <td width="8%" style="font-weight: normal;">' . $row['COL-5'] . '</td>
                            <td width="8%" style="font-weight: normal;">' . $row['COL-6'] . '</td>
                            <td style="font-weight: normal;">' . $row['COL-7'] . '</td>
                            <td style="font-weight: normal; text-align: right;">' . number_format($row['COL-8'], 2, ',', '.') . '</td>
                            <td style="font-weight: normal; text-align: right;">' . number_format($row['COL-9'], 2, ',', '.') . '</td>
                            <td width="12%" style="font-weight: normal; text-align: right;">' . number_format($row['COL-10'], 2, ',', '.') . '</td>
                        </tr>';
                            $numrow++;
                            $totret += $row['COL-10'];
                        }
                        echo $tableIva;
                        ?>
                    </tbody>
                </table>
                <table border='0' style='border-collapse: collapse' align='center' width='100%'>
                    <tr>
                        <td width='88%' style="text-align: right;" colspan="9">Total Impuesto Municipal Retenido:</td>
                        <td width='12%' class="unica" style="text-align: right;"><?php echo number_format($totret, 2, ',', '.') ?></td>
                    </tr>
                </table>
            </tfoot>
        </table>
        <table>
            <tr>
                <td width='20%'></td>
                <td width='20%' align='center'><img src='<?php echo $FIRMA ?>' width='200px' height='100px'></td>
                <td width='20%'></td>
                <td width='20%'></td>
                <td width='20%'></td>
            </tr>
            <tr>
                <td width='20%'></td>
                <td width='20%' align='center'>______________________________________<br />AGENTE DE RETENCIÓN (SELLO Y FIRMA)<br /></td>
                <td width='20%'></td>
                <td width='20%' align='center'>______________________________________<br />RECIBIDO CONFORME POR<br /></td>
                <td width='20%'></td>
            </tr>
            <tr>
                <td width='20%'></td>
                <td width='20%' align='center'>Fecha de Descarga:<?php echo ' ' . $hoy ?></td>
                <td width='20%'></td>
                <td width='20%' align='center'>Fecha de Recepción<br /></td>
                <td width='20%'></td>
            </tr>
        </table>
    </div>
    <?php
    if ($totret == 0) {
        echo
        '<div class="anulado">
            <img src="./images/Anulado.png" height="35px" alt="">
        </div>';
    }
    ?>
</body>

</html>