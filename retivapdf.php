<?php ob_start();
header('Content-Type: text/html; charset=UTF-8');
require_once "./conexion.php";

$hoy = date("d/m/Y");
$doc = $_POST["doc"];
$tipo = $_POST["tipo"];
$rif = $_POST["rif"];
$EMPRESA = $_POST["EMPRESA"];
$logoRet = "./images/" . $EMPRESA . "-logo-ret.png";
$logoRet64 = "data:image/png;base64," . base64_encode(file_get_contents($logoRet));
$FirmaySello = "./images/" . $EMPRESA . "-FirmaySello.png";
$FSello64 = "data:image/png;base64," . base64_encode(file_get_contents($FirmaySello));
$anulado = "./images/anulado.png";
$anulado64 = "data:image/png;base64," . base64_encode(file_get_contents($anulado));
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documento de IVA</title>
</head>

<style>
    @page {
        margin-left: 0.2cm;
        margin-right: 0.1cm;
        margin-top: 0.2cm;
        margin-bottom: 0.1cm;
    }

    body {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 20px;
        color: #000000;
        background-color: #ffffff;
        margin: 0px;
        padding: 0px;
    }

    .paginaVertical {
        width: 230mm;
        height: 279.4mm;
        margin: 2cm
    }

    .paginaHorizontal {
        width: 230mm;
        height: 189mm;
        margin: 1cm
    }

    .anulado {
        position: absolute;
        top: 400px;
        left: 350px;
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

    h5 {
        color: #000000;
        font-family: Verdana;
        font-size: 10pt;
        text-decoration: underline;
        margin-bottom: 10px;
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

    .cabecera {
        height: 40px;
        font-weight: normal;
    }

    .cabecera2 {
        height: 20px;
        font-weight: normal;
    }

    th {
        background-color: #EAEAEA;
    }

    .tbfont {
        font-size: 9px;
    }

    .tbfont2 {
        font-size: 6px;
    }

    .interno {
        font-weight: normal;
    }

    .unica {
        border-left: solid 1px;
        border-bottom: solid 1px;
        border-right: solid 1px;
        border-color: gray;
    }
</style>

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
    IMP_nc_open_nreten as '0',
    CONVERT(VARCHAR, IMP_nc_open_feccon, 103) AS '1',
    UPPER(CMPNYNAM) AS '2',
    CO_MI_rif000 AS '3',
    CONCAT('AÑO ',RIGHT(LTRIM(RTRIM(IMP_nc_open_period)),4),' / MES ',
	CASE
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=1 THEN 'ENERO'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=2 THEN 'FEBRERO'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=3 THEN 'MARZO'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=4 THEN 'ABRIL'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=5 THEN 'MAYO'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=6 THEN 'JUNIO'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=7 THEN 'JULIO'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=8 THEN 'AGOSTO'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=9 THEN 'SEPTIEMBRE'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=10 THEN 'OCTTUBRE'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=11 THEN 'NOVIEMBRE'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=12 THEN 'DICIEMBRE'
	END) AS '4',
    UPPER(LTRIM(RTRIM(ADDRESS1))) AS '5.1',
    UPPER(LTRIM(RTRIM(ADDRESS2))) AS '5.2',
    UPPER(CONCAT(LTRIM(RTRIM(ADDRESS3)),', ',LTRIM(RTRIM(CITY)),', ',LTRIM(RTRIM(STATE)))) AS '5.3',
    UPPER(IMP_nc_open_nompro) AS '6',
    open_p as '7',
    PV_MI_direc1 as '8.1',
	PV_MI_direc2 as '8.2',
	PV_MI_direc3 as '8.3'
    FROM IMPP2001
    INNER JOIN DYNAMICS.dbo.SY01500 on INTERID = DB_NAME()
    INNER JOIN IMPC0001 on CO_MI_idcomp = DB_NAME()
    INNER JOIN IMPP0161 ON PV_MI_rif000 = open_p
    WHERE open_p = '" . $rif . "'
    AND IMP_nc_open_numfac = '" . $doc . "'");
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
    <div id="" Class="paginaHorizontal">
        <table border='0' style="width:100%; height:60px;">
            <tr>
                <td width='200'>
                    <img src="<?php echo $logoRet64 ?>" width="205" height="72" border="0" alt="">
                </td>
                <td valign='top' align='center'>
                    <h4>COMPROBANTE DE RETENCIÓN DE IVA</h4>
                </td>
            </tr>
        </table>
        <table border='0' style='border-collapse: collapse' align=center width='100%'>
            <tr>
                <td colspan="2">(Ley IVA - Art. 11: La administración Tributaria podrá designar como responsables del pago del impuesto, en calidad de agentes de retención a quienes por sus funciones publicas o por razón de sus actividades privadas intervengan en operaciones gravadas con el impuesto establecido en este decreto con rango, valor y fuerza de ley)</td>
            </tr>
            <tr>
                <td style="width:200px;">
                    <h5>Datos de la Transacción:</h5>
                </td>
                <td style="width:500px;"></td>
            </tr>
            <tr>
                <td style="width:200px;">Nº del Comprobante:</td>
                <td style="width:500px;">Fecha de Emisión:</td>
            </tr>
            <tr>
                <td style="width:200px; font-weight: normal;"><?php echo $ncomp ?></td>
                <td style="width:500px; font-weight: normal"><?php echo $fecha ?></td>
            </tr>
            <tr>
                <td style="width:200px;">Periodo Fiscal:</td>
                <td style="width:500px;">&nbsp;</td>
            </tr>
            <tr>
                <td style="width:200px; font-weight: normal;"><?php echo $perdf ?></td>
                <td style="width:500px; font-weight: normal">&nbsp;</td>
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
                <td style="width:500px;"><b>&nbsp;</b></td>
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
        <table border='0' style='border-collapse: collapse' align=center width='100%'>
            <tr>
                <td width='43%'></td>
                <td width='33%'>
                    <table border='1' width='100%' style='border-collapse: collapse' bordercolor='#000000'>
                        <tr>
                            <td align='center' bgcolor='#EAEAEA'><b>Compras Internas o Importaciones</b></td>
                        </tr>
                    </table>
                </td>
                <td width='7%'></td>
            </tr>
        </table>

        <?php
        $sql = ("SELECT IMP_nc_open_numope AS 'col-1',
                CONVERT(VARCHAR, IMP_nc_open_fecdoc, 103) AS 'col-2',
                IMP_nc_open_numfac AS 'col-3',
                IMP_nc_open_ncontro AS 'col-4',
                IMP_nc_open_numntd AS 'col-5',
                IMP_nc_open_numntc AS 'col-6',
                CASE
                    WHEN IMP_nc_open_tiptra = 1 THEN '01-Reg'
                    WHEN IMP_nc_open_tiptra = 2 THEN '02-Comp'
                    WHEN IMP_nc_open_tiptra = 3 THEN '03-Anul'
                    ELSE '04-Ajuste'
                END AS 'col-7',
                IMP_nc_open_facafe AS 'col-8',
                STR(IIF(IMP_nc_open_tipdoc = 4, IMP_nc_open_cociva * -1, IMP_nc_open_cociva),9,2) AS 'col-9',
                STR(IMP_nc_open_cosiva,9,2) AS 'col-10',
                STR(IIF(IMP_nc_open_tipdoc = 4, IMP_basimp_alicgene * -1, IMP_basimp_alicgene),9,2) AS 'col-11',
                STR(IMP_porceimp_alicgene,9,2) AS 'col-12',
				STR(IIF(IMP_nc_open_tipdoc = 4, IMP_montoimp_alicgene * -1, IMP_montoimp_alicgene),9,2) AS 'col-13',
				STR(IIF(IMP_nc_open_tipdoc = 4, IMP_basimp_alicreduc * -1, IMP_basimp_alicreduc),9,2) AS 'col-14',
                STR(IMP_porceimp_alicreduc,9,2) AS 'col-15',
				STR(IIF(IMP_nc_open_tipdoc = 4, IMP_montoimp_alicreduc * -1, IMP_montoimp_alicreduc),9,2) AS 'col-16',
				STR(IIF(IMP_nc_open_tipdoc = 4, IMP_basimp_alicadic * -1, IMP_basimp_alicadic),9,2) AS 'col-17',
                STR(IMP_porceimp_alicadic,9,2) AS 'col-18',
				STR(IIF(IMP_nc_open_tipdoc = 4, IMP_montoimp_alicadic * -1, IMP_montoimp_alicadic),9,2) AS 'col-19',
                CASE
                    WHEN IMP_porcrete_alicgene != 0 THEN STR(ABS(IMP_porcrete_alicgene),9,2)
                    WHEN IMP_porcrete_alicreduc != 0 THEN STR(ABS(IMP_porcrete_alicreduc),9,2)
                    ELSE STR(ABS(IMP_porcrete_alicadic),9,2)
                END AS 'col-20',
				IIF(IMP_nc_open_numntc='',STR(ABS(IMP_nc_open_ivaret),9,2),STR(IMP_nc_open_ivaret,9,2)) AS 'col-21'
            FROM IMPP2001
            WHERE open_p = '" . $rif . "'
            AND IMP_nc_open_numfac = '" . $doc . "'
            OR IMP_nc_open_facafe = '" . $doc . "'");

        $stmt = sqlsrv_query($conn, $sql);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $tableIva =

            "<table class='tbfont2' border='1' style='border-collapse: collapse' align='center' width='100%'>
            <tr>
                <td align='center' bgcolor='#EAEAEA'><b>Fecha de la Factura</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Número Factura</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Número Control</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Número ND</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Número NC</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Tipo de Trans.</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Factura Afectada</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Total Compras Incl. IVA</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Total Compras Exentas</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Total Base Imp Alic. General</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>% Alíc</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Total Imp. Causado IVA Gral.</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Total Base Imp Alic. Reduc.</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>% Alíc</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Total Imp. Causado IVA Reduc.</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Total Base Imp Alic. Adic.</b></td>               
                <td align='center' bgcolor='#EAEAEA'><b>% Alíc</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Total Imp. Causado IVA Adic.</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>% Ret</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Total Monto del Imp. Retenido</b></td>
            </tr>";

        $numrow = 1;
        //Totales
        $totcciva = 0;
        $totcsiva = 0;
        $totbimp = 0;
        $totimp = 0;
        $totivaret = 0;
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $tableIva .=
            "
            <tbody>
            <tr class='interno'>
                <td width='5%' align='center'>" . $row['col-2'] . "</td> 
                <td width='5%' align='center'>" . $row['col-3'] . "</td>
                <td width='5%' align='center'>" . $row['col-4'] . "</td>
                <td width='5%' align='center'>" . $row['col-5'] . "</td>
                <td width='5%' align='center'>" . $row['col-6'] . "</td>
                <td width='4%' align='center'>" . $row['col-7'] . "</td>
                <td width='5%' align='center'>" . $row['col-8'] . "</td>
                <td width='6%' align='right'>" . number_format($row['col-9'], 2, ',', '.') . "</td>
                <td width='6%' align='right'>" . number_format($row['col-10'], 2, ',', '.') . "</td>
                <td width='6%' align='right'>" . number_format($row['col-11'], 2, ',', '.') . "</td>
                <td width='3%' align='right'>" . number_format($row['col-12'], 2, ',', '.') . "</td>
                <td width='6%' align='right'>" . number_format($row['col-13'], 2, ',', '.') . "</td>
                <td width='6%' align='right'>" . number_format($row['col-14'], 2, ',', '.') . "</td>
                <td width='3%' align='right'>" . number_format($row['col-15'], 2, ',', '.') . "</td>
                <td width='6%' align='right'>" . number_format($row['col-16'], 2, ',', '.') . "</td>
                <td width='6%' align='right'>" . number_format($row['col-17'], 2, ',', '.') . "</td>
                <td width='3%' align='right'>" . number_format($row['col-18'], 2, ',', '.') . "</td>
                <td width='6%' align='right'>" . number_format($row['col-19'], 2, ',', '.') . "</td>
                <td width='3%' align='right'>" . number_format($row['col-20'], 2, ',', '.') . "</td>
                <td width='6%' align='right'>" . number_format($row['col-21'], 2, ',', '.') . "</td>
            </tr>";
            $numrow++;
            $totcciva += $row['col-9'];
            $totcsiva += $row['col-10'];
            $totbimp += $row['col-11'];
            $totimp += $row['col-13'];
            $totivaret += $row['col-21'];
        }
        $tableIva .=
        "
        </tbody>
        </table>
        <table class='tbfont2' border='0' style='border-collapse: collapse' align='center' width='100%'>
            <tr height='25'>
                <td width='94%' align='right'>Totales Impuesto Retenido:</td>
                <td class='unica' align='right'>" . number_format($totivaret, 2, ',', '.') . "</td>
            </tr>
        </table>
        ";
        echo $tableIva;
        ?>
        <table border='0' style='border-collapse: collapse' align=center width='100%'>
            <tr>
                <td width='20%'></td>
                <td width='20%'></td>
                <td width='20%'></td>
                <td width='20%'></td>
                <td width='20%'></td>
            </tr>
            <tr>
                <td width='20%'></td>
                <td width='20%' align='center'><img src='<?php echo $FSello64 ?>' width='200px' height='100px'></td>
                <td width='20%'></td>
                <td width='20%'></td>
                <td width='20%'></td>
            </tr>
            <tr>
                <td width='20%'></td>
                <td width='20%' align='center'>______________________________________<br />Firma y sello del agente de retención <br /></td>
                <td width='20%'></td>
                <td width='20%' align='center'>______________________________________<br />Nombre, firma y sello del proveedor <br />Fecha de Descarga:<?php echo ' ' . $hoy ?></td>
                <td width='20%'></td>
            </tr>
        </table>
    </div>
    <?php
    if ($totivaret == 0) {
        echo
        '<div class="anulado">
            <img src="' . $anulado64 . '" height="35px" alt="">
        </div>';
    }
    ?>
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
$filename = "RETIVA";
$dompdf->stream($rif . '_' . $filename . '_' . $doc);
?>