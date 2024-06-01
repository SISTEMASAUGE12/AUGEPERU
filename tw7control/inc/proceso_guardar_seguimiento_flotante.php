<?php 
	  $bd=new BD;  
	
	$rpta=2;
	$texto="";
	
	$_POST['idusuario'] = $_SESSION["visualiza"]["idusuario"];
	$_POST['estado_idestado'] = 1;
	$_POST['fecha_atendido'] = fecha_hora(2);
	$_POST['fecha_registro'] = fecha_hora(2);
	
	$campos=array('idusuario','id_suscrito','motivo','id_tipo_atencion','id_tipo_intera','descripcion','curso','precio','id_nivel','id_tipo_recordatorio','fecha_registro','estado_idestado');  
	
	if( $_POST["id_tipo_recordatorio"] > 1  &&  !empty($_POST["fecha_recordatorio"]) ){ /* si marco algun recordatorio */
		$campos=array_merge($campos, array('fecha_recordatorio','hora_recordatorio'));
	}
	// echo "select * from suscritos where id_suscrito='".$_POST["id_suscrito"]."' ";
	// exit();
	
	?>