<?php error_reporting(E_ALL);
session_start();
include_once("../tw7control/class/functions.php");
include_once("../tw7control/class/class.bd.php"); 

/*  infu */ 
require_once '../vendor/autoload.php';
require('../vendor/infusionsoft/php-sdk/src/Infusionsoft/Api/ContactService.php');
$token = file_get_contents("../token/token/token.json"); //Obtiene el token del archivo (se puede cambiar a su base de datos)
/* end */


$url = 'https://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? ':88/mori/tuweb7/w2019/withlove/' : '/' ); 
$_POST['action']=isset($_POST['action'])?$_POST['action']:'';
$rpta = 2;/*si es error*/
$email='';
$dni='';
$id_suscrito='';
$link_go='';
$bd = new BD;

$minutos_en_segundos_permitidos_para_la_sesion_del_usuario=1200;  // para validar a los falsos conetcados q no cierran sesion 


if($_POST['action']=='registro'){
	
	require_once "inc/recaptchalib.php";
	$secret = "6LfUxLcdAAAAAC36NTm4-FSBf6WgkRfOpNQ7TC9N"; // your secret key
	$response = null; // empty response
	$reCaptcha = new ReCaptcha($secret); // check secret key

	// if submitted check response - Captura valor de recaptcha
	// if($_POST["g-recaptcha-response"]){
		// $response = $reCaptcha->verifyResponse(
			// $_SERVER["REMOTE_ADDR"],
			// $_POST["g-recaptcha-response"]
		// );
	// }
		

		
		
	// if($response != null && $response->success){ //si no es robot
			

		@$email     = utf8_decode(addslashes($_POST['email']));

		if(filter_var($email, FILTER_VALIDATE_EMAIL) ){
			
			$explode = explode("@", $email);
			// if ($explode[1] == "gmail.com") {  /* solo permitimos  registros de correos:: GMAIL */			
		
					$mi_email= $email;
					$mi_email_no_reply="no-reply@educaauge.com";
					$nombre_empresa="EDUCA AUGE ";



					@$nombre    = utf8_decode(addslashes($_POST['nombre']));
					@$apellidos    = utf8_decode(addslashes($_POST['ap_pa'].' '.$_POST['ap_ma']));
					@$dni     = utf8_decode(addslashes($_POST['dni']));
					@$telefono  = utf8_decode(addslashes($_POST['telefono']));
					$_POST["fecha_registro"]=fecha_hora(2);
					$_POST["hora_registro"]=fecha_hora(0);
					$_POST["orden"]=1;
					$_POST["clave"]=md5($_POST["clave"]);
					$_POST["estado_idestado"]=1;
					$_POST["estado"]=1;
					// $_POST["id_pais"]=1;  // momentaneo ya que se acorto el registro de cliente. y se oculto la opcion de seleccioanr pais 

					/* saco prefijo del pais */
					$pais=executesql("select * from paises where id_pais='".$_POST["id_pais"]."' ");
					// if( $_POST["id_pais"] != '1'){ /* si es diferente a peru se agrega prefijo al numero */
						$_POST['telefono']= !empty($pais[0]['prefijo'])? $pais[0]['prefijo'].''.$_POST['telefono']: $_POST['telefono'];						
					// }

							
							 
						/* VALIDO SI YA EXISTE EL DNI */
						$validate_telefono=executesql("select * from suscritos where estado_idestado=1 and telefono='".$_POST['telefono']."' ");
						if(!empty($validate_telefono) ){
								/* si ya existe frustamos el registro...  */			
								 $rpta="existe_telefono";
								 $id_suscrito=$validate_dni[0]["id_suscrito"];

								 
								 
						}else{
							
							/* VALIDO SI YA EXISTE EL DNI */
								$validate_dni=executesql("select * from suscritos where estado_idestado=1 and dni='".$dni."' ");
								if(!empty($validate_dni) ){
										/* si ya existe frustamos el registro...  */			
										 $rpta="existe_dni";
										 $id_suscrito=$validate_dni[0]["id_suscrito"];
										 
								}else{
									/* si dni es nuevo, normal registramos proceso */
									$validate_email=executesql("select * from suscritos where estado_idestado=1 and email='".$email."' ");
									if(!empty($validate_email) ){
										 $rpta="existe_email";
										 $id_suscrito=$validate_email[0]["id_suscrito"];
										 
									}else{
										/* todo bien::: cliente nuevo registramos */
										include('registro_v2_inc_proceso_completo.php');
										
									}

								} /* END if  si el dni no existe completamos el registro */
						} /* END validate telefono */
						
				// }else{
					// $rpta='ingresa_email_gmail';  /*  VALIDO SOLO GMAIL */
				// }
				
			}else{
				$rpta='email_no_valido';				
			}
	
	// }else{  // si es robot :  error 
		// $rpta='soy_robot';
	// }
			
} /* end post action*/



echo json_encode(
	array(
		'rpta' => $rpta, 
		'dni' => $dni, 
		'email' => $email,
		'id_suscrito' => $id_suscrito,
		'link_go' => $link_go
	)
);
?>