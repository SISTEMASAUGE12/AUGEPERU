<?php include_once("auten.php");
include_once("tw7control/class/class.upload.php");

$url = 'https://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? ':88/mori/tuweb7/w2019/withlove/' : '/' );

$_POST['action']=isset($_POST['action'])?$_POST['action']:'';
$rpta = 2;/*si es error*/
if($_POST['action']=='registro'){

@$nombre    = utf8_decode(addslashes($_POST['nombre']));
@$apellidos    = utf8_decode(addslashes($_POST['ap_pa'].' '.$_POST['ap_ma']));
@$dni     = utf8_decode(addslashes($_POST['dni']));
@$telefono  = utf8_decode(addslashes($_POST['telefono']));
@$email     = utf8_decode(addslashes($_POST['email']));


$dominio="augeperu.org";
// $mi_email="ventas@".$dominio;
$mi_email="noresponder@educaauge.com";

$nombre_empresa="GRUPO AUGE ";


/*Para Empresa*/
$cabeceras_emp  = "From: ".$nombre_empresa." <$mi_email> \n"
. "Reply-To: $mi_email\n";
$cabeceras_emp .= 'MIME-Version: 1.0' . "\r\n";
$cabeceras_emp .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$asunto_emp     = " Nueva Solicitud de CoAutoría -  ".$nombre_empresa;
$email_to_emp   = $mi_email;
$contenido_emp  = "
<p> Nuevo solicitud Registrada <br />
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
$asunto     = " Nueva Solicitud de CoAutoría -  ".$nombre_empresa; ;
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
	$_POST['tipo']=2; /* 2: tipo couatoria */
	$_POST['orden'] = _orden_noticia("","solicitudes_coautorias","");

	// $_POST["cursos"]= implode(',',$_POST['cursos']);
	if(!isset($_POST["nombre_magisterio"]) ){
		$_POST["nombre_magisterio"]='no_encontrado';
	}
	$_POST["fecha_registro"]=fecha_hora(2);
	$_POST["id_suscrito"]= (isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"]) )?$_SESSION["suscritos"]["id_suscrito"]:'0';

	$campos=array('tipo','id_suscrito','id_especialidad','nombre_magisterio',"nombre",'ap_pa','ap_ma',"telefono","email","dni","direccion",'fecha_nac',"direccion_nac","iddpto","iddist",'idprvc',"estado",'fecha_registro','estado_idestado','orden');

	if(isset($_FILES['voucher']) && !empty($_FILES['voucher']['name'])){
        $_POST['voucher'] = carga_imagen('tw7control/files/images/solicitud/','voucher','');
        $campos = array_merge($campos,array('voucher'));
    }


	//echo var_dump(arma_insert('solicitudes_coautorias',$campos,'POST'));
	// exit();

	$insertado=$bd->inserta_(arma_insert('solicitudes_coautorias',$campos,'POST'));
	if( $insertado > 0){
		/* creo sesion temporal para darle acceso a ver/comprar los libros con coautoria*/
		$_SESSION["coautoria"]["rewrite"]=1; /* 1. acceso permitido */
		$_SESSION["coautoria"]["nombre"]=$_POST["nombre"].' '.$_POST["ap_pa"];
		$rpta=1;
		
	}
	
	
	$bd->close();

	if($insertado > 0){
		$rpta =1;
		@mail($email_to_emp, $asunto_emp, $contenido_emp, $cabeceras_emp); /* empresa */
		@mail($email_to, $asunto, $contenido, $cabeceras); /* cliente */
	
	}else{
		$rpta =10;

	}

}
echo json_encode(array('rpta' => $rpta));
?>