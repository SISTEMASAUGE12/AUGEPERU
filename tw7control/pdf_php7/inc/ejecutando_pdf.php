<?php
// Author:Ing. Luis Eduardo Mori Ayala
// creando new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Luis Mori');
$pdf->SetTitle('Asistente turistico');// titulo del archivo
$pdf->SetSubject('Creacion de ruta');
$pdf->SetKeywords('TCPDF, PDF, ruta, test, guide');
// set default header data
$pdf->SetHeaderData(LOGO,LOGO_WIDTH, "Asistente Turístico - NOMBRE EMPRESA", TITULO_HEADER);//cabezera
// set tamaño de fuente en header and footer 
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// fuente
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//margenes
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// auto saltar pagina
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// logo
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set <font></font>
$pdf->SetFont('dejavusans', '', 10);
// add a page
$pdf->AddPage();
?>