<?php error_reporting(E_ALL); 
session_start();
require_once 'vendor/autoload.php';

// include_once("intranet/class/functions.php");
// include_once("intranet/class/class.bd.php");

include_once("tw7control/class/functions.php");
include_once("tw7control/class/class.bd.php");

require('vendor/infusionsoft/php-sdk/src/Infusionsoft/Api/ContactService.php');


$bd = new BD;
$bd->Begin();
$_POST["fecha_registro"]=fecha_hora(1); /* solo fecha */
$_POST["fecha_hora"]=fecha_hora(2);
$_POST["fecha_hoy"]=fecha_hora(2);

	
$infusionsoft = new \Infusionsoft\Infusionsoft(array(
	'clientId' => 'hAgVQQ86FV2EeKZW7nhuhuI2GLnhaRnV',
    'clientSecret' => 'sRa4sAqTDZjMI96G',
    // 'redirectUri' => 'https://jhocamoagencia.com/api_hola.php',
    'redirectUri' => 'https://www.educaauge.com/api_hola.php',
));


/* Consulto si se genero el token del día */
$sql=" select * from tokens where fecha_registro ='".$_POST["fecha_registro"]."' ORDER by orden desc ";  /* token diario generate */

// $sql=" select * from tokens  ORDER by orden desc limit 0,1";  /* un solo token:  trabajo con el ultimo creado */
// echo $sql;

$token_del_dia=executesql($sql,0);
if( !empty($token_del_dia) ){
	/* ya existe un token creado actualmnte  */
	
	echo "<h1 style='padding:50px;'>TK DEL DIA ->".$token_del_dia["token"].'</h1>';
	$_SESSION['token']=$token_del_dia["token"];
	
	// if (isset($_SESSION['token'])) { 
    // $infusionsoft->setToken(unserialize($_SESSION['token'])); /* funcion set, para la generacion del token, llamamos el gettoken, para ser utilizado y crear contactos .. */
	// }

	// if ($infusionsoft->getToken()) {
    
			// $campos= array('FirstName' => 'LUISILLO 2', 'LastName' => 'Mori', 'Email' => 'desarrollo@tuweb7.com');
			// $ide_contacto= $infusionsoft->contacts('xml')->add($campos);
			// echo 'Reg. OK'.$ide_contacto;
			
	// }else {
		// echo 'Primero crea un TOKEN del dia. ';
	// }
	

}else{
	/* GENERO EL NUEVO TOKEN */
	// unset($_SESSION['token']);  /* si existe una sesion activa la elimino para crear el nuevo token */

		if (isset($_SESSION['token'])) { 
				// echo 'YA EXISTE ->'.$_SESSION['token'];
				unset($_SESSION['token']); /* si existe un token, elimino la sesssion */
				// $infusionsoft->setToken(unserialize($_SESSION['token']));
		}

		if (isset($_GET['code']) and !$infusionsoft->getToken()) {
				echo 'Existe CODE -> ';
				$infusionsoft->requestAccessToken($_GET['code']);   /* codigo necesari para crear el token */
				// $_SESSION['token'] = serialize($infusionsoft->requestAccessToken($_GET['code']));
				// echo ($_SESSION['token']);
		}


		if ($infusionsoft->getToken()) {
				
				$_POST['token'] = $_SESSION['token'] = serialize($infusionsoft->getToken());
				$_POST['orden'] = _orden_noticia("","tokens","");
				$token_array=array('token','fecha_registro','fecha_hora','orden');
				
				$insertado=$bd->inserta_(arma_insert("tokens",$token_array,"POST"));


				// $campos= array('FirstName' => 'LUISILLO', 'LastName' => 'Mori', 'Email' => 'desarrollo@tuweb7.com');
				// $infusionsoft->contacts('xml')->add($campos);
				// echo 'Reg. OK';
				
				echo '<h1 style="padding:50px;">TOKEN DEL DÍA '.fecha_hora(2).' </br>CREADO. OKEY </h1>';
				
		}else {
			echo 'Primero debes iniciar sesión en tu cuenta de Infusionsoft!';
			echo '<a href="' . $infusionsoft->getAuthorizationUrl() . '" style="background:red;color:#fff;padding:6px 10px;border-radius:5px;display:block;font-size:35px;line-height:35px;max-width:250px;margin-top:20px;text-decoration:none;">Click para crear Token </a>';

		}

}  /* IF END */

