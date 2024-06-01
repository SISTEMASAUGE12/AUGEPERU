<?php session_start();
error_reporting(E_ALL);
include_once("../../class/class.bd.php"); 
include_once("../../class/functions.php");


$imagen_silabo = 'images/certificado_silabo_vacio_fondo_blanco.jpg';  // dentro de carpeta PDF:: images
$imagen_fondo_certificado = 'certificado_fondo_generico.jpg'; 


$data=executesql(" select * from certificados_configs where estado_idestado=1 order by id_config desc ");

$sql_=" select s.*, su.* , cu.titulo as titulo_curso , cer.certificado_fecha_inicio, cer.certificado_fecha_fin, cer.titulo as titulo_del_certificado, cer.duracion , cer.certificado_codigo, cer.certificado_libro,  cer.imagen,  cer.imagen_silabo, s.fecha_registro as fecha_compra , sus_x_cer.order_pdf 
      from solicitudes s 
      INNER JOIN suscritos su ON  s.id_suscrito = su.id_suscrito
      INNER JOIN certificados cer ON  s.id_certificado = cer.id_certificado 
      INNER JOIN suscritos_x_certificados sus_x_cer ON  s.id_pedido = sus_x_cer.id_pedido  
      INNER JOIN cursos cu ON  s.id_curso = cu.id_curso 
      where s.estado_idestado=1 and s.ide='".$_GET["rewrite"]."' ";

$solicitud=executesql($sql_);
if( isset($solicitud) && !empty($solicitud) ){
  // echo $solicitud[0]['imagen']; 
  if( !empty($solicitud[0]['imagen_silabo']) ){
    $imagen_silabo = '../../files/images/certificados/'.$solicitud[0]['imagen_silabo'];
  }  

  if( !empty($solicitud[0]['imagen']) ){    
    //$imagen_fondo_certificado = '../../files/images/certificados/'.$solicitud[0]['imagen'];
    $imagen_fondo_certificado=$solicitud[0]['imagen'];
  }
  //$imagen_fondo_certificado = 'https://www.educaauge.com/tw7control/files/images/certificados/'.$solicitud[0]['imagen'];
  
    $imagen_qr="../../qr/codes/certificados/".$solicitud[0]["ide"].".png";
    $div_qr="<img src='".$imagen_qr."' style='' > ";

}


// Include the main TCPDF library (search for installation path).
// require_once('pdf_include_ruta.php');
require_once('tcpdf_include.php');

  
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
      $img_file = K_PATH_IMAGES_CERTIFICADOS; /** 1062px ancho * 760px alto */
      
      
      //$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
      $this->Image($img_file, 0, 0, 0, 0, '', '', '', false, 0, '', false, false, 0); // tamaño completo
      
      // restore auto-page-break status
      $this->SetAutoPageBreak($auto_page_break, $bMargin);
      // set the starting point for the page content
      $this->setPageMark();
    }
  }
  
  // create new PDF document
  $pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  // L: echado; P: a4 
  
  // set document information
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor('Certificado educaauge.com');
$pdf->SetTitle('TCPDF Example 051');
$pdf->SetSubject('TCPDF certificado educauage');
$pdf->SetKeywords('TCPDF, PDF');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(30, 25, 30);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// remove default footer
$pdf->setPrintFooter(false);
// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetAutoPageBreak(TRUE, 0);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// $pdf->SetFont('times', '', 10);
$pdf->SetFont('dejavusans', '', 12);// fuente

// add a page
$pdf->AddPage();


