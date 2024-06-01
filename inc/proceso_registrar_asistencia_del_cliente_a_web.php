<?php 	

$sql_asistencia=" select * from asistencia where estado_idestado=1 and ='".$_SESSION['suscritos']["id_suscrito"]."' ";
$consultando_asistencia= executesql($sql_asistencia);

if( empty($consultando_asistencia) ){   // sino existe una asistencioa activa, registramos
	
	$bd=new BD;
	$bd->Begin();
	$fecha = fecha_hora(2);
	$hora = fecha_hora(0);

	$id_suscrito = $_SESSION['suscritos']["id_suscrito"];
	// $ip_add = get_public_ip();
	// fuente:: https://www.delftstack.com/es/howto/php/php-get-user-ip/#utilice-_serverremote_addr-para-encontrar-la-direcci%C3%B3n-ip-del-usuario-en-php
						
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip_add = 'A'.$_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip_add = 'B'.$_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip_add = $_SERVER['REMOTE_ADDR'];
	}
	
	$_POST['agente']=$_SERVER['HTTP_USER_AGENT']; // dispositivo y navegador de acceso
	$_POST['comentario']='login_web_2_en_inc';

	$campos_asistencia=array('comentario', array('id_suscrito',$id_suscrito),array('cap_ip',$ip_add),'agente',array('estado_idestado',1),array('fecha_registro',$fecha),array('hora_registro',$hora));
	// echo var_dump(arma_insert("asistencia",$campos_asistencia,"POST"));

	$id=$bd->inserta_(arma_insert("asistencia",$campos_asistencia,"POST"));
	// $bd->actualiza_(armaupdate('asistencia',$campo_actua," id_asistencia='".$fila["id_asistencia"]."'",'POST')); // fecha_cierre
	$bd->close();

}



