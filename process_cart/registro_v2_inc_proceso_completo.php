<?php 
$_POST['id_canal']='1'; /* canal::: online default  */
if( $_POST['registro_desde'] == '4'){

}else{
	$_POST['registro_desde']='3'; /* formulario v2 */
}

$_POST["clientes_aleatorios"]='';

/* si dni es nuevo, normal registramos proceso */
		//$campos=array("nombre",'ap_pa','ap_ma',"telefono","email","dni","id_especialidad","id_pais","id_escala_mag","clave","estado",'estado_idestado','registro_desde','id_canal');
		$campos=array("nombre",'ap_pa','ap_ma',"telefono","email","dni","id_especialidad","id_pais","clave","estado",'estado_idestado','registro_desde','id_canal');

		if( !empty($_POST["id_tipo_cliente"]) ){  
			$campos= array_merge($campos,array('id_tipo_cliente'));
		}

		// asigno vendedora automaticamnete a cada registro
		include('asignacion_automatica_de_cliente_a_vendedoras.php');  /* registro a cursos gratis mediante landing pages */

		// echo var_dump(arma_insert('suscritos',array_merge($campos,array('orden','fecha_registro')),'POST'));
		// exit();
		// desactibo algpritmo automatico 
		// $insertado=$id_suscrito= $_POST["id_suscrito"]=$bd->inserta_(arma_insert('suscritos',array_merge($campos,array('idusuario','orden','fecha_registro','hora_registro')),'POST'));/*inserto hora -orden y guardo imag*/   // para algopritmo de asignacion, envio idusuario
		
		$insertado=$id_suscrito= $_POST["id_suscrito"]=$bd->inserta_(arma_insert('suscritos',array_merge($campos,array('orden','fecha_registro','hora_registro')),'POST'));/*inserto hora -orden y guardo imag*/  // sin idususario 


		
		if($insertado > 0) $rpta = "ok";
		if($rpta == "ok"){
			$_SESSION["suscritos"]["id_suscrito"] = $_POST["id_suscrito"];
			$_SESSION["suscritos"]["email"] =  $_POST["email"];
			$_SESSION["suscritos"]["nombre"]=$_POST["nombre"];
			
			
			/* si se asigno a aun avendedora aleatoria:: *sumo un asignado al usuario vendedor:  sale de include asignacion */
			if( !empty($_POST["clientes_aleatorios"]) ){
				$campos_vendedor=array('clientes_aleatorios');
				$bd->actualiza_(armaupdate('usuario',$campos_vendedor," idusuario='".$_POST["idusuario"]."'",'POST'));/*actualizo*/
			}
			
			include('webinar_registro_de_clientes_x_webinar_leads.php'); /* si se registro desde webinar */
			include('registro_a_cursos_gratis.php');  /* registro a cursos gratis mediante landing pages */

			
			/* * link go  */
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

			// si viene desde trafico: cambiamos link_go
			if( $_POST['viene_desde'] == "trafico"){  // si viene desde trafico y ya existe normal enviamos al gracias, no se nuestran alertas: rpta:1
				$_SESSION['trafico']['id']=$id_suscrito;
				$_SESSION['trafico']['link_wsp']=$_POST["link_wsp"];
				$rpta="ok";
				$link_go="trafico_gracias";		
			 }


		} // end ok:: cliente registrado 


	?> 