<?php ob_start();
require_once "./conexion.php";

$hoy = date("d/m/Y");
$doc = $_POST["doc"];
$tipo = $_POST["tipo"];
$rif = $_POST["rif"];
$logoRet = "./images/logo-ret.png";
$logoRet64 = "data:image/png;base64," . base64_encode(file_get_contents($logoRet));
$FirmaySello = "./images/FirmaySello.png";
$FSello64 = "data:image/png;base64," . base64_encode(file_get_contents($FirmaySello));
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documento de ACRV</title>
</head>

<style>
    @page {
        margin-left: 0.5cm;
        margin-right: 0.5cm;
        margin-top: 1cm;
        margin-bottom: 0.5cm;
    }

    body {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 10px;
        color: #000000;
        background-color: #ffffff;
        margin: 0px;
        padding: 0px;
    }

    p {
        text-indent: 10px;
        font-family: verdana;
        font-size: 10pt;
        margin-bottom: 10px;
    }

    h4 {
        color: #000000;
        font-family: verdana;
        font-size: 14pt;
        margin-bottom: 1px;
    }

    table {
        font-family: verdana;
        font-size: 8pt;
    }

    div {
        color: #000000;
        font-family: verdana;
        font-size: 8pt;
        font-weight: bold;
    }
</style>

