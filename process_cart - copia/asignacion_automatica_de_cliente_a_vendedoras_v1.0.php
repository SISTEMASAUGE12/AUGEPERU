<?php 
/** VALIDO a vendedoras si estan conectadas o no, si paso sus 20min de actividad, forzamos el cambio de estado a a :DESCONECTADA */
$asesoras=executesql("select * from usuario where idtipo_usu=4 and estado_idestado=1  and conectividad=1 and idusuario!=21 ");
foreach($asesoras as $ase){
	// sacamos ultima conexcion
	$asistencia=executesql(" select * from asistencia_usuarios where idusuario='".$ase["idusuario"]."' order by id_asistencia desc limit 0,1  ");
	if( !empty($asistencia)){
		if( empty($asistencia[0]['fecha_cierra'])){   // si esta vacio::  aun no a cerrado session 
			// validamos si ya paso sus 20minutos validos de conexion: //minutos_en_segundos_permitidos_para_la_sesion_del_usuario::: auten.php
			if( time() - $asistencia[0]['controlador'] > $minutos_en_segundos_permitidos_para_la_sesion_del_usuario) {  // 40 segundos 
					// si se paso ya el tiepo valido de conexion y no cerro sesion, FORZAMOS EL CIERRE.
					// FORZAMOS CIERRE DE SESION 
					$fecha_cierra = fecha_hora(2);
					$hora_cierra = fecha_hora(0);
					$_POST["tipo_cierre"]=4; // usuario te voto, por vivo

					$campos_asistencia=array('tipo_cierre', array('fecha_cierra',$fecha_cierra),array('hora_cierra',$hora_cierra)); 
					$bd->actualiza_(armaupdate('asistencia_usuarios',$campos_asistencia,"id_asistencia='". $asistencia[0]['id_asistencia']."'",'POST'));/*actualizo*/
					
					$campos_conectividad=array(array('conectividad',2));
					$bd->actualiza_(armaupdate('usuario',$campos_conectividad,"idusuario='".$ase["idusuario"]."'",'POST'));/*actualizo*/
					//  END FORZAMOS CIERRE DE SESION 
					
			}  // END SI su tiempo conectividad se termino

		} // END si aun no cierra su sesion

	} // end asistencias  
} // end for vendedoras 



/* ASIGNAR VENDEDORA CONECTADA O OFFLINE AUTOMATICO.   */
	// consulto los conectados y saco el que tiene menos asignados..
	$sql_conectados="SELECT MIN( clientes_aleatorios ) AS minimo_clientes, idusuario
	FROM usuario
	WHERE conectividad =1 and idtipo_usu=4  and estado_idestado=1 and idusuario!=21 
	GROUP BY idusuario";

	// $sql_conectados.=" ORDER BY minimo_clientes ASC limit 0,1 ";
	$sql_conectados.=" ORDER BY rand()  limit 0,1 ";
	

	// echo  $sql_conectados; 
	
	$validate_conectados=executesql($sql_conectados);
	if( !empty($validate_conectados) ){
		$_POST["idusuario"]= $validate_conectados[0]['idusuario'];
		$_POST["clientes_aleatorios"]= $validate_conectados[0]['minimo_clientes'] +1;
			
	}else{
	// si no hay ningun conectado, le asigno a las desconectadas. 
	// consulto los NO conectados y saco el que tiene menos asignados.. 
		$sql_off="SELECT MIN( clientes_aleatorios ) AS minimo_clientes, idusuario
		FROM usuario
		WHERE conectividad =2 and idusuario!=21  and idtipo_usu=4 and estado_idestado=1 
		GROUP BY idusuario ";

		// $sql_off.= " ORDER BY minimo_clientes ASC limit 0,1 ";		
		$sql_off.= " ORDER BY rand()  limit 0,1 ";		
		// echo  $sql_off; 
		
		$validate_off=executesql($sql_off);
		if( !empty($validate_off) ){
			$_POST["idusuario"]= $validate_off[0]['idusuario'];
			$_POST["clientes_aleatorios"]= $validate_off[0]['minimo_clientes'] +1;
				
		} // end consulta desconectados 

	} // end consuta conectados


	$campos=array_merge($campos,array('idusuario'));  // asigno el vendedor automatico 

?>