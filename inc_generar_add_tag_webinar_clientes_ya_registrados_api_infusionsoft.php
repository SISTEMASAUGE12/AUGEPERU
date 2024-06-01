<?php 
			$registro_desde="antes_del_update";
			$campos= array(
						'FirstName' => $_POST['FirstName'],
						'LastName' => $_POST['LastName'],
						// '_nombres' => 'MISHOU 2',
						// 'numDNI' => '12345678',
						'_datosderegistro' => 	$registro_desde,
						'StreetAddress1' => $_POST['StreetAddress1'],
						'Phone1' => $_POST['Phone1'],
						'Email' => $_POST['correo']
			);
			
			/* validar si ya existe el correo en la api */
			$des=$infusionsoft->contacts('xml')->findByEmail($_POST['correo'], array('Id') ); /* verifico si ya existe este correo registrado */
			
			// echo "despues consulta";
			if( count($des) == 0){				/* si el correo no figura en la BD de infusionsoft, lo registramos */
				$contactId= $infusionsoft->contacts('xml')->add($campos);  /* Registramos en la api */
				$infusionsoft->contacts('xml')->addToGroup($contactId, $tagId);  /* Asigno una etiqueta */
								
				/* si se registro desde un un webinar asigno esta etiqueta */
				if( isset($_SESSION["url"]) && ($_SESSION["url"]=='webinar') && !empty($_SESSION["data_webinar"]["id_webinar"]) && !empty($_SESSION["data_webinar"]["etiqueta_infusion"]) ){  /* sol osi vienes desde webinar */
					$tagId_webinar=$_SESSION["data_webinar"]["etiqueta_infusion"];
					$infusionsoft->contacts('xml')->addToGroup($contactId, $tagId_webinar);  /* Asigno una etiqueta webinar */
				}
				
				$infusionsoft->emails('xml')->optIn($_POST['correo'], "Home page newsletter subscriber"); /* permiso de consentiiento para recibir e-mails */
				/* FUNEL MAILS */
				$infusionsoft->funnels()->achieveGoal('ik813', 'registroeducaaugev1', $contactId);
			
						
			}else{
				/* si correo ya figura agregamos tag si es que existe ...*/
									
				/* si se registro desde un un webinar asigno esta etiqueta */
				if( isset($_SESSION["url"]) && ($_SESSION["url"]=='webinar') && !empty($_SESSION["data_webinar"]["id_webinar"]) && !empty($_SESSION["data_webinar"]["etiqueta_infusion"]) ){  /* sol osi vienes desde webinar */
					$contactId=$des[0]['Id'];
					$tagId_webinar=$_SESSION["data_webinar"]["etiqueta_infusion"];
					$infusionsoft->contacts('xml')->addToGroup($contactId, $tagId_webinar);  /* Asigno una etiqueta webinar */
				}
			
			
			}
