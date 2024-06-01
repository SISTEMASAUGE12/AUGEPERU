<?php 
// if( isset($_SESSION["data_webinar"]["etiqueta_infusion"]) && !empty($_SESSION["data_webinar"]["etiqueta_infusion"]) ){

	$_webinar=executesql("select * from webinars where id_webinar='".$_POST["id_webinar"]."' ");
	if( !empty($_webinar) ){

		if( $_webinar[0]["etiqueta_infusion"]  != '' ){  

			$tagId_webinar= $_webinar[0]["etiqueta_infusion"];
			$registro_desde="webinar";
			$campos= array(
						'FirstName' => $_POST['FirstName'],
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
		
		} // end si esta != vacio el tag del webinar 
	}
// }/* end si exisye un valor de tag infusion  */