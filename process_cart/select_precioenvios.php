<?php  error_reporting(0);
session_start();
include_once("../intranet/class/functions.php");
include_once("../intranet/class/class.bd.php"); 
$bd=new BD;
$result_precio=0;


if(!empty($_POST["id_envio"])){  
  $id_envio=$_POST["id_envio"];  
}

if(!empty($_POST["id_envio"]) ){

  if(!empty($_SESSION["suscritos"]["id_suscrito"])){
		if($_POST["id_envio"]=='1000' || $_POST["id_envio"]=='1001' ){ //pare recojo en tienda
			$result_precio= 0;
			$_SESSION["suscritos"]["precio_envio"]= 0;
		}else{
			$sql="select * from precio_envios where estado_idestado=1 and id_envio=".$id_envio." limit 0,1";				
			$bd = new BD();		
			$result = executesql($sql);
			if(!empty($result)){
				$options='';
				foreach($result as $row){ 	
					$valor=(!empty($row["costo_promo"]) && $row["costo_promo"]!='0.00')?$row["costo_promo"]:$row["precio"];				
				}
			}
			// $result_precio= $msj.$options."</select> ";
			$result_precio= $valor;
			$_SESSION["suscritos"]["precio_envio"]= $valor;
			
		}
	

  }else{ //para no suscritos
      $result_precio="Por favor inicie sesión...";      
  } 
  $bd->close();
	
	
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	//comprobamos algunos datos
	if(!isset($_SESSION["suscritos"]["precio_envio"] ) || !is_numeric($_SESSION["suscritos"]["precio_envio"] )){
		echo json_encode(array(
				"res" 		=> "error", 
				"message" 	=> "El precio de envio no es correcto."
				)
		);
	}else{
		require("../class/Carrito.class.php");
		$carrito = new Carrito();		
		// $articulo = array(
			// "id"			=>		$_POST["id"]			
		// ); 
		$carrito->precio_envio();
		$carrito->update_carrito();
		// echo json_encode(array("res" => "ok"));
	}
}



  echo json_encode(array( "res"=>'ok',"result_precio" => $_SESSION["suscritos"]["precio_envio"]  )); 
}  

  
?>