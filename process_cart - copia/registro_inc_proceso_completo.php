<?php 

/* si dni es nuevo, normal registramos proceso */
		// $campos=array("nombre",'ap_pa','ap_ma',"telefono","email","dni","id_especialidad","id_pais","id_escala_mag","direccion",'ciudad',"estado");
		if( $_POST["ap_ma"] == '[object HTMLInputElement]'){ // para evitar datos vacios o con este valor
			$_POST["ap_ma"] = '*';
		}
		$campos=array("nombre",'ap_pa','ap_ma',"telefono","email","dni","id_especialidad","id_pais","direccion",'ciudad',"estado");


		// echo var_dump(armaupdate('suscritos',$campos," id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."'",'POST'));
		// exit();
		
		$insertado =$bd->actualiza_(armaupdate('suscritos',$campos," id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."'",'POST')); 

		$bd->close();
		
		// echo '--> '.$insertado ; // update no devuelve valor sale 0 .
		// exit();
		
		if($insertado >= 0) $rpta = "ok";
		if($rpta == "ok"){
			// $_SESSION["suscritos"]["id_suscrito"] = $_POST["id_suscrito"];
			$_SESSION["suscritos"]["email"] =  $_POST["email"];
			$_SESSION["suscritos"]["nombre"]=$_POST["nombre"];
			

			
			include('webinar_registro_de_clientes_x_webinar_leads.php'); /* si se registro desde webinar */
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

			
		}

		/* API INFUSUSION SOFT */
		/* ID CATE: 28 --> EDUCACAUGE */
		/* ID TAG: 2096 --> REG. FACEBOOK EDUCACAUGE */
		/* ID TAG: 2098 --> REG. GOOGLE EDUCACAUGE */
		/* ID TAG: 2100 --> REG. COMUN  EDUCACAUGE ******************  */
			
			$tagId=2100;	
			$_POST['FirstName']=$_POST["nombre"];
			$_POST['LastName']='';
			// $_POST['_nombres']='';
			// $_POST['numDNI']='';
			$_POST['StreetAddress1']='not';
			$_POST['Phone1']=$_POST['telefono'];
			$_POST['correo']=$_POST["email"];
			// echo "antes ___";
			include('../inc_generar_add_contacts_api_infusionsoft.php');
		/*  END API INFUSUSION SOFT */
		
		
	
	
	?> 