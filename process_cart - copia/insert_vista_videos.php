<?php  
header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL);
require("../class/Carrito.class.php");
require("../tw7control/class/class.upload.php");

$_POST['action']=isset($_POST['action'])?$_POST['action']:'';
$rpta = 2;

$bd=new BD;      

if($_POST['action']=='registro'){

	$bd=new BD;
	@$id_curso		= utf8_encode(utf8_decode($_POST['id_curso']));
	@$id_detalle    = utf8_encode(utf8_decode($_POST['id_detalle']));
	@$id_sesion     = utf8_encode(utf8_decode($_POST['id_sesion']));
	@$id_suscrito 	= utf8_encode(utf8_decode($_POST['id_suscrito']));
	$fecha 		= fecha_hora(2);
	$orden = _orden_noticia("","conta_video","");
	$campo = array(array('id_suscrito',$id_suscrito),array('id_curso',$id_curso),array('id_detalle',$id_detalle),array('id_sesion',$id_sesion),array('fecha_registro',$fecha),array('orden',$orden),array('estado_idestado',1));
	$i = $bd->inserta_(arma_insert('conta_video',$campo,'POST'));
  	$bd->close();
  	if($i>0) $rpta = 1;
}

echo json_encode(array(
	'rpta' => $rpta
));

?>