<?php 
// CURSOS especialidades ..
						// CURSOS especialidades ..
						// CURSOS especialidades ..
						// desde la clase del carrito, ti tiene especialidades los agregamos como cursos especialidades al alumno ..
						if( !empty($row['cursos_especialidades']) ){
							
							$sql_especialidades="select id_curso, id_tipo, validez_meses, tag  from cursos where estado_idestado=1 and id_curso IN (".$row['cursos_especialidades'].") order by titulo asc ";
							$especialidades=executesql($sql_especialidades);
							if( !empty($especialidades) ){
								foreach( $especialidades as $anexo ){
										// linea pedido agregamos los especialidades para tener un buen historial de asignaciones ...
										// $_orden_linea_depen = _orden_noticia("","linea_pedido","");
										$_orden_linea_depen = 1;
										$tag_id_campana_shop=$anexo['tag'];
										
										
										
										$campos_linea_pedido_especialidades=array('id_pedido',array('id_curso',$anexo['id_curso']),array('cantidad',1),array('precio','0.00'),array('subtotal','0.00'),array('orden',$_orden_linea_depen),array('estado_idestado',1),'fecha_registro'); 
										$bd->inserta_(arma_insert("linea_pedido",$campos_linea_pedido_especialidades,"POST"));
										
										
										if( empty($anexo['validez_meses']) ){								
											// $validez_meses_especialidades=  0; 
											$validez_meses_especialidades=  12;  /* por defecto es 12 m */
											
										}else{
											$validez_meses_especialidades=$anexo['validez_meses'];
										}
										$_POST['especialidades'] = 1;
										
									// ASIGNAMOS CURSOS especialidades ..	
									
									/* VALIDAMOS SI YA TIENE ESTE CURSO ASIGNADO EL CLIENTE */
									/* validamos si ya tiene -asignado el  curso */
									$validate_curso_existente_especialidades=executesql("select * from suscritos_x_cursos where id_curso='".$anexo['id_curso']."' and id_suscrito='".$_POST['id_suscrito']."' and estado_idestado=1  and estado!=3 ");
									if(!empty($validate_curso_existente_especialidades)){ 
										/* si ya existe este curso en la lista del cliente ya no lo volvemos a asignar.. */
									}else{			
											// $_POST['orden'] = _orden_noticia("","suscritos_x_cursos","");
											$_POST['orden'] = 1;
											$campos=array('id_suscrito',array('id_curso',$anexo["id_curso"]),array('id_tipo',$anexo["id_tipo"]),'id_pedido','dependiente','especialidades','orden','fecha_registro',array('validez_meses',$validez_meses_especialidades),'estado','estado_idestado');
											$bd->inserta_(arma_insert('suscritos_x_cursos',$campos,'POST'));
											
											
											
										// asigno clases por curso del _ alumnos con estado pendiente: estado:2 pendiente, 1. finalizada ..
										// asigno clases por curso del _ alumnos con estado pendiente: estado:2 pendiente, 1. finalizada ..
											$_POST['orden'] = _orden_noticia("","avance_de_cursos_clases","");
											$_POST['estado_idestado']='1';
											$_POST['estado_fin']='2';
											// recorremos las clases del curso ..
											$sql_n_clase="select d.id_detalle,d.id_sesion from detalle_sesiones d 
																					INNER JOIN sesiones s  ON s.id_sesion=d.id_sesion 
																					INNER JOIN cursos c  ON c.id_curso=s.id_curso 
																					WHERE d.estado_idestado=1 and c.id_curso='". $anexo['id_curso']."' ";
											$n_clase_especialidades=executesql($sql_n_clase);
											if( !empty($n_clase_especialidades)){
												foreach($n_clase_especialidades as $rowe){
													// recorremos y agregamos 
														$_POST['id_detalle']=$rowe['id_detalle'];
														$_POST['id_sesion']=$rowe['id_sesion'];
														$campos=array('id_suscrito',array('id_curso',$anexo['id_curso']),'id_sesion','id_detalle','id_pedido','orden','fecha_registro','estado_fin','estado_idestado');
														$bd->inserta_(arma_insert('avance_de_cursos_clases',$campos,'POST'));								
												}
											}
														
											// /* 3. API INFUSION ADD TAG CURSO COMPRADO */
											if( !empty($tag_id_campana_shop) && $tag_id_campana_shop > 0 &&  $_POST['tipo_pago']=='2' ){ /* si es pago tarjeta y  se detecto los cursos de campaña se activa esta parte */
												include('../inc_api_infusion_compro_curso_todos_tags.php');
											}
											
										}/* END validate clases */		
									/* END VALIDAMOS SI YA TIENE ESTE CURSO ASIGNADO EL CLIENTE */
										


								}  // for especialidades
							} // if si existe curso especialidades
												
						}	
						// END REGISTRANDO CURSOS especialidades ...
						
?>						