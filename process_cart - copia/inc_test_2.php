<?php error_reporting(E_ALL);
session_start();
include_once("../tw7control/class/functions.php");
include_once("../tw7control/class/class.bd.php"); 

echo fecha_hora(2);

require_once '../vendor/autoload.php';
require('../vendor/infusionsoft/php-sdk/src/Infusionsoft/Api/ContactService.php');

$url = 'https://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? ':88/mori/tuweb7/w2019/withlove/' : '/' ); 

$rpta = 2;/*si es error*/
$bd = new BD;



$_POST["fecha_registro"]=fecha_hora(1); /* solo fecha */

$infusionsoft = new \Infusionsoft\Infusionsoft(array(
	'clientId' => 'hAgVQQ86FV2EeKZW7nhuhuI2GLnhaRnV',
    'clientSecret' => 'sRa4sAqTDZjMI96G',
    // 'redirectUri' => 'https://jhocamoagencia.com/enviar.php',
    'redirectUri' => 'https://www.educaauge.com/process_cart/inc_test.php',  /* aqui esto no tiene influencia, sol oapra generar el primer token del dia en otro archivo apip_hola */
));


$tagId=$tagId_registro=2100;	
$correo_cliente_api='soporte.miweb7@gmail.com';

$tagId_campana_shop=2110;	/* cod.curso 555 - */
$tagId_campana_shop=2106;	/* cod.curso 561 - */
/* Consulto si se genero el token del día */
$sql=" select * from tokens where fecha_registro ='".$_POST["fecha_registro"]."' ORDER by orden desc ";
$sql_token_anerior=" select * from tokens  ORDER by orden desc limit 0,1 "; /* se supone que es del dia anterior */


$token_del_dia=executesql($sql,0);
$token_anterior=executesql($sql_token_anerior,0);

if( !empty($token_del_dia) || !empty($token_anterior) ){
	
	if( !empty($token_del_dia) ){
		echo "del_dia";
			$_SESSION['token']=$token_del_dia["token"];
	}else if(  !empty($token_anterior) ){
			
		echo "del_dia_anterior";
			/* generamos nuevo token  */
			$_SESSION['token']=$token_anterior["token"];
	}
	
	
	if(isset($_SESSION['token']) ){
    $infusionsoft->setToken(unserialize($_SESSION['token'])); /* funcion set, para la generacion del token, llamamos el gettoken, para ser utilizado y crear contactos .. */

			echo $infusionsoft->refreshAccessToken();
			echo serialize($infusionsoft->refreshAccessToken());
			
	}
	
	// $infusionsoft->refreshAccessToken();  /* genero nuevo token ?? */

	if($infusionsoft->getToken() ){
		// echo "existe ";
			/* validar si ya existe el correo en la api */
			if( !empty($correo_cliente_api) ){
					
					$registro_desde=1;
							// $_POST['correo']='test_101@gmail.com';
					$campos= array(
								'FirstName' => 'Goten',
								'LastName' => 'test new token',
								'_datosderegistro' => 	$registro_desde,
								'StreetAddress1' => '1234567890',
								'Phone1' => '123456789',
								'Email' => $correo_cliente_api
					);
					
			
				
				
				$des=$infusionsoft->contacts('xml')->findByEmail($correo_cliente_api, array('Id') ); /* verifico si ya existe este correo registrado */
				// echo "x_5";
				if( count($des) == 0 ){
						echo "no registrado aun  ";
						
						
										/* si el correo no figura en la BD de infusionsoft, lo registramos */
							// echo "aqui registro.. ";
							$contactId= $infusionsoft->contacts('xml')->add($campos);  /* Registramos en la api */
							// echo 'Reg. OK'.$contactId;
							/* contactId --> IDCONTACTO */
										
							$infusionsoft->contacts('xml')->addToGroup($contactId, $tagId);  /* Asigno una etiqueta */
							// echo 'Reg. tag  OK'.$contactId;
							
							$infusionsoft->emails('xml')->optIn($_POST['correo'], "Home page newsletter subscriber"); /* permiso de consentiiento para recibir e-mails */

							
							/* FUNEL MAILS */
							$infusionsoft->funnels()->achieveGoal('ik813', 'registroeducaaugev1', $contactId);
					
				}else{
						echo " ya existe ";
						// echo var_dump($des);
						// echo '***-->'.$des[0]['Id'];
						
						// $contactId= $des[0]['Id'];
						// $tag_id_campana_shop=2082;
						
							// $infusionsoft->contacts('xml')->addToGroup($contactId, $tag_id_campana_shop);  /* Asigno una etiqueta de campaña de compra  */

							// echo "okeyy ps ";
				}
						

				
			} /* end if si existe correo de cliente  */
			
			
	}else{
		echo "token no existe ";
	} /* end if si existe el token api */
} /* end if si existe el token del día */


echo fecha_hora(2);

