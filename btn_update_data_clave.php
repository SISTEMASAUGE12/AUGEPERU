<?php include('auten.php');

$_POST['action']=isset($_POST['action'])?$_POST['action']:'';
$rpta = 2;/*si es error*/
if($_POST['action']=='actualizarclave'){  
		$bd= new BD;
		$_POST['clave']=md5($_POST['clave']);
		$campos=array("clave");
		
		// echo var_dump(armaupdate("suscritos",$campos," id_suscrito='".$_POST["id"]."'",'POST'));
		// exit();
		
		
		
		$bd->actualiza_(armaupdate("suscritos",$campos," id_suscrito='".$_POST["id_alumno"]."'",'POST'));//update
		
		
		$bd->close();
		$rpta = 1;
}
echo json_encode(array('rpta' => $rpta));

?>