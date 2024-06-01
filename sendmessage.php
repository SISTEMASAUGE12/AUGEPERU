<?php session_start();
error_reporting(0);
require("tw7control/class/class.bd.php");
require("tw7control/class/functions.php");
include_once("tw7control/class/class.upload.php");


$_POST['action'] = isset($_POST['action']) ? $_POST['action'] : '';
$rpta  = 2;

if($_POST['action']=='recuperar'){
    $bd=new BD;
		@$email     = utf8_encode(utf8_decode($_POST['correo']));
		
		// @$dni     = utf8_encode(utf8_decode($_POST['dni']));
    $sql_mail="SELECT * FROM suscritos WHERE email = '".$email."'";
		
		// echo $sql_mail;
		
		$usuario = executesql($sql_mail);
    if(!empty($usuario)){

			$email= $usuario[0]["email"];

    	$mi_email="noresponder@educaauge.com";
    	//Preparamos el mensaje hacia la web
    	$cabeceras  = "From:  EducaAuge.com <$mi_email> \n"
     . "Reply-To: $mi_email\n";
    	$cabeceras .= 'MIME-Version: 1.0' . "\r\n";
    	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    	$asunto     = "Recuperacion de contrasena | EducaAuge.com ";
    	$email_to   = $email;

		$contenido  = '<p><br><br></p>
		<div style="max-width: 580px; margin: 0 auto; padding: 20px 25px 60px; background: #f9f9f9"><img src="https://www.educaauge.com/img/logo.png"><p style="font-size: 15px"><br><br><br><strong>Hola '.$usuario[0]["nombre"].',</strong><br> Bienvenido!, Desde el link ubicado en la parte de abajo podras entrar a cambiar tu contrase&ntilde;a</p>
			<div style="text-align:center;">
			<p style="font-size: 12px;"><strong>-&nbsp;</strong><a href="https://www.educaauge.com/recuperar/198237434563476584376583476587364857634756872'.$usuario[0]["id_suscrito"].'" target="_blank" rel="noopener noreferrer" style="font-weight: bold;text-decoration: none;
			    display: inline-block;
			    max-width: 352px;
			    width: 100%;
			    margin: 0;
			    font-size: 17.5px;
			    letter-spacing: -1px;
			    text-align: center;
			    -webkit-border-radius: 5px;
			    -moz-border-radius: 5px;
			    border-radius: 5px;
			    padding: 12px;
			    background: #092F56;
			    color: #fff;" >Recuperar contrase&ntilde;a</a></p>
			</div>
		</div> ';
    	
			$rpta = 1;
			if(@mail($email_to, $asunto, $contenido, $cabeceras)){ 
			}
			
    }
		
}elseif($_POST['action']=='actualizar'){
    $bd=new BD;
	@$email     = utf8_encode(utf8_decode($_POST['correo']));
	@$clave     = utf8_encode(utf8_decode($_POST['clave']));
	$contrasena=md5($clave);
  	$campos=array(array("clave",$contrasena));
  	$where =" email='".$email."'";
  	$query=armaupdate("suscritos",$campos,$where,"POST");
  	$i=$bd->actualiza_($query);
  	$bd->close();
  	if($i>0) $rpta = 1;
		
		
		
}elseif($_POST['action']=='actualizar_v2'){
	/* nueva fora, actuliza directamente ingresando un correo y dni */
	$bd=new BD;
	@$dni     = utf8_encode(utf8_decode($_POST['dni']));
	// @$email     = utf8_encode(utf8_decode($_POST['email']));
	@$clave     = utf8_encode(utf8_decode($_POST['clave']));
	
	// if( !empty($email) &&  !empty($dni) &&  !empty($clave) ){
	if(  !empty($dni) &&  !empty($clave) ){
		
		// $sql_consulta="select * from suscritos where email='".$_POST["email"]."' and dni='".$_POST["dni"]."' "; 
		$sql_consulta="select * from suscritos where  dni='".$_POST["dni"]."' "; 
		$consulta=executesql($sql_consulta);
		
		if( !empty($consulta) ){
			// echo "entro ???".$consulta[0]['id_suscrito'];
			
			$email= $consulta[0]['email'];

			/* si encontro los datos actulizamos */
			$contrasena=md5($clave);
			$campos=array(array("clave",$contrasena));
			// $where =" email='".$email."'";
			$where =" dni='".$dni."'";
			$query=armaupdate("suscritos",$campos,$where,"POST");
			
			$i=$bd->actualiza_($query);

			//echo $i; 

			$bd->close();
			$rpta = 1; 
			
			
			if($rpta==1){ 		
					$mi_email="noresponder@educaauge.com";
					//Preparamos el mensaje hacia la web
					$cabeceras  = "From:  EducaAuge.com <$mi_email> \n"
				 . "Reply-To: $mi_email\n";
					$cabeceras .= 'MIME-Version: 1.0' . "\r\n";
					$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$asunto     = "Recuperacion de contrasena | EducaAuge.com ";
					$email_to   = $email;

					$contenido  = '<p><br><br></p>
					<div style="max-width: 580px; margin: 0 auto; padding: 20px 25px 60px; background: #f9f9f9"><img src="https://www.educaauge.com/img/logo.png"><p style="font-size: 15px"><br><br><br><strong>Hola '.$email.',</strong><br> Haz actualizado tu clave en educaauge.com!, </p>
						<div style="text-align:center;">
					
						</div>
					</div> ';
			}
			
			
		} /*  end if consulta */
	} /* *cvalido q no etsen vacios los datos  */
	
		
		
		
		
}elseif($_POST['action']=='comentario'){
    $bd=new BD;
	@$id_curso		= utf8_encode(utf8_decode($_POST['id_curso']));
	@$id_detalle    = utf8_encode(utf8_decode($_POST['id_detalle']));
	@$id_sesion     = utf8_encode(utf8_decode($_POST['id_sesion']));
	@$id_suscrito 	= utf8_encode(utf8_decode($_POST['id_suscrito']));
	@$comen     	= utf8_encode(utf8_decode($_POST['comen']));
	$fecha 		= fecha_hora(2);
	$orden = _orden_noticia("","comentario","");
	$campo = array(array('id_suscrito',$id_suscrito),array('id_curso',$id_curso),array('id_detalle',$id_detalle),array('id_sesion',$id_sesion),array('comen',$comen),array('fecha_registro',$fecha),array('orden',$orden),array('estado_idestado',2));
	$i = $bd->inserta_(arma_insert('comentario',$campo,'POST'));
  	$bd->close();
  	if($i>0) $rpta = 1;
	
	
}elseif($_POST['action']=='convocatoria'){ 


	/* contacto */
	$url="https://www.educaauge.com/convocatoria";
	require_once "inc/recaptchalib.php";
	$secret = "6LfUxLcdAAAAAC36NTm4-FSBf6WgkRfOpNQ7TC9N"; // your secret key

	$response = null; // empty response
	$reCaptcha = new ReCaptcha($secret); // check secret key

	/*
	if($_POST["g-recaptcha-response"]){
		$response = $reCaptcha->verifyResponse(
			$_SERVER["REMOTE_ADDR"],
			$_POST["g-recaptcha-response"]
		);
	}



	if($response != null && $response->success){ //si no es robot
*/

		/* contacto */
		@$nombre     = utf8_encode(utf8_decode($_POST['nombre']));
		@$email     = utf8_encode(utf8_decode($_POST['correo']));
		@$fono     = utf8_encode(utf8_decode($_POST['fono']));
		@$asunto     = utf8_encode(utf8_decode($_POST['asunto']));
		@$mensaje     = utf8_encode(utf8_decode($_POST['mensaje']));


		$_POST['estado_idestado']=1;
		$_POST['fecha_registro']=fecha_hora(2);
		$campos=array('nombre', 'mensaje','fono','correo','asunto',"estado_idestado",'fecha_registro'); 

		if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
			$_POST['imagen'] = carga_imagen('tw7control/files/images/contactos/','imagen','','234','23432');
			$campos = array_merge($campos,array('imagen'));
		}

		// echo var_dump($campos);
		//exit();


	$mi_email="noresponder@educaauge.com";

	 $email_to="informes@educaauge.com";
	//  $email_to="jopedis85@gmail.com";


	//Preparamos el mensaje hacia la web
	$cabeceras  = "From:  EducaAuge.com <$mi_email> \n"
 . "Reply-To: $mi_email\n";
	$cabeceras .= 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$asunto     = " CONVOCATORIA Mensaje desde contacto web  | EducaAuge.com ";

		$contenido  = '<p><br><br></p>
		<div style="max-width: 580px; margin: 0 auto; padding: 20px 25px 60px; background: #f9f9f9"><img src="https://www.educaauge.com/img/logo.png"><p style="font-size: 15px"><br><br><br>
		
			<strong>Nuevo mensaje desde la web:: contacto ,</strong><br> DATOS: <br> <br>
				NOMBRE: '.$_POST["nombre"].'  <br>
				EMAIL: '.$_POST["correo"].'  <br>
				CELULAR: '.$_POST["fono"].'  <br>
				ASUNTO: '.$_POST["asunto"].'  <br>
				MENSAJE: '.$_POST["mensaje"].'  <br><br>
			</p';
			
		if(!empty($_POST["imagen"]) ){ 
			$imagen_file="https://www.educaauge.com/tw7control/files/images/contactos/".$_POST["imagen"];
			$contenido.= 
			'<div style="text-align:center;">
					<p style="font-size: 12px;"><strong>-&nbsp;</strong>
						<a href="'.$imagen_file.'" target="_blank" rel="noopener noreferrer" style="font-weight: bold;text-decoration: none;
							display: inline-block;
							max-width: 352px;
							width: 100%;
							margin: 0;
							font-size: 17.5px;
							letter-spacing: -1px;
							text-align: center;
							-webkit-border-radius: 5px;
							-moz-border-radius: 5px;
							border-radius: 5px;
							padding: 12px;
							background: #092F56;
							color: #fff;" >Ver archivo adjunto </a>
					</p>
			</div>
			';
		}
			
		$contenido.='</div> ';
    	


	
		$bd=new BD;

		$inserto=$bd->inserta_(arma_insert('contactos',$campos,'POST'));
		
		if($inserto > 0){
			$rpta = 1;
		?>
		
		<script type='text/javascript'>
<?php
			if(@mail($email_to, $asunto, $contenido, $cabeceras)){
						
				echo "alert('Enviado. Pronto, nos pondremos en contacto con usted..');document.location=('".$url."');";
			}else{
				echo "alert('Error: Su informaci\u00F3n no pudo ser enviada, intente m\u00E1s tarde.');document.location=('".$url."');";
			}
			?>
		</script>
<?php 	
		} /* end si registro :: inserto  */

