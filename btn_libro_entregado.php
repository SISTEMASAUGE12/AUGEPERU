<?php include_once("auten.php");
include_once("tw7control/class/class.upload.php");

$url = 'https://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? ':88/mori/tuweb7/w2019/withlove/' : '/' );

$_POST['action']=isset($_POST['action'])?$_POST['action']:'';
$rpta = 2;/*si es error*/
if($_POST['action']=='marcar_entregado'){

@$libro    = utf8_decode(addslashes($_POST['libro']));
@$nombre    = $_SESSION["suscritos"]["email"];
@$email    = $_SESSION["suscritos"]["email"];


$dominio="educaauge.com";
// $mi_email="ventas@".$dominio;
$mi_email="noresponder@educaauge.com";
$nombre_empresa="GRUPO AUGE ";


/*Para Client*/
$cabeceras  = "From: ".$nombre_empresa." <$mi_email> \n"
. "Reply-To: $mi_email\n";
$cabeceras .= 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$asunto     = " Libro entregado  -  ".$libro;
$email_to   = $email;
$contenido  = '<p><br><br></p>
<div style="max-width: 580px; margin: 0 auto; padding: 20px 25px 60px; background: #f9f9f9"><img src="'.$url.'/img/send_email/cabezera_logo2.png"><p style="font-size: 15px"><br><br><br><strong>Hola '.$nombre.',</strong><br> Entrega exitosa del libro: '.$libro.'.<br><br>

</p>

<p style="font-size: 15px">&nbsp;</p>

<p style="font-size: 12px">&nbsp;</p>
<p style="font-size: 12px">&nbsp;</p>
<p style="font-size: 14px">Ante cualquier duda, les invitamos a ponerse en comunicaci&oacute;n con nosotros.<br><br>Saludos cordiales,<br>- El Equipo '.$nombre_empresa.'<br><br></p>
</div> ';

	$bd = new BD;
	$_POST["fecha_entrega"]=fecha_hora(2);
	
	$_POST["estado"]=1;
	$campos=array('fecha_entrega','estado');
	
	/* MARCO SOLICITUD COMO ENTREGADA */
	$bd->actualiza_(armaupdate('solicitudes_libros',$campos," ide='".$_POST["ide_solicitud"]."'",'POST'));/*actualizo*/
		
	/* MARCO suscritos_x_certificados COMO ENTREGADA */
	//$_POST["estado_entrega"]=1;
	//$campos_sxc=array('fecha_entrega','estado_entrega');
	//$bd->actualiza_(armaupdate('suscritos_x_cursos',$campos_sxc," ide='".$_POST["ide_sxc"]."'",'POST'));/*actualizo*/
	
  // $bd->close();
	$rpta=1;
	
			@mail($email_to_emp, $asunto_emp, $contenido_emp, $cabeceras_emp); /* empresa */
		@mail($email_to, $asunto, $contenido, $cabeceras); /* cliente */
	
	
}

echo json_encode(array(    
    "res" => $rpta 
    // "link_go" => $link_go 
  )); 
	
?>