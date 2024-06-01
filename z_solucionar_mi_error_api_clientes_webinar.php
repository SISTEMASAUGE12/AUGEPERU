<?php 
include("auten.php");

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


	$_webinar=executesql("select * from webinars where id_webinar='32' ");
	if( !empty($_webinar) ){

		if( $_webinar[0]["etiqueta_infusion"]  != '' ){  


			$recorrer_clientes=executesql(" select s.* from webinars_x_leads w INNER JOIN suscritos s ON w.id_suscrito=s.id_suscrito  where  w.id_webinar='32' "); 
			foreach( $recorrer_clientes as $row){ 

				$_POST['correo']=$row['email'];

			$tagId_webinar= $_webinar[0]["etiqueta_infusion"];
			$registro_desde="webinar-32";
			$campos= array(
						'FirstName' => $row['nombre'],
						'_datosderegistro' => 	$registro_desde,
						'Email' => $_POST['correo']
			);
			
			// echo "antes consulta->".$_POST['correo'];
			/* validar si ya existe el correo en la api */
			$des=$infusionsoft->contacts('xml')->findByEmail($_POST['correo'], array('Id') ); /* verifico si ya existe este correo registrado */
			
			
			
			// echo "despues consulta";
			if( count($des) == 0){				/* si el correo no figura en la BD de infusionsoft, lo registramos */
				$contactId= $infusionsoft->contacts('xml')->add($campos);  /* Registramos en la api */
				// $infusionsoft->contacts('xml')->addToGroup($contactId, $tagId);  /* Asigno una etiqueta */								
				$infusionsoft->contacts('xml')->addToGroup($contactId, $tagId_webinar);  /* Asigno una etiqueta webinar */								
				$infusionsoft->emails('xml')->optIn($_POST['correo'], "Home page newsletter subscriber"); /* permiso de consentiiento para recibir e-mails */
				/* FUNEL MAILS */
				$infusionsoft->funnels()->achieveGoal('ik813', 'registroeducaaugev1', $contactId);
				
			
			}else{
				/* si correo ya figura agregamos tag si es que existe ...*/ 		
					$contactId=$des[0]['Id'];
					$infusionsoft->contacts('xml')->addToGroup($contactId, $tagId_webinar);  /* Asigno una etiqueta webinar */
				
				
			}
	
		
		
		}	
	} // end si esta != vacio el tag del webinar 
}
