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


    include_once("conexion.php");

    // Con esta Consulta saco el encabezado de las retencionesb tanto de IVA como de ISLR

    $sql = ("SELECT TOP 1
    IMP_nc_open3_ncompr as '0',
    CONVERT(VARCHAR, IMP_nc_open3_feccon, 103) AS '1',
    UPPER(CMPNYNAM) AS '2',
    TAXREGTN AS '3',
    CONCAT('AÑO ',RIGHT(TRIM(IMP_nc_open3_period),4),' / MES ',
	CASE
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=1 THEN 'ENE'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=2 THEN 'FEB'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=3 THEN 'MAR'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=4 THEN 'ABR'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=5 THEN 'MAY'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=6 THEN 'JUN'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=7 THEN 'JUL'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=8 THEN 'AGO'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=9 THEN 'SEP'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=10 THEN 'OCT'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=11 THEN 'NOV'
		WHEN SUBSTRING(IMP_nc_open3_period,5,2)=12 THEN 'DIC'
	END) AS '4',
    UPPER(TRIM(ADDRESS1)) AS '5.1',
    UPPER(TRIM(ADDRESS2)) AS '5.2',
    UPPER(CONCAT(TRIM(ADDRESS3),', ',TRIM(CITY),', ',TRIM(STATE))) AS '5.3',
    UPPER(IMP_nc_open3_nompro) AS '6',
    open3_p as '7',
	PV_MI_direc1 as '8.1',
	PV_MI_direc2 as '8.2',
	PV_MI_direc3 as '8.3'
    FROM IMPP3000
    INNER JOIN DYNAMICS.dbo.SY01500 on INTERID = DB_NAME()
	INNER JOIN IMPP0161 on PV_MI_idprov = open3_p 
    WHERE open3_p = '" . $rif . "'
    AND IMP_nc_open3_numfac = '" . $doc . "'
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
                    <img src="./images/logo-ret.jpg" width="205" height="72" border="0" alt="">
                </td>
                <td valign='top' align='center'>
                    <h4>&nbsp;COMPROBANTE DE RETENCIÓN DE ISLR</h4>
                </td>
                <td valign='top' align='right' width='100'>
                    <a href="#" onclick="javascript:window.print()"><img src="./images/print.png" width="25" height="25"></a>
                </td>
            </tr>
        </table>

        <table border='0' style='border-collapse: collapse' width='100%'>
            <tr>
                <td colspan='3' rowspan='2'>(Decreto 1.808 de retenciones de impuesto sobre la renta, Gaceta Oficial Nro. 36.203 del 12 de Mayo de 1.997)</td>
                <td colspan='2'> &nbsp;</td>

                <td align='center'>
                    <div>Nº COMPROBANTE</div>
                    <div class="hr">
                        <hr />
                    </div>
                </td>

                <td> &nbsp;</td>
                <td align='center'>
                    <div>FECHA DE EMISIÓN</div>
                    <div class="hr">
                        <hr />
                    </div>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan='2'> &nbsp;</td>

                <td align='center'> <?php echo $ncomp ?> </td>

                <td>&nbsp;</td>
                <td align='center'> <?php echo $fecha ?> </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td width='30%'>&nbsp;</td>
                <td width='2%'>&nbsp;</td>
                <td width='19%'>&nbsp;</td>
                <td width='10%'>&nbsp;</td>
                <td width='2%'>&nbsp;</td>
                <td width='14%'>&nbsp;</td>
                <td width='2%'>&nbsp;</td>
                <td width='14%'>&nbsp;</td>
                <td width='12%'>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <div>NOMBRE DEL AGENTE DE RETENCIÓN</div>
                    <div class="hr">
                        <hr />
                    </div>
                </td>
                <td>&nbsp;</td>
                <td colspan='2'>
                    <div>RIF DEL AGENTE DE RETENCIÓN</div>
                    <div class="hr">
                        <hr />
                    </div>
                </td>
                <td>&nbsp;</td>
                <td align='center'>
                    <div>PERÍODO FISCAL</div>
                    <div class="hr">
                        <hr />
                    </div>
                </td>
                <td colspan='3'>&nbsp;</td>
            </tr>
            <tr>
                <td><?php echo $rzsoc ?></td>
                <td>&nbsp;</td>
                <td colspan='2'><?php echo $rifEmp ?></td>
                <td width='2%'>&nbsp;</td>
                <td align='center'><?php echo $perdf ?></td>
                <td colspan='3'>&nbsp;</td>
            </tr>
            <tr>
                <td colspan='9'>&nbsp;</td>
            </tr>
            <tr>
                <td colspan='4'>
                    <div>DIRECCIÓN FISCAL DEL AGENTE DE RETENCIÓN</div>
                    <div class="hr">
                        <hr />
                    </div>
                </td>
                <td width='2%'>&nbsp;</td>
                <td width='10%'>&nbsp;</td>
                <td colspan='3'>&nbsp;</td>
            </tr>
            <tr>
                <td colspan='4'><?php echo $dir1 . ' ' . $dir2 . ' ' . $dir3 ?></td>
                <td width='2%'>&nbsp;</td>
                <td width='10%'>&nbsp;</td>
                <td colspan='3'>&nbsp;</td>
            </tr>
            <tr>
                <td colspan='9'>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <div>NOMBRE O RAZÓN SOCIAL DEL SUJETO RETENIDO</div>
                    <div class="hr">
                        <hr />
                    </div>
                </td>
                <td>&nbsp;</td>
                <td colspan='2'>
                    <div>REGISTRO DE INFORMACIÓN FISCAL DEL SUJETO</div>
                    <div class="hr">
                        <hr />
                    </div>
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan='3'>&nbsp;</td>
            </tr>
            <tr>
                <td><?php echo $nempr ?></td>
                <td>&nbsp;</td>
                <td colspan='2'><?php echo $rif ?></td>
                <td width='2%'>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan='3'>&nbsp;</td>
            </tr>
            <tr>
                <td colspan='9'>&nbsp;</td>
            </tr>
            <tr>
                <td colspan='4'>
                    <div>DIRECCIÓN FISCAL DEL SUJETO RETENIDO</div>
                    <div class="hr">
                        <hr />
                    </div>
                </td>
                <td width='2%'>&nbsp;</td>
                <td width='10%'>&nbsp;</td>
                <td colspan='3'>&nbsp;</td>
            </tr>
            <tr>
                <td colspan='4'><?php echo $dirP1 . ' ' . $dirP2 . ' ' . $dirP3 ?></td>
                <td width='2%'>&nbsp;</td>
                <td width='10%'>&nbsp;</td>
                <td colspan='3'>&nbsp;</td>
            </tr>
            <tr>
        </table>
        <br /><br />

        <?php
        $sql = ("SELECT CONVERT(VARCHAR, IMP_nc_open3_fecdoc, 103) AS 'COL-1',
                        IMP_nc_open3_numfac AS 'COL-2',
                        IMP_nc_open3_ncontro AS 'COL-3',
                        IMP_nc_open3_detimp AS 'COL-4',
                        IMP_nc_open3_basimp + (IMP_nc_open3_basimp * IMP_nc_open3_porimp)/100 AS 'COL-5',
                        IMP_nc_open3_basimp AS 'COL-6',
                        IMP_nc_open3_porimp AS 'COL-7',
                        0 AS 'COL-8',
                        (IMP_nc_open3_basimp * IMP_nc_open3_porimp)/100 AS 'COL-9'
                FROM IMPP3000
                WHERE open3_p = '" . $rif . "'
                AND IMP_nc_open3_numfac = '" . $doc . "'");

        $stmt = sqlsrv_query($conn, $sql);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $tableIva =
            "<table border='1' style='border-collapse: collapse' align='center' width='100%'>
            <tr height='25'>
                <td align='center' bgcolor='#EAEAEA'><b>Fecha de la Factura</b></td>
                <td width='90' align='center' bgcolor='#EAEAEA'><b>Número de Factura</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Número de Control</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Descripción</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Monto Total (Bs.)</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Base Imponible de Retención (Bs.)</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>% Islr Ret.</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Sustraendo (Bs.)</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Importe Islr (Bs.)</b></td>
            </tr>";

        $numrow = 1;
        //Totales
        $totmto = 0;
        $totbimp = 0;
        $totimp = 0;
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $tableIva .= "
            <tr>
                <td align='center'>" . $row['COL-1'] . "</td>
                <td align='center'>" . $row['COL-2'] . "</td>
                <td align='center'>" . $row['COL-3'] . "</td>
                <td align='left'>" . $row['COL-4'] . "</td>
                <td align='right'>" . number_format($row['COL-5'], 2, ',', '.') . "</td>
                <td align='right'>" . number_format($row['COL-6'], 2, ',', '.') . "</td>
                <td align='right'>" . number_format($row['COL-7'], 2, ',', '.') . "</td>
                <td align='right'>" . number_format($row['COL-8'], 2, ',', '.') . "</td>
                <td align='right'>" . number_format($row['COL-9'], 2, ',', '.') . "</td>
            </tr>";
            $numrow++;
            $totmto += $row['COL-5'];
            $totbimp += $row['COL-6'];
            $totimp += $row['COL-9'];
        }
        $tableIva .= "

            <tr height='25'>
                <td align='right' colspan='3'></td>
                <td align='right'>Totales (Bs.):</td>
                <td align='right'>" . number_format($totmto, 2, ',', '.') . "</td>
                <td align='right'>" . number_format($totbimp, 2, ',', '.') . "</td>
                <td>&nbsp;</td>
                <td align='right'>&nbsp;</td>
                <td align='right'>" . number_format($totimp, 2, ',', '.') . "</td>
            </tr>
        </table>
        ";
        echo $tableIva;
        ?>

        <table border='0' style='border-collapse: collapse' align=center width='100%'>
            <tr>
                <td align='center'>
                    <img src='./images/FirmaySello.png' width='200px' height='100px'>
                </td>
            </tr>
            <tr>
                <td align='center'>_______________________________________________________</td>
            </tr>
            <tr>
                <td align='center'><?php echo $rzsoc ?><br />Fecha de Descarga:<?php echo ' ' . $hoy ?></td>
            </tr>
        </table>
    </div>
</body>

</html>