<body>
    <?php
    $hoy = date("d/m/Y");
    $doc = $_POST["doc"];
    $tipo = $_POST["tipo"];
    $rif = $_POST["rif"];
    $fechaini = $_POST["fechaini"];
    $ano = substr($fechaini, 0, 4);


    include_once("conexion.php");

    // Con esta Consulta saco el encabezado de las retenciones

    $sql = ("SELECT TOP 1
                    RIGHT(CONVERT(VARCHAR, IMP_nc_open3_feccon, 103),4) AS '1',
                    CONCAT('31/12/',RIGHT(CONVERT(VARCHAR, IMP_nc_open3_feccon, 103),4)) AS '2',
                    UPPER(CMPNYNAM) AS '3',
                    CO_MI_rif000 AS '4',
                    CONCAT(RIGHT(CONVERT(VARCHAR, IMP_nc_open3_feccon, 103),4),'0101 - ',RIGHT(CONVERT(VARCHAR, IMP_nc_open3_feccon, 103),4),'1231') AS '5',
                    UPPER(LTRIM(RTRIM(ADDRESS1))) AS '6.1',
                    UPPER(LTRIM(RTRIM(ADDRESS2))) AS '6.2',
                    UPPER(CONCAT(LTRIM(RTRIM(ADDRESS3)),', ',LTRIM(RTRIM(CITY)),', ',LTRIM(RTRIM(STATE)))) AS '6.3',
                    UPPER(IMP_nc_open3_nompro) AS '7',
                    open3_p as '8',
                    PV_MI_direc1 as '9.1',
                    PV_MI_direc2 as '9.2',
                    PV_MI_direc3 as '9.3'
            FROM IMPP3000
            INNER JOIN DYNAMICS.dbo.SY01500 on INTERID = DB_NAME()
            INNER JOIN IMPC0001 on CO_MI_idcomp = DB_NAME()
            INNER JOIN IMPP0161 on PV_MI_idprov = open3_p  
            WHERE open3_p = '" . $rif . "'");
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $aimp = $row["1"];
        $femi = $row["2"];
        $rzsoc = utf8_encode($row["3"]);
        $rifEmp = $row["4"];
        $perdf = utf8_encode($row["5"]);
        $dir1 = utf8_encode($row["6.1"]);
        $dir2 = utf8_encode($row["6.2"]);
        $dir3 = utf8_encode($row["6.3"]);
        $nempr = utf8_encode($row["7"]);
        $dirP1 = utf8_encode($row["9.1"]);
        $dirP2 = utf8_encode($row["9.2"]);
        $dirP3 = utf8_encode($row["9.3"]);
    }
    ?>
    <div id="" class="paginaHorizontal">

        <table border='0' style="width:100%; height:60px;">
            <tr>
                <td width='200'>
                    <img src="<?php echo $logoRet64 ?>" width="205" height="72" border="0" alt="">
                </td>
                <td valign='top' align='center'>
                    <h4>COMPROBANTE DE RETENCIÓN DE ARCV</h4>
                </td>
            </tr>
        </table>

        <table border='0' style='border-collapse: collapse' width='100%'>
            <tr>
                <td colspan='3' rowspan='2'>(Decreto 1.808 de retenciones de impuesto sobre la renta, Gaceta Oficial Nro. 36.203 del 12 de Mayo de 1.997)</td>
                <td colspan='2'> </td>

                <td align='center'>
                    <div>AÑO IMPOSITIVO</div>
                    <hr>
                </td>

                <td> </td>
                <td align='center'>
                    <div>FECHA DE EMISIÓN</div>
                    <hr>
                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan='2'> </td>

                <td align='center'> <?php echo $aimp ?> </td>

                <td></td>
                <td align='center'><?php echo $femi ?></td>
                <td></td>
            </tr>
            <tr>
                <td width='30%'></td>
                <td width='2%'></td>
                <td width='19%'></td>
                <td width='10%'></td>
                <td width='2%'></td>
                <td width='14%'></td>
                <td width='2%'></td>
                <td width='14%'></td>
                <td width='12%'></td>
            </tr>
            <tr>
                <td>
                    <div>NOMBRE DEL AGENTE DE RETENCIÓN</div>
                    <hr>
                </td>
                <td></td>
                <td colspan='2'>
                    <div>RIF DEL AGENTE</div>
                    <hr>
                </td>
                <td></td>
                <td align='center'>
                    <div>PERÍODO</div>
                    <hr>
                </td>
                <td colspan='3'></td>
            </tr>
            <tr>
                <td><?php echo $rzsoc ?></td>
                <td></td>
                <td colspan='2'><?php echo $rifEmp ?></td>
                <td width='2%'></td>
                <td align='center'><?php echo $perdf ?></td>
                <td colspan='3'></td>
            </tr>
            <tr>
                <td colspan='9'></td>
            </tr>
            <tr>
                <td colspan='4'>
                    <div>DIRECCIÓN FISCAL DEL AGENTE DE RETENCIÓN</div>
                    <hr>
                </td>
                <td width='2%'></td>
                <td width='10%'></td>
                <td colspan='3'></td>
            </tr>
            <tr>
                <td colspan='4'><?php echo $dir1 . ' ' . $dir2 . ' ' . $dir3 ?></td>
                <td width='2%'></td>
                <td width='10%'></td>
                <td colspan='3'></td>
            </tr>
            <tr>
                <td colspan='9'></td>
            </tr>
            <tr>
                <td>
                    <div>NOMBRE O RAZÓN SOCIAL DEL SUJETO RETENIDO</div>
                    <hr>
                </td>
                <td></td>
                <td colspan='2'>
                    <div>REGISTRO DE INFORMACIÓN FISCAL DEL SUJETO</div>
                    <hr>
                </td>
                <td></td>
                <td></td>
                <td colspan='3'></td>
            </tr>
            <tr>
                <td><?php echo $nempr ?></td>
                <td></td>
                <td colspan='2'><?php echo $rif ?></td>
                <td width='2%'></td>
                <td></td>
                <td colspan='3'></td>
            </tr>
            <tr>
                <td colspan='9'></td>
            </tr>
            <tr>
                <td colspan='4'>
                    <div>DIRECCIÓN FISCAL DEL SUJETO RETENIDO</div>
                    <hr>
                </td>
                <td width='2%'></td>
                <td width='10%'></td>
                <td colspan='3'></td>
            </tr>
            <tr>
                <td colspan='4'><?php echo $dirP1 . ' ' . $dirP2 . ' ' . $dirP3 ?></td>
                <td width='2%'></td>
                <td width='10%'></td>
                <td colspan='3'></td>
            </tr>
            <tr>
        </table>
        <br /><br />
        <?php
        $sql = ("SELECT RIGHT(LTRIM(RTRIM(IMP_nc_open3_period)),4) AS 'COL-1',
                        CASE
                            WHEN LEFT(LTRIM(RTRIM(IMP_nc_open3_period)),3)='M1' THEN '01'
                            WHEN LEFT(LTRIM(RTRIM(IMP_nc_open3_period)),3)='M2' THEN '02'
                            WHEN LEFT(LTRIM(RTRIM(IMP_nc_open3_period)),3)='M3' THEN '03'
                            WHEN LEFT(LTRIM(RTRIM(IMP_nc_open3_period)),3)='M4' THEN '04'
                            WHEN LEFT(LTRIM(RTRIM(IMP_nc_open3_period)),3)='M5' THEN '05'
                            WHEN LEFT(LTRIM(RTRIM(IMP_nc_open3_period)),3)='M6' THEN '06'
                            WHEN LEFT(LTRIM(RTRIM(IMP_nc_open3_period)),3)='M7' THEN '07'
                            WHEN LEFT(LTRIM(RTRIM(IMP_nc_open3_period)),3)='M8' THEN '08'
                            WHEN LEFT(LTRIM(RTRIM(IMP_nc_open3_period)),3)='M9' THEN '09'
                            WHEN LEFT(LTRIM(RTRIM(IMP_nc_open3_period)),3)='M10' THEN '10'
                            WHEN LEFT(LTRIM(RTRIM(IMP_nc_open3_period)),3)='M11' THEN '11'
                            WHEN LEFT(LTRIM(RTRIM(IMP_nc_open3_period)),3)='M12' THEN '12'
                        END AS 'COL-2',
                        SUM(IMP_nc_open3_basimp) AS 'COL-3',
                        IMP_nc_open3_porimp AS 'COL-4',
                        0 AS 'COL-5',
                        SUM((IMP_nc_open3_basimp * IMP_nc_open3_porimp)/100) AS 'COL-6'
                FROM IMPP3000
                WHERE open3_p = '" . $rif . "'
                AND RIGHT(LTRIM(RTRIM(IMP_nc_open3_period)),4) = '" . $ano . "'
                GROUP BY RIGHT(LTRIM(RTRIM(IMP_nc_open3_period)),4),LEFT(LTRIM(RTRIM(IMP_nc_open3_period)),3),IMP_nc_open3_porimp
                ORDER BY [COL-1],[COL-2]");

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
                <td width='10%' align='center' bgcolor='#EAEAEA'><b>Año</b></td>
                <td width='10%' align='center' bgcolor='#EAEAEA'><b>Mes</b></td>
                <td width='20%' align='center' bgcolor='#EAEAEA'><b>Cantidad Objeto de Retención (Bs.)</b></td>
                <td width='10%' align='center' bgcolor='#EAEAEA'><b>% Retención</b></td>
                <td width='15%' align='center' bgcolor='#EAEAEA'><b>Sustraendo (Bs.)</b></td>
                <td width='20%' align='center' bgcolor='#EAEAEA'><b>Importe ISLR (Bs.)</b></td>
            </tr>";
        $numrow = 1;
        //Totales
        $totret = 0;
        $totsus = 0;
        $totimp = 0;
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $tableIva .= "

            <tr>
                <td align='center'>" . $row['COL-1'] . "</td>
                <td align='center'>" . $row['COL-2'] . "</td>
                <td align='right'>" . number_format($row['COL-3'], 2, ',', '.') . "</td>
                <td align='right'>" . number_format($row['COL-4'], 2, ',', '.') . "</td>
                <td align='right'>" . number_format($row['COL-5'], 2, ',', '.') . "</td>
                <td align='right'>" . number_format($row['COL-6'], 2, ',', '.') . "</td>
            </tr>";
            $numrow++;
            $totret += $row['COL-3'];
            $totsus += $row['COL-5'];
            $totimp += $row['COL-6'];
        }
        $tableIva .= "
            <tr height='25'>
                <td align='right' colspan='2'>Totales (Bs.):</td>
                <td align='right'>" . number_format($totret, 2, ',', '.') . "</td>
                <td></td>
                <td align='right'>" . number_format($totsus, 2, ',', '.') . "</td>
                <td align='right'>" . number_format($totimp, 2, ',', '.') . "</td>
            </tr>
        </table>";
        echo $tableIva;
        ?>

        <table border='0' style='border-collapse: collapse' align=center width='100%'>
            <tr>
                <td align='center'>
                    <img src='<?php echo $FSello64 ?>' width='200px' height='100px'>
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
<?php
include_once "./vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;

$dompdf = new Dompdf();
$dompdf->setPaper('Letter', 'landscape');
$options = $dompdf->getOptions();
$dompdf->setOptions($options);
$dompdf->loadhtml(ob_get_clean());
$dompdf->render();
header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=documento.pdf");
$pdf = $dompdf->output();
$filename = "RETARCV";
//file_put_contents($filename, $pdf);
$dompdf->stream($rif. '_'.$filename.'_'.$doc);
//echo $dompdf->output();
?>