<?php
require("../class/Carrito.class.php");
require("../intranet/class/class.bd.php"); 
require("../intranet/class/functions.php");
require("../intranet/class/PHPPaging.lib.php");
$data="";
 
 //no saca los datos ,,revisar luego , sino seria mostrat todas las rutas y al hacer clik que se descargue 
 //pero serioa bonit q se descrgue  slito
 
     //  Librerias TCPDF 
$tcpdf_include_dirs = array(
	realpath('tcpdf.php'),
	'/usr/share/php/tcpdf/tcpdf.php',
	'/usr/share/tcpdf/tcpdf.php',
	'/usr/share/php-tcpdf/tcpdf.php',
	'/var/www/tcpdf/tcpdf.php',
	'/var/www/html/tcpdf/tcpdf.php',
	'/usr/local/apache2/htdocs/tcpdf/tcpdf.php'
);
foreach ($tcpdf_include_dirs as $tcpdf_include_path) {
	if (@file_exists($tcpdf_include_path)) {
		require_once($tcpdf_include_path);
		break;
	} 
}
//Empieza Pdf
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Luis Mori');
$pdf->SetTitle('Lambayeque Turismo - Asistente turistico');// titulo del archivo
$pdf->SetSubject('Creacion de ruta');
$pdf->SetKeywords('TCPDF, PDF, ruta, test, guide');
//header - footer
$pdf->SetHeaderData(LOGO,LOGO_WIDTH, "Lambayeque Turismo", TITULO_HEADER);//cabezera
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));// set tamaño de fuente en header and footer 
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);// fuente
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);//margenes
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);// auto saltar pagina
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);// logo
$pdf->SetFont('dejavusans', '', 10);// fuente
$pdf->AddPage();// add a page

$error = '<h1 style="text-align:center;">Ing.moriayala@gmail.com</h1>
          <h2 style="text-align:center;">Se perdio cnexión con el servidor,Lo sentimos :( </h2>
          <h3 style="text-align:center;">Intentelo nuevamente </h3>' ;
$cero = '<h1 style="text-align:center;">Ing.moriayala@gmail.com</h1>
          <h2 style="text-align:center;">Cero destinos encontrados :( </h2>
          <h3 style="text-align:center;">... </h3>' ;
          
if(isset($_GET['clave']) && isset($_GET['sus'])){  // si existe parametro 
    $sql="SELECT * FROM asistente WHERE estado_idestado='1'"
          .(isset($_GET['sus']) ? " AND id_suscrito='".$_GET['sus']."'" : "")." "
          .(isset($_GET['clave']) ? " AND id_asistente='".$_GET['clave']."'" : "").
          "ORDER BY orden DESC";

    $exe = executesql($sql);
    if(!empty($exe)){
      $_POST['titulo']=$exe[0]["titulo"]; //titulo rruta
      $consulta="SELECT d.titulo as nombre , d.descripcion as descripcion , d.imagen as imagen FROM destino d
                INNER JOIN destino_x_asis dxa ON d.id_destino=dxa.id_destino 
                INNER JOIN asistente a ON dxa.id_asistente=a.id_asistente 
                where a.id_asistente='".$_GET['clave']."' ";
      $destinos = executesql($consulta);
      if(!empty($destinos)){//buscando destinos
            $head='<h1 style="text-align:center;">'.$_POST['titulo'].'</h1>';
            foreach($destinos as $row){//recrro destinos
              $name_destino=$row["nombre"];
              $des=$row["descripcion"];
              $imagen="../intranet/files/images/destinos/".$row["imagen"];
              $data = $data.
											'<img src="'.$imagen.'" style="text-align:center;width:120px;heigth:120px;display:inline-block;" />
                      <h2 style="text-align:center;display:inline-block;">'.$name_destino.'</h2>
                      '.$des;
            }// 1° for desinos
            $html=$head.$data;
      }else{
        $pdf->writeHTML($cero, true, false, true, false, '');         
      }
    }else{
      $pdf->writeHTML($error, true, false, true, false, '');      
    }// if existe ruta  
}else{ 
  $pdf->writeHTML($error, true, false, true, false, '');
}

// ejecutar el $html
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->lastPage();
// $pdf->AddPage();
$pdf->Output('"'.$_POST['titulo'].'".pdf', 'D');
  ?>