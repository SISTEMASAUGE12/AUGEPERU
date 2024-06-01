<?php
//comprobamos que sea una petición ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
 
	require("../class/Carrito.class.php");
	$carrito = new Carrito();
	$precio_envio = $carrito->precio_envio(); //Extraigo el precio_envio de la funcion precio_envio , dentro de Class
	$precio_subtotal = $carrito->precio_subtotal();
	$precio_total = $carrito->precio_total();

	$precio_subtotal_online = $carrito->precio_subtotal_online();
	$precio_total_online = $carrito->precio_total_online();
	
	$articulos_total = $carrito->articulos_total();
	$id_suscrito = $carrito->id_suscrito(); //Extraigo el id_suscrito de la funcion id_suscrito , dentro de Class
	
	if($carrito->get_content()){
		echo json_encode(array(
				"res" 				=> 	"ok", 
				"content" 			=> 	$carrito->get_content(),
				"precio_envio" 	=> 	$precio_envio,
				"precio_subtotal" 		=> 	$precio_subtotal,
				"precio_total" 		=> 	$precio_total,
				"precio_subtotal_online" 		=> 	$precio_subtotal_online,
				"precio_total_online" 		=> 	$precio_total_online,
				
				"articulos_total" 	=> 	$articulos_total,
				"id_suscrito" 	=> 	$id_suscrito //asigno el valor de la funcion al json
			)
		);	
		
	}else{
		// "precio_envio" 	=> 	0,
		// $_SESSION["suscritos"]["precio_envio"]=0;
		echo json_encode(array("res" => "empty"));
	}
    
}
?>