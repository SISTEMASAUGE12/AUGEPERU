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
$pdf->setMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
$pdf->setHeaderMargin(0);
$pdf->setFooterMargin(0);

// set auto page breaks
$pdf->setAutoPageBreak(TRUE, 0);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}



$_GET["sql"]= "SELECT pp.*,YEAR(pp.fecha_registro) as anho, MONTH(pp.fecha_registro) as mes, s.email as email,  CONCAT(pp.nombre,' ',pp.ap_pa,' ',pp.ap_ma ) as suscritos, s.dni as dni,  c.titulo as curso, c.codigo as cod_curso ,dp.titulo as dpto , prov.titulo as provincia, dist.titulo as dist , ag.nombre as agencia, su.nombre as sucursal , s.telefono as telefono FROM solicitudes_libros pp INNER JOIN cursos c ON pp.id_curso=c.id_curso   INNER JOIN suscritos s ON pp.id_suscrito=s.id_suscrito LEFT JOIN dptos dp ON pp.iddpto= dp.iddpto  LEFT JOIN prvc prov ON pp.idprvc= prov.idprvc  LEFT JOIN dist dist ON pp.iddist= dist.iddist  INNER JOIN agencias ag   ON pp.id_agencia= ag.id_agencia   INNER JOIN agencias_sucursales su ON pp.id_sucursal= su.id_sucursal WHERE pp.estado_idestado= 1    AND pp.estado = 2  AND DATE(pp.fecha_registro)  BETWEEN  DATE('2021-04-03')  and DATE('2024-04-29') ";


$html='';
$lineas=0;


$ejecutar_consulta = executesql($_GET["sql"]);
foreach( $ejecutar_consulta as $data ){

    $html.= ' <div style="text-align:left ;border-bottom:2px solid #000;">
        <h3 style="padding-bottom:20px;font-weight:400;">1.NOMBRES COMPLETOS:  </h3>
        <h3 style="padding-bottom:20px;font-weight:400;">2.DNI:     </h3>
        <h3 style="padding-bottom:20px;font-weight:400;">3.NÚMERO DE CELULAR:    </h3>        
        <h3 style="padding-bottom:20px;font-weight:400;">4.DPTO:   </h3>
        <h3 style="padding-bottom:20px;font-weight:400;">5.PROVINCIA:    </h3>
        <h3 style="padding-bottom:20px;font-weight:400;">6.DISTRITO:    </h3>
        <h3 style="padding-bottom:20px;font-weight:400;">7.RECOGE:   </h3>     
    </div>';
    if( $lineas ==3 ){    // agrego salto de pagina     
      $html.=" <br><br> ";
    }
}


$pdf->AddPage();
$pdf->setFont('times', 'I', 14);       
//$pdf->Write(0, $html);
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);



$html_2=' <div style="text-align:left ;border-bottom:2px solid #000;">
    <h3 style="padding-bottom:20px;font-weight:400;">1.NOMBRES COMPLETOS:  </h3>
    <h3 style="padding-bottom:20px;font-weight:400;">2.DNI:     </h3>
    <h3 style="padding-bottom:20px;font-weight:400;">3.NÚMERO DE CELULAR:    </h3>        
    <h3 style="padding-bottom:20px;font-weight:400;">4.DPTO:   </h3>
    <h3 style="padding-bottom:20px;font-weight:400;">5.PROVINCIA:    </h3>
    <h3 style="padding-bottom:20px;font-weight:400;">6.DISTRITO:    </h3>
    <h3 style="padding-bottom:20px;font-weight:400;">7.RECOGE:   </h3>     
</div>';
$pdf->AddPage();
$pdf->setFont('times', 'I', 14);       
//$pdf->Write(0, $html);
$pdf->writeHTMLCell(0, 0, '', '', $html_2, 0, 1, 0, true, '', true);




//Close and output PDF document
$pdf->Output('example_015.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
