<?php

$hoy = date("d/m/Y");
$doc = $_POST["doc"];
$tipo = $_POST["tipo"];
$rif = $_POST["rif"];
$logoRet = "./images/logo-ret.png";
$logoRet64 = "data:image/png;base64," . base64_encode(file_get_contents($logoRet));
$FirmaySello = "./images/FirmaySello.png";
$FSello64 = "data:image/png;base64," . base64_encode(file_get_contents($FirmaySello));

include_once("conexion.php");

$html = '
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/retenciones.css" rel="stylesheet" />
    <title>Documento de IVA</title>
</head>

<body>';

    $sql = ('SELECT TOP 1
    IMP_nc_open_nreten as "0",
    CONVERT(VARCHAR, IMP_nc_open_feccon, 103) AS "1",
    UPPER(CMPNYNAM) AS "2",
    TAXREGTN AS "3",
    CONCAT("AÑO ",RIGHT(TRIM(IMP_nc_open_period),4)," / MES ",
	CASE
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=1 THEN "ENE"
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=2 THEN "FEB"
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=3 THEN "MAR"
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=4 THEN "ABR"
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=5 THEN "MAY"
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=6 THEN "JUN"
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=7 THEN "JUL"
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=8 THEN "AGO"
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=9 THEN "SEP"
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=10 THEN "OCT"
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=11 THEN "NOV"
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=12 THEN "DIC"
	END) AS "4",
    UPPER(TRIM(ADDRESS1)) AS "5.1",
    UPPER(TRIM(ADDRESS2)) AS "5.2",
    UPPER(CONCAT(TRIM(ADDRESS3),", ",TRIM(CITY),", ",TRIM(STATE))) AS "5.3",
    UPPER(IMP_nc_open_nompro) AS "6",
    open_p as "7"
    FROM IMPP2001
    INNER JOIN DYNAMICS.dbo.SY01500 on INTERID = DB_NAME()
    WHERE open_p = ' . $rif . '
    AND IMP_nc_open_numfac = ' . $doc);

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
    }
echo $sql;
echo $ncomp;
echo $fecha;
echo $rzsoc;
echo $rifEmp;
echo $perdf;
echo $dir1;
echo $dir2;
echo $dir3;
echo $nempr;
die;

