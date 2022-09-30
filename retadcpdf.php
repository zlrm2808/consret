<?php ob_start();

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
    <title>Documento de ADC</title>
</head>

<style>
    @page {
        margin-left: 0.5cm;
        margin-right: 0.5cm;
        margin-top: 1cm;
        margin-bottom: 0.5cm;
    }

    @page {
        margin-left: 0.1cm;
        margin-right: 0.05cm;
        margin-top: 0.1cm;
        margin-bottom: 0.05cm;
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
        top: 430px;
        left: 300px;
    }

    .anulado2 {
        position: absolute;
        top: 370px;
        left: 350px;
    }

    .anulado3 {
        position: absolute;
        top: 340px;
        left: 310px;
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
        font-size: 7px;
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


    include_once("conexion.php");

    // Con esta Consulta saco el encabezado de las retenciones

    $sql = ("SELECT TOP 1
    IMP_gene_ncompr as '0',
    CONVERT(VARCHAR, IMP_gene_feccon, 103) AS '1',
    UPPER(CMPNYNAM) AS '2',
    CO_MI_rif000 AS '3',
    CONCAT('AÑO ',LEFT(CONVERT(VARCHAR,IMP_gene_fecdoc,23),4),' / MES ',
	CASE
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=1 THEN 'ENERO'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=2 THEN 'FEBRERO'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=3 THEN 'MARZO'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=4 THEN 'ABRIL'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=5 THEN 'MAYO'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=6 THEN 'JUNIO'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=7 THEN 'JULIO'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=8 THEN 'AGOSTO'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=9 THEN 'SEPTIEMBRE'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),6,2)=10 THEN 'OCTUBRE'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),5,2)=11 THEN 'NOVIEMBRE'
		WHEN SUBSTRING(CONVERT(VARCHAR,IMP_gene_fecdoc,23),5,2)=12 THEN 'DICIEMBRE'
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
    INNER JOIN IMPC0001 on CO_MI_idcomp = DB_NAME()
	INNER JOIN IMPP0161 on PV_MI_idprov = IMP_gene_rif000
    WHERE IMP_gene_rif000 =  '" . $rif . "'
    AND IMP_gene_detimp LIKE '%MUN%'
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
        <table border='0' style='border-collapse: collapse' align=center width='100%'>
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
            <td style="width:45%;">
                <h5>Datos de Identificacion del Sujeto Retenido</h5>
            </td>
            <tr>
                <td style="width:400px;"><b>Nombre o Razón Social:</b></td>
                <td style="width:500px;"><b>Nombre o Razón Social:</b></td>
            </tr>
            <tr>
                <td style="width:400px; font-weight: normal;"><?php echo utf8_encode($rzsoc) ?></td>
                <td style="width:500px; font-weight: normal"><?php echo utf8_encode($nempr) ?></td>
            </tr>
            <tr>
                <td style="width:400px;"><b>Nº de Registro de Información Fiscal:</b></td>
                <td style="width:500px;"><b>Nº de Registro de Información Fiscal:</b></td>
            </tr>
            <tr>
                <td style="width:400px; font-weight: normal;"><?php echo $rifEmp ?></td>
                <td style="width:500px; font-weight: normal"><?php echo $rif ?></td>
            </tr>
            <tr>
                <td style="width:400px;"><b>Dirección Fiscal:</b></td>
                <td style="width:500px;"><b>Dirección Fiscal:</b></td>
            </tr>
            <tr>
                <td style="width:400px; font-weight: normal;"><?php echo utf8_encode($dir1) ?></td>
                <td style="width:500px; font-weight: normal;"><?php echo utf8_encode($dirP1) ?></td>
            </tr>
            <tr>
                <td style="width:400px; font-weight: normal;"><?php echo utf8_encode($dir2) ?></td>
                <td style="width:500px; font-weight: normal;"><?php echo utf8_encode($dirP2) ?></td>
            </tr>
            <tr>
                <td style="width:400px; font-weight: normal;"><?php echo utf8_encode($dir3) ?></td>
                <td style="width:500px; font-weight: normal;"><?php echo utf8_encode($dirP3) ?></td>
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
                AND IMP_gene_detimp LIKE '%MUN%' 
                AND IMP_gene_numdoc = '" . $doc . "'
                UNION
                SELECT IMP_gene_nopera AS 'COL-1', 
                    CONVERT(VARCHAR, IMP_gene_fecdoc, 103) AS 'COL-2', 
                    '' AS 'COL-3', 
                    IMP_gene_ncontr AS 'COL-4', 
                    IMP_gene_numntd AS 'COL-5', 
                    IMP_gene_numntc AS 'COL-6',  
                    CASE 
                        WHEN IMP_gene_tiptra = 1 THEN '01-Registro' 
                        WHEN IMP_gene_tiptra = 2 THEN '02-Complemento' 
                        WHEN IMP_gene_tiptra = 3 THEN '03-Anulacion' 
                        ELSE '04-Ajuste' END AS 'COL-7', 
                    IMP_gene_numfaf AS 'COL-8', 
                    IMP_gene_montabon AS 'COL-9', 
                    IMP_gene_basimp AS 'COL-10', 
                    IMP_gene_porimp AS 'COL-11', 
                    IMP_gene_monimp AS 'COL-12', 
                    IMP_gene_detimp AS 'COL-13' 
                FROM IMPP4300
                WHERE IMP_gene_rif000 = '" . $rif . "'
                AND IMP_gene_detimp LIKE '%MUN%' 
                AND IMP_gene_numfaf = '" . $doc . "'");

        $stmt = sqlsrv_query($conn, $sql);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $tableIva =
            "<table border='1' style='border-collapse: collapse' align='center' width='900px'>
            <tr>
                <td align='center' bgcolor='#EAEAEA'><b>Fecha Documento</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Nº Factura</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Nº Control</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Nº Nota Débito</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Nº Nota Crédito</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Tipo TRX</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Nº Fac Afectada</b></td>
                <td align='center' bgcolor='#EAEAEA'><b>Monto Pagado o Abonado en Cuenta</b></td>
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
            <tr class='interno'>
                <td width='8%'align='center'>" . $row['COL-2'] . "</td>
                <td width='6%' align='center'>" . $row['COL-3'] . "</td>
                <td width='8%' align='center'>" . $row['COL-4'] . "</td>
                <td width='10%' align='center'>" . $row['COL-5'] . "</td>
                <td width='10%' align='center'>" . $row['COL-6'] . "</td>
                <td width='10%' align='center'>" . $row['COL-7'] . "</td>
                <td width='10%' align='center'>" . $row['COL-8'] . "</td>
                <td width='10%' align='right'>" . number_format($row['COL-9'], 2, ',', '.') . "</td>
                <td width='8%' align='right'>" . number_format($row['COL-10'], 2, ',', '.') . "</td>
                <td width='3%' align='right'>" . number_format($row['COL-11'], 2, ',', '.') . "</td>
                <td width='7%' align='right'>" . number_format($row['COL-12'], 2, ',', '.') . "</td>
                <td width='7%' align='center'>" . $row['COL-13'] . "</td>
            </tr>";
            $numrow++;
            $totret += $row['COL-12'];
        }
        $tableIva .= "
        </table>
        <table border='0' style='border-collapse: collapse' align='center' width='900px'>
            <tr>
                <td width='85.7%' align='right'>Totales (Bs.):</td>
                <td class='unica' width='7%' align='right'>" . number_format($totret, 2, ',', '.') . "</td>
                <td width='7%' align='right'>&nbsp;</td>
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
                <td align='center'><?php echo utf8_encode($rzsoc) . '(SELLO Y FIRMA)' ?><br />Fecha de Descarga:<?php echo ' ' . $hoy ?></td>
                </td>
                <td align='center'>RECIBIDO CONFORME POR</td>
            </tr>
            <tr>
            </tr>
        </table>
    </div>
    <?php
    if ($totret == 0) {
        echo
        '<div class="anulado3">
            <img src="' . $anulado64 . '" height="35px" alt="">
        </div>';
    }
    ?>
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
$filename = "RETADC";
$dompdf->stream($rif . '_' . $filename . '_' . $doc);
?>