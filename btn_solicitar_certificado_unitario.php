<?php include_once("auten.php");
include_once("tw7control/class/class.upload.php");

$url = 'https://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? ':88/mori/tuweb7/w2019/withlove/' : '/' );

$_POST['action']=isset($_POST['action'])?$_POST['action']:'';
$rpta = 2;/*si es error*/
if($_POST['action']=='registro'){

@$nombre  = $_POST["api_nombre"]   = utf8_decode(addslashes($_POST['nombre']));
@$_POST["api_paterno"]    = $_POST['ap_pa'];
@$_POST["api_materno"]    = $_POST['ap_ma'];
@$apellidos    = utf8_decode(addslashes($_POST['ap_pa'].' '.$_POST['ap_ma']));
@$dni     = utf8_decode(addslashes($_POST['dni']));
@$telefono  = utf8_decode(addslashes($_POST['telefono']));
@$email     = utf8_decode(addslashes($_POST['email']));


$dominio="educaauge.com";
// $mi_email="ventas@".$dominio;
$mi_email="noresponder@educaauge.com";
$nombre_empresa="GRUPO AUGE ";

$bd = new BD;
$_POST["estado_idestado"]=1;
$_POST["estado"]=2;
$_POST["estado_api"]=2; // para q valide desde el correo 
$_POST['orden'] = _orden_noticia("","solicitudes","");
$_POST['nombre_magisterio'] = '';
// $_POST["cursos"]= implode(',',$_POST['cursos']);
$_POST["fecha_registro"]=fecha_hora(2);
$_POST["id_suscrito"]= $_SESSION["suscritos"]["id_suscrito"];




// $campos=array('id_suscrito','id_pedido','nombre_magisterio',"nombre",'ap_pa','ap_ma','api_nombre','api_paterno','api_materno',"telefono","email","dni",'id_certificado','id_curso',"direccion","agencia","iddpto","iddist",'idprvc',"estado",'fecha_registro','estado_idestado','orden','estado_api');  // para ubigeo si va, se oculto por digital certificado

$campos=array('id_suscrito','id_pedido','nombre_magisterio',"nombre",'ap_pa','ap_ma','api_nombre','api_paterno','api_materno',"telefono","email","dni",'id_certificado','id_curso',"estado",'fecha_registro','estado_idestado','orden','estado_api');


if(isset($_FILES['voucher']) && !empty($_FILES['voucher']['name'])){
	$_POST['voucher'] = carga_imagen('tw7control/files/images/solicitud/','voucher','');
	$campos = array_merge($campos,array('voucher'));
}

// echo var_dump(arma_insert('solicitudes',$campos,'POST'));
// exit();

$insertado = $id_seguimiento =$bd->inserta_(arma_insert('solicitudes',$campos,'POST'));
$bd->close();


/*Para Empresa*/
$cabeceras_emp  = "From: ".$nombre_empresa." <$mi_email> \n"
. "Reply-To: $mi_email\n";
$cabeceras_emp .= 'MIME-Version: 1.0' . "\r\n";
$cabeceras_emp .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$asunto_emp     = " Nueva Solicitud de certificado -  ".$nombre_empresa;
$email_to_emp   = $mi_email;
$contenido_emp  = "
<p><br />
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

//cuerpo mensaje
$asunto     =  $dominio.', valida los datos para tu certificado ';
$contenido  = '<p><br><br></p>
<div style="max-width: 580px; margin: 0 auto; padding: 20px 25px 60px; background: #f9f9f9"><img src="https://www.'.$dominio.'/img/send_email/cabezera_logo2.png">
<p style="font-size: 15px"><br>Estimado(a) '.$nombre.' <br>'.$dominio.', le hace llegar los datos que se emplearan en su certificado, para su validación de estar todo correcto o dar click en editar si fuera necesario. <br></br>
</p>
<div style="text-align:left;">';

$contenido.='
<div style="width:100%;float:left;padding:20px 15px;margin:0;"><a >														
<div style="display:inline-block;">
	<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">NOMBRE: <span style="float: right;font-weight: 800;">'.$_POST['nombre'].'</span></p>
	<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">AP. PATERNO: <span style="float: right;font-weight: 800;">'.$_POST['ap_pa'].'</span></p>
	<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">AP. MATERNO: <span style="float: right;font-weight: 800;"> '.$_POST['ap_ma'].'</span></p>
	<!-- 
	<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">DIRECCIÓN: <span style="float: right;font-weight: 800;"> '.$_POST['direccion'].'</span></p>
	<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">AGENCIA: <span style="float: right;font-weight: 800;"> '.$_POST['agencia'].'</span> <br></br> </p>		
	-->									
</div>  					
</a></div>';

$contenido.= " <div style='max-width:400px;padding:50px 15px 20px;margin:0 auto;' >
<p style='padding:20px 0;'> </br> </p>

<a href='https://www.educaauge.com/approbeseguimiento/".$_POST["id_suscrito"]."/".$id_seguimiento."' style='padding: 15px 20px;background:green;color:#fff;font-size:19px;text-decoration: none;
border-radius: 8px;margin-top:30px;'> 
	Click para aprobar datos 
</a>
<p style='padding:20px 0;'> ó </p>
<br></br> 
<a href='https://www.educaauge.com/updateseguimiento/".$_POST["id_suscrito"]."/".$id_seguimiento."' style='padding: 15px 20px;background:red;color:#fff;font-size:19px;text-decoration: none;
border-radius: 8px;margin-top:30px;' >
	 Click para <b>actualizar</b> datos 
</a>
</div> ";

$contenido.='</div>
<p style="font-size: 12px">&nbsp;</p>
<p style="font-size: 14px">Ante cualquier duda, les invitamos a ponerse en comunicaci&oacute;n con nosotros.<br><br>Saludos cordiales,<br>- El Equipo '.$dominio.'<br><br><br></p> 
</div> ';





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