/*
	}else{ /* si no marco:: no soy robot  */
?>
		<script type='text/javascript'>
				<?php echo "alert('Debes marcar el check de No soy robot');document.location=('".$url."');";?>
		</script>
<?php 	
/*
	}  /* end no soy robot validacion  */

	

}else{
	/* contacto */
	$url="https://www.educaauge.com/contacto";
	require_once "inc/recaptchalib.php";
	$secret = "6LfUxLcdAAAAAC36NTm4-FSBf6WgkRfOpNQ7TC9N"; // your secret key
	$response = null; // empty response
	$reCaptcha = new ReCaptcha($secret); // check secret key

	/*
	if($_POST["g-recaptcha-response"]){
		$response = $reCaptcha->verifyResponse(
			$_SERVER["REMOTE_ADDR"],
			$_POST["g-recaptcha-response"]
		);
	}

	if($response != null && $response->success){ //si no es robot
	/* contacto */
	@$nombre     = utf8_encode(utf8_decode($_POST['nombre']));
	@$email     = utf8_encode(utf8_decode($_POST['correo']));
	@$fono     = utf8_encode(utf8_decode($_POST['fono']));
	@$asunto     = utf8_encode(utf8_decode($_POST['asunto']));
	@$mensaje     = utf8_encode(utf8_decode($_POST['mensaje']));


	$_POST['estado_idestado']=1;
	$_POST['fecha_registro']=fecha_hora(2);
	$campos=array('nombre', 'mensaje','fono','correo','asunto',"estado_idestado",'fecha_registro'); 

	if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
		$_POST['imagen'] = carga_imagen('tw7control/files/images/contactos/','imagen','','','');
		$campos = array_merge($campos,array('imagen'));
	}


	$mi_email="noresponder@educaauge.com";

	 $email_to="informes@educaauge.com";
	//  $email_to="jopedis85@gmail.com";


	//Preparamos el mensaje hacia la web
	$cabeceras  = "From:  EducaAuge.com <$mi_email> \n"
 . "Reply-To: $mi_email\n";
	$cabeceras .= 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$asunto     = " CONTACTO Mensaje desde contacto web  | EducaAuge.com ";

		$contenido  = '<p><br><br></p>
		<div style="max-width: 580px; margin: 0 auto; padding: 20px 25px 60px; background: #f9f9f9"><img src="https://www.educaauge.com/img/logo.png"><p style="font-size: 15px"><br><br><br>
		
			<strong>Nuevo mensaje desde la web:: contacto ,</strong><br> DATOS: <br> <br>
				NOMBRE: '.$_POST["nombre"].'  <br>
				EMAIL: '.$_POST["correo"].'  <br>
				CELULAR: '.$_POST["fono"].'  <br>
				ASUNTO: '.$_POST["asunto"].'  <br>
				MENSAJE: '.$_POST["mensaje"].'  <br><br>
			</p';
			
		if(!empty($_POST["imagen"]) ){ 
			$imagen_file="https://www.educaauge.com/tw7control/files/images/contactos/".$_POST["imagen"];
			$contenido.= 
			'<div style="text-align:center;">
					<p style="font-size: 12px;"><strong>-&nbsp;</strong>
						<a href="'.$imagen_file.'" target="_blank" rel="noopener noreferrer" style="font-weight: bold;text-decoration: none;
							display: inline-block;
							max-width: 352px;
							width: 100%;
							margin: 0;
							font-size: 17.5px;
							letter-spacing: -1px;
							text-align: center;
							-webkit-border-radius: 5px;
							-moz-border-radius: 5px;
							border-radius: 5px;
							padding: 12px;
							background: #092F56;
							color: #fff;" >Ver archivo adjunto </a>
					</p>
			</div>
			';
		}
			
		$contenido.='</div> ';
    	


		// echo var_dump(arma_insert('contactos',$campos,'POST'));
		// exit();

		$bd=new BD;

		$inserto=$bd->inserta_(arma_insert('contactos',$campos,'POST'));
		
		if($inserto > 0){
			$rpta = 1;
		?>
		
		<script type='text/javascript'>
<?php
			if(@mail($email_to, $asunto, $contenido, $cabeceras)){
						
				echo "alert('Enviado. Pronto, nos pondremos en contacto con usted..');document.location=('".$url."');";
			}else{
				echo "alert('Error: Su informaci\u00F3n no pudo ser enviada, intente m\u00E1s tarde.');document.location=('".$url."');";
			}
			?>
		</script>
<?php 	
		} /* end si registro :: inserto  */


	/* }else{ /* si no marco:: no soy robot  */
?>
		<script type='text/javascript'>
				<?php echo "alert('Debes marcar el check de No soy robot');document.location=('".$url."');";?>
		</script>
<?php 	

	/* }  /* end no soy robot validacion  */
    
}

echo json_encode(array('rpta' => $rpta ));
?>