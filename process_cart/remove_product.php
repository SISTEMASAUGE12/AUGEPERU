<?php //comprobamos que sea una petición ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){ 
	require("../class/Carrito.class.php");
	$carrito = new Carrito();
	$unique_id = $_POST["unique_id"];
	$remove = $carrito->remove_producto($unique_id);
	if($remove){
		echo json_encode(array("res" => "ok"));
	}else{
		echo json_encode(array("res" => "error"));
	}  
	
	//reseteando envio pedido
	if($carrito->get_content()){}else{ 
		$_SESSION["suscritos"]["precio_envio"]=0;
		$carrito->precio_envio();
	}
} ?>