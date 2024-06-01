<?php header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL); session_start();
require("../tw7control/class/class.bd.php"); 
require("../tw7control/class/functions.php");
require("../tw7control/class/class.upload.php");

$url = 'http://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? '/mori/yoemprendo/zsoli/' : '' ); 
$rpta="no"; 

	$sql_val_email= executesql("select * from suscritos where  email='".$_POST["email"]."' "); 
	if(!empty($sql_val_email)){
		$cli_habilitado= executesql("select * from suscritos where  estado_idestado=1 and email='".$_POST["email"]."' "); 
		if( !empty($cli_habilitado) ){
			
			// $cli_ok= executesql("select * from suscritos where  estado_idestado=1 and email='".$_POST["email"]."' and logeado = 0 "); 
			// if( !empty($cli_ok) ){
				
					$cli_ok= executesql("select * from suscritos where  estado_idestado=1 and email='".$_POST["email"]."' and clave='".md5($_POST['clave'])."' "); 
					if( !empty($cli_ok) ){
							// si esta registrado y habilitado .. 
							$data_id_suscrito = $cli_ok[0]['id_suscrito']; 
							$data_email = $cli_ok[0]['email']; 

							// validamos si lo mandamos a completar sus datos. 
							$_SESSION["suscritos"]["id_suscrito"]= $data_id_suscrito;
							$_SESSION["suscritos"]["email"]= $data_email;

							include("inc/validar_ingreso_por_asistencia_del_cliente.php");


							if( empty($cli_ok[0]['nombre']) || empty($cli_ok[0]['telefono']) || empty($cli_ok[0]['email']) || empty($cli_ok[0]['dni']) || empty($cli_ok[0]['id_especialidad'])   ){ 

								$rpta = 'completar_datos';										
							}else{								
									$rpta = 'ya_existe'; 	
									
									// validamos si ya tiene un incio de seesion activo, 
							}											
						
						
					}else{// Error de calve incorrecta
						$rpta = 'error_clave'; 								
					}
			// }else{ $rpta = '_ya_esta_logeado'; }
					
		}else{
			// Cliente deshabilitado 
			$rpta = 'cliente_deshabilitado'; 		
		}
	}else{
		//cliente no registramos 
		$rpta = 'cliente_no_registrado'; 		
		
	}		

include('webinar_registro_de_clientes_x_webinar_leads.php');
	

if( isset($_SESSION["webinar"]["rewrite"]) && !empty($_SESSION["webinar"]["rewrite"]) ){
		$link_go='webinar/'.$_SESSION["webinar"]["rewrite"];
		
// }else if( isset($_SESSION["url"]) && $_SESSION["url"]=="cesta" ){
		// $link_go='cesta';
	
}else if( isset($_SESSION["url"]) &&  !empty($_SESSION["url"]) ){
		$link_go=$_SESSION["url"];
	
}else{
	$link_go="mis-cursos";
}


  // echo  $rpta;
	echo json_encode(array(    
    "res" => $rpta ,
    "email" => $_POST["email"] ,
    "link_go" => $link_go 
  )); 
	
?>
