<?php
include_once "./vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;

$dompdf = new Dompdf();
$dompdf->setPaper('Letter', 'landscape');
$options = $dompdf->getOptions();
$dompdf->setOptions($options);
ob_start();
include "./retivapdf.php";
$html = ob_get_clean();
$dompdf->loadHtml($html);
$dompdf->render();
header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=documento.pdf");
//$dompdf->stream();
//$dompdf->output();
ob_clean();
$pdf->render();
$pdf->stream("Ret IVA.pdf", ['Attachment' => false]);
exit(0);
?>