if( isset($solicitud) && !empty($solicitud) ){
  
  if( $solicitud[0]['estado_api']==1 ){ // si cliente aprobodo us datos 

    $nombre='yyy';
    $ap_pa='yyy';
    $ap_ma='yyy';
    if( !empty($solicitud[0]['api_nombre_editado']) ){
      $nombre=$solicitud[0]['api_nombre_editado'];
    }else if( !empty($solicitud[0]['api_nombre']) ) {
      $nombre=$solicitud[0]['api_nombre'];
    }else{
      $nombre=$solicitud[0]['nombre'];
    }

    if( !empty($solicitud[0]['api_paterno_editado']) ){
      $ap_pa=$solicitud[0]['api_paterno_editado'];

    }else if( !empty($solicitud[0]['api_paterno']) ){
      $ap_pa=$solicitud[0]['api_paterno'];
    }else{
      $ap_pa=$solicitud[0]['ap_pa'];
    }

    if( !empty($solicitud[0]['api_materno_editado']) ){
      $ap_ma=$solicitud[0]['api_materno_editado'];
    }else if( !empty($solicitud[0]['api_materno']) ){
      $ap_ma=$solicitud[0]['api_materno'];
    }else{
      $ap_ma=$solicitud[0]['ap_ma'];
    }

    $nombre_completo= $nombre.' '.$ap_pa.' '.$ap_ma;

    $fecha_inicio=
    $fecha_fin= '';

    $meses=array('Jan'=>'enero','Feb'=>'febrero','Mar'=>'marzo','Apr'=>'abril','May'=>'mayo','Jun'=>'junio','Jul'=>'julio','Aug'=>'agosto','Sep'=>'septiembre','Oct'=>'octubre','Nov'=>'noviembre','Dec'=>'diciembre');

/*
    $fecha_inicio_texto=  strtr(date('d\ \d\e\ M  \d\e\l\ Y',strtotime($solicitud[0]["certificado_fecha_inicio"])),$meses);
    $fecha_fin_texto=  strtr(date('d\ \d\e\ M  \d\e\l\ Y',strtotime($solicitud[0]["certificado_fecha_fin"])),$meses);
*/

    // fecha inio: cuado compro el curso


  // Print a text
  $html = '
  <div style="text-align:center;"><h4 style="font-family:helvetica;font-weight:bold;font-size:18px;line-height:20px;">CENTRO DE CAPACITACIÓN & ACTUALIZACIÓN PROFESIONAL AUGE - PERÚ<br><small style="font-family:helvetica;padding-top:20px;">GERENCIA REGIONAL DE EDUCACIÓN LA LIBERTAD<br>UNIDAD DE GESTIÓN EDUCATIVA LOCAL - CHEPÉN </small></h4>
          <h3 style="font-weight:bold;font-size:40px;line-height:40px;">CERTIFICADO <br><small style="font-family:helvetica;">Otorgado a:</small></h3>
          <h3 style="font-family:helvetica;font-weight:500;font-size:20px;line-height:5px;border-bottom:2px solid #B58749;">'.$nombre_completo.'</h3>       
      </div>
      <table border="0" width="100%" margin="0 auto" cellpadding="1" cellspacing="0">   
        <tr>
            <td colspan="12" style="font-size:14px; text-align:center;">
              <p style="margin:0;padding-top:50px;text-align:justify;min-height:300px;height:250px;">Por haber participado como ASISTENTE en el curso de Actualización Docente, denominado
                <b>'.$solicitud[0]["titulo_del_certificado"].' </b>, autorizado mediante
                resolución directoral '.$data[0]["resolucion"].'. Desarrollado del '.$solicitud[0]["certificado_fecha_inicio"].' al '.$solicitud[0]["certificado_fecha_fin"].', 
                bajo la modalidad virtual y con una duración de '.$solicitud[0]["duracion"].'  horas pedagógicas.
              </p>
            </td>       
        </tr>
      </table>

      <table border="0" width="100%" margin="0 auto" cellpadding="0.15" cellspacing="0">  
          <tr><td colspan="12"><p style="height:130px;"></p></td></tr> 
          <tr><td colspan="12"><p style="height:130px;"></p></td></tr> 
          <tr>
              <td colspan="5" style="font-size:14px; text-align:center;">
                <figure style="font-size:14px; text-align:center;"><img src="../../files/images/certificados_configs/'.$data[0]["imagen"].'" style="text-align:center;height:80px;" ></figure>
                <p style="font-size:12px; text-align:center;"><b style="text-decoration:overline;border-top:2px solid #B58749;margin-top:0;padding-top:0;">'.$data[0]["persona_1"].'</b><br>'.$data[0]["cargo_1"].'</p>
              </td>
              <td colspan="2" style="font-size:14px; text-align:center;"></td>            
              <td colspan="5" style="font-size:14px; text-align:center;">
                <figure style="font-size:14px; text-align:center;"><img src="../../files/images/certificados_configs/'.$data[0]["imagen_2"].'" style=" text-align:center;height:80px;"></figure>
                <p style="font-size:12px; text-align:center;"><b style="text-decoration:overline;"> '.$data[0]["persona_2"].'</b><br>'.$data[0]["cargo_2"].'</p>
              </td>
          </tr>
      </table>
      <table border="0" width="100%" margin="0 auto" cellpadding="1" cellspacing="0">   
        <tr>          
          <td colspan="1" cellpadding="1"  style="font-size:14px; text-align:center;">
            <figure style="font-size:14px; text-align:center;margin-top:30px;">  
              <img src="images/espacio_arriba_del_qr.png" style="font-size:14px; text-align:center;">
              <img src="../qr/codes/certificados/'.$solicitud[0]["ide"].'.png" style="font-size:14px; text-align:center;" >
            </figure>
          </td>

          <td colspan="9" style="text-align:center;border-bottom:0px solid #B58749;">
          </td> 

          <td colspan="2" style="font-size:14px; text-align:center;">
            <p style="margin:0;padding-top:50px;text-align:justify;font-size:11px;line-height:14px;background-color:#eee;">
              <b>N° DEL REGISTRO:</b> '.$solicitud[0]['order_pdf'].'<br>
             <b> CÓDIGO: </b>'.$solicitud[0]['certificado_codigo'].' <br>
             <b> LIBRO: </b> '.$solicitud[0]['certificado_libro'].'  
            </p>
          </td>       
        </tr>
      </table>
      

  ';

  }else{
    $html=' <div style="text-align:center;"><h4 style="font-family:helvetica;font-weight:bold;font-size:18px;line-height:20px;">LO SENTIMOS. CLIENTE AUN NO APRUEBA SUS DATOS </h4></div>';
  } // end validacoin si esta parobado los datos 
}else{
  $html=' <div style="text-align:center;"><h4 style="font-family:helvetica;font-weight:bold;font-size:18px;line-height:20px;">LO SENTIMOS. NO TIENES ACCESO A VISUALIZAR ESTE CONTENIDO <br> :) </h4></div>';
}

$pdf->writeHTML($html, true, false, true, false, '');


// set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(0, 0, 0);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);
// add a page
$pdf->AddPage();
$html='      <!-- temraio -->
<img src="'.$imagen_silabo.'" style="text-align:center;width:1600px;heigth:720px;display:inline-block;" /> ';
$pdf->writeHTML($html, true, false, true, false, '');



// remove default header
$pdf->setPrintHeader(false);
//Close and output PDF document
$pdf->Output('certificado.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+