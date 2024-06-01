<?php //comprobamos que sea una petición ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	require("../class/Carrito.class.php");
	$carrito = new Carrito();
	$carrito->destroy();  
	
	//resetenado precio de envio
	$_SESSION["suscritos"]["precio_envio"]=0;
	$carrito->precio_envio();	
}
?>