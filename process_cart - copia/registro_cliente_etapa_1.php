<?php header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL); session_start();
require("../tw7control/class/class.bd.php"); 
require("../tw7control/class/functions.php");
require("../tw7control/class/class.upload.php");

$url = 'http://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? '/mori/yoemprendo/zsoli/' : '/' ); 

$rpta="no";
$link_go=isset($_SESSION["url"])?$_SESSION["url"]:"";



require_once "../inc/recaptchalib.php";
$secret = "6LfUxLcdAAAAAC36NTm4-FSBf6WgkRfOpNQ7TC9N"; // your secret key
$response = null; // empty response
$reCaptcha = new ReCaptcha($secret); // check secret key


// if submitted check response - Captura valor de recaptcha
	if($_POST["g-recaptcha-response"]){
		$response = $reCaptcha->verifyResponse(
			$_SERVER["REMOTE_ADDR"],
			$_POST["g-recaptcha-response"]
		);
	}
	
// if($response != null && $response->success){ //si no es robot
		// echo "Hi thanks for submitting the form!";	

			$bd = new BD;
			$_POST["estado_idestado"]=1;
			$_POST["fecha_registro"]=fecha_hora(1);
			$_POST["orden"]=_orden_noticia("","suscritos","");

			$sql= "select * from suscritos where email='".$_POST["email"]."' "; 
			$vallogingoo=executesql($sql);
			if(empty($vallogingoo)){
				// Registramos nuevo cliente 
				// si no existe cleinte, registramos nuevo cliente 
				$_POST['clave']=md5($_POST['clave']);
				$campos=array("email","clave","fecha_registro","orden","estado_idestado");
				// echo var_dump(arma_insert("suscritos",$campos,"POST"));
				// exit();
				
				$insertado=$bd->inserta_(arma_insert("suscritos",$campos,"POST"));
				
				if($insertado > 0){
					$_SESSION["suscritos"]["id_suscrito"]=$insertado;
					$_SESSION["suscritos"]["email"]=$_POST["email"];
					$rpta = 'completar_datos';
					
					
				}
				
			}else{	
					// si ya existe
					// validamos si esta completa su información sino lo enviamos ala registro
					// es informacion sensible para hacer compras en ecommerce. 			
					// if( empty($vallogingoo[0]['nombre']) || empty($vallogingoo[0]['ap_pa']) || empty($vallogingoo[0]['ap_ma']) || empty($vallogingoo[0]['telefono']) || empty($vallogingoo[0]['email']) || empty($vallogingoo[0]['dni'])  || empty($vallogingoo[0]['ciudad'])  || empty($vallogingoo[0]['direccion'])   ){
				
				if( empty($vallogingoo[0]['nombre'])  || empty($vallogingoo[0]['telefono']) || empty($vallogingoo[0]['email']) ){
						$rpta = 'completar_datos';
						$_SESSION["suscritos"]["id_suscrito"]=$vallogingoo[0]['id_suscrito'];
						$_SESSION["suscritos"]["email"] =  $_POST["email"];

						
					}else{
						$_SESSION["suscritos"]["id_suscrito"]=$vallogingoo[0]['id_suscrito'];
						$_SESSION["suscritos"]["email"] =  $_POST["email"];
						$rpta = 'ya_existe'; 		
					}
					
			}	


			// include('webinar_registro_de_clientes_x_webinar_leads.php');

				
// }else{  // si es robot :  error 
	// $rpta='robot';

// }

// echo  $rpta;
echo json_encode(array(    
	"res" => $rpta ,
	"link_go" => $link_go 
)); 
	

?>
