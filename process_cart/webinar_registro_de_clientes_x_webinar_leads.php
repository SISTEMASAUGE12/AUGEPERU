<?php 
/* SI se resigsto por el webinar, registro suscrito_x_webinar: leads */
// echo "Q1->".$_SESSION["data_webinar"]["id_webinar"];
// echo "Q2->".$_SESSION["data_webinar"]["rewrite"];
// echo "Q_3->".$_SESSION["suscritos"]["id_suscrito"];


if( (isset($_SESSION["suscritos"]["id_suscrito"]) && $_SESSION["suscritos"]["id_suscrito"] > 0 ) && isset($_SESSION["url"]) && ($_SESSION["url"]=='webinar') ){  /* sol osi vienes desde webinar */
	// echo "Hola_entro";

	$_POST["estado_idestado"]=1;
	$_POST["id_suscrito"]=$_SESSION["suscritos"]["id_suscrito"];
	// $_POST["id_webinar"]=$_SESSION["url_webinar"]["id_webinar"];
	$_POST["id_webinar"]=$_SESSION["data_webinar"]["id_webinar"];
	
	
	$_POST["email"]=$_SESSION["suscritos"]["email"];
	$_POST['orden'] = 1;
	// $_POST['orden'] = _orden_noticia("","webinars_x_leads","");
	$_POST["fecha_registro"]=fecha_hora(2);

	$campos=array('id_webinar','id_suscrito',"email",'fecha_registro','orden','estado_idestado');
	
	$sql_1="select * from webinars_x_leads where estado_idestado=1 and  id_suscrito='".$_POST["id_suscrito"]."' and id_webinar='".$_POST["id_webinar"]."' ";
	
	// echo  $sql_1; 
	
	$validate=executesql($sql_1);
	if( !empty($validate) ){
		/* ya no registro creo su sesion de ingreso */
			/* capturo REWRITE Y EN JS lo concateno con la palabra webinar/ ... para el redireccionamiento */
			// $_SESSION["webinar"]["rewrite"]=$_SESSION["url_webinar"]["rewrite"]; 
			$_SESSION["webinar"]["rewrite"]=$_SESSION["data_webinar"]["rewrite"]; 
			
			
			$_SESSION["webinar"]["nombre"]=$_SESSION["suscritos"]["email"];
			
			// echo "ya registrado ";
			
	}else{
		/* registro */
		
			// echo '**-->'.$_SESSION["data_webinar"]["rewrite"]; 
		// echo var_dump(arma_insert('webinars_x_leads',$campos,'POST'));
		// exit();
		
		
		$insertado=$bd->inserta_(arma_insert('webinars_x_leads',$campos,'POST'));
		if( $insertado > 0){
			
			
			// $_SESSION["webinar"]["rewrite"]=$_SESSION["url_webinar"]["rewrite"];
			$_SESSION["webinar"]["rewrite"]=$_SESSION["data_webinar"]["rewrite"];
			$_SESSION["webinar"]["nombre"]=$_SESSION["suscritos"]["email"];
		}
		
	}
	
	// echo "XXX2";
	// exit();
	
}

?>