<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/retenciones.css" rel="stylesheet" />
    <title>Retencion</title>
</head>

<body>
<?php
$doc = $_POST["doc"];
$tipo = $_POST["tipo"];
$rif = $_POST["rif"];

echo $doc;
echo $tipo;
echo $rif;
die;

    include_once("conexion.php");

    // Con esta Consulta saco el encabezado de las retencionesb tanto de IVA como de ISLR

    $sql = ("SELECT TOP 1
    IMP_nc_open_nreten as '0',
    CONVERT(VARCHAR, IMP_nc_open_feccon, 103) AS '1',
    CMPNYNAM AS '2',
    TAXREGTN AS '3',
    CONCAT('AÑO: ',RIGHT(TRIM(IMP_nc_open_period),4),' MES: ',SUBSTRING(IMP_nc_open_period,5,2)) AS '4',
    TRIM(ADDRESS1) AS '5.1',
    TRIM(ADDRESS2) AS '5.2',
    CONCAT(TRIM(ADDRESS3),', ',TRIM(CITY),', ',TRIM(STATE)) AS '5.3',
    IMP_nc_open_nompro AS '6',
    open_p as '7'
    FROM IMPP2001
    INNER JOIN DYNAMICS.dbo.SY01500 on INTERID = DB_NAME()
    WHERE open_p = 'J000123713'
    AND CONVERT(VARCHAR, IMP_nc_open_feccon, 23) >= '2022-01-01';
    "
    );
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
    }

    if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
    }

    $html = '<a href="#">HTML</a>';
    $pdf = '<a href="#">PDF</a>';

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $ncomp = $row["0"];
    $fecha = $row["1"];
    $rzsoc = $row["2"];
    $rif = $row["3"];
    $perdf = $row["4"];
    $dir1 = $row["5.1"];
    $dir2 = $row["5.2"];
    $dir3 = $row["5.3"];
    $nempr = $row["6"];
    $rempr = $row["7"];
    }

