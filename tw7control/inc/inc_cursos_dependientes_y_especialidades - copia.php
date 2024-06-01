<?php 		
// ESPECIALIDADES Y DEPENDIENTES 	
		$especialidad=executesql(" select * from suscritos where id_suscrito='".$_POST["id_suscrito"]."' ",0);
		$sql_data="select * from cursos where id_curso='".$_POST["id_curso"]."'";
		$curso=executesql($sql_data);
		


		if(!empty($curso)){
			foreach($curso as $row){
			
				/* CURSOS ESPECIALIDADES  .. */
						if( !empty($row['cursos_especialidades']) && !empty($especialidad["id_especialidad"]) ){
							
							$especialidad_del_cliente=$especialidad["id_especialidad"];
							
							$sql_especialidades=" select c.* from cursos c 
										INNER JOIN especialidades esp ON c.id_especialidad=esp.id_especialidad 
										WHERE c.estado_idestado=1 and c.id_curso IN (".$row['cursos_especialidades'].") and esp.id_especialidad='".$especialidad_del_cliente."' 
										ORDER by c.titulo asc ";
										
							$especialidades=executesql($sql_especialidades);
							if( !empty($especialidades) ){
								foreach( $especialidades as $anexo ){
	
										/** infusion tag  */
										$tag_id_campana_shop=$anexo['tag'];
										/** infusion tag  */

										if( empty($anexo['validez_meses']) ){								
											$validez_meses_dependientes=  12; 
										}else{
											$validez_meses_dependientes=$anexo['validez_meses'];
										}
										$_POST['dependiente'] = 2; //NO 
										$_POST['especialidades'] = 1; // SI 

										/* VALIDAMOS SI YA TIENE ESTE CURSO ASIGNADO EL CLIENTE */
										/* validamos si ya tiene -asignado el  curso */
										$validate_curso_existente_especialidades=executesql("select * from suscritos_x_cursos where id_curso='".$anexo['id_curso']."' and id_suscrito='".$_POST['id_suscrito']."' and estado_idestado=1  and estado!=3 ");
										if(!empty($validate_curso_existente_especialidades)){ 
											/* si ya existe este curso en la lista del cliente ya no lo volvemos a asignar.. */
										}else{	
											// ASIGNAMOS CURSOS especialidades ..	
													//$_POST['orden'] = _orden_noticia("","suscritos_x_cursos","");
													$_POST['orden'] = 1;
													$campos=array('id_suscrito',array('id_curso',$anexo["id_curso"]),'id_pedido',array('idusuario',$_SESSION["visualiza"]["idusuario"]),'dependiente','especialidades','orden','fecha_registro',array('validez_meses',$validez_meses_dependientes),'estado','estado_idestado');
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
													$n_clase_especial=executesql($sql_n_clase);
													if( !empty($n_clase_especial)){
														foreach($n_clase_especial as $rowe_clases_especialidd){
															// recorremos y agregamos 
																$_POST['id_detalle']=$rowe_clases_especialidd['id_detalle'];
																$_POST['id_sesion']=$rowe_clases_especialidd['id_sesion'];
																$campos=array('id_suscrito',array('id_curso',$anexo['id_curso']),'id_sesion','id_detalle','id_pedido','orden','fecha_registro','estado_fin','estado_idestado');
																$bd->inserta_(arma_insert('avance_de_cursos_clases',$campos,'POST'));								
														}
													}
										} /** end validacion si tiene el curso especialidad  */									
								}  // for ESPECIALIDADES
							} // if si existe curso ESPECIALIDADES
												
						}	
						// END REGISTRANDO CURSOS ESPECIALIDADES ...	
				
					


			/* CURSOS DEPENDIENTES .. */
						if( !empty($row['cursos_dependientes']) ){
							
							$sql_dependientes="select * from cursos where estado_idestado=1 and id_curso IN (".$row['cursos_dependientes'].") order by titulo asc ";
							$dependientes=executesql($sql_dependientes);
							if( !empty($dependientes) ){
								foreach( $dependientes as $anexo ){
										
										/** infusion tag  depdndeinete  */
										$tag_id_campana_shop=$anexo['tag'];
										/** infusion tag  */

										if( empty($anexo['validez_meses']) ){								
											$validez_meses_dependientes=  12; 
										}else{
											$validez_meses_dependientes=$anexo['validez_meses'];
										}
										$_POST['dependiente'] = 1;

										/* VALIDAMOS SI YA TIENE ESTE CURSO ASIGNADO EL CLIENTE */
										/* validamos si ya tiene -asignado el  curso */
										$validate_curso_existente_dependientes=executesql("select * from suscritos_x_cursos where id_curso='".$anexo['id_curso']."' and id_suscrito='".$_POST['id_suscrito']."' and estado_idestado=1  and estado!=3 ");
										if(!empty($validate_curso_existente_dependientes)){ 
											/* si ya existe este curso en la lista del cliente ya no lo volvemos a asignar.. */
										}else{	
											// ASIGNAMOS CURSOS DEPENDIENTES ..	
													$_POST['orden'] = _orden_noticia("","suscritos_x_cursos","");
													$campos=array('id_suscrito',array('id_curso',$anexo["id_curso"]),'id_pedido',array('idusuario',$_SESSION["visualiza"]["idusuario"]),'dependiente','orden','fecha_registro',array('validez_meses',$validez_meses_dependientes),'estado','estado_idestado');
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
													$n_clase_dependientes=executesql($sql_n_clase);
													if( !empty($n_clase_dependientes)){
														foreach($n_clase_dependientes as $rowe_clases_depen){
															// recorremos y agregamos 
																$_POST['id_detalle']=$rowe_clases_depen['id_detalle'];
																$_POST['id_sesion']=$rowe_clases_depen['id_sesion'];
																$campos=array('id_suscrito',array('id_curso',$anexo['id_curso']),'id_sesion','id_detalle','id_pedido','orden','fecha_registro','estado_fin','estado_idestado');
																$bd->inserta_(arma_insert('avance_de_cursos_clases',$campos,'POST'));								
														}
													}
													
												 /* 4. API INFUSION ADD TAG CURSO DEPENDIENTE  */
												if( !empty($tag_id_campana_shop) && $tag_id_campana_shop > 0  ){  
													include('../inc_api_infusion_compro_curso_todos_tags.php');
												}					
												/* --- */
													
													/* si el curso Dependiente tiene especialidades, tbm agregamos las especialidad */
													/* si el curso Dependiente tiene especialidades, tbm agregamos las especialidad */
														/* CURSOS ESPECIALIDADES  de DEPEMDIENTES .. */
																if( !empty($anexo['cursos_especialidades']) && !empty($especialidad["id_especialidad"]) ){
																	
																	$especialidad_del_cliente=$especialidad["id_especialidad"];
																	
																	$sql_especialidades_dependientes=" select c.* from cursos c 
																				INNER JOIN especialidades esp ON c.id_especialidad=esp.id_especialidad 
																				WHERE c.estado_idestado=1 and c.id_curso IN (".$anexo['cursos_especialidades'].") and esp.id_especialidad='".$especialidad_del_cliente."' 
																				ORDER by c.titulo asc ";
																				
																	$especialidades_dependientes=executesql($sql_especialidades_dependientes);
																	if( !empty($especialidades_dependientes) ){
																		foreach( $especialidades_dependientes as $anexo_2 ){

																				/** infusion tag  depdndeinete  -> con especlidad  */
																				$tag_id_campana_shop=$anexo['tag'];
																				/** infusion tag  */

																				if( empty($anexo_2['validez_meses']) ){								
																					$validez_meses_dependientes=  12; 
																				}else{
																					$validez_meses_dependientes=$anexo_2['validez_meses'];
																				}
																				$_POST['dependiente'] = 2; //NO 
																				$_POST['especialidades'] = 1; // SI 

																				/* VALIDAMOS SI YA TIENE ESTE CURSO ASIGNADO EL CLIENTE */
																				/* validamos si ya tiene -asignado el  curso */
																				$si_cliente_ya_tiene_esta_especialidad_del_dependiente=executesql("select * from suscritos_x_cursos where id_curso='".$anexo_2['id_curso']."' and id_suscrito='".$_POST['id_suscrito']."' and estado_idestado=1  and estado!=3 ");
																				if(!empty($si_cliente_ya_tiene_esta_especialidad_del_dependiente)){ 
																					/* si ya existe este curso en la lista del cliente ya no lo volvemos a asignar.. */
																				}else{	
																						// ASIGNAMOS CURSOS especialidades ..	
																						$_POST['orden'] = _orden_noticia("","suscritos_x_cursos","");
																						$campos=array('id_suscrito',array('id_curso',$anexo_2["id_curso"]),'id_pedido',array('idusuario',$_SESSION["visualiza"]["idusuario"]),'dependiente','especialidades','orden','fecha_registro',array('validez_meses',$validez_meses_dependientes),'estado','estado_idestado');
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
																																WHERE d.estado_idestado=1 and c.id_curso='". $anexo_2['id_curso']."' ";
																						$n_clase_especial=executesql($sql_n_clase);
																						if( !empty($n_clase_especial)){
																							foreach($n_clase_especial as $rowe_clases_especialidd_depen){
																								// recorremos y agregamos 
																									$_POST['id_detalle']=$rowe_clases_especialidd_depen['id_detalle'];
																									$_POST['id_sesion']=$rowe_clases_especialidd_depen['id_sesion'];
																									$campos=array('id_suscrito',array('id_curso',$anexo_2['id_curso']),'id_sesion','id_detalle','id_pedido','orden','fecha_registro','estado_fin','estado_idestado');
																									$bd->inserta_(arma_insert('avance_de_cursos_clases',$campos,'POST'));								
																							}
																						}

																				/* 4. API INFUSION ADD TAG CURSO DEPENDIENTE: especilidad   */
																						if( !empty($tag_id_campana_shop) && $tag_id_campana_shop > 0  ){ 
																							include('../inc_api_infusion_compro_curso_todos_tags.php');
																						}	
																						/*  --   */



																				}  /* end validaion si ya tiene esta especialidades del curso dpendiente  */

																		}  // for ESPECIALIDADES del depemndiente 
																	} // if si existe curso ESPECIALIDADES del depeniente 
																						
																}	
																// END REGISTRANDO CURSOS ESPECIALIDADES de los DEPENDIENTES ...	
													/*  END:: si el curso Dependiente tiene especialidades, tbm agregamos las especialidad */
										

										} /** end validacion si tiene el curso depedndiente  */
									
								}  // for dependientes
							} // if si existe curso dependientes
												
						}	
						// END REGISTRANDO CURSOS DEPENDIENTES ...	
				

				
				
				
			}
		}
// DEPENDIENTES 		
// DEPENDIENTES 		
// DEPENDIENTES 		

?>