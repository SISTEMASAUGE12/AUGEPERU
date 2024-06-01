<?php include('auten.php');
require("tw7control/class/class.upload.php");

$_POST['action']=isset($_POST['action'])?$_POST['action']:'';
$rpta = 2;/*si es error*/
if($_POST['action']=='actualizar'){

  	$bd= new BD;
	$campos=array('id_especialidad','id_escala_mag',"nombre",'ap_pa','ap_ma','telefono',"dni","ciudad",'direccion');
	$bd->actualiza_(armaupdate("suscritos",$campos," id_suscrito='".$_POST["id"]."'",'POST'));//update
  	$bd->close();
	$rpta = 1;
}

echo json_encode(array('rpta' => $rpta));
?>