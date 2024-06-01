<?php header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL); session_start();
require("../tw7control/class/class.bd.php"); 
require("../tw7control/class/functions.php");
require("../tw7control/class/class.upload.php");

$url = 'http://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? '/mori/yoemprendo/zsoli/' : '' ); 
$rpta="no";


			$bd = new BD;
			$_POST["estado_idestado"]=1;
			$_POST["fecha_registro"]=fecha_hora(1);
			$_POST["orden"]=_orden_noticia("","suscritos","");
			
			$vallogingoo=executesql("select *from suscritos where email='".$_POST["email"]."'",0);
			if(empty($vallogingoo)){
				// si no existe cleinte, registramos
				$_POST['registro_desde']='2'; /* reg. con Google */  

				$campos=array('id_fb',"nombre","email","fecha_registro","orden","estado_idestado",'registro_desde');
				$insertado=$bd->inserta_(arma_insert("suscritos",$campos,"POST"));
				
				if($insertado > 0){
					$_SESSION["suscritos"]["id_suscrito"]=$insertado;
					$_SESSION["suscritos"]["email"]=$_POST["email"];
					$_SESSION["suscritos"]["registro_desde"]=$_POST["registro_desde"];
					$rpta = 'completar_datos';
				}
				
			}else{	
					// si ya existe
					// validamos si esta completa su información sino lo enviamos ala registro
					// es informacion sensible para hacer compras en ecommerce. 			
					$_SESSION["suscritos"]["id_suscrito"]=$vallogingoo['id_suscrito'];
					$_SESSION["suscritos"]["email"]=$vallogingoo['email'];
					$_SESSION["suscritos"]["registro_desde"]='2';

					// if( empty($vallogingoo['id_pais']) || empty($vallogingoo['nombre']) || empty($vallogingoo['ap_pa']) || empty($vallogingoo['ap_ma']) || empty($vallogingoo['telefono']) || empty($vallogingoo['email']) || empty($vallogingoo['dni'])  || empty($vallogingoo['ciudad'])  || empty($vallogingoo['direccion'])   ){
					
					if( empty($vallogingoo['nombre']) ||  empty($vallogingoo['dni']) || empty($vallogingoo['telefono']) || empty($vallogingoo['email'])  || empty($vallogingoo['id_especialidad'])   ){
						$rpta = 'completar_datos';
						
					}else{
						$rpta = 'ya_existe'; 		
					}
						
					/* API INFUSUSION SOFT */
					/* ID CATE: 28 --> EDUCACAUGE */
					/* ID TAG: 2100 --> REG. COMUN  EDUCACAUGE ******************  */
							
						require_once '../vendor/autoload.php';
						require('../vendor/infusionsoft/php-sdk/src/Infusionsoft/Api/ContactService.php');
						$token = file_get_contents("../token/token/token.json"); //Obtiene el token del archivo (se puede cambiar a su base de datos)

						$_POST["fecha_registro"]=fecha_hora(1); /* solo fecha */
						$_POST["fecha_hora"]=fecha_hora(2);
						$_POST["fecha_hoy"]=fecha_hora(2);

						/* Establece su información de conexión */
						$infusionsoft = new \Infusionsoft\Infusionsoft(array(
							'clientId' => 'hAgVQQ86FV2EeKZW7nhuhuI2GLnhaRnV',   
								'clientSecret' => 'sRa4sAqTDZjMI96G', 	
						));
						/* token sale del arcgivo de donde se incluye este script */
						if (!empty($token)) {
							$infusionsoft->setToken(unserialize($token)); //Establece el token que se utilizará en las llamadas
						}
						
						$tagId=2100;	
						$_POST['FirstName']=$vallogingoo['nombre'];
						$_POST['LastName']=$vallogingoo['ap_pa'].''.$vallogingoo['ap_ma'];
						// $_POST['_nombres']='';
						// $_POST['numDNI']='';
						$_POST['StreetAddress1']='not';
						$_POST['Phone1']=$vallogingoo['telefono'];
						$_POST['correo']=$vallogingoo['email'];
						include('../inc_generar_add_tag_webinar_clientes_ya_registrados_api_infusionsoft.php');
						
					/*  END API INFUSUSION SOFT */
					
			}	



include('webinar_registro_de_clientes_x_webinar_leads.php');
include('registro_a_cursos_gratis.php');  /* registro a cursos gratis mediante landing pages */
	
	 
if( isset($_SESSION["webinar"]["rewrite"]) && !empty($_SESSION["webinar"]["rewrite"]) ){
		$link_go='webinar/'.$_SESSION["webinar"]["rewrite"];
		
// }else if( isset($_SESSION["url"]) && $_SESSION["url"]=="cesta" ){
		// $link_go='cesta';

}else if( isset($_SESSION["curso_gratis"]["rewrite"]) && !empty($_SESSION["curso_gratis"]["rewrite"]) ){
		$link_go='gratis/'.$_SESSION["curso_gratis"]["rewrite"];
		
		
}else if( isset($_SESSION["url"]) &&  !empty($_SESSION["url"]) ){
		$link_go=$_SESSION["url"];
	
}else{
	$link_go="mis-cursos";
}




	  // echo  $rpta;
	echo json_encode(array(    
    "res" => $rpta ,
    "link_go" => $link_go 
  )); 
	
?>
