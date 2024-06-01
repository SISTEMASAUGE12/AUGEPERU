<?php header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL); session_start();
require("../tw7control/class/class.bd.php"); 
require("../tw7control/class/functions.php");
require("../tw7control/class/class.upload.php");
$url = 'http://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? '/mori/yoemprendo/zsoli/' : '/' ); 
$rpta="no";
$link_go=isset($_SESSION["url"])?$_SESSION["url"]:"";
$id_suscrito='-';

	
if($_POST["action"]=="actualiza_tus_datos"){ 
	if( !empty($_POST["data"]) ){ 
		// echo "Hi thanks for submitting the form!";	


			$sql= "select * from suscritos where dni='".$_POST["data"]."' or email='".$_POST["data"]."' "; 
			$vallogingoo=executesql($sql);
			if(empty($vallogingoo)){
				/* no existe lo mandamos al registro*/
				$rpta='4';
			}else{	
				// si ya existe
				$id_suscrito =$vallogingoo[0]['id_suscrito'];
				
				// $_SESSION["suscritos"]["id_suscrito"]=$vallogingoo[0]['id_suscrito'];
				// $_SESSION["suscritos"]["email"] =  $vallogingoo[0]['dni'];


				$data_id_suscrito = $vallogingoo[0]['id_suscrito']; 
				$data_email = $vallogingoo[0]['email']; 

				// include("inc/validar_ingreso_por_asistencia_del_cliente.php");


				$rpta='existe_data';
						
			}	
	} /* end if: data */	
			
			
// }else{  // para otro action  
	// $rpta='robot';

}

//$id_suscrito=!empty($_SESSION["suscritos"]["id_suscrito"])?$_SESSION["suscritos"]["id_suscrito"]:'';


// echo  $rpta;
echo json_encode(array(    
	"rpta" => $rpta ,
	"id_suscrito" => $id_suscrito,
	"data" => $_POST["data"],
	"link_go" => $link_go 
)); 
	

?>
