<?php error_reporting(E_ALL);
session_start();
include_once("../tw7control/class/functions.php");
include_once("../tw7control/class/class.bd.php"); 

echo fecha_hora(2);

unset($_SESSION['token']);

require_once '../vendor/autoload.php';
require('../vendor/infusionsoft/php-sdk/src/Infusionsoft/Api/ContactService.php');

$url = 'https://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? ':88/mori/tuweb7/w2019/withlove/' : '/' ); 

$rpta = 2;/*si es error*/
$bd = new BD;

echo "A1";

$_POST["fecha_registro"]=fecha_hora(1); /* solo fecha */

$infusionsoft = new \Infusionsoft\Infusionsoft(array(
	'clientId' => 'hAgVQQ86FV2EeKZW7nhuhuI2GLnhaRnV',
    'clientSecret' => 'sRa4sAqTDZjMI96G',
    // 'redirectUri' => 'https://jhocamoagencia.com/enviar.php',
    'redirectUri' => 'https://www.educaauge.com/process_cart/inc_test.php',  /* aqui esto no tiene influencia, sol oapra generar el primer token del dia en otro archivo apip_hola */
));

echo "B1";

$tagId_registro=2100;	
$correo_cliente_api='ing.moriayala@gmail.com';

$tagId_campana_shop=2110;	/* cod.curso 555 - */
$tagId_campana_shop=2106;	/* cod.curso 561 - */
/* Consulto si se genero el token del día */
$sql=" select * from tokens where fecha_registro ='".$_POST["fecha_registro"]."' ORDER by ide desc ";
$sql_token_anerior=" select * from tokens  ORDER by ide desc limit 0,1 "; /* se supone que es del dia anterior */


$token_del_dia=executesql($sql,0);
$token_anterior=executesql($sql_token_anerior,0);

echo "C1";
if( !empty($token_del_dia) || !empty($token_anterior) ){
	
	if( !empty($token_del_dia) ){
			$_SESSION['token']=$token_del_dia["token"];
	echo "D1 -> EXISTE";
	
	echo $token_anterior["token"];
	echo "===>>>E1  EXISTE";
	
	/* generamos nuevo token  */
				 $infusionsoft->setToken('9uJdXJSJwB7Yensn1Xn1eiLTn4fZElGg');
				echo var_dump($infusionsoft->setToken('9uJdXJSJwB7Yensn1Xn1eiLTn4fZElGg'));
				echo "__________";
			$infusionsoft->refreshAccessToken();

// echo $infusionsoft->setToken($token_anterior["token"]);

				// $infusionsoft->refreshAccessToken();
				
						
	
	echo "x1";
	echo $infusionsoft->refreshAccessToken();
	echo "x2";
	echo var_dump($infusionsoft->refreshAccessToken());
	
				$_POST['token'] = $_SESSION['token'] = serialize($infusionsoft->refreshAccessToken());
				$token_array=array('token','fecha_registro','fecha_hora');
				
	echo "yyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy";
				$insertado=$bd->inserta_(arma_insert("tokens",$token_array,"POST"));
	echo "E1 -> ERROR EXISTE";

			
	
	
	}else if(  $token_anterior ){
			
			
			$_SESSION['token']=$token_anterior["token"];
	}
	
	
	if(isset($_SESSION['token']) ){
    $infusionsoft->setToken(unserialize($_SESSION['token'])); /* funcion set, para la generacion del token, llamamos el gettoken, para ser utilizado y crear contactos .. */
	}
	
	// $infusionsoft->refreshAccessToken();  /* genero nuevo token ?? */

	if($infusionsoft->getToken() ){
		// echo "existe ";
			/* validar si ya existe el correo en la api */
			if( !empty($correo_cliente_api) ){
				
				$des=$infusionsoft->contacts('xml')->findByEmail($correo_cliente_api, array('Id') ); /* verifico si ya existe este correo registrado */
				// echo "x_5";
				if( count($des) == 0 ){
						echo "no registrado aun  ";
					
				}else{
						echo " ya existe ";
						// echo var_dump($des);
						// echo '***-->'.$des[0]['Id'];
						
						$contactId= $des[0]['Id'];
						$tag_id_campana_shop=2082;
						
							$infusionsoft->contacts('xml')->addToGroup($contactId, $tag_id_campana_shop);  /* Asigno una etiqueta de campaña de compra  */

							echo "okeyy ps ";
				}
						

				
			} /* end if si existe correo de cliente  */
			
			
	}else{
		echo "token no existe ";
	} /* end if si existe el token api */
} /* end if si existe el token del día */


echo fecha_hora(2);

