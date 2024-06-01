<?php 
session_start();
error_reporting(E_ALL);
include_once("../../class/class.bd.php"); 
include_once("../../class/functions.php");

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Nicola Asuni');
$pdf->setTitle('TCPDF Example 015');
$pdf->setSubject('TCPDF Tutorial');
$pdf->setKeywords('TCPDF, PDF, example, test, guide');

// set default monospaced font
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);



// set margins
$pdf->setMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT);
$pdf->setHeaderMargin(0);
$pdf->setFooterMargin(0);

// set auto page breaks
$pdf->setAutoPageBreak(TRUE, 15);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}


$html='';
$lineas=0;
$pdf->setFont('times', 'I', 12); 

$ejecutar_consulta = executesql($_GET["sql"]);
foreach( $ejecutar_consulta as $data ){

    $html.= '  
    <div style="text-align:left ;border-bottom:2px solid #000;">
        <h3 style="padding-bottom:20px;font-weight:400;">1.NOMBRES COMPLETOS:'.$data["suscritos"].'  </h3>
        <h3 style="padding-bottom:20px;font-weight:400;">2.DNI:  '.$data["dni"].'    </h3>
        <h3 style="padding-bottom:20px;font-weight:400;">3.NÚMERO DE CELULAR: '.$data["telefono"].'    </h3>        
        <h3 style="padding-bottom:20px;font-weight:400;">4.DPTO:  '.$data["dpto"].'   </h3>
        <h3 style="padding-bottom:20px;font-weight:400;">5.PROVINCIA:  '.$data["provincia"].' </h3>
        <h3 style="padding-bottom:20px;font-weight:400;">6.DISTRITO:  '.$data["dist"].' </h3>
        <h3 style="padding-bottom:20px;font-weight:400;">7.RECOGE:  '.$data["sucursal"].' - '.$data["agencia"].'  </h3>             
    </div>
    
    ';
    if( $lineas ==3 ){    // agrego salto de pagina     
      $html.=" ";
    }
}


$pdf->AddPage();
$pdf->setFont('times', 'I', 12);       
//$pdf->Write(0, $html);
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);




//Close and output PDF document
$pdf->Output('example_015.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