$html .=
    '<div id="" Class="paginaHorizontal">
        <table border="0" style="width:80%; height:30px; margin-top:-35px;">
            <tr>
                <td width="200">
                    <img src="'. $logoRet64 .'" width="205" height="72" border="0" alt="">
                </td>
                <td valign="top" align="center">
                    <h4>COMPROBANTE DE RETENCIÓN DE IVA</h4>
                </td>
            </tr>
        </table>
        <table border="0" style="border-collapse: collapse;" width="110%" style="margin-top:-10px;">
            <tr>
                <td colspan="4" rowspan="2">(Ley IVA - Art. 11: La administración Tributaria podrá designar como responsables del pago del impuesto, en calidad de agentes de retención a quienes por sus funciones publicas o por razón de sus actividades privadas intervengan en operaciones gravadas con el impuesto establecido en este decreto con rango, valor y fuerza de ley)</td>
                <td colspan="1"></td>
                <td align="center">
                    <div>Nº COMPROBANTE</div>
                    <div class="hr">
                        <hr />
                    </div>
                </td>
                <td></td>
                <td align="center">
                    <div>FECHA DE EMISIÓN</div>
                    <div class="hr">
                        <div class="hr">
                            <hr />
                        </div>
                    </div>
                </td>
                <td colspan="1"></td>
            </tr>
            <tr>
                <td colspan="1"></td>
                <td align="center">'.$ncomp.' </td>
                <td></td>
                <td align="center">'.$fecha.'</td>
                <td></td>
            </tr>
            <tr>
                <td width="30%"></td>
                <td width="2%"></td>
                <td width="19%"></td>
                <td width="10%"></td>
                <td width="2%"></td>
                <td width="14%"></td>
                <td width="2%"></td>
                <td width="14%"></td>
                <td width="12%"></td>
            </tr>
            <tr>
                <td>
                    <div>NOMBRE DEL AGENTE DE RETENCIÓN</div>
                    <div Class="hr">
                        <hr />
                    </div>
                </td>
                <td></td>
                <td colspan="2">
                    <div>RIF DEL AGENTE DE RETENCIÓN</div>
                    <div class="hr">
                        <hr />
                    </div>
                </td>
                <td></td>
                <td colspan="2" align="center">
                    <div>PERÍODO FISCAL</div>
                    <div class="hr">
                        <hr />
                    </div>
                </td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td><?php echo $rzsoc ?></td>
                <td></td>
                <td colspan="2"><?php echo $rifEmp ?></td>
                <td width="2%"></td>
                <td colspan="3" align="left"><?php echo $perdf ?></td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td colspan="9"></td>
            </tr>
            <tr>
                <td colspan="4">
                    <div>DIRECCIÓN FISCAL DEL AGENTE DE RETENCIÓN</div>
                    <div class="hr">
                        <hr />
                    </div>
                </td>
                <td width="2%"></td>
                <td width="10%"></td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td colspan="8">'.$dir1 . ' ' . $dir2 . ' ' . $dir3 .'</td>
                <td></td>
            </tr>
            <tr>
                <td width="27%"></td>
                <td width="2%"></td>
                <td width="19%"></td>
                <td width="10%"></td>
                <td width="2%"></td>
                <td width="10%"></td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td>
                    <div>NOMBRE O RAZÓN SOCIAL DEL SUJETO RETENIDO</div>
                    <div Class="hr">
                        <hr />
                    </div>
                </td>
                <td></td>
                <td colspan="2">
                    <div>REGISTRO DE INFORMACIÓN FISCAL DEL SUJETO</div>
                    <div class="hr">
                        <hr />
                    </div>
                </td>
                <td></td>
                <td></td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td>'.$nempr.'</td>
                <td></td>
                <td colspan="2"><?php echo $rif ?></td>
                <td width="2%"></td>
                <td></td>
                <td colspan="3"></td>
            </tr>
        </table>

        <table border="0" style="border-collapse: collapse" align=center width="100%">
            <tr>
                <td width="69%"></td>
                <td width="24%">
                    <table border="1" width="100%" style="border-collapse: collapse" bordercolor="#000000">
                        <tr>
                            <td align="center" bgcolor="#EAEAEA"><b>Compras Internas o Importaciones</b></td>
                        </tr>
                    </table>
                </td>
                <td width="7%"></td>
            </tr>
        </table>';
        
        $sql = ('SELECT IMP_nc_open_numope AS "col-1",
                CONVERT(VARCHAR, IMP_nc_open_fecdoc, 103) AS "col-2",
                IMP_nc_open_numfac AS "col-3",
                IMP_nc_open_ncontro AS "col-4",
                IMP_nc_open_numntd AS "col-5",
                IMP_nc_open_numntc AS "col-6",
                CASE
                    WHEN IMP_nc_open_tiptra = 1 THEN "01-Registro"
                    WHEN IMP_nc_open_tiptra = 2 THEN "02-Complemento"
                    WHEN IMP_nc_open_tiptra = 3 THEN "03-Anulacion"
                    ELSE "04-Ajuste"
                END AS "col-7",
                IMP_nc_open_facafe AS "col-8",
                STR(IIF(IMP_nc_open_tipdoc = 4, IMP_nc_open_cociva * -1, IMP_nc_open_cociva),9,2) AS "col-9",
                STR(IMP_nc_open_cosiva,9,2) AS "col-10",
                STR(IIF(IMP_nc_open_tipdoc = 4, IMP_basimp_alicgene * -1, IMP_basimp_alicgene),9,2) AS "col-11",
                STR(IMP_porceimp_alicgene,9,2) AS "col-12",
                IIF(IMP_nc_open_tipdoc = 4, IMP_montoimp_alicgene * -1, IMP_montoimp_alicgene) AS "col-13",
                IIF(IMP_nc_open_tipdoc = 4,IMP_montrete_alicgene,ABS(IMP_montrete_alicgene)) AS "col-14"
            FROM IMPP2001
            WHERE open_p = ' . $rif . '
            AND IMP_nc_open_numfac = ' . $doc . '
            OR IMP_nc_open_facafe = ' . $doc);

        $stmt = sqlsrv_query($conn, $sql);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $tableIva =

            '<table border="1" style="border-collapse: collapse; margin: left -30px;" align="center" width="105%">
            <tr height="5">
                <td width="2%" align="center" bgcolor="#EAEAEA"><b>Nº</b></td>
                <td width="8%"align="center" bgcolor="#EAEAEA"><b>Fecha Factura</b></td>
                <td width="8%"align="center" bgcolor="#EAEAEA"><b>Nro Factura</b></td>
                <td width="8%"align="center" bgcolor="#EAEAEA"><b>Nro Control</b></td>
                <td width="6%"align="center" bgcolor="#EAEAEA"><b>Nro. Nota Debito</b></td>
                <td width="6%"align="center" bgcolor="#EAEAEA"><b>Nro. Nota Crédito</b></td>
                <td width="8%"align="center" bgcolor="#EAEAEA"><b>Transacción</b></td>
                <td width="5%"align="center" bgcolor="#EAEAEA"><b>Fac. Afec</b></td>
                <td width="10%" align="center" bgcolor="#EAEAEA"><b>Total Compras Incl. IVA</b></td>
                <td width="10%" align="center" bgcolor="#EAEAEA"><b>Compras sin Derecho Crédito IVA</b></td>
                <td width="8%" align="center" bgcolor="#EAEAEA"><b>Base Imp</b></td>
                <td width="3%" align="center" bgcolor="#EAEAEA"><b>% Alíc</b></td>
                <td width="8%" align="center" bgcolor="#EAEAEA"><b>Imp IVA</b></td>
                <td width="10%" align="center" bgcolor="#EAEAEA"><b>IVA Ret</b></td>
            </tr>';

        $numrow = 1;
        //Totales
        $totcciva = 0;
        $totcsiva = 0;
        $totbimp = 0;
        $totimp = 0;
        $totivaret = 0;
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $tableIva .= '
            <tr height="10">
                <td align="center">" . $row["col-1"] . "</td>
                <td align="center">" . $row["col-2"] . "</td> 
                <td align="center">" . $row["col-3"] . "</td>
                <td align="center">" . $row["col-4"] . "</td>
                <td align="center">" . $row["col-5"] . "</td>
                <td align="center">" . $row["col-6"] . "</td>
                <td align="center">" . $row["col-7"] . "</td>
                <td align="center">" . $row["col-8"] . "</td>
                <td align="right">' . number_format($row["col-9"], 2, ",", ".") . '</td>
                <td align="right">' . number_format($row["col-10"], 2, ",", ".") . '</td>
                <td align="right">' . number_format($row["col-11"], 2, ",", ".") . '</td>
                <td align="right">' . number_format($row['col-12'], 2, ",", ".") . '</td>
                <td align="right">' . number_format($row["col-13"], 2, ",", ".") . '</td>
                <td align="right">' . number_format($row["col-14"], 2, ",", ".") . '</td>
            </tr>';
            $numrow++;
            $totcciva += $row["col-9"];
            $totcsiva += $row["col-10"];
            $totbimp += $row["col-11"];
            $totimp += $row["col-13"];
            $totivaret += $row["col-14"];
        }
        $tableIva .= '
            <tr height="10">
                <td align="right" colspan="8">Totales (Bs.):</td>
                <td align="right">' . number_format($totcciva, 2, ",", ".") . '</td>
                <td align="right">' . number_format($totcsiva, 2, ",", ".") . '</td>
                <td align="right">' . number_format($totbimp, 2, ",", ".") . '</td>
                <td></td>
                <td align="right">' . number_format($totimp, 2, ",", ".") . '</td>
                <td align="right">' . number_format($totivaret, 2, ",", ".") . '</td>
            </tr>
        </table>';
        echo $tableIva;
        
        $html .=
        '<table border="0" style="border-collapse: collapse" align=center width="100%" style="margin-top: 10px;">
            <tr>
                <td width="20%"></td>
                <td width="20%"></td>
                <td width="20%"></td>
                <td width="20%"></td>
                <td width="20%"></td>
            </tr>
            <tr>
                <td width="20%"></td>
                <td width="20%" align="center"><img src='. $FSello64 .' width="140px" height="70px"></td>
                <td width="20%"></td>
                <td width="20%"></td>
                <td width="20%"></td>
            </tr>
            <tr>
                <td width="20%"></td>
                <td width="20%" align="center">______________________________________<br />Firma y sello del agente de retención <br /></td>
                <td width="20%"></td>
                <td width="20%" align="center">______________________________________<br />Nombre, firma y sello del proveedor <br /></td>
                <td width="20%"></td>
            </tr>
        </table>
        Fecha de Descarga:'. " " . $hoy;'
    </div>
</body>
</html>';

echo $html;
die;

include_once "./vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;

$dompdf = new Dompdf();
$dompdf->setPaper('Letter', 'landscape');
$options = $dompdf->getOptions();
$dompdf->setOptions($options);
ob_start();
include "./retivapdf.php";
$dompdf->loadHtml($html);
$dompdf->render();
header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=documento.pdf");
$pdf = $dompdf->output();
$filename = "Ret IVA.pdf";
file_put_contents($filename, $pdf);
$dompdf->stream($filename);
?>