<?php /* RANDOM d */

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

?>