?>


    <div id="" Class="paginaHorizontal">
        <table border='0' style="width:100%; height:60px;">
            <tr>
                <td width='200'>
                    <img src="/img/empresas/polytex/comp_img.jpg" width="205" height="72" border="0" alt="">
                </td>
                <td valign='top' align='center'>
                    <h4>&nbsp;COMPROBANTE DE RETENCI&Oacute;N DE IVA</h4>
                </td>
                <td valign='top' align='right' width='100'>
                    <a href="#" onclick="javascript:window.print()"><img src="./images/print.png" width="25" height="25"></a>
                </td>
            </tr>
        </table>
        <table border='0' style='border-collapse: collapse;' width='100%'>
            <tr>
                <td colspan='3' rowspan='2'>(Ley IVA - Art. 11: La administración Tributaria podrá designar como responsables del pago del impuesto, en calidad de agentes de retención a quienes por sus funciones publicas o por razón de sus actividades privadas intervengan en operaciones gravadas con el impuesto establecido en este decreto con rango, valor y fuerza de ley)</td>
                <td colspan='2'> &nbsp;</td>
                <td align='center'>
                    <div>Nº COMPROBANTE</div>
                    <div class="hr">
                        <hr />
                    </div>
                </td>
                <td>&nbsp;</td>
                <td align='center'>
                    <div>FECHA DE EMISI&Oacute;N</div>
                    <div class="hr">
                        <div class="hr">
                            <hr />
                        </div>
                    </div>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan='2'> &nbsp;</td>
                <td align='center'> 20220600030589 </td>
                <td>&nbsp;</td>
                <td align='center'> 27/06/2022 </td>
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
                    <div>NOMBRE O RAZÓN SOCIAL DEL AGENTE DE RETENCI&Oacute;N</div>
                    <div Class="hr">
                        <hr />
                    </div>
                </td>
                <td>&nbsp;</td>
                <td colspan='2'>
                    <div>REGISTRO DE INFORMACIÓN FISCAL DEL AGENTE</div>
                    <div class="hr">
                        <hr />
                    </div>
                </td>
                <td>&nbsp;</td>
                <td align='center'>
                    <div>PER&Iacute;ODO FISCAL</div>
                    <div class="hr">
                        <hr />
                    </div>
                </td>
                <td colspan='3'>&nbsp;</td>
            </tr>
            <tr>
                <td> POLYTEX DE MARACAY C. A. </td>
                <td>&nbsp;</td>
                <td colspan='2'>J075558855 </td>
                <td width='2%'>&nbsp;</td>
                <td align='center'>AÑO 2022 / MES 06 </td>
                <td colspan='3'>&nbsp;</td>
            </tr>
            <tr>
                <td colspan='9'>&nbsp;</td>
            </tr>
            <tr>
                <td colspan='4'>
                    <div>DIRECCI&Oacute;N FISCAL DEL AGENTE DE RETENCI&Oacute;N</div>
                    <div class="hr">
                        <hr />
                    </div>
                </td>
                <td width='2%'>&nbsp;</td>
                <td width='10%'>&nbsp;</td>
                <td colspan='3'>&nbsp;</td>
            </tr>
            <tr>
                <td colspan='4'> AV LAS INDUSTRIAS, ZONA G, LOCAL GALPONES 10, 11, 18 Y 19, URB INDUSTRIAL SOCO LA VICTORIA ARAGUA ZONA POSTAL 2121 </td>
                <td width='2%'>&nbsp;</td>
                <td width='10%'>&nbsp;</td>
                <td colspan='3'>&nbsp;</td>
            </tr>
            <tr>
                <td width='27%'>&nbsp;</td>
                <td width='2%'>&nbsp;</td>
                <td width='19%'>&nbsp;</td>
                <td width='10%'>&nbsp;</td>
                <td width='2%'>&nbsp;</td>
                <td width='10%'>&nbsp;</td>
                <td colspan='3'>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <div>NOMBRE O RAZÓN SOCIAL DEL SUJETO RETENIDO</div>
                    <div Class="hr">
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
                <td></td>
                <td colspan='3'>&nbsp;</td>
            </tr>
            <tr>
                <td> VIRTUAL OFFICE GROUP, C.A. </td>
                <td>&nbsp;</td>
                <td colspan='2'> J309672371 </td>
                <td width='2%'>&nbsp;</td>
                <td></td>
                <td colspan='3'>&nbsp;</td>
            </tr>
        </table>

        <table border='0' style='border-collapse: collapse' align=center width='100%'>
            <tr>
                <td width='68%'>&nbsp;</td>
                <td width='24%'>
                    <table border='1' width='100%' style='border-collapse: collapse' bordercolor='#000000'>
                        <tr>
                            <td align='center' bgcolor='#EAEAEA'><b>Compras Internas o Importaciones</b></td>
                        </tr>
                    </table>
                </td>
                <td width='7%'>&nbsp;</td>
            </tr>
        </table>

        <table border='1' style='border-collapse: collapse' align='center' width='100%'>
            <tr height='25'>
                <td width='3%' align='center' bgcolor='#EAEAEA'><b>Oper Nº</b></td>
                <td width='7%' align='center' bgcolor='#EAEAEA'><b>Fecha de la Factura</b></td>
                <td width='6%' align='center' bgcolor='#EAEAEA'><b>N&uacute;mero de Factura</b></td>
                <td width='8%' align='center' bgcolor='#EAEAEA'><b>N&uacute;m. Control de Factura</b></td>
                <td width='7%' align='center' bgcolor='#EAEAEA'><b>N&uacute;m. Nota D&eacute;bito</b></td>
                <td width='7%' align='center' bgcolor='#EAEAEA'><b>N&uacute;m. Nota Crédito</b></td>
                <td width='6%' align='center' bgcolor='#EAEAEA'><b>Tipo de Trans.</b></td>
                <td width='6%' align='center' bgcolor='#EAEAEA'><b>N&uacute;m. de Factura Afectada</b></td>
                <td width='10%' align='center' bgcolor='#EAEAEA'><b>Total Compras Incluyendo el IVA (Bs.)</b></td>
                <td width='9%' align='center' bgcolor='#EAEAEA'><b>Compras sin Derecho Crédito IVA (Bs.)</b></td>
                <td width='10%' align='center' bgcolor='#EAEAEA'><b>Base Imponible (Bs.)</b></td>
                <td width='4%' align='center' bgcolor='#EAEAEA'><b>%Al&iacute;cuota</b></td>
                <td width='9%' align='center' bgcolor='#EAEAEA'><b>Impuesto IVA (Bs.)</b></td>
                <td width='9%' align='center' bgcolor='#EAEAEA'><b>IVA Retenido (Bs.)</b></td>
            </tr>

            <tr height='22'>
                <td align='center'> 1 </td>
                <td align='center'> 21/06/2022 </td> <!-- fecha factura -->
                <td align='center'> 4440 </td>
                <!--número factura-->
                <td align='center'> 00-003578 </td>
                <!--Nro Control factura-->
                <td align='center'> 0 </td>
                <!--'Num nota débito-->
                <td align='center'> 0 </td>
                <!--Num Nota crédito-->
                <td align='center'> 1 </td>
                <!--tipo de trans-->
                <td align='center'> 0 </td>
                <!--Número de factura afectada-->
                <td align='right'>915,29&nbsp;</td>
                <!--'total compras incluyendo Iva-->
                <td align='right'>0,00&nbsp;</td>
                <!--'compras sin derecho a crédito IVA-->
                <td align='right'>789,04&nbsp;</td>
                <!--Base Imponible-->
                <td align='right'>16,00&nbsp;</td>
                <!--%Alícuota-->
                <td align='right'>126,25&nbsp;</td>
                <!--Impuesto IVA-->
                <td align='right'>94,68&nbsp;</td>
                <!--Iva Retenido-->
            </tr>

            <tr height='25'>
                <td align='right' colspan='8'>Totales (Bs.):&nbsp;</td>
                <td align='right'>915,29&nbsp;</td>
                <td align='right'>0,00&nbsp;</td>
                <td align='right'>789,04&nbsp;</td>
                <td>&nbsp;</td>
                <td align='right'>126,25&nbsp;</td>
                <td align='right'>94,68&nbsp;</td>
            </tr>
        </table>

        <table border='0' style='border-collapse: collapse' align=center width='100%'>
            <tr>
                <td width='20%'>&nbsp;</td>
                <td width='20%' align='center'><img src='/img/empresas/polytex/firm_img.jpg' width='200px' height='100px'></td>
                <td width='20%'>&nbsp;</td>
                <td width='20%'>&nbsp;</td>
                <td width='20%'>&nbsp;</td>
            </tr>
            <tr>
                <td width='20%'>&nbsp;</td>
                <td width='20%' align='center'>______________________________________<br />Firma y sello del agente de retención <br />&nbsp;</td>
                <td width='20%'>&nbsp;</td>
                <td width='20%' align='center'>______________________________________<br />Nombre, firma y sello del proveedor <br />Fecha de Descarga: 31/08/2022 </td>
                <td width='20%'>&nbsp;</td>
            </tr>
        </table>
    </div>
</body>

</html>