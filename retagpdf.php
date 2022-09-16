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
    <title>Documento de RETAG</title>
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
        width: 100%;
    }

    div {
        color: #000000;
        font-family: verdana;
        font-size: 8pt;
        font-weight: bold;
    }

    th {
        background-color: #EAEAEA;
    }

    .Tabletot {
        width: 1000px;
        border-collapse: collapse;
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
    IMP_gene_corr as '0',
    CONVERT(VARCHAR, IMP_gene_feccon, 103) AS '1',
    UPPER(CMPNYNAM) AS '2',
    TAXREGTN AS '3',
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
    UPPER(TRIM(ADDRESS1)) AS '5.1',
    UPPER(TRIM(ADDRESS2)) AS '5.2',
    UPPER(CONCAT(TRIM(ADDRESS3),', ',TRIM(CITY),', ',TRIM(STATE))) AS '5.3',
    UPPER(IMP_gene_nompro) AS '6',
    IMP_gene_rif000 as '7',
	PV_MI_direc1 as '8.1',
	PV_MI_direc2 as '8.2',
	PV_MI_direc3 as '8.3'
    FROM IMPP4000
    INNER JOIN DYNAMICS.dbo.SY01500 on INTERID = DB_NAME()
	INNER JOIN IMPP0161 on PV_MI_idprov = IMP_gene_rif000
    WHERE IMP_gene_rif000 =  '" . $rif . "'
    AND IMP_gene_corr != ''
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
    <center>
        <h4>COMPROBANTE DE RETENCIÓN MUNICIPAL ALCALDIA DE GIRARDOT</h4>
    </center>
    <div id="encabezado" class="paginaHorizontal" style="margin-top: -10px ;">
        <table border="0">
            <thead>
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
                    <td style="width:500px; font-weight: normal;"><?php echo $rzsoc ?></td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px; font-weight: normal"><?php echo $nempr ?></td>
                </tr>
                <tr>
                    <td style="width:500px;"><b>Nº de Licencia de Actividades Económicas:</b></td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px;"><b>Nº de Licencia del Sujeto Retenido:</b></td>
                </tr>
                <tr>
                    <td style="width:500px; font-weight: normal;">1234567890123</td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px; font-weight: normal">9876543210987</td>
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
                    <td style="width:500px; font-weight: normal;"><?php echo $dir1 ?></td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px; font-weight: normal;"><?php echo $dirP1 ?></td>
                </tr>
                <tr>
                    <td style="width:500px; font-weight: normal;"><?php echo $dir2 ?></td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px; font-weight: normal;"><?php echo $dirP2 ?></td>
                </tr>
                <tr>
                    <td style="width:500px; font-weight: normal;"><?php echo $dir3 ?></td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px; font-weight: normal;"><?php echo $dirP3 ?></td>
                </tr>
                <tr>
                    <td style="width:500px;">
                        <h5>Datos de la Transacción:</h5>
                    </td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px;">
                        <h5></h5>
                    </td>
                </tr>
                <tr>
                    <td style="width:500px;">Periodo Fiscal:</td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px;">Nº del Comprobante</td>
                </tr>
                <tr>
                    <td style="width:500px; font-weight: normal;"><?php echo $perdf ?></td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px; font-weight: normal"><?php echo $ncomp ?></td>
                </tr>
                <tr>
                    <td style="width:500px;">Fecha de Emisión:</td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px;">Nº de la Operación de la Contabilidad de la Empresa</td>
                </tr>
                <tr>
                    <td style="width:500px; font-weight: normal;"><?php echo $fecha ?></td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="width:500px; font-weight: normal">4.948</td>
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
                            IMP_gene_numfaf AS 'COL-6',
                            IMP_gene_acteco AS 'COL-7',
                            IMP_gene_basimp AS 'COL-8',
                            '' AS 'COL-9',
                            IMP_gene_monimp AS 'COL-10'
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
            ?>
            <tfoot>
                <table border="1" class="Tabletot">
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
                            $tableIva .= '
                        <tr>
                            <td style="font-weight: normal;">' . $row['COL-1'] . '</td>
                            <td style="font-weight: normal;">' . $row['COL-2'] . '</td>
                            <td style="font-weight: normal;">' . $row['COL-3'] . '</td>
                            <td style="font-weight: normal;">' . $row['COL-4'] . '</td>
                            <td style="font-weight: normal;">' . $row['COL-5'] . '</td>
                            <td style="font-weight: normal;">' . $row['COL-6'] . '</td>
                            <td style="font-weight: normal;">' . $row['COL-7'] . '</td>
                            <td style="font-weight: normal; text-align: right;">' . number_format($row['COL-8'], 2, ',', '.') . '</td>
                            <td style="font-weight: normal; text-align: right;">' . $row['COL-9'] . '</td>
                            <td style="font-weight: normal; text-align: right;">' . number_format($row['COL-10'], 2, ',', '.') . '</td>
                        </tr>';
                            $numrow++;
                            $totret += $row['COL-10'];
                        }
                        echo $tableIva;
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="text-align: right;" colspan="9">Total Impuesto Municipal Retenido</td>
                            <td style="text-align: right;"><?php echo number_format($totret, 2, ',', '.') ?></td>
                        </tr>
                    </tfoot>
                </table>
            </tfoot>
        </table>
        <table>
            <tr>
                <td width='20%'></td>
                <td width='20%' align='center'><img src='<?php echo $FSello64 ?>' width='200px' height='100px'></td>
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
                <td width='20%'></td>
                <td width='20%'></td>
                <td width='20%' align='center'>Fecha de Recepción<br /></td>
                <td width='20%'></td>
            </tr>
        </table>
    </div>

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
$filename = "RETAG";
$dompdf->stream($rif . '_' . $filename . '_' . $doc);
?>