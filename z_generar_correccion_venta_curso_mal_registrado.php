<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

  $bd = new BD;
  $bd->Begin();
 
/* Recorro los clientes que compraron el curso, en ese rango de fecha de compra  */
$sql="select sc.*, c.cursos_especialidades from suscritos_x_cursos sc  INNER JOIN cursos c ON sc.id_curso=c.id_curso WHERE sc.id_curso=892 and  sc.estado_idestado=1 order by sc.ide asc ";

$_POST["estado"]= 1; // curso afectado por mal registro en sistema - falta de especialidades - 
$_POST["estado_idestado"]= 1; // curso afectado por mal registro en sistema - falta de especialidades - 
$_POST["fecha_registro"]= fecha_hora(2); // curso afectado por mal registro en sistema - falta de especialidades - 

	$leads_wwebi=executesql($sql);
	if( !empty($leads_wwebi) ){

		foreach($leads_wwebi as $data){
									
			// ESPECIALIDADES  	
					$_POST["id_suscrito"]= $data["id_suscrito"]; // curso afectado por mal registro en sistema - falta de especialidades - 
					$_POST["id_pedido"]= $data["id_pedido"]; // curso afectado por mal registro en sistema - falta de especialidades - 
					$_POST["id_curso"]=892; // curso afectado por mal registro en sistema - falta de especialidades - 
					$especialidad=executesql(" select * from suscritos where id_suscrito='".$data["id_suscrito"]."' ",0);
			
						
							/* CURSOS ESPECIALIDADES  .. */
									if( !empty($data['cursos_especialidades']) && !empty($especialidad["id_especialidad"]) ){
										
										$especialidad_del_cliente=$especialidad["id_especialidad"];
										
										if( $especialidad_del_cliente == 13){ // si es DPCC esta es igua lq sociales pero no se crearn cursos para este entonces 
											$especialidad_del_cliente=6; // tome el valor de sociales
										}

										$sql_especialidades=" select c.* from cursos c 
													INNER JOIN especialidades esp ON c.id_especialidad=esp.id_especialidad 
													WHERE c.estado_idestado=1 and c.id_curso IN (".$data['cursos_especialidades'].") and esp.id_especialidad='".$especialidad_del_cliente."' 
													ORDER by c.titulo asc ";
													

										// echo $sql_especialidades;
										// exit();

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
													$_POST['nota'] = 892; // SI 
			
													/* VALIDAMOS SI YA TIENE ESTE CURSO ASIGNADO EL CLIENTE */
													/* validamos si ya tiene -asignado el  curso */
													$validate_curso_existente_especialidades=executesql("select * from suscritos_x_cursos where id_curso='".$anexo['id_curso']."' and id_suscrito='".$_POST['id_suscrito']."' and estado_idestado=1  and estado!=3 ");
													if(!empty($validate_curso_existente_especialidades)){ 
														/* si ya existe este curso en la lista del cliente ya no lo volvemos a asignar.. */
													}else{	
														// ASIGNAMOS CURSOS especialidades ..	
																$_POST['orden'] = 1;
																$campos=array('id_suscrito',array('id_curso',$anexo["id_curso"]),'id_pedido','nota','dependiente','especialidades','orden','fecha_registro',array('validez_meses',$validez_meses_dependientes),'estado','estado_idestado');
																 $bd->inserta_(arma_insert('suscritos_x_cursos',$campos,'POST'));

																// echo var_dump(arma_insert('suscritos_x_cursos',$campos,'POST'));
																// exit();
																
																
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
		}
	}

  $bd->Commit();
  $bd->close();

?>