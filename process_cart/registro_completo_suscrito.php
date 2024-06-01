<?php error_reporting(E_ALL);
session_start();
include_once("../tw7control/class/functions.php");
include_once("../tw7control/class/class.bd.php"); 

require_once '../vendor/autoload.php';
require('../vendor/infusionsoft/php-sdk/src/Infusionsoft/Api/ContactService.php');
$token = file_get_contents("../token/token/token.json"); //Obtiene el token del archivo (se puede cambiar a su base de datos)


$url = 'https://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? ':88/mori/tuweb7/w2019/withlove/' : '/' ); 

$_POST['action']=isset($_POST['action'])?$_POST['action']:'';
$rpta = 2;/*si es error*/
$link_go='';
$bd = new BD;

if($_POST['action']=='registro'){ 

@$nombre    = utf8_decode(addslashes($_POST['nombre']));
@$apellidos    = utf8_decode(addslashes($_POST['ap_pa'].' '.$_POST['ap_ma']));
@$dni     = utf8_decode(addslashes($_POST['dni']));
@$telefono  = utf8_decode(addslashes($_POST['telefono']));
@$email     = utf8_decode(addslashes($_POST['email']));

$mi_email= $email;
$mi_email_no_reply="no-reply@educaauge.com";

$nombre_empresa="EDUCA AUGE ";

		$_POST["estado_idestado"]=1;
		$_POST["estado"]=1;
		// $_POST["id_pais"]=1;  // momentaneo ya que se acorto el registro de cliente. y se oculto la opcion de seleccioanr pais 
		
		/* saco prefijo del pais */
		$pais=executesql("select * from paises where id_pais='".$_POST["id_pais"]."' ");
		$_POST['telefono']= !empty($pais[0]['prefijo'])? $pais[0]['prefijo'].''.$_POST['telefono']: $_POST['telefono'];
		
		
		// $_POST["fecha_registro"]=fecha_hora(2);
		// $_POST["orden"]=_orden_noticia("","suscritos","");
	 // $_POST["clave"]=md5($_POST["clave"]);
		 
			/* VALIDO SI YA EXISTE EL DNI */
	$validate_dni=executesql("select * from suscritos where estado_idestado=1 and dni='".$dni."' ");
	if(!empty($validate_dni) ){
			/* si ya existe frustamos el registro...  */
			
			/* si el dni es de l asesion actual normal dejar pasar */
			$validate_dni_2=executesql("select * from suscritos where estado_idestado=1 and dni='".$dni."'  and id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."' ");
			if( !empty($validate_dni_2) ){ /* si el dni es de la session actul, entonces dejar actualizasr los datos. .. */
					
					include('registro_inc_proceso_completo.php');
					
			}else{
				 /* si el dni no existe completamos el registro */
				 if( !empty($validate_dni[0]['dni']) ){  /* si ya tiene un dni asignado ya no puede editar datos. */
					 $rpta="existe_dni";
					 
				 }
				
			}
			
			 // exit();
			 
	}else{
		/* si dni es nuevo, normal registramos proceso */
		include('registro_inc_proceso_completo.php');

	} /* END if  si el dni no existe completamos el registro */


	
} /* end post action*/



echo json_encode(
	array(
		'rpta' => $rpta, 
		'link_go' => $link_go
	)
);
?>