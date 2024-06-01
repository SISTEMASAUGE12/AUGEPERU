<?php   // proceso de insercion y recorrido de lina de pedido


										// $_POST['orden'] = _orden_noticia("","linea_pedido","");
										$_POST['orden'] = 1;
										$_POST['cantidad']=  1;
										$_POST['dependiente'] = 2; // por defecto que no son dependientes 
										$_POST['especialidades'] = 2; // por defecto que no son especiales 																				
										
										$data_curso=executesql("select * from examenes where id_examen='".$_POST["id_examen"]."' ",0);
										$_POST['talla']= '7777'; /* si es libro o curso, etc */	
										$_POST["id_curso"]=$data_curso['id_examen']; ;	/* cod.curso 555 - */

										/* Infusion */
										$tag_id_campana_shop=$data_curso['tag']; ;	/* cod.curso 555 - */
										/* Infusion */


										$precio_linea=(  $data_curso['costo_promo'] >0  )?$data_curso['costo_promo']: $data_curso['precio'];
										$_POST['precio']=$_POST['subtotal']=  $precio_linea;									
										$campos_detalle=array('id_pedido','id_curso','cantidad','precio','subtotal','talla','fecha_registro','orden','estado_idestado'); 
										
								
										/*
										echo var_dump(arma_insert("linea_pedido",$campos_detalle,"POST"));
										exit();
										*/

										$bd->inserta_(arma_insert("linea_pedido",$campos_detalle,"POST"));
																				
									/* REGISTRO SUSCRITO X CERTIFICADO */
										$_POST['validez_meses']='99';
										$_POST['orden'] =1;
										$_POST['dependiente'] = 2;
										$_POST['estado'] = 1; 								
										$_POST['habilitar_solicitar_directo'] = 1; //   1::  no respeta validacion de terminar clase 
										
										
										
										$campos_asignacion=array('id_suscrito','id_examen','id_pedido','orden','fecha_registro','estado','estado_idestado');										
										$bd->inserta_(arma_insert('suscritos_x_examenes',$campos_asignacion,'POST'));										
										/*  
										echo var_dump(arma_insert('suscritos_x_certificados',$campos_asignacion,'POST'));
										exit();
										*/
											
									/* END REGISTRO SUSCRITO X CURSO */
								
										
?>										