<?php  
header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL);
require("../class/Carrito.class.php");
require("../tw7control/class/class.upload.php");

$_POST['action']=isset($_POST['action'])?$_POST['action']:'';
$rpta = 2;/*si es error*/
$res = 2;/*si es error*/

$bd=new BD;      

if($_POST['action']=='registro'){

	$fecha = fecha_hora(2);
	$fecha_1 = strtotime('-1 hour',strtotime($fecha));  
	$fecha_1 = date('Y-m-d H:i:s',$fecha_1); 

	$ip_add = get_public_ip();
	$prueba = executesql("SELECT * FROM asistencia WHERE id_suscrito = ".$_POST['id_suscrito']." AND id_curso = ".$_POST['id_curso']." AND id_sesion = ".$_POST['id_sesion']." AND id_detalle = ".$_POST['id_detalle']." AND fecha_registro BETWEEN '".$fecha_1."' AND '".$fecha."' ORDER BY orden DESC");
	$conteo = count($prueba);

  	$id_detalle = $_POST["id_detalle"];
  	$id_sesion = $_POST["id_sesion"];
  	$id_curso = $_POST["id_curso"];
  	$id_suscrito = $_POST["id_suscrito"];
	$orden = _orden_noticia("","asistencia","");
	$estado='1';
	$hora = fecha_hora(0);

    $campos_asistencia=array(array('id_detalle',$id_detalle),array('id_sesion',$id_sesion),array('id_curso',$id_curso),array('id_suscrito',$id_suscrito),array('orden',$orden),array('cap_ip',$ip_add),array('estado_idestado',$estado),array('fecha_registro',$fecha),array('hora_registro',$hora));

	if($conteo == 0){
				
	    $id=$bd->inserta_(arma_insert("asistencia",$campos_asistencia,"POST"));      
			
		if($id>0) $rpta=1;

	}elseif($conteo == 1){

		$id=$bd->inserta_(arma_insert("asistencia",$campos_asistencia,"POST"));      
		if($id>0) $rpta=1;
		$res = '1';
		// foreach($prueba as $row){
			// if($ip_add == $row['cap_ip']){
			// }else{
			// }
		// }

	}elseif($conteo > 1){
		$id=$bd->inserta_(arma_insert("asistencia",$campos_asistencia,"POST"));      
		if($id>0) $rpta=1;
		
		$prueba2 = executesql("SELECT * FROM asistencia WHERE id_suscrito = ".$_POST['id_suscrito']." AND id_curso = ".$_POST['id_curso']." AND id_sesion = ".$_POST['id_sesion']." AND id_detalle = ".$_POST['id_detalle']." AND cap_ip = '".$ip_add."' AND fecha_registro BETWEEN '".$fecha_1."' AND '".$fecha."' ORDER BY orden DESC");
		if(count($prueba2) == 0){
		}else{ $res = '1'; }
	}
}

echo json_encode(array(
	'res' => $res,
	'rpta' => $rpta
));

?>