<?php 
// CURSOS DEPENDIENTES ..
// CURSOS DEPENDIENTES ..
// CURSOS DEPENDIENTES ..
// desde la clase del carrito, ti tiene dependientes los agregamos como cursos dependientes al alumno ..
if( !empty($row['cursos_dependientes']) ){
	
	$sql_dependientes="select id_curso, id_tipo, validez_meses, tag from cursos where estado_idestado=1 and id_curso IN (".$row['cursos_dependientes'].") order by titulo asc ";
	$dependientes=executesql($sql_dependientes);
	if( !empty($dependientes) ){
		foreach( $dependientes as $anexo ){
				// linea pedido agregamos los dependientes para tener un buen historial de asignaciones ...
				// $_orden_linea_depen = _orden_noticia("","linea_pedido","");
				$_orden_linea_depen =1;
				$tag_id_campana_shop=$anexo['tag'];

				
				$campos_linea_pedido_dependientes=array('id_pedido',array('id_curso',$anexo['id_curso']),array('cantidad',1),array('precio','0.00'),array('subtotal','0.00'),array('orden',$_orden_linea_depen),array('estado_idestado',1),'fecha_registro'); 
				$bd->inserta_(arma_insert("linea_pedido",$campos_linea_pedido_dependientes,"POST"));
				
				
				if( empty($anexo['validez_meses']) ){								
					// $validez_meses_dependientes=  0; 
					$validez_meses_especialidades=  12;  /* por defecto es 12 m */

				}else{
					$validez_meses_dependientes=$anexo['validez_meses'];
				}
				$_POST['dependiente'] = 1;
				
			// ASIGNAMOS CURSOS DEPENDIENTES ..	
			
			/* VALIDAMOS SI YA TIENE ESTE CURSO ASIGNADO EL CLIENTE */
			/* validamos si ya tiene -asignado el  curso */
			$validate_curso_existente_dependiente=executesql("select * from suscritos_x_cursos where id_curso='".$anexo['id_curso']."' and id_suscrito='".$_POST['id_suscrito']."' and estado_idestado=1 and estado!=3 ");
			if(!empty($validate_curso_existente_dependiente)){
					/* si ya existe este curso en la lista del cliente ya no lo volvemos a asignar.. */
			}else{
				
						// $_POST['orden'] = _orden_noticia("","suscritos_x_cursos","");
						$_POST['orden'] =1;
						$campos=array('id_suscrito',array('id_curso',$anexo["id_curso"]), array('id_tipo',$anexo["id_tipo"]), 'id_pedido','dependiente','especialidades','orden','fecha_registro',array('validez_meses',$validez_meses_dependientes),'estado','estado_idestado');
						$bd->inserta_(arma_insert('suscritos_x_cursos',$campos,'POST'));
						
						
					// asigno clases por curso del _ alumnos con estado pendiente: estado:2 pendiente, 1. finalizada ..
					// asigno clases por curso del _ alumnos con estado pendiente: estado:2 pendiente, 1. finalizada ..
						// $_POST['orden'] = _orden_noticia("","avance_de_cursos_clases","");
						$_POST['orden'] = 	1;
						$_POST['estado_idestado']='1';
						$_POST['estado_fin']='2';
						// recorremos las clases del curso ..
						$sql_n_clase="select d.id_detalle,d.id_sesion from detalle_sesiones d 
																INNER JOIN sesiones s  ON s.id_sesion=d.id_sesion 
																INNER JOIN cursos c  ON c.id_curso=s.id_curso 
																WHERE d.estado_idestado=1 and c.id_curso='". $anexo['id_curso']."' ";
						$n_clase_dependientes=executesql($sql_n_clase);
						if( !empty($n_clase_dependientes)){
							foreach($n_clase_dependientes as $rowe){
								// recorremos y agregamos 
									$_POST['id_detalle']=$rowe['id_detalle'];
									$_POST['id_sesion']=$rowe['id_sesion'];
									$campos=array('id_suscrito',array('id_curso',$anexo['id_curso']),'id_sesion','id_detalle','id_pedido','orden','fecha_registro','estado_fin','estado_idestado');
									$bd->inserta_(arma_insert('avance_de_cursos_clases',$campos,'POST'));								
							}
						}
					
					// /* 4. API INFUSION ADD TAG CURSO COMPRADO */
					if( !empty($tag_id_campana_shop) && $tag_id_campana_shop > 0 &&  $_POST['tipo_pago']=='2' ){ /* si es pago tarjeta y  se detecto los cursos de campaña se activa esta parte */
						include('../inc_api_infusion_compro_curso_todos_tags.php');
					}					

			}/* END validate */		
			/* END VALIDAMOS SI YA TIENE ESTE CURSO ASIGNADO EL CLIENTE */
	

		}  // for dependientes
	} // if si existe curso dependientes
						
}	
// END REGISTRANDO CURSOS DEPENDIENTES ...

?>						