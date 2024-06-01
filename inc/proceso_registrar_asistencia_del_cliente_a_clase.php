<?php 	
$bd=new BD;
$bd->Begin();

$fecha = fecha_hora(2);
$fecha2 = fecha_hora(1);
$fecha2 = $fecha2.' 00:00:00';
$hora = fecha_hora(0);
$fecha_1 = strtotime('-1 hour',strtotime($fecha));  
$fecha_1 = date('Y-m-d H:i:s',$fecha_1); 

$id_suscrito = $_SESSION['suscritos']["id_suscrito"];
// $ip_add = get_public_ip(); // no es ocnfiable este dato fue reempalzado 

// fuente:: https://www.delftstack.com/es/howto/php/php-get-user-ip/#utilice-_serverremote_addr-para-encontrar-la-direcci%C3%B3n-ip-del-usuario-en-php						
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	$ip_add = 'A'.$_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$ip_add = 'B'.$_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
	$ip_add = $_SERVER['REMOTE_ADDR'];
}

$_POST['agente']=$_SERVER['HTTP_USER_AGENT'];



// $detal["id_detalle"] = $detal["id_detalle"];
// $detal["id_sesion"] = $detal["id_sesion"];
// $curs[0]['id_curso'] = $curs[0]['id_curso'];
// $id_asistencia = _id_asistencia_noticia("","asistencia","");
$estado='1'; /* estado::1; de activo; osea hay un cliente ahora coenctado a esta clase .. */





$campos_asistencia=array(array('id_detalle',$detal["id_detalle"]),array('id_sesion',$detal["id_sesion"]),array('id_curso',$curs[0]['id_curso']),array('id_suscrito',$id_suscrito),array('cap_ip',$ip_add),array('estado_idestado',$estado),array('fecha_registro',$fecha),array('hora_registro',$hora),'agente',);

/* # calcular tiempo de actividad */
$compro = executesql("SELECT * FROM asistencia WHERE id_suscrito = ".$_SESSION['suscritos']['id_suscrito']." AND id_curso = ".$curs[0]['id_curso']." AND id_sesion = ".$detal["id_sesion"]." AND id_detalle = ".$detal["id_detalle"]." AND cap_ip = '".$ip_add."' AND fecha_registro BETWEEN '".$fecha2."' AND '".$fecha."' AND tiempo IS NULL ORDER BY id_asistencia DESC");

//Si coincide con una sesion guardada, registrar el tiempo que estuvo anteriormente, poner su estado en 2 y guardar el nuevo registro
if(!empty($compro)){ 
	foreach($compro as $fila){
			$hora1 = $fila['hora_registro'];
			$datex7 = new DateTime($hora);
			$datex77 = new DateTime($hora1);
			$horax7 = date_diff($datex7, $datex77);

			$hx7x7 = $horax7->format('%Hh %im %ss');
			$campo_actua = array(array('tiempo',$hx7x7),array('estado_idestado',2));
			$bd->actualiza_(armaupdate('asistencia',$campo_actua," id_asistencia='".$fila["id_asistencia"]."'",'POST'));
			
			// echo var_dump(arma_insert("asistencia",$campos_asistencia,"POST"));
			
			$id=$bd->inserta_(arma_insert("asistencia",$campos_asistencia,"POST"));
	} 

// } /* cierre temporal hasta revisar esto . */

}else{

	// /** Si esque no coincide con niuna clave buscar si hay otro ip registrado guardar este ip y alertar que ya hay otro usuario usando y redirigir al inicio **/ 
	$asis = executesql("SELECT * FROM asistencia WHERE id_suscrito = ".$_SESSION['suscritos']['id_suscrito']." AND id_curso = ".$curs[0]['id_curso']." AND id_sesion = ".$detal["id_sesion"]." AND id_detalle = ".$detal["id_detalle"]." AND fecha_registro BETWEEN '".$fecha2."' AND '".$fecha."' AND tiempo IS NULL ORDER BY id_asistencia DESC");

	if(!empty($asis)){ 
			// foreach($asis as $fila2){
				// $campos_asis = array(array('id_detalle',$detal["id_detalle"]),array('id_sesion',$detal["id_sesion"]),array('id_curso',$curs[0]['id_curso']),array('id_suscrito',$id_suscrito),array('id_asistencia',$id_asistencia),array('cap_ip',$ip_add),array('estado_idestado',2),array('fecha_registro',$fecha),array('hora_registro',$hora),array('tiempo','00h 00m 00s'));
				// $id=$bd->inserta_(arma_insert("asistencia",$campos_asis,"POST"));
				
				// /* votar 2 clientes */		
				// echo '<script language="javascript">alert("Hay otra persona conectada con este usuario");</script>';
				// $urlk = $url.'error_usuario';
				// echo '<script language="javascript">location.href = \''.$urlk.'\';</script>';
		
			// } 
			
	}else{

		// /** Ahora toca buscar si coincide con el Ip y no con el id_detalle, si esto coincide se actualiza al sesion anterior y se guarda la nueva ** / 
		$asis2 = executesql("SELECT * FROM asistencia WHERE id_suscrito = ".$_SESSION['suscritos']['id_suscrito']." AND id_curso = ".$curs[0]['id_curso']." AND id_sesion = ".$detal["id_sesion"]." AND cap_ip = '".$ip_add."' AND fecha_registro BETWEEN '".$fecha2."' AND '".$fecha."' AND tiempo IS NULL ORDER BY id_asistencia DESC LIMIT 0,1");
		if(!empty($asis2)){ 
				foreach($asis2 as $fila3){
						$hora1 = $fila3['hora_registro'];
						$datex7 = new DateTime($hora);
						$datex77 = new DateTime($hora1);
						$horax7 = date_diff($datex7, $datex77);

						$hx7x7 = $horax7->format('%Hh %im %ss');
						$campo_actua = array(array('tiempo',$hx7x7),array('estado_idestado',2));
						$bd->actualiza_(armaupdate('asistencia',$campo_actua," id_asistencia='".$fila3["id_asistencia"]."'",'POST'));
						$id=$bd->inserta_(arma_insert("asistencia",$campos_asistencia,"POST"));
				} 
				
		}else{

			$id=$bd->inserta_(arma_insert("asistencia",$campos_asistencia,"POST"));
		}
	}
}

?>