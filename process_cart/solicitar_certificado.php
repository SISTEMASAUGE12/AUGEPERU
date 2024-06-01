<?php error_reporting(E_ALL);session_start();
include_once("../tw7control/class/functions.php");
include_once("../tw7control/class/class.bd.php"); 

$url = 'https://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? ':88/mori/tuweb7/w2019/withlove/' : '/' ); 

$_POST['action']=isset($_POST['action'])?$_POST['action']:'';
$rpta = 2;/*si es error*/
if($_POST['action']=='registro'){ 
 // echo "entro";
 
@$nombre    = utf8_decode(addslashes($_POST['nombre']));
@$apellidos    = utf8_decode(addslashes($_POST['ap_pa'].' '.$_POST['ap_ma']));
@$dni     = utf8_decode(addslashes($_POST['dni']));
@$telefono  = utf8_decode(addslashes($_POST['telefono']));
@$email     = utf8_decode(addslashes($_POST['email']));



// $mi_email="test@tuweb7.top";
$mi_email="ventas@educaauge.com";
$mi_email_no_reply="no-reply@educaauge.com";

$nombre_empresa="GRUPO AUGE ";


/*Para Empresa*/
$cabeceras_emp  = "From: ".$nombre_empresa." <$mi_email> \n" 
. "Reply-To: $mi_email\n";
$cabeceras_emp .= 'MIME-Version: 1.0' . "\r\n";
$cabeceras_emp .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$asunto_emp     = " Nueva Solicitud de certificado -  ".$nombre_empresa; 
$email_to_emp   = $mi_email;
$contenido_emp  = "
<p> Nuevo Usuario Registrado <br />
Nombre: ".$nombre."<br />
Apellidos: ".$apellidos."<br />
Dni: ".$dni."<br />
Telefono: ".$telefono."<br />
Email: ".$email."<br /><br /></p>
<p>* Recomendamos, que proceda a contartar con este nuevo usuario.</p>

";




/*Para Client*/
$cabeceras  = "From: ".$nombre_empresa." <$mi_email> \n" 
. "Reply-To: $mi_email\n";
$cabeceras .= 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$asunto     = " Nueva Solicitud de certificado -  ".$nombre_empresa; ; 
$email_to   = $email;
$contenido  = '<p><br><br></p>
<div style="max-width: 580px; margin: 0 auto; padding: 20px 25px 60px; background: #f9f9f9"><img src="'.$url.'/img/send_email/cabezera_logo2.png"><p style="font-size: 15px"><br><br><br><strong>Hola '.$nombre.' '.$apellidos.',</strong><br> Hemos recibido tu solicitud.<br><br>

Hola hemos recibido tu solicitud de certificado, dentro de poco nos pondremos en contacto contigo.<br /><br />
</p>

<p style="font-size: 15px">&nbsp;</p>

<p style="font-size: 12px">&nbsp;</p>
<p style="font-size: 12px">&nbsp;</p>
<p style="font-size: 14px">Ante cualquier duda, les invitamos a ponerse en comunicaci&oacute;n con nosotros.<br><br>Saludos cordiales,<br>- El Equipo '.$nombre_empresa.'<br><br></p>
</div> ';




	$bd = new BD;
	$_POST["estado_idestado"]=1;
	$_POST["estado"]=2;
	$_POST['orden'] = _orden_noticia("","solicitudes","");

	$_POST["cursos"]= implode(',',$_POST['cursos']);
	$_POST["fecha_registro"]=fecha_hora(2);
	$_POST["id_suscrito"]= $_SESSION["suscritos"]["id_suscrito"];

	$campos=array('id_suscrito',"nombre",'ap_pa','ap_ma',"telefono","email","dni",'cursos',"direccion","agencia","dpto","dist",'prov',"estado",'fecha_registro','estado_idestado','orden');


	// echo var_dump(arma_insert('solicitudes',$campos,'POST'));
	// exit();
	
	$insertado=$bd->inserta_(arma_insert('solicitudes',$campos,'POST'));

	$bd->close();
	
	if($insertado > 0) $rpta =1;
	

}
echo json_encode(array('rpta' => $rpta));
?>