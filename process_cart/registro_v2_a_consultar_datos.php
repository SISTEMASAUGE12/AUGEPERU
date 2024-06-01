<?php header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL); session_start();
require("../tw7control/class/class.bd.php"); 
require("../tw7control/class/functions.php");
require("../tw7control/class/class.upload.php");
$url = 'http://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? '/mori/yoemprendo/zsoli/' : '/' ); 

$_POST['action']=isset($_POST['action'])?$_POST['action']:'';
$rpta = 2;/*si es error*/
$bd= new BD;
$_POST['clave']=md5($_POST['clave']);

// api reniec // actali-tus-datos-php
$_POST["dni"]= (!empty($_POST["api_dni"]))? $_POST["api_dni"] : $_POST["dni"];
$_POST["nombre"]=$_POST["api_nombre"];
$_POST["ap_pa"]=$_POST["api_ap_pa"];
$_POST["ap_ma"]=$_POST["api_ap_ma"];

//$campos=array('id_especialidad','id_escala_mag',"nombre",'ap_pa','ap_ma','telefono',"dni",'email',"id_pais",'clave');
$campos=array('id_especialidad','id_tipo_cliente','id_escala_mag',"nombre",'ap_pa','ap_ma','telefono',"dni",'email',"id_pais");
if( isset($_POST['clave']) && !empty($_POST['clave']) ){
	$campos=array_merge($campos,array('clave'));

}


if($_POST['action']=='actualizar'){
	// if( !empty($_SESSION["suscritos"]["id_suscrito"]) ){ 
		
			if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) ){
				if($_POST["email"]  != $_POST["email_origen"] ){  
					/* si intenta cambiar de email */
					
					/* VALIDO SOLO GMAIL */
					/* validamos que ingrese uno de tipo @gmail,com */
					// $explode = explode("@", $_POST["email"]);
					// if ($explode[1] == "gmail.com") { 
						// /* solo permitimos  registros de correos:: GMAIL */		
						// /* si quiere cambiar su corero por un gmail, normal todo okey */
						// $bd->actualiza_(armaupdate("suscritos",$campos," id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."'",'POST'));//update
						// $rpta = 1;
						// /*enviar un correo al cliente indicando que se modificaron sus datos .. */
						
					// }else{
						// /* si no es gmail.com reportamos error */
						/* $rpta=2;*/ 
						// $rpta='ingresa_un_correo_gmail';
					// }
					
					/* ACEPTO TODOS LOS CORREOS*/
					// $bd->actualiza_(armaupdate("suscritos",$campos," id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."'",'POST'));//update
					$bd->actualiza_(armaupdate("suscritos",$campos," id_suscrito='".$_POST["id_suscrito"]."'",'POST'));//update
					$rpta = 1;
						
				}else{
					/* si no intenta cambiar de mail: no hay problema actyalizamos  */
					// $bd->actualiza_(armaupdate("suscritos",$campos," id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."'",'POST'));//update
					$bd->actualiza_(armaupdate("suscritos",$campos," id_suscrito='".$_POST["id_suscrito"]."'",'POST'));//update
					$rpta = 1;
					/*enviar un correo al cliente indicando que se modificaron sus datos .. */
					
				}
				
			}else{
				$rpta=2;
			}	/* end if email valido */			
	// } /* end if validate si exist sesion */
}

echo json_encode(array('rpta' => $rpta));  
?>