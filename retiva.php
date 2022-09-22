<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/retenciones.css" rel="stylesheet" />
    <title>Documento de IVA</title>
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
    IMP_nc_open_nreten as '0',
    CONVERT(VARCHAR, IMP_nc_open_feccon, 103) AS '1',
    UPPER(CMPNYNAM) AS '2',
    CO_MI_rif000 AS '3',
    CONCAT('AÑO ',RIGHT(LTRIM(RTRIM(IMP_nc_open_period)),4),' / MES ',
	CASE
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=1 THEN 'ENE'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=2 THEN 'FEB'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=3 THEN 'MAR'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=4 THEN 'ABR'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=5 THEN 'MAY'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=6 THEN 'JUN'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=7 THEN 'JUL'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=8 THEN 'AGO'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=9 THEN 'SEP'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=10 THEN 'OCT'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=11 THEN 'NOV'
		WHEN SUBSTRING(IMP_nc_open_period,5,2)=12 THEN 'DIC'
	END) AS '4',
    UPPER(LTRIM(RTRIM(ADDRESS1))) AS '5.1',
    UPPER(LTRIM(RTRIM(ADDRESS2))) AS '5.2',
    UPPER(CONCAT(LTRIM(RTRIM(ADDRESS3)),', ',LTRIM(RTRIM(CITY)),', ',LTRIM(RTRIM(STATE)))) AS '5.3',
    UPPER(IMP_nc_open_nompro) AS '6',
    open_p as '7'
    FROM IMPP2001
    INNER JOIN DYNAMICS.dbo.SY01500 on INTERID = DB_NAME()
    INNER JOIN IMPC0001 on CO_MI_idcomp = DB_NAME()
    WHERE open_p = '" . $rif . "'
    AND IMP_nc_open_numfac = '" . $doc . "'
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
        $rzsoc = utf8_encode($row["2"]);
        $rifEmp = $row["3"];
        $perdf = $row["4"];
        $dir1 = utf8_encode($row["5.1"]);
        $dir2 = utf8_encode($row["5.2"]);
        $dir3 = utf8_encode($row["5.3"]);
        $nempr = utf8_encode($row["6"]);
    }
    ?>
    <div id="" Class="paginaHorizontal">
        <table border='0' style="width:100%; height:60px;">
            <tr>
                <td width='200'>
                    <img src="<?php echo $LOGORET ?>" width="205" height="72" border="0" alt="">
                </td>
                <td valign='top' align='center'>
                    <h4>COMPROBANTE DE RETENCIÓN DE IVA</h4>
                </td>
                <td valign='top' align='right' width='100'>
                    <a href="#" onclick="javascript:window.print()"><img src="./images/print.png" width="25" height="25"></a>
                </td>
            </tr>
        </table>
        <table border='0' style='border-collapse: collapse;' width='100%'>
            <tr>
                <td colspan='3' rowspan='2'>(Ley IVA - Art. 11: La administración Tributaria podrá designar como responsables del pago del impuesto, en calidad de agentes de retención a quienes por sus funciones publicas o por razón de sus actividades privadas intervengan en operaciones gravadas con el impuesto establecido en este decreto con rango, valor y fuerza de ley)</td>
                <td colspan='2'> </td>
                <td align='center'>
                    <div>Nº COMPROBANTE</div>
                    <div class="hr">
                        <hr />
                    </div>
                </td>
                <td></td>
                <td align='center'>
                    <div>FECHA DE EMISIÓN</div>
                    <div class="hr">
                        <div class="hr">
                            <hr />
                        </div>
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
                    <div Class="hr">
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
                <td colspan='4'><?php echo $dir1 . ' ' . $dir2 . ' ' . $dir3 ?>
                    <div class="hr">
                        <hr />
                    </div>
                </td>
                <td width='2%'></td>
                <td width='10%'></td>
                <td colspan='3'></td>
            </tr>
            <tr>
                <td width='27%'></td>
                <td width='2%'></td>
                <td width='19%'></td>
                <td width='10%'></td>
                <td width='2%'></td>
                <td width='10%'></td>
                <td colspan='3'></td>
            </tr>
            <tr>
                <td>
                    <div>NOMBRE O RAZÓN SOCIAL DEL SUJETO RETENIDO</div>
                    <div Class="hr">
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
                    WHEN IMP_nc_open_tiptra = 1 THEN '01-Registro'
                    WHEN IMP_nc_open_tiptra = 2 THEN '02-Complemento'
                    WHEN IMP_nc_open_tiptra = 3 THEN '03-Anulacion'
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
                STR(ABS(IMP_porcrete_alicgene),9,2) AS 'col-20',
				STR((IIF(IMP_nc_open_tipdoc = 4, IMP_montoimp_alicgene * -1, IMP_montoimp_alicgene)+(IIF(IMP_nc_open_tipdoc = 4, IMP_montoimp_alicreduc * -1, IMP_montoimp_alicreduc)+(IIF(IMP_nc_open_tipdoc = 4, IMP_montoimp_alicadic * -1, IMP_montoimp_alicadic)))),9,2) AS 'col-21'
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
            <tr height='25'>
                <td align='center' bgcolor='#EAEAEA'><b>Oper Nº</b></td>
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
            $tableIva .= "
            <tbody>
            <tr height='22'>
                <td width='2%' align='center'>" . $row['col-1'] . "</td>
                <td width='5%' align='center'>" . $row['col-2'] . "</td> 
                <td width='5%' align='center'>" . $row['col-3'] . "</td>
                <td width='6.5%' align='center'>" . $row['col-4'] . "</td>
                <td width='2%' align='center'>" . $row['col-5'] . "</td>
                <td width='2%' align='center'>" . $row['col-6'] . "</td>
                <td width='8%' align='center'>" . $row['col-7'] . "</td>
                <td width='5%' align='center'>" . $row['col-8'] . "</td>
                <td align='right'>" . number_format($row['col-9'], 2, ',', '.') . "</td>
                <td align='right'>" . number_format($row['col-10'], 2, ',', '.') . "</td>
                <td align='right'>" . number_format($row['col-11'], 2, ',', '.') . "</td>
                <td width='2%' align='right'>" . number_format($row['col-12'], 2, ',', '.') . "</td>
                <td align='right'>" . number_format($row['col-13'], 2, ',', '.') . "</td>
                <td align='right'>" . number_format($row['col-14'], 2, ',', '.') . "</td>
                <td width='2%' align='right'>" . number_format($row['col-15'], 2, ',', '.') . "</td>
                <td align='right'>" . number_format($row['col-16'], 2, ',', '.') . "</td>
                <td width='5%' align='right'>" . number_format($row['col-17'], 2, ',', '.') . "</td>
                <td width='2%' align='right'>" . number_format($row['col-18'], 2, ',', '.') . "</td>
                <td align='right'>" . number_format($row['col-19'], 2, ',', '.') . "</td>
                <td width='2%' align='right'>" . number_format($row['col-20'], 2, ',', '.') . "</td>
                <td width='5%' align='right'>" . number_format($row['col-21'], 2, ',', '.') . "</td>
            </tr>";
            $numrow++;
            $totcciva += $row['col-9'];
            $totcsiva += $row['col-10'];
            $totbimp += $row['col-11'];
            $totimp += $row['col-13'];
            $totivaret += $row['col-21'];
        }
        $tableIva .= "
        </tbody>
        <tfoot>
            <table class='tbfont2' border='0' style='border-collapse: collapse' align='center' width='100%'>
                <tr height='25'>
                    <td width='95%' align='right'>Totales Impuesto Retenido:</td>
                    <td class='unica' align='right'>" . number_format($totivaret, 2, ',', '.') . "</td>
                </tr>
            </table>
        </tfoot>
        </table>";
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
                <td width='20%' align='center'><img src='<?php echo $FIRMA ?>' width='200px' height='100px'></td>
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
</body>

</html>