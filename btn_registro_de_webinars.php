<?php include_once("auten.php");

$url = 'https://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? ':88/mori/tuweb7/w2019/withlove/' : '/' );

$_POST['action']=isset($_POST['action'])?$_POST['action']:'';
$rpta = 2;/*si es error*/


if($_POST['action']=='registro'){

@$webinar    = utf8_decode(addslashes($_POST['webinar']));
@$nombre=$_POST["nombre"]    = utf8_decode(addslashes($_POST['nombre_completo']));
@$email     = utf8_decode(addslashes($_POST['email']));
@$telefono  = utf8_decode(addslashes($_POST['telefono']));
@$tipo  = utf8_decode(addslashes($_POST['tipo']));


	$bd = new BD;
	$_POST["estado_idestado"]=1;
	$_POST['orden'] = 1;
	$_POST["fecha_registro"]=fecha_hora(2);
	$_POST["hora_registro"]=fecha_hora(0);
	$_POST["id_suscrito"]=1; /* para registro a webinar tipo 2 */
	
	$_POST["estado"]=1;
	$_POST["id_pais"]=1; // setiado a peru

	/* saco prefijo del pais */
	$pais=executesql("select * from paises where id_pais='".$_POST["id_pais"]."' ");
	// if( $_POST["id_pais"] != '1'){ /* si es diferente a peru se agrega prefijo al numero */
		$_POST['telefono']= !empty($pais[0]['prefijo'])? $pais[0]['prefijo'].''.$_POST['telefono']: $_POST['telefono'];						
	// }
	$_POST["clave"]=md5($_POST["telefono"]);
	$_POST['id_canal']='1'; /* canal::: online default  */
	$_POST['registro_desde']='5'; /* desde webinar  */
	

	/* registratr el cliente  */

	/* VALIDO SI YA EXISTE EL DNI */
	$validate_telefono=executesql("select * from suscritos where estado_idestado=1 and telefono='".$_POST['telefono']."' ");
	if(!empty($validate_telefono) ){
			/* si ya existe frustamos el registro...  */			
			$_POST["id_suscrito"]= $validate_telefono[0]['id_suscrito'];									 
	}else{							
		/* VALIDO SI YA EXISTE EL DNI 
		$validate_dni=executesql("select * from suscritos where estado_idestado=1 and dni='".$dni."' ");
		if(!empty($validate_dni) ){										
		}else{
	*/
				/* si dni es nuevo, normal registramos proceso */
				$validate_email=executesql("select * from suscritos where estado_idestado=1 and email='".$email."' ");
				if(!empty($validate_email) ){		
					$_POST["id_suscrito"]= $validate_email[0]['id_suscrito'];							
				}else{
					/* todo bien::: cliente nuevo registramos */
					// $campos=array("nombre","telefono","email","dni","id_especialidad","id_pais","clave","estado",'estado_idestado','registro_desde','id_canal');
					
					$campos=array("nombre","telefono","email","id_pais","clave","estado",'estado_idestado','registro_desde','id_canal');
			
					

					$insertado=$_POST["id_suscrito"]=$bd->inserta_(arma_insert('suscritos',array_merge($campos,array('orden','fecha_registro','hora_registro')),'POST'));/*inserto hora -orden y guardo imag*/

				}
				
		/* 	} /* END if  si el dni no existe completamos el registro */

	} /* END validate telefono */

	
	/* si se asigno a aun avendedora aleatoria:: *sumo un asignado al usuario vendedor:  sale de include asignacion 
	// deshabilito esto no se asigna automatico a la svnededoras. ..
	if( !empty($_POST["clientes_aleatorios"]) ){
		$campos_vendedor=array('clientes_aleatorios');
		$bd->actualiza_(armaupdate('usuario',$campos_vendedor," idusuario='".$_POST["idusuario"]."'",'POST'));// actualizo 
	}
	/* --- */


	/** Registro lead:: webinar  */

	$campos=array('id_webinar','id_suscrito',"nombre_completo","email",'telefono','tipo','fecha_registro','estado_idestado','orden');
	$validate=executesql("select * from webinars_x_leads where email='".$_POST["email"]."' and id_webinar='".$_POST["id_webinar"]."' ");
	if( !empty($validate) ){
		/* ya no registro creo su sesion de ingreso */
			$_SESSION["webinar"]["rewrite"]=$_POST["rewrite"];
			$_SESSION["webinar"]["nombre"]=$_POST["nombre_completo"];
			
			// $_SESSION["suscritos"]["id_suscrito"] = 1;
			$_SESSION["suscritos"]["id_suscrito"] = $_POST["id_suscrito"];
			$_SESSION["suscritos"]["email"] =  $_POST["email"];
			$_SESSION["suscritos"]["nombre"]=$_POST["nombre_completo"];
			
			$rpta=1;
		
	}else{
		
		//echo var_dump(arma_insert('webinars_x_leads',$campos,'POST'));
		 // exit();
		
		
		/* registro */
		$insertado=$bd->inserta_(arma_insert('webinars_x_leads',$campos,'POST'));
		if( $insertado > 0){
			$_SESSION["webinar"]["rewrite"]=$_POST["rewrite"];
			$_SESSION["webinar"]["nombre"]=$_POST["nombre_completo"];
			
			$_SESSION["suscritos"]["id_suscrito"] = $_POST["id_suscrito"];
			$_SESSION["suscritos"]["email"] =  $_POST["email"];
			$_SESSION["suscritos"]["nombre"]=$_POST["nombre_completo"];
			
			$rpta=1;

			if($_POST["tipo"]==6){
				$rpta=6;
			}
			
			@mail($email_to_emp, $asunto_emp, $contenido_emp, $cabeceras_emp); /* empresa */
			@mail($email_to, $asunto, $contenido, $cabeceras); /* cliente */
	
			
		}
		
	}


		
			/* API INFUSUSION SOFT */
		
		// if( isset($_SESSION["data_webinar"]["etiqueta_infusion"]) && !empty($_SESSION["data_webinar"]["etiqueta_infusion"]) ){	 // no entiendo porq esta validacin la comento: 30-12-2023
				
				require_once 'vendor/autoload.php';
				require('vendor/infusionsoft/php-sdk/src/Infusionsoft/Api/ContactService.php');
				$token = file_get_contents("token/token/token.json"); //Obtiene el token del archivo (se puede cambiar a su base de datos)
				$infusionsoft = new Infusionsoft\Infusionsoft(array(
					'clientId' => 'hAgVQQ86FV2EeKZW7nhuhuI2GLnhaRnV',   
						'clientSecret' => 'sRa4sAqTDZjMI96G', 	
				));

				$_POST["fecha_registro"]=fecha_hora(1); 
				$_POST["fecha_hora"]=fecha_hora(2);
				$_POST["fecha_hoy"]=fecha_hora(2);

				// token sale del arcgivo de donde se incluye este script 
				if (!empty($token)) {
					$infusionsoft->setToken(unserialize($token)); //Establece el token que se utilizará en las llamadas
				}

				$_POST['FirstName']=$_POST['nombre_completo'];
				$_POST['StreetAddress1']='not';
				$_POST['correo']=$_POST['email'];
				// echo "aqui okey";
				
				include('inc_api_infusionsoft_webinar_modo_2.php');
		//	}	
			
			/*  END API INFUSUSION SOFT */
	
	
	
}
echo json_encode(array('rpta' => $rpta));
?>