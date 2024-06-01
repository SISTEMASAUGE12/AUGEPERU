<?php //comprobamos que sea una petición ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	//comprobamos algunos datos
	if(!isset($_POST["id"]) || !is_numeric($_POST["id"])){
		echo json_encode(array(
				"res" 		=> "error", 
				"message" 	=> "El id del producto no es correcto."
				)
		);
	}else{
		require("../class/Carrito.class.php");
		$carrito = new Carrito();		
		$articulo = array(
			"id"			=>		$_POST["id"],
			"id_tipo"		=>		$_POST["id_tipo"],
			"cantidad"		=>		$_POST["cantidad"],
			"precio"		=>		$_POST["precio"],
			"precio_online"		=>		$_POST["precio_online"],	
			"tag"		=>		$_POST["tag"],
			"nombre"		=>		$_POST["nombre"],
			"imagen"		=>		$_POST["imagen"],
			"rewrite"		=>		$_POST["rewrite"],
			"profe"		=>		$_POST["profe"],
			"validez_meses"		=>		$_POST["validez_meses"],
			"cursos_dependientes"		=>		$_POST["cursos_dependientes"],
			"cursos_dependientes_data"		=>		$_POST["cursos_dependientes_data"],
			"cursos_especialidades"		=>		$_POST["cursos_especialidades"],
			"cursos_especiales_data"		=>		$_POST["cursos_especiales_data"]
		); 

		$carrito->add($articulo);
		echo json_encode(array("res" => "ok"));
	}
}else{
	echo "eror__--";
}
 
?>