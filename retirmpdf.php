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
    <title>Documento de IRM</title>
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


include_once("conexion.php");

// Con esta Consulta saco el encabezado de las retenciones

$sql = ("SELECT TOP 1
    IMP_gene_ncompr as '0',
    CONVERT(VARCHAR, IMP_gene_feccon, 103) AS '1',
    UPPER(CMPNYNAM) AS '2',
    TAXREGTN AS '3',
    CONCAT('AÑO ',LEFT(CONVERT(VARCHAR,IMP_gene_fecdoc,23),4),' / MES ',
	CASE
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=1 THEN 'ENE'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=2 THEN 'FEB'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=3 THEN 'MAR'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=4 THEN 'ABR'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=5 THEN 'MAY'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=6 THEN 'JUN'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=7 THEN 'JUL'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=8 THEN 'AGO'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=9 THEN 'SEP'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=10 THEN 'OCT'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),5,2)=11 THEN 'NOV'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),5,2)=12 THEN 'DIC'
	END) AS '4',
    UPPER(LTRIM(RTRIM(ADDRESS1))) AS '5.1',
    UPPER(LTRIM(RTRIM(ADDRESS2))) AS '5.2',
    UPPER(CONCAT(LTRIM(RTRIM(ADDRESS3)),', ',LTRIM(RTRIM(CITY)),', ',LTRIM(RTRIM(STATE)))) AS '5.3',
    UPPER(IMP_gene_nompro) AS '6',
    IMP_gene_rif000 as '7',
	PV_MI_direc1 as '8.1',
	PV_MI_direc2 as '8.2',
	PV_MI_direc3 as '8.3'
    FROM IMPP4000
    INNER JOIN DYNAMICS.dbo.SY01500 on INTERID = DB_NAME()
	INNER JOIN IMPP0161 on PV_MI_idprov = IMP_gene_rif000
    WHERE IMP_gene_rif000 =  '" . $rif . "'
    AND IMP_gene_numdoc = '" . $doc . "'");
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
                <img src="<?php echo $logoRet64 ?>" width="205" height="72" border="0" alt="">
            </td>
            <td valign='top' align='center'>
                <h4>COMPROBANTE DE RETENCIÓN DE IMPUESTO MUNICIPAL</h4>
            </td>
        </tr>
    </table>

    <table border='0' style='border-collapse: collapse' width='100%'>
        <tr>
            <td colspan='3' rowspan='2'>(Decreto 1.808 de retenciones de impuesto sobre la renta, Gaceta Oficial Nro. 36.203 del 12 de Mayo de 1.997)</td>
            <td colspan='2'> </td>

            <td align='center'>
                <div>Nº COMPROBANTE</div>
                <div class="hr">
                    <hr />
                </div>
            </td>

            <td> </td>
            <td align='center'>
                <div>FECHA DE EMISIÓN</div>
                <div class="hr">
                    <hr />
                </div>
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan='2'> </td>

            <td align='center'> <?php echo $ncomp ?> </td>

            <td></td>
            <td align='center'> <?php echo $fecha ?> </td>
            <td></td>
        </tr>
        <tr>
            <td colspan='2'>&nbsp;</td>
            <td align='center'>&nbsp;</td>
            <td>&nbsp;</td>
            <td align='center'>&nbsp;</td>
            <td>&nbsp;</td>
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
                <div class="hr">
                    <hr />
                </div>
            </td>
            <td></td>
            <td colspan='2'>
                <div>RIF DEL AGENTE DE RETENCIÓN</div>
                <div class="hr">
                    <hr />
                </div>
            </td>
            <td></td>
            <td align='center'>
                <div>PERÍODO FISCAL</div>
                <div class="hr">
                    <hr />
                </div>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan='2'>&nbsp;</td>
            <td width='2%'>&nbsp;</td>
            <td align='center'>&nbsp;</td>
            <td colspan='3'>&nbsp;</td>
        </tr>
        <tr>
            <td colspan='9'></td>
        </tr>
        <tr>
            <td colspan='4'>
                <div>DIRECCIÓN FISCAL DEL AGENTE DE RETENCIÓN</div>
                <div class="hr">
                    <hr />
                </div>
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
            <td colspan='4'>&nbsp;</td>
            <td width='2%'>&nbsp;</td>
            <td width='10%'>&nbsp;</td>
            <td colspan='3'>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <div>NOMBRE O RAZÓN SOCIAL DEL SUJETO RETENIDO</div>
                <div class="hr">
                    <hr />
                </div>
            </td>
            <td></td>
            <td colspan='2'>
                <div>REGISTRO DE INFORMACIÓN FISCAL DEL SUJETO</div>
                <div class="hr">
                    <hr />
                </div>
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
    </table>
    <br /><br />

    <?php
    $sql = ("SELECT IMP_gene_nopera AS 'COL-1',
						CONVERT(VARCHAR, IMP_gene_fecdoc, 103) AS 'COL-2',
                        IMP_gene_numdoc AS 'COL-3',
                        IMP_gene_ncontr AS 'COL-4',
						IMP_gene_numntd AS 'COL-5',
						IMP_gene_numntc AS 'COL-6',
                        CASE
                            WHEN IMP_gene_tiptra = 1 THEN '01-Registro'
                            WHEN IMP_gene_tiptra = 2 THEN '02-Complemento'
                            WHEN IMP_gene_tiptra = 3 THEN '03-Anulacion'
                            ELSE '04-Ajuste'
                        END AS 'COL-7',
						IMP_gene_numfaf AS 'COL-8',
						IMP_gene_montabon AS 'COL-9',
						IMP_gene_basimp AS 'COL-10',
						IMP_gene_porimp AS 'COL-11',
						IMP_gene_monimp AS 'COL-12',
						IMP_gene_detimp AS 'COL-13'
                FROM IMPP4000
                WHERE IMP_gene_rif000 = '" . $rif . "'
                AND IMP_gene_numdoc = '" . $doc . "'");

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
                <td align='center' bgcolor='#EAEAEA'><b>Nº Oper</b></td>            
                <td align='center' bgcolor='#EAEAEA'><b>Fecha Documento</b></td>
                <td width='90' align='center' bgcolor='#EAEAEA'><b>Nº Factura</b></td>
                <td width='7%' align='center' bgcolor='#EAEAEA'><b>Nº Control</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Nº Nota Débito</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Nº Nota Crédito</b></td>
                <td width='11%' align='center' bgcolor='#EAEAEA'><b>Tipo TRX</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Nº Fac Afectada</b></td>
                <td width='12%' align='center' bgcolor='#EAEAEA'><b>Monto Pagado o Abonado en Cuenta</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Base de Retención</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>% Ret</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Total Retenido</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>ID Detalle Retención</b></td>
            </tr>";

    $numrow = 1;
    //Totales
    $totret = 0;
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $tableIva .= "
            <tr>
                <td align='center'>" . $row['COL-1'] . "</td>
                <td align='center'>" . $row['COL-2'] . "</td>
                <td align='center'>" . $row['COL-3'] . "</td>
                <td align='center'>" . $row['COL-4'] . "</td>
                <td align='center'>" . $row['COL-5'] . "</td>
                <td align='center'>" . $row['COL-6'] . "</td>
                <td align='center'>" . $row['COL-7'] . "</td>
                <td align='center'>" . $row['COL-8'] . "</td>
                <td align='right'>" . number_format($row['COL-9'], 2, ',', '.') . "</td>
                <td align='right'>" . number_format($row['COL-10'], 2, ',', '.') . "</td>
                <td align='right'>" . number_format($row['COL-11'], 2, ',', '.') . "</td>
                <td align='right'>" . number_format($row['COL-12'], 2, ',', '.') . "</td>
                <td align='center'>" . $row['COL-13'] . "</td>
            </tr>";
        $numrow++;
        $totret += $row['COL-12'];
    }
    $tableIva .= "

            <tr height='25'>
                <td align='right' colspan='6'>Totales (Bs.):</td>
                <td align='right'></td>
                <td align='right'></td>
                <td align='right'></td>
                <td></td>
                <td align='right'></td>
                <td align='right'>" . number_format($totret, 2, ',', '.') . "</td>
                <td align='right'></td>
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
            <td align='center'>_______________________________________________________</td>
        </tr>
        <tr>
            <td align='center'><?php echo $rzsoc . '' ?>(SELLO Y FIRMA)</td>
            <td align='center'>RECIBIDO CONFORME POR</td>
        </tr>
    </table>
</div>
</body>
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
$filename = "RETIRM";
$dompdf->stream($rif . '_' . $filename . '_' . $doc);
?>