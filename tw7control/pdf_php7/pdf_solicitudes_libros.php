<?php 
// Author:Ing. Luis Eduardo Mori Ayala
include('auten.php');
require_once('pdf_include_ruta.php');

//extraer data base datos
// $search=executesql("select * from destino where id_destino=2");

  // Extend the TCPDF class to create custom Header and Footer
  class MYPDF extends TCPDF {
    //Page header
    public function Header() {
      // get the current page break margin
      $bMargin = $this->getBreakMargin();
      // get current auto-page-break mode
      $auto_page_break = $this->AutoPageBreak;
      // disable auto-page-break
      $this->SetAutoPageBreak(false, 0);
      
      // set bacground image /** 1062px ancho * 760px alto */
      /** 1062px ancho * 760px alto */
      //$img_file = K_PATH_IMAGES.'image_demo.jpg'; /** 1062px ancho * 760px alto */
      $img_file = IMG_FONDO_BLANCO; /** 1062px ancho * 760px alto */
      
      
      //$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
      $this->Image($img_file, 0, 0, 0, 0, '', '', '', false, 0, '', false, false, 0); // tamaño completo
      
      // restore auto-page-break status
      $this->SetAutoPageBreak($auto_page_break, $bMargin);
      // set the starting point for the page content
      $this->setPageMark();
    }
  }
  
  // create new PDF document
  $pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  


// create new PDF document
define ('PDF_PAGE_ORIENTATION', 'P');  // A4 normal 
// $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Luis Mori');
$pdf->SetTitle('ENVIO DE LIBROS');// titulo del archivo
$pdf->SetSubject('Creacion de PDF LIBRO');
$pdf->SetKeywords('TCPDF, PDF, ruta, test, guide');
//header - footer

$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);// fuente
$pdf->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT);//margenes
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);// auto saltar pagina
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);// logo
$pdf->SetFont('dejavusans', '', 10);// fuente
$pdf->AddPage();// add a page

// create some HTML content ., p es automatica
$html = '';

$ejecutar_consulta = executesql($_GET["sql"]);
foreach( $ejecutar_consulta as $data ){

    $html .= '
    
    <div style="text-align:left ;border-bottom:2px solid #000;">
        <h3 style="padding-bottom:20px;font-weight:400;">1.NOMBRES COMPLETOS:'.$data["suscritos"].'  </h3>
        <h3 style="padding-bottom:20px;font-weight:400;">2.DNI:  '.$data["dni"].'    </h3>
        <h3 style="padding-bottom:20px;font-weight:400;">3.NÚMERO DE CELULAR: '.$data["telefono"].'    </h3>        
        <h3 style="padding-bottom:20px;font-weight:400;">4.DPTO:  '.$data["dpto"].'   </h3>
        <h3 style="padding-bottom:20px;font-weight:400;">5.PROVINCIA:  '.$data["provincia"].' </h3>
        <h3 style="padding-bottom:20px;font-weight:400;">6.DISTRITO:  '.$data["dist"].' </h3>
        <h3 style="padding-bottom:20px;font-weight:400;">7.RECOGE:  '.$data["sucursal"].' - '.$data["agencia"].'  </h3>  </h4>    
    </div>';
}
 

// sirve para ejecutar el $html
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->lastPage();
$pdf->AddPage();

//Close and output PDF document
$pdf->Output('ticket_envio_de_libros.pdf', 'I'); // I para visualizar ; D para que se baje automatico