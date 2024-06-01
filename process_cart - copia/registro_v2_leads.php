<?php 
$_POST['id_canal']='1'; /* canal::: online default  */
if( $_POST['registro_desde'] == '4'){

}else{
	$_POST['registro_desde']='3'; /* formulario v2 */
}

		$campos=array("nombre",'ap_pa','ap_ma',"telefono","email","dni","id_especialidad","id_pais","clave","estado",'estado_idestado','registro_desde','id_canal');

		if( !empty($_POST["id_tipo_cliente"]) ){  
			$campos= array_merge($campos,array('id_tipo_cliente'));
		}		
		$insertado=$id_suscrito= $_POST["id_suscrito"]=$bd->inserta_(arma_insert('suscritos_leads',array_merge($campos,array('orden','fecha_registro','hora_registro')),'POST'));/*inserto hora -orden y guardo imag*/  // sin idususario 

		
		if($insertado > 0) $rpta = "ok";
		if($rpta == "ok"){
			/*
			$_SESSION["suscritos"]["id_suscrito"] = $_POST["id_suscrito"];
			$_SESSION["suscritos"]["email"] =  $_POST["email"];
			$_SESSION["suscritos"]["nombre"]=$_POST["nombre"];
			*/
			
			$link_go='gracias';									

		} // end ok:: cliente registrado 


	?> 