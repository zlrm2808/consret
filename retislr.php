<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/retenciones.css">
    <title>Documento de ISLR</title>
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
    IMP_nc_open3_ncompr as '0',
    CONVERT(VARCHAR, IMP_nc_open3_feccon, 103) AS '1',
    UPPER(CMPNYNAM) AS '2',
    CO_MI_rif000 AS '3',
    CONCAT('AÑO ',RIGHT(LTRIM(RTRIM(IMP_nc_open3_period)),4),' / MES ',
	CASE
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=1 THEN 'ENERO'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=2 THEN 'FEBRERO'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=3 THEN 'MARZO'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=4 THEN 'ABRIL'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=5 THEN 'MAYO'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=6 THEN 'JUNIO'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=7 THEN 'JULIO'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=8 THEN 'AGOSTO'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=9 THEN 'SEPTIEMBRE'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=10 THEN 'OCTUBRE'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=11 THEN 'NOVIEMBRE'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=12 THEN 'DICIEMBRE'
	END) AS '4',
    UPPER(LTRIM(RTRIM(ADDRESS1))) AS '5.1',
    UPPER(LTRIM(RTRIM(ADDRESS2))) AS '5.2',
    UPPER(CONCAT(LTRIM(RTRIM(ADDRESS3)),', ',LTRIM(RTRIM(CITY)),', ',LTRIM(RTRIM(STATE)))) AS '5.3',
    UPPER(IMP_nc_open3_nompro) AS '6',
    open3_p as '7',
	PV_MI_direc1 as '8.1',
	PV_MI_direc2 as '8.2',
	PV_MI_direc3 as '8.3'
    FROM IMPP3000
    INNER JOIN DYNAMICS.dbo.SY01500 on INTERID = DB_NAME()
    INNER JOIN IMPC0001 on CO_MI_idcomp = DB_NAME()
	INNER JOIN IMPP0161 on PV_MI_rif000 = open3_p 
    WHERE open3_p = '" . $rif . "'
    AND IMP_nc_open3_numfac = '" . $doc . "'");
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
        $dirP1 = $row["8.1"];
        $dirP2 = $row["8.2"];
        $dirP3 = $row["8.3"];
    }
    ?>
    <div id="" class="paginaHorizontal">
        <table border='0' style="width:100%; height:60px;">
            <tr>
                <td width='200'>
                    <img src="<?php echo $LOGORET ?>" width="205" height="72" border="0" alt="">
                </td>
                <td valign='top' align='center'>
                    <h4>COMPROBANTE DE RETENCIÓN DE ISLR</h4>
                </td>
                <td valign='top' align='right' width='100'>
                    <a href="#" onclick="javascript:window.print()"><img src="./images/print.png" width="25" height="25"></a>
                </td>
            </tr>
        </table>
        <table border='0' style='border-collapse: collapse' align=center width='100%'>
            <tr>
                <td colspan="2">(Decreto 1.808 de retenciones de impuesto sobre la renta, Gaceta Oficial Nro. 36.203 del 12 de Mayo de 1.997)</td>
            </tr>
            <tr>
                <td style="width:200px;">
                    <h5>Datos de la Transacción:</h5>
                </td>
                <td style="width:500px;"></td>
            </tr>
            <tr>
                <td style="width:200px;">Fecha de Emisión:</td>
                <td style="width:500px;">Periodo Fiscal:</td>
            </tr>
            <tr>
                <td style="width:200px; font-weight: normal;"><?php echo $fecha ?></td>
                <td style="width:500px; font-weight: normal"><?php echo $perdf ?></td>
            </tr>
        </table>
        <table border='0' style='border-collapse: collapse' align=center width='100%'>
            <td style="width:45%;">
                <h5>Datos de Identificacion del Agente de Retención</h5>
            </td>
            <td style="width:5%;">&nbsp;</td>
            <td style="width:45%;">
                <h5>Datos de Identificacion del Sujeto Retenido</h5>
            </td>
            <tr>
                <td style="width:500px;"><b>Nombre o Razón Social:</b></td>
                <td style="width:50px;">&nbsp;</td>
                <td style="width:540px;"><b>Nombre o Razón Social:</b></td>
            </tr>
            <tr>
                <td style="width:500px; font-weight: normal;"><?php echo utf8_encode($rzsoc) ?></td>
                <td style="width:100px;">&nbsp;</td>
                <td style="width:500px; font-weight: normal"><?php echo utf8_encode($nempr) ?></td>
            </tr>
            <tr>
                <td style="width:500px;"><b>Nº de Registro de Información Fiscal:</b></td>
                <td style="width:100px;">&nbsp;</td>
                <td style="width:500px;"><b>Nº de Registro de Información Fiscal:</b></td>
            </tr>
            <tr>
                <td style="width:500px; font-weight: normal;"><?php echo $rifEmp ?></td>
                <td style="width:100px;">&nbsp;</td>
                <td style="width:500px; font-weight: normal"><?php echo $rif ?></td>
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
        </table>
        <br /><br />

        <?php
        $sql = ("SELECT CONVERT(VARCHAR, IMP_nc_open3_fecdoc, 103) AS 'COL-1',
                        IMP_nc_open3_numfac AS 'COL-2',
                        IMP_nc_open3_ncontro AS 'COL-3',
                        IMP_nc_open3_detimp AS 'COL-4',
                        IIF(PM20000.DOCAMNT = 0,PM30200.DOCAMNT,PM20000.DOCAMNT) AS 'COL-5',
                        IMP_nc_open3_basimp AS 'COL-6',
                        IMP_nc_open3_porimp AS 'COL-7',
                        IMP_nc_open3_monimp AS 'COL-8', 
                        IMP_nc_open3_numnd AS 'COL-9',
                        IMP_nc_open3_numnc AS 'COL-10'
                FROM IMPP3000
                LEFT JOIN PM20000 ON PM20000.DOCNUMBR = IMP_nc_open3_numdoc
                LEFT JOIN PM30200 ON PM30200.DOCNUMBR = IMP_nc_open3_numdoc
				WHERE IMP_nc_open3_numdoc= '" . $doc . "'
                UNION
                SELECT CONVERT(VARCHAR, IMP_nc_open3_fecdocd, 103) AS 'COL-1', 
                        IMP_nc_open3_numfacd AS 'COL-2', 
                        IMP_nc_open3_ncontrod AS 'COL-3', 
                        IMP_nc_open3_detimpd AS 'COL-4',
                        IIF(PM20000.DOCAMNT = 0,PM30200.DOCAMNT,PM20000.DOCAMNT) AS 'COL-5',
                        IMP_nc_open3_basimpd AS 'COL-6', 
                        IMP_nc_open3_porimpd AS 'COL-7', 
                        IMP_nc_open3_monimpd AS 'COL-8', 
                        IMP_nc_open3_numndd AS 'COL-9', 
                        IMP_nc_open3_numncd AS 'COL-10' 
                FROM IMPP3100
                LEFT JOIN PM20000 ON PM20000.DOCNUMBR = IMP_nc_open3_numdocd
                LEFT JOIN PM30200 ON PM30200.DOCNUMBR = IMP_nc_open3_numdocd
                WHERE IMP_nc_open3_numfafd = '" . $doc . "'");

        $stmt = sqlsrv_query($conn, $sql);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $tableIva =
            "<table class='tbfont' border='1' style='border-collapse: collapse' align='center' width='100%'>
            <tr>
                <td align='center' bgcolor='#EAEAEA'><b>Fecha de la Factura</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Número de Factura</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Número de Control</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Número de ND</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Número de NC</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Monto Pagado o Abonado en Cuenta</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Base Imponible de Retención</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>% ISLR Ret.</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Importe ISLR</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Detalle Ret</b></td>
            </tr>";
        $numrow = 1;
        //Totales
        $totbimp = 0;
        $totimp = 0;
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $tableIva .= "
            <tr class='interno'>
                <td width='8%' align='center'>" . $row['COL-1'] . "</td>
                <td width='8%' align='center'>" . $row['COL-2'] . "</td>
                <td width='8%' align='center'>" . $row['COL-3'] . "</td>
                <td width='8%' align='center'>" . $row['COL-9'] . "</td>
                <td width='8%' align='center'>" . $row['COL-10'] . "</td>
                <td width='12%' align='right'>" . number_format($row['COL-5'], 2, ',', '.') . "</td>
                <td width='12%' align='right'>" . number_format($row['COL-6'], 2, ',', '.') . "</td>
                <td width='12%' align='right'>" . number_format($row['COL-7'], 2, ',', '.') . "</td>
                <td width='12%' align='right'>" . number_format($row['COL-8'], 2, ',', '.') . "</td>
                <td width='12%' align='left'>" . $row['COL-4'] . "</td>
            </tr>";
            $numrow++;
            $totbimp += $row['COL-6'];
            $totimp += $row['COL-8'];
        }
        $tableIva .= "
        </table>
        <table border='0' class='tbfont' border='0' style='border-collapse: collapse' align='center' width='100%'>
            <tr>
                <td width='76%' colspan='2' align='right'>Totales (Bs.):</td>
                <td class='unica' width='12%' align='right'>" . number_format($totimp, 2, ',', '.') . "</td>
                <td width='12%' align='right'></td>
            </tr>
        </table>";
        echo $tableIva;
        ?>

        <table border='0' style='border-collapse: collapse' align=center width='100%'>
            <tr>
                <td align='center'>
                    <img src='<?php echo $FIRMA ?>' width='200px' height='100px'>
                </td>
            </tr>
            <tr>
                <td align='center'>_______________________________________________________</td>
            </tr>
            <tr>
                <td align='center'><?php echo utf8_encode($rzsoc) ?><br />Fecha de Descarga:<?php echo ' ' . $hoy ?></td>
            </tr>
        </table>
    </div>
    <?php
    if ($totimp == 0) {
        echo
        '<div class="anulado2">
            <img src="./images/Anulado.png" height="35px" alt="">
        </div>';
    }
    ?>
</body>

</html>