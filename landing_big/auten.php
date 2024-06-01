<?php error_reporting(E_ALL); session_start();
include_once("../tw7control/class/functions.php");
include_once("../tw7control/class/class.bd.php");
include_once("../tw7control/class/PHPPaging.lib.php");

$des_keys="";
$des_meta=" ";

// $url = 'http://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? '/mori/w2021/augeperu/landing_big/' : '/augeperu/' );
$url = 'https://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? '/mori/tuweb7/w2021/augeperu/' : '/landing_big/' );

$fecha_hoy=fecha_hora(1);


if(!empty($_GET["task"])){
		if(!empty($_SESSION["suscritos"]["id_suscrito"])){
				$filtro_x_distinto_al_cliente=" and id_suscrito!='".$_SESSION["suscritos"]["id_suscrito"]."' ";
		}
		
  	if($_GET["task"] == "valida_email_suscrito"){ //registro crear clientes ..main.js
    	$consultando=executesql("select * from suscritos where email='".$_POST["envio_usuario"]."' ".$filtro_x_distinto_al_cliente);
    	echo !empty($consultando) ? 'false' : 'true';
    	exit();
  	}
	if($_GET["task"] == "valida_dni_suscrito"){ //registro crear clientes ..main.js
    	$consultando=executesql("select * from suscritos where dni='".$_POST["envio_dni_usuario"]."' ".$filtro_x_distinto_al_cliente);
    	echo !empty($consultando) ? 'false' : 'true';
    	exit();
  	}				
		
	if($_GET["task"] == "cerrar_sesion" ){		
    	unset($_SESSION["suscritos"]);
    	header('Location:'.$url.'');
    	exit();
  	} //cerrando sesion
}

$not_img="img/iconos/no-disponible.jpg";  
?>