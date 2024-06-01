<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");
include('qr/phpqrcode/qrlib.php');  // libreria del QR


if($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
	$voucher_correctos=1; // 1:: todos los vocuhers son correctos , si es mayor a 1 quiere decir que uno de los voucher ya fue registrado 

	$_POST['estado_idestado']=1;
	$_POST['estado_pago']=1;
	$_POST['categoria_venta']=2; // categoria venta manual de certificado 


	if(empty($_POST['total'])) $_POST['total']='0.00'; 
	$_POST['subtotal']=$_POST['total'];
	
			
	if($_SESSION["visualiza"]["idtipo_usu"] == 4 ){  /* si estan con perfil vendedor, asigna automatico a ese vendedor, sino al que marcoen el select  */
		$_POST['idusuario'] = $_SESSION["visualiza"]["idusuario"];				
	}
	// $_POST['idusuario'] =$_SESSION["visualiza"]["idusuario"];
	
	
	// $_POST['usuario_modifico'] =$_SESSION["visualiza"]["idusuario"];
	$_POST['fecha_modificacion'] = fecha_hora(2);
	
	$campos=array('categoria_venta','id_suscrito','tipo_pago','estado_pago','total','subtotal','total_voucher','articulos','banco_pago','fecha_pago_off','codigo_ope_off','observacion','fecha_modificacion','estado_idestado'); /*inserto campos principales*/
	

	if(empty($_POST['total_voucher'])) $_POST['total_voucher']='0.00'; 
	if(empty($_POST['total_voucher_2'])) $_POST['total_voucher_2']='0.00';
	if(empty($_POST['total_voucher_3'])) $_POST['total_voucher_3']='0.00';


	// voucher 2 y 3 en tabla pedidos
	if( !empty($_POST["banco_pago_2"]) ){  /* si estan con perfil vendedor, asigna automatico a ese vendedor, sino al que marcoen el select  */
		$campos=array_merge($campos, array('banco_pago_2'));
	}
	if( !empty($_POST["codigo_ope_off_2"]) ){  /* si estan con perfil vendedor, asigna automatico a ese vendedor, sino al que marcoen el select  */
		$campos=array_merge($campos, array('codigo_ope_off_2'));
	}
	if( !empty($_POST["total_voucher_2"]) ){  /* si estan con perfil vendedor, asigna automatico a ese vendedor, sino al que marcoen el select  */
		$campos=array_merge($campos, array('total_voucher_2'));
	}
	// voucher 3
	if( !empty($_POST["banco_pago_3"]) ){  /* si estan con perfil vendedor, asigna automatico a ese vendedor, sino al que marcoen el select  */
		$campos=array_merge($campos, array('banco_pago_3'));
	}
	if( !empty($_POST["codigo_ope_off_3"]) ){  /* si estan con perfil vendedor, asigna automatico a ese vendedor, sino al que marcoen el select  */
		$campos=array_merge($campos, array('codigo_ope_off_3'));
	}
	if( !empty($_POST["total_voucher_3"]) ){  /* si estan con perfil vendedor, asigna automatico a ese vendedor, sino al que marcoen el select  */
		$campos=array_merge($campos, array('total_voucher_3'));
	}



  if($_GET["task"]=='insert'){

			/**  VALIDAMOS:: SI VENTA INCLUYE LIBRO, DEBE TENER TODO INFO DE SEGUIMIENTO SINO BLOQUEO LA VENTA .. */
			if( !empty($_POST["api_nombre"])  && !empty($_POST["api_paterno"])  && !empty($_POST["api_materno"])  && !empty($_POST["iddpto"])  && !empty($_POST["idprvc"])  && !empty($_POST["iddist"])  && !empty($_POST["id_agencia"])  && !empty($_POST["id_sucursal"])  &&  !empty($_POST["direccion"])     ){
			}else{
				echo " <h3 style='padding:70px 0;text-align:center;' > PARA LA VENTA DE CERTIFICADOS:  </BR> DEBEN COMPLETAR TODOS LOS CAMPOS DE SEGUIMIENTO QUE EL FORMULARIO INDICA <span style='color:red;'>*OBLIGATORIO* </span>  </br> VUELVE A REALIZAR LA VENTA CORRECTAMENTE </br>   </br></br>   </br>
					<a href='https://www.educaauge.com/tw7control/index.php?page=pedidos_manuales_certificados&module=venta%20de%20manual&parenttab=Certificados&task=new' style='background:red;color:#fff;padding:10px;border-radius:8px;text-decoration:none;' > VOLVER A VENDER CORRECTAMENTE</a>
					</br>   </br>
				</h3> 
				";							
				exit();
			}


			//name client
			$nclient=executesql("select * from suscritos where id_suscrito='".$_POST["id_suscrito"]."'");

			/* validamos si, ya tiene el curso blokeamos , sino lo tiene registramos */
			$_curso_repetidos=0;
			$_yacomprados=' ';
			$n_cursos=0;


			/* 
			echo var_dump($_POST['subcategorias']);
			echo "--";
			echo var_dump($_POST['array_certificados_a_vender']);
			*/ 

		
			if(isset($_POST['subcategorias'])){ // del slect multiple 
				foreach($_POST['subcategorias'] as $v){
					$division = explode('_',$v);
					$_POST["id_curso"] = $division[0];
					$_POST["id_certificado"] = $division[1];
					$n_cursos++;

					$sql_valida_si_curso="select * from suscritos_x_certificados where id_suscrito='".$_POST["id_suscrito"]."' and id_certificado ='".$_POST["id_certificado"]."' and estado!=3 ";
					// $sql_valida_si_curso;  // si el curso diferente de rechasdo, ya lo ha comrpado 

					$validamos_si_ya_tiene_curso=executesql($sql_valida_si_curso);
					if( !empty($validamos_si_ya_tiene_curso) ){  // si ya tiene un curso, blokeamos la venta 
						$_curso_repetidos++; // si ya lo tiene contamos 
						$_yacomprados.=$_yacomprados.' ,'.$_POST["id_certificado"];
					}
				}
			} // end validacion si ya tiene cursoss 			
			// echo $sql_valida_si_curso;

			/** VALIDACION DE CERTIFICADOS EXTRAS A VENDER */
			if(isset($_POST['array_certificados_a_vender'])){
				$data_string= implode(',',$_POST['array_certificados_a_vender']);  // como llega en una linea, lo comnvierto a string 
				$data_array_cursos =explode(',',$data_string);   // ese string lo convierto a un array separado  (antes estaba en conjunto )
				// echo var_dump($data_array_cursos);
				$longitud_cursos_asignar = count($data_array_cursos);							
			
				for($i=0; $i<$longitud_cursos_asignar; $i++){
					  //saco el valor de cada elemento      
					$_POST["id_certificado_extra"] = $data_array_cursos[$i];
					if( !empty($_POST["id_certificado_extra"]) ){
						$sql_valida_si_curso="select * from suscritos_x_certificados where id_suscrito='".$_POST["id_suscrito"]."' and id_certificado ='".$_POST["id_certificado_extra"]."' and estado!=3 ";
						// $sql_valida_si_curso;  // si el curso diferente de rechasdo, ya lo ha comrpado 
	
						$validamos_si_ya_tiene_curso=executesql($sql_valida_si_curso);
						if( !empty($validamos_si_ya_tiene_curso) ){  // si ya tiene un curso, blokeamos la venta 
							$_curso_repetidos++; // si ya lo tiene contamos 
							$_yacomprados.=$_yacomprados.' , extra:'.$_POST["id_certificado_extra"];
						}
					} // END SI EL ID ES DIFERNRETE VACIO EL PRIMER VALOR SALE VACIO ','
				}
			}		


			if($_curso_repetidos == 0){ // si aun no tiene el curso, le vendemos 
				if($n_cursos > 0){ // almenos un curso 



						if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
							$_POST['imagen'] = carga_imagen('files/images/comprobantes/','imagen','','600','600');
							$campos = array_merge($campos,array('imagen'));
						}

					$_POST["codigo"]='-';
						
					// $_POST['orden'] = _orden_noticia("","pedidos","");
						$_POST['orden'] = 1067;
						$_POST['fecha_registro'] = fecha_hora(2);
						$campos=array_merge($campos,array('codigo','orden','fecha_registro','idusuario')); 
						

						/* Chequeo si es comision compartida */
						$sql_validate_compartido="select s.id_suscrito, s.idusuario, u.nomusuario, u.tipo_asesora, u.comision 
						from suscritos s 
						LEFT join  usuario u ON s.idusuario=u.idusuario 
						where s.id_suscrito='".$_POST["id_suscrito"]."'  ";

						$usuario_compartido=executesql($sql_validate_compartido);
						if( !empty($usuario_compartido) ){  /* sino es su cliente, registramos venta compartidas. */

							if( $usuario_compartido[0]['idusuario'] == $_SESSION["visualiza"]["idusuario"] ){ // si es mio 
								$_POST["tipo_venta"]=1; // venta propia
								$_POST["compartido_con"]='propio'; // venta propio
																			

							}else if( empty($usuario_compartido[0]['idusuario']) ){ // si es cliente antiguo y no tiene vendedor aun  
								/* este clienete pasa hacer mio */ 
								$_POST["idusuario"]=$_SESSION["visualiza"]["idusuario"];
								$campos_cliente=array('idusuario');
								$bd->actualiza_(armaupdate('suscritos',$campos_cliente," id_suscrito='".$_POST["id_suscrito"]."'",'POST')); 
								
								$_POST["compartido_con"]='propio'; // venta propia
								$_POST["tipo_venta"]=1; // venta propia
								
							}else{ // si no es mio, la venta va para el otro, compartida
								$_POST["tipo_venta"]=2; // venta compartida
								$_POST["compartido_con"]= $usuario_compartido[0]['idusuario'].' - '.$usuario_compartido[0]['nomusuario'];
								$_POST["tipo_asesora"]=$usuario_compartido[0]['tipo_asesora']; //  tipo_ayudante:: xq el usuario es de otro

							}

						} // end validate si es propio o compartido 

						
						/* valido si el cliente ya tiene un compra, si ya tiene compra, sera tipo_venta=3, cliente ya con compra no suma en comisiones.  */
						$cliente_ya_compro=executesql(" select * from pedidos where estado_pago=1 and estado_idestado=1 and id_suscrito='".$_POST["id_suscrito"]."' ");
						if( !empty($cliente_ya_compro) ){  // si ya tiene compras, esta venta no suma en comision: ser tipo_venta =3 
							$_POST["tipo_venta"]=3; // venta CLIENTE ya con compra
						}

						$campos=array_merge($campos,array('tipo_venta','compartido_con')); 

						/*
						echo var_dump(arma_insert('pedidos',$campos,'POST'));
						exit();
						*/
					

						/** VOUCHERS VALIDACIONES  */
						/* validar si este codigo ya existe:: solo validare por codigo ya no por banco   */
						// $sql_existe_voucher= "select * from vouchers where codigo_operacion='".$_POST["codigo_ope_off"]."' and id_banco='".$_POST["banco_pago"]."' and estado_idestado=1 ";
						$sql_existe_voucher= "select * from vouchers where codigo_operacion='".$_POST["codigo_ope_off"]."'  and estado_idestado=1 ";
						$existe_voucher=executesql($sql_existe_voucher);

						if( !empty($existe_voucher) ){   // si el voucher ya existe lo marcamos, como exista y aumentao contadlr de validacion 
							$voucher_correctos++;
						}

						// validacion voucher 2 y 3 
						if( !empty($_POST["codigo_ope_off_2"]) ){
							$sql_existe_voucher_2= "select * from vouchers where codigo_operacion='".$_POST["codigo_ope_off_2"]."'  and estado_idestado=1 ";
							$existe_voucher_2=executesql($sql_existe_voucher_2);
							
							if( !empty($existe_voucher_2) ){   // si el voucher ya existe lo marcamos, como exista y aumentao contadlr de validacion 
								$voucher_correctos++;
							}
						}
						

						if( !empty($_POST["codigo_ope_off_3"]) ){
							$sql_existe_voucher_3= "select * from vouchers where codigo_operacion='".$_POST["codigo_ope_off_3"]."'  and estado_idestado=1 ";
							$existe_voucher_3 =executesql($sql_existe_voucher_3);

							if( !empty($existe_voucher_3) ){   // si el voucher ya existe lo marcamos, como exista y aumentao contadlr de validacion 
								$voucher_correctos++;
							}
						}


						if( empty($existe_voucher) && $voucher_correctos == 1 ){   /* si no existe, registramos venta */
							
								// if($_SESSION["visualiza"]["idusuario"] == 23 ){  
										// echo var_dump(arma_insert('pedidos',$campos,'POST'));
										// exit(); 
								// }

								/* 1. API INFUSION 				 */ 				

									$tag_id_campana_shop=''; // Infusion soft api 
									require_once '../vendor/autoload.php';
									require('../vendor/infusionsoft/php-sdk/src/Infusionsoft/Api/ContactService.php');
									//  Infusion
										
										$nombre_suscritos=$nclient[0]["nombre"];
										$correo_cliente_api=$_POST['correo']= $nclient[0]["email"];
											
										
										// 1. API INFUSION CLIENTE: Obtener ID si ya existe o registrar sino esta en infusion aun  
										/*
										if( !empty($correo_cliente_api) ){ // si es pago tarjeta y  tenemos correo del cliente  									
											$tagId=2100;	
											$registro_desde="venta_manual";
											$_POST['FirstName']= $nclient[0]["nombre"];
											$_POST['LastName']= $nclient[0]["ap_pa"].' '.$nclient[0]["ap_ma"];
											$_POST['StreetAddress1']='';
											$_POST['Phone1']= $nclient[0]["telefono"];					
											$_POST['correo']=$nclient[0]["email"];																				
											include('../inc_api_infusion_compro_curso.php');
										}
										*/
								/** end api infusion  */								
								
								// valido si cliente ya tiene una compra anterior, si ya tiene compra anterior no suma ninguna comision	
								$sql_valida_si_compro="select * from pedidos where estado_idestado=1 and estado_pago=1 and id_suscrito='".$_POST["id_suscrito"]."' ";
									// echo $sql_valida_si_compro;

								$si_cliente_tiene_ya_compra=executesql($sql_valida_si_compro);
								if( !empty($si_cliente_tiene_ya_compra) ){
									$rpta_si_cliente_tiene_ya_compra=1;  // si ya tiene una compra ya no suma nada en comisiones 
								}else{
									$rpta_si_cliente_tiene_ya_compra=0;  // si aun no tiene compras si suma  
								}

								// registranos la venta::: 
								
								// echo var_dump(arma_insert('pedidos',$campos,'POST'));
								// exit();
								

								$id_pedido=$_POST["id_pedido"]=$bd->inserta_(arma_insert('pedidos',$campos,'POST'));

								
						}else{
								echo "<script>alert('Codigo ya registrado en el sistema: ".$_POST["codigo_ope_off"]." -cod.venta: ".	$existe_voucher[0]['id_pedido']."');</script>";
						}

						
						if($id_pedido > 0){

								/* registro en tabla vouchers */
								$_POST['estado_idestado']=1;
								$_POST['fecha_registro']=fecha_hora(2);
								$_POST['codigo_operacion']=$_POST["codigo_ope_off"];
								$_POST['orden'] = _orden_noticia("","vouchers","");
								$_POST['id_banco']=$_POST["banco_pago"];
								
								$campos_voucher=array('id_banco','codigo_operacion','id_suscrito','id_pedido','total','estado_idestado','fecha_registro','orden');
								// echo var_dump(arma_insert("vouchers",$campos_voucher,"POST"));
								// exit();
								$_POST['id_vouchers']=$bd->inserta_(arma_insert("vouchers",$campos_voucher,"POST"));
								
								// registro voucher 2 y3 		
								if( !empty($_POST["codigo_ope_off_2"]) &&  strlen($_POST["codigo_ope_off_2"]) > 3 ){
									$campos_voucher_2=array(array('id_banco',$_POST["banco_pago_2"]),array('codigo_operacion',$_POST["codigo_ope_off_2"]),'id_suscrito','id_pedido',array('total',$_POST["total_voucher_2"]),'estado_idestado','fecha_registro','orden');
									// echo var_dump(arma_insert("vouchers",$campos_voucher,"POST"));
									// exit();
									$bd->inserta_(arma_insert("vouchers",$campos_voucher_2,"POST"));  // registro vouhcer 2
								}						
								
																
								if( !empty($_POST["codigo_ope_off_3"]) &&  strlen($_POST["codigo_ope_off_3"]) > 3 ){
									$campos_voucher_3=array(array('id_banco',$_POST["banco_pago_3"]),array('codigo_operacion',$_POST["codigo_ope_off_3"]),'id_suscrito','id_pedido',array('total',$_POST["total_voucher_3"]),'estado_idestado','fecha_registro','orden');
									// echo var_dump(arma_insert("vouchers",$campos_voucher,"POST"));
									// exit();
									$bd->inserta_(arma_insert("vouchers",$campos_voucher_3,"POST"));  // registro vouhcer 2
								}
	

								
								
								/* LINEA PEDIDO VENTA NATURAL  */
								if(isset($_POST['subcategorias'])){
									foreach($_POST['subcategorias'] as $v){
										$division = explode('_',$v);
										// $_POST["id_cat"] = $division[0]; 
										$_POST["id_certificado"] = $division[1];
										//$_POST["id_curso"] = $_POST["id_certificado"];
										$_POST["id_curso"] = $division[0]; // id del curso vinculado con el certificado
										$_POST['talla']='9999'; // certificado vendido directamnete
										
										include('inc_proceso_recorrido_linea_pedido_y_registros_solicitudes_certificados.php'); // aca se ejecutan todos los procesos 
									} /* end for array, linea pedido  */
								} /* end if linea pedido */
								

								/* LINEA PEDIDO :: certificados EXTRAS */
								if(isset($_POST['array_certificados_a_vender'])){
									$data_string= implode(',',$_POST['array_certificados_a_vender']);  // como llega en una linea, lo comnvierto a string 
									$data_array_cursos =explode(',',$data_string);   // ese string lo convierto a un array separado  (antes estaba en conjunto )
									$longitud_cursos_asignar = count($data_array_cursos);							
								
									for($i=0; $i<$longitud_cursos_asignar; $i++){  //saco el valor de cada elemento      
										$_POST["id_certificado"] = $data_array_cursos[$i];  // certificado extra
										if( !empty($_POST["id_certificado"]) ){
											$_POST['talla']='9998'; // certificado vendido modo extra
											
											// saco id_curso del certifiado extra: 
											$curso_extra=executesql("select id_curso from certificados  where id_certificado='".$_POST["id_certificado"]."'");
											$_POST["id_curso"] = $curso_extra[0]["id_curso"]; // id del curso vinculado con el certificado
											
											include('inc_proceso_recorrido_linea_pedido_y_registros_solicitudes_certificados.php'); // aca se ejecutan todos los procesos 
										} // valido if si es diferente de vacio 										
									} // end for linea de certificados  extra
								} /* end if linea pedido EXTRA */

								

								// valido si cliente ya tiene una compra anterior, si ya tiene compra anterior no suma ninguna comision								
								if( $rpta_si_cliente_tiene_ya_compra == 1  ){
										/* *si el cliente ya tiene compra, no se hace nada no se registra ni venta compartida ; ni venta propia de comision  */
										// asi sea un aventa compartida osea que un asesor vendio a un cliente de otro, esta venta no suma, ni se crea un reporte..

								}else{ 	

									/* *** 
											if( $_POST["tipo_venta"]==2 ){ // si fue venta compartida, registramos los 2 involucrados
										
												// primero el que registro  la venta: el no dueño del cliente 
												$_POST["estado_idestado"]=1; // yo registra venta que no es mia  
												$_POST["tipo_compartido"]=2; // yo registra venta que no es mia  
												$_POST['comision']=2; // si es compartida, yo fui el que ayudo . 
												
												$campos_compartidos=array('id_pedido',array('idusuario',$_SESSION["visualiza"]["idusuario"]), array('tipo_asesora',$_SESSION["visualiza"]["tipo_asesora"]), 'id_suscrito', 'comision','tipo_compartido','compartido_con','estado_idestado','fecha_registro' ); 
												$bd->inserta_(arma_insert('pedidos_compartidos',$campos_compartidos,'POST'));
									
												
												// agrego al sigte involucrado de la venta compartida:: DUeño del cliente  
												$idusuario_compartido= $usuario_compartido[0]['idusuario']; // yo registra venta que no es mia  
												$tipo_asesora_2= $usuario_compartido[0]['tipo_asesora']; // yo registra venta que no es mia  
												$tipo_compartido_2 = 1; // el fue dueño del cliente  
												$compartido_con_2= $_SESSION["visualiza"]["idusuario"].' - '.$_SESSION["visualiza"]["nomusuario"]; // el fue dueño del cliente  
									
												if($tipo_asesora_2 == 1){ // si soy tipo oficina, la comision no afecta
													$comision_2= $usuario_compartido[0]['comision']; // no varia: es 5.
												}else{ // pero si dueño es externo pierde un 20%: osea 2 soles
													$comision_2= $usuario_compartido[0]['comision']  - ($usuario_compartido[0]['comision'] *0.20); // - 20%
												}
									
												$campos_compartidos_2=array('id_pedido',array('idusuario',$idusuario_compartido), array('tipo_asesora',$tipo_asesora_2), 'id_suscrito', array('comision',$comision_2) ,array('tipo_compartido',$tipo_compartido_2),array('compartido_con',$compartido_con_2),'estado_idestado','fecha_registro' ); 
												$bd->inserta_(arma_insert('pedidos_compartidos',$campos_compartidos_2,'POST'));
												
												// end si fue venta compartida 

											}else{
												// si no es venta compratida es una venta de comision: o venta propia. suma comision 100%  
												$_POST["estado_idestado"]=1;
												$campos_comision=array('id_pedido',array('idusuario',$_SESSION["visualiza"]["idusuario"]),'id_suscrito',array('comision',$_SESSION["visualiza"]["comision"]),'fecha_registro','estado_idestado');
												$bd->inserta_(arma_insert('pedidos_comisiones',$campos_comision,'POST'));
												
											} // end si fue venta compartida 
											
									*** */


								} // end si cliente ya compro anterioremnete 								

						} /* end if registro pedido exitoso */		
						
						
			

		
			}else{
				// echo "tiene repetidos ";
				/* si ya tiene un curso comprado anteriormente, mostramos alerta */
				echo "<script>alert(' Seleecciona al menos  un curso a vender! ');</script>";
			}

		}else{
			/* compelta todos los datos del cleinte para poder venderle  */
			echo "<script>alert('Venta no procesada: ".$_curso_repetidos." Cliente tiene el/los cursos ya comprados: ".$_yacomprados."');</script>";
		}




	}else{ /**   UPDATE UPDATE ::::    >>>>    ACTUALIZAR SOLO UBIGEO - UPDATE UBIGEO */

		if(isset($_POST['subcategorias'])){
			foreach($_POST['subcategorias'] as $v){
				$division = explode('_',$v);
				// $_POST["id_cat"] = $division[0]; 
				$_POST["id_certificado"] = $division[1];
				//$_POST["id_curso"] = $_POST["id_certificado"];															
				$_POST["id_curso"] = $division[0];															
				
				$_POST["fecha_update"] = fecha_hora(2);															
				
				$_POST["api_nombre"]=strtoupper($_POST["api_nombre"]);
				$_POST["api_paterno"]=strtoupper($_POST["api_paterno"]);
				$_POST["api_materno"]=strtoupper($_POST["api_materno"]);
				//$campos_solicitudes=array('api_nombre','api_paterno','api_materno','fecha_update'); 
				$campos_solicitudes=array('api_nombre','api_paterno','api_materno', 'id_agencia','id_sucursal','agencia','direccion','iddpto','idprvc','iddist','fecha_update'); 
				
				// echo var_dump(armaupdate('solicitudes',$campos_solicitudes," id_certificado='".$_POST["id_certificado"]."'  and  id_pedido='".$_POST["id_pedido"]."'  and  id_suscrito='".$_POST["id_suscrito"]."'  and id_curso='".$_POST["id_curso"]."'    ",'POST'));
				// exit();

				$bd->actualiza_(armaupdate('solicitudes',$campos_solicitudes," id_certificado='".$_POST["id_certificado"]."'  and  id_pedido='".$_POST["id_pedido"]."'  and  id_suscrito='".$_POST["id_suscrito"]."'  and id_curso='".$_POST["id_curso"]."'    ",'POST'));/*actualizo*/
			
			}
		}  // end cursos recorrido 
			


	} /* end if insert  */
	$bd->close();
	gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);

	
	
}else if( $_GET["task"]=='edit' || $_GET["task"]=='new'){
  if($_GET["task"]=='edit'){
		 
		if( $_SESSION["visualiza"]["idtipo_usu"] ==4 ){  /* filtro solo ventas del vendedor : */
			$usuario=executesql("select * from pedidos where id_pedido='".$_GET["id_pedido"]."' and idusuario='".$_SESSION["visualiza"]["idusuario"]."' ",0);

			 
		}else{
		 $usuario=executesql("select * from pedidos where id_pedido='".$_GET["id_pedido"]."'",0);
			 
		}	
		 
		$solicitudes=executesql(" select * from solicitudes where  id_pedido='".$_GET["id_pedido"]."'",0 ); 

  } 
?>

<script src="ckeditor/sample.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="ckfinder/ckfinder.js"></script>

<script src="dist/js/jQuery-2.1.4.min.js"></script>
<script type="text/javascript" src="js/buscar_certificado_para_vender.js?ud=<?php echo $unix_date; ?>"></script>


<?php if( $_GET["task"]=='new' ){ ?>
<script src="js/buscar_reniec_certificado.js"></script>
<?php } ?>


<section class="content">
  <div class="row">
    <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">VENTA DE CERTIFICADOS MANUAL</h3>
            </div><!-- /.box-header -->
						
<?php 							 
		if( $_SESSION["visualiza"]["idtipo_usu"] ==4  && isset($_GET["id_pedido"]) ){  /* filtro solo ventas del vendedor : */
			if( empty($usuario) ){ /* si esta venta no pertence al usuario vendedor: conusltas */
					echo "<h3 style='color:red;'>No tienes acceso a esta venta, no te pertence. </h3>";
			}
			 
		}	
?>		 
													
<?php $task_=$_GET["task"]; ?>

				<div class="form-group" style="padding-bottom:90px;display:<?php  echo (!empty($_POST["consulta_dni"])  ||  ($_GET["task"]=='edit'))?'none':'block';?>;">
					<form action="<?php echo $link2."&task=new"; ?>" method="post">
							<div class="col-sm-3">		
							<label for="inputPassword3" class=" control-label">DNI</label>
							<?php 
								create_input("text","consulta_dni",$cliente["dni"],"form-control",$table,"required ".$disabled." maxlength='8' onkeypress='javascript:return soloNumeros(evt,0);' placeholder='Ingresa DNI del cliente' autocomplete='off'  ",''); 	
								?>
							</div>
							<div class="col-sm-3">		
								<button style="margin-top:25px;">Buscar</button>
							</div>
					</form>
				</div>


<?php  
if( (isset($_POST["consulta_dni"]) && !empty($_POST["consulta_dni"]) ) ||  $_GET["task"]=='edit' ){ 
		// echo $_POST["consulta_dni"];							

		$disabled='';
		if( $_GET["task"]=='edit'){ 
			
			$sql_dni=" id_suscrito=".$usuario["id_suscrito"];
			$disabled='disabled';
			
		}elseif( !empty($_POST["consulta_dni"]) ){		  // si est anew, registro de venta					
			$sql_dni=" dni=".$_POST["consulta_dni"];	
			echo "<script> buscar_dni_reniec_certificado('".$_POST["consulta_dni"]."');</script>";						
		}

		$_sql_cliente="select s.*, esp.titulo as especialidad from suscritos s INNER JOIN especialidades esp ON s.id_especialidad=esp.id_especialidad where ".$sql_dni." ";
		// echo $_sql_cliente;
		$cliente=executesql($_sql_cliente,0);
		
		if( !empty($cliente) ){   // si esta seguimos 

?>

            <!-- form start -->
            <form  action="pedidos_manuales_certificados.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>"   class="form-horizontal" method="POST" enctype="multipart/form-data" autocomplete="OFF" onsubmit="return aceptar()" >
<?php 
if($task_=='edit') create_input("hidden","id_pedido",$usuario["id_pedido"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link2,"",$table,"");
create_input("hidden","tipo_pago",4,"",$table,""); 
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
				 <div class="box-body">
<!-- Data Pedido principal... -->
							<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
									
									<!-- Data suscritos ... -->                  
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                          Datos Cliente
                        </a>
                      </h4>
                    </div>


                    <div id="collapseThree" class="panel-collapse collapse in " role="tabpanel" aria-labelledby="headingThree">
                      <div class="panel-body">


											<div class="form-group">
												<div class="col-sm-12"><h3>Datos del cliente:</h3></div>
												<div class="col-sm-4">																						
													<label for="inputPassword3" class=" control-label">DNI</label>
													<?php 
													create_input("text","dni",$cliente["dni"],"form-control",$table,"required disabled  max-lenght='8' placeholder='Ingresa DNI del cliente' autocomplete='off'  ",''); 	
													?>
												</div>


												
											<?php	if($_SESSION["visualiza"]["idtipo_usu"] != 4 ){ ?> 
														<div class="col-sm-6">
															<label for="inputEmail3" class="col-sm- control-label">USUARIO VENDEDOR ASIGNADO</label>
															<?php crearselect("idusuario","select idusuario,nomusuario   from usuario where estado_idestado=1 and idtipo_usu=4 order by nomusuario asc",'class="form-control" ',$usuario["idusuario"],"-- seleccione vendedor --"); ?>
														</div>
											<?php } ?> 
												
											</div>
											<div class="form-group">					
												<div class="col-sm-5">
														<label for="inputPassword3" class=" control-label">Nombre: </label>
														<?php create_input("text","nombre",$cliente["nombre"].' '.$cliente["ap_pa"].' '.$cliente["ap_ma"],"form-control",$table,"disabled",$agregado); ?>
												</div>
												<div class="col-sm-3">
													<label for="inputPassword3" class=" control-label">Estado</label>
													<?php 
													create_input("text","estado",$cliente["estado"],"form-control",$table,"disabled",$agregado); 
													create_input("hidden","id_suscrito",$cliente["id_suscrito"],"form-control",$table,"",$agregado); 
													?>
												</div>					
											</div>	                											
										              
											<div class="form-group">
												<div class="col-sm-5">
													<label for="inputPassword3" class=" control-label">Especialidad:</label>
													<?php create_input("text","id_especialidad",$cliente["especialidad"],"form-control",$table,"disabled",$agregado); ?>
												</div>
												<div class="col-sm-5">
													<label for="inputPassword3" class=" control-label">Email</label>
													<?php create_input("text","email",$cliente["email"],"form-control",$table,"disabled",$agregado); ?>
												</div>
												<div class="col-sm-2">
													<label for="inputPassword3" class=" control-label">Telèfono</label>
													<?php create_input("text","telefono",$cliente["telefono"],"form-control",$table,"disabled"," "); ?>
												</div>								
											</div>			
											

											<!-- API VALIDACION RENIEC DATOS-->
											<div class="form-group">
												<div class="col-sm-12"><h3>Datos Para Validación Api Reniec* :</h3></div>
												<div class="col-sm-4 ">
													<label for="inputPassword3" class=" control-label">Nombres: </label>
													<?php 
														// create_input("text","api_nombre",$cliente["api_nombre"],"form-control hide" ,$table,"  ",$agregado);
														create_input("text","api_nombre", strtoupper($solicitudes["api_nombre"]) ,"form-control  " ,$table,"   onkeyup='javascript:this.value=this.value.toUpperCase();' ",$agregado);
													?>
													<?php // create_input("text","api_nombre_text",$cliente["api_nombre_text"],"form-control",$table,"disabled",$agregado);  // para mostrar texto solo visible?>
												</div>												
												<div class="col-sm-4 ">
													<label for="inputPassword3" class=" control-label">Ap. paterno: </label>
													<?php create_input("text","api_paterno", strtoupper($solicitudes["api_paterno"]) ,"form-control  ",$table,"  onkeyup='javascript:this.value=this.value.toUpperCase();'",$agregado); ?>
													<?php // create_input("text","api_paterno_text",$cliente["api_paterno_text"],"form-control",$table,"disabled",$agregado); ?>
												</div>												
												<div class="col-sm-4 ">
													<label for="inputPassword3" class=" control-label">Ap. materno: </label>
													<?php create_input("text","api_materno", strtoupper($solicitudes["api_materno"]) ,"form-control   ",$table,"  onkeyup='javascript:this.value=this.value.toUpperCase();'  ",$agregado); ?>
													<?php // create_input("text","api_materno_text",$cliente["api_materno_text"],"form-control",$table,"disabled",$agregado); ?>
												</div>																													
											</div>
											<!-- *END API RENIEC -->


											<!-- * ubigeo -->
											<?php 
											//   OCULTADO PORQE SOLO SERA DIGITAL  -- se vuelve habilitar 
?>

											<div class="form-group">
												<div class="col-sm-10 ">
														<h3>Datos para solicitud de certificados: <small style="color:red;">*obligatorios </small></h3>
												</div>
											</div>

											<div class="form-group">
												<div class="col-sm-4 ">
													<label class="poppi sub texto">Departamento</label>
													<?php crearselect("iddpto","select iddpto, titulo from dptos order by titulo asc",'class="form-control" required onchange="javascript:display(\'pedidos_manuales_certificados.php\',this.value,\'cargar_prov\',\'idprvc\')"',$solicitudes["iddpto"],"Seleccionar"); ?>
												</div>

												<div class="col-sm-4 ">
													<label class="poppi sub texto">Provincia</label>
													<?php if($task_=='edit'){ ?>
														<?php crearselect("idprvc","select idprvc,titulo from prvc WHERE dptos_iddpto='".$solicitudes["iddpto"]."'",'class="form-control"  required onchange="javascript:display(\'pedidos_manuales_certificados.php\',this.value,\'cargar_dist\',\'iddist\')" ',$solicitudes["idprvc"],"Seleccione"); ?>
													
														<?php }else{ ?>    
															
															<select name="idprvc" required id="idprvc" class="form-control" onchange="javascript:display('pedidos_manuales_certificados.php',this.value,'cargar_dist','iddist')"><option value="<?php echo $solicitudes["idprvc"]; ?>" selected="selected">Selecciona</option></select>
													<?php }  ?>       
												</div>

												<div class="col-sm-4 ">
													<label class="poppi sub texto">Distrito</label>												
												<?php if($task_=='edit'){ ?>
													<?php crearselect("iddist","select iddist,titulo from dist WHERE prvc_idprvc='".$solicitudes["idprvc"]."'",'class="form-control" ',$solicitudes["iddist"],"Seleccione"); ?>
												
												<?php }else{ ?>       
														<select name="iddist" id="iddist" required class="form-control"><option value="" selected="selected">Selecciona</option></select>
												<?php } ?> 

											</div>			

											</DIV>

											<div class="form-group">
												<div class="col-sm-4 criterio_buscar">
													<label for="inputPassword3" class=" control-label">Agencia de Envio: (*cliente )</label>
													
													<?php crearselect("id_agencia", "select id_agencia,nombre from agencias where estado_idestado=1 order by nombre asc", 'class="form-control" requerid  onchange="javascript:display(\'pedidos_manuales_certificados.php\',this.value,\'cargar_sucursales\',\'id_sucursal\')"', $solicitudes["id_agencia"], "-- Agencia de envio --"); ?>
												</div>
												
												<div class="col-sm-6 criterio_buscar">	
													<label for="inputPassword3" class=" control-label"> Sucursal </label>

													<?php if($task_=='edit'){  $sql="select id_sucursal, concat(nombre,' - ',direccion) as nombre from agencias_sucursales WHERE id_agencia='".$solicitudes["id_agencia"]."' "; ?>
														<select name="id_sucursal" id="id_sucursal" required class="form-control" >
															<option value="" selected="selected">-- subcateg. --</option>
															<?php 
																	$listaprov=executesql($sql);
																	foreach($listaprov as $data){ ?>
																<option value="<?php echo $data['id_sucursal']; ?>" selected="<?php echo ($data['id_sucursal']==$solicitudes["id_sucursal"])?'selected':'';?>"> <?php echo $data['nombre']?></option>
																	<?php } ?>
														</select>
													
													<?php }else{ ?>
													<select name="id_sucursal" id="id_sucursal"  required class="form-control" ><option value="" selected="selected">-- sucursal. --</option></select>
													<?php } ?>
												</div>
											</div>

											<div class="form-group">
												<div class="col-sm-5">
													<label for="inputPassword3" class=" control-label">Dirección de envio:</label>
													<?php create_input("text","direccion",( ($task_=='edit') ? $solicitudes["direccion"] : "---") ,"form-control",$table,"  required ",$agregado); ?>
												</div>
												<div class="col-sm-5">
													<label for="inputPassword3" class=" control-label">Referencia: (*cliente )</label>
													<?php create_input("text","agencia",( ($task_=='edit') ? $solicitudes["agencia"] : "---") ,"form-control",$table,"   ",$agregado); ?>
												</div>
																		
											</div>		
											<?php // --- **  ?>	
																		
															
                      </div>
                    </div>
                  </div>
									
								
								
								
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Datos Compra Manual: codigo:  <b><?php echo $usuario['id_pedido']; ?></b>
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
												
											<div class="col-sm-6">											
												<div class="form-group">
                          <label for="inputEmail3" class="col-sm-4 control-label">Estado Pagó:</label>
													<div class="col-sm-8">
														<select id="estado_pago" name="estado_pago" class="form-control   "   >  <!-- saco valor desde la BD -->
															<option value="1" <?php echo ($usuario['estado_pago'] == 1) ? 'selected' : '' ;?>>APROBADO</option>
																									
															<option value="2" <?php echo ($usuario['estado_pago'] == 2) ? 'selected' : '' ;?>>Por aprobar</option>
															<option value="3" <?php echo ($usuario['estado_pago'] == 3) ? 'selected' : '' ;?>>Rechazado</option>
														</select>
													</div>
                        </div>
											</div>
											
											<div class="col-sm-6">											
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-4 control-label">Tipo de compra: </label>
														<div class="col-sm-8">
															<label class="control-label" style="font-weight:400;">
															<?php echo 'COMPRA MANUAL';	?>
															</label>
														</div>																										                         
													</div>
											</div>
											
											<div class="col-sm-12">
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">total Total:</label>
                          <div class="col-sm-4 ">
                            <?php create_input("text","total",$usuario["total"],"form-control",$table,' required ',$agregado); ?>
                          </div>
                        </div>
											</div>
											
											<div class="col-sm-12">
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">#Total de certificados:</label>
                          <div class="col-sm-4 ">
                            <?php create_input("text","articulos",$usuario["articulos"],"form-control",$table,' required ',$agregado); ?>
                          </div>
                        </div>
											</div>
										
									
										<div class="col-sm-12 ">											
												<div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Fecha del pago:</label>
                          <div class="col-sm-4">
                          <?php 
													if( $task_ =="edit" ){
															echo $usuario["fecha_pago_off"]; 
													}	else{

														create_input("date","fecha_pago_off",$usuario["fecha_pago_off"],"form-control",$table," required ",$agregado);
													}												
													
													?>
                          </div>
												</div>
										</div>
										<div class="col-sm-12 ">											
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2 control-label">Banco deposito:</label>
												<label class="col-sm-4 ">
													<?php crearselect("banco_pago","select id_banco, nombre from bancos where estado_idestado=1 order by nombre asc ",'class="form-control" required ',$usuario["banco_pago"],""); ?>              
												</label>
											</div>  
										</div>  
												
										<div class="col-sm-12 ">											
												<div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Código referencia:</label>
													<div class="col-sm-4 ">
                          <?php create_input("text","codigo_ope_off",$usuario["codigo_ope_off"],"form-control",$table," required ",$agregado); ?>
														
													</div>																										                         
                        </div>
										</div>

										<div class="col-sm-12 ">											
												<div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Observación:</label>
													<div class="col-sm-4 ">
                          <?php create_input("textarea","observacion",$usuario["observacion"],"form-control",$table,"  ",$agregado); ?>
														
													</div>																										                         
                        </div>
										</div>
												
										                        
                       <div class="form-group">
													<label for="inputPassword3" class="col-sm-2 control-label">Imágen comprobante</label>
													<div class="col-sm-6">
													<?php if( $task_ !="edit" ){ ?>
														<input type="file" name="imagen" id="imagen" required class="form-control">
													<?php } ?>

														<?php create_input("hidden","imagen_ant",$usuario["imagen"],"",$table,$agregado); 
															if($usuario["imagen"]!=""){ 
														?>
														<!-- 
															<img src="<?php echo "files/images/comprobantes/".$usuario["imagen"]; ?>" width="200" class="mgt15">
															-->
															<button type="button" class="abrir_modal_images" data-toggle="modal" data-target="<?php echo '#image_1';  ?>" > 
																<img style="height:50px;width:50px;"  class="img-responsive" src="<?php echo "files/images/comprobantes/".$usuario["imagen"]; ?>">
															</button>
															
														<?php } ?> 
													</div>
												</div>

					<div id="<?php echo 'image_1'; ?>" class="modal  bd-example-modal-lg  modal_images modal_images_practico " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display:none;">
						<div class="modal-dialog modal-lg">
							<div class="modal-content text-center">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLongTitle">Comprobante adjunto: </h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-20px;">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<img src="<?php echo 'files/images/comprobantes/'.$usuario["imagen"]; ?>"  class="img-responsive" style="max-width:600px;margin: auto;">								
								<div class="text-center" style="padding:30px 0 10px;">
									<a href="<?php echo 'files/images/comprobantes/'.$usuario["imagen"]; ?>"  target="_blank" class="btn btn-primary" style="max-width:600px;">	Ver imagen completa [Click aquí]</a>							
								</div>
							</div>
						</div>
					</div>

									<!--  IMAGEN VOUCHER 2 -->									
									<div class="col-sm-12 ">											
												<h4> <b>VOUCHER #2  </b> * <small style="color:red;"><b> </b></small> </h4>										
												<div class="form-group">
													<label for="inputPassword3" class="col-sm-2 control-label">Banco deposito:</label>
													<label class="col-sm-4 ">
														<?php crearselect("banco_pago_2","select id_banco, nombre from bancos where estado_idestado=1 order by nombre asc ",'class="form-control" required ',$usuario["banco_pago_2"],""); ?>              
													</label>
												</div>  
											</div>  
											
											<div class="col-sm-12">
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label"> s/ Total del voucher:</label>
                          <div class="col-sm-4 ">
                            <?php create_input("text","total_voucher_2",$usuario["total_voucher_2"],"form-control",$table,"   onkeypress='javascript:return soloNumeros_precio(event,2);' ",$agregado); ?>
                          </div>
                        </div>
											</div>

											<div class="col-sm-12 ">											
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-2 control-label">Código referencia:</label>
														<div class="col-sm-4 ">
														<?php create_input("text","codigo_ope_off_2",$usuario["codigo_ope_off_2"],"form-control",$table,"   ",$agregado); ?>
															
														</div>																										                         
													</div>
											</div>
                        
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2 control-label">Imágen comprobante #2</label>
												<div class="col-sm-6">
													<input type="file" name="imagen_2" id="imagen_2"   class="form-control">
													<?php create_input("hidden","imagen_ant_2",$usuario["imagen_2"],"",$table,$agregado); 
														if($usuario["imagen_2"]!=""){ 
													?>
													<!-- 
														<img src="<?php echo "files/images/comprobantes/".$usuario["imagen_2"]; ?>" width="200" class="mgt15">
														-->
														<button type="button" class="abrir_modal_images" data-toggle="modal" data-target="<?php echo '#image_2';  ?>" > 
															<img style="height:50px;width:50px;"  class="img-responsive" src="<?php echo "files/images/comprobantes/".$usuario["imagen_2"]; ?>">
														</button>
														
													<?php } ?> 
												</div>
											</div>

											<div id="<?php echo 'image_2'; ?>" class="modal  bd-example-modal-lg  modal_images modal_images_practico " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display:none;">
													<div class="modal-dialog modal-lg">
														<div class="modal-content text-center">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLongTitle">Comprobante adjunto: </h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-20px;">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<img src="<?php echo 'files/images/comprobantes/'.$usuario["imagen_2"]; ?>"  class="img-responsive" style="max-width:600px;margin: auto;">								
															<div class="text-center" style="padding:30px 0 10px;">
																<a href="<?php echo 'files/images/comprobantes/'.$usuario["imagen_2"]; ?>"  target="_blank" class="btn btn-primary" style="max-width:600px;">	Ver imagen completa [Click aquí]</a>							
															</div>
														</div>
													</div>
											</div>
											<!-- ** end 2DO data de voucher -->		

									<!--  IMAGEN VOUCHER 3 -->									
											<div class="col-sm-12 ">											
												<h4> <b>VOUCHER #3  </b> * <small style="color:red;"><b> </b></small> </h4>										
												<div class="form-group">
													<label for="inputPassword3" class="col-sm-2 control-label">Banco deposito:</label>
													<label class="col-sm-4 ">
														<?php crearselect("banco_pago_3","select id_banco, nombre from bancos where estado_idestado=1 order by nombre asc ",'class="form-control" required ',$usuario["banco_pago_3"],""); ?>              
													</label>
												</div>  
											</div>  
											
											<div class="col-sm-12">
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label"> s/ Total del voucher:</label>
                          <div class="col-sm-4 ">
                            <?php create_input("text","total_voucher_3",$usuario["total_voucher_3"],"form-control",$table,"   onkeypress='javascript:return soloNumeros_precio(event,2);' ",$agregado); ?>
                          </div>
                        </div>
											</div>


											<div class="col-sm-12 ">											
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-2 control-label">Código referencia:</label>
														<div class="col-sm-4 ">
														<?php create_input("text","codigo_ope_off_3",$usuario["codigo_ope_off_3"],"form-control",$table,"   ",$agregado); ?>
															
														</div>																										                         
													</div>
											</div>
                        
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2 control-label">Imágen comprobante #3 </label>
												<div class="col-sm-6">
													<input type="file" name="imagen_3" id="imagen_3"   class="form-control">
													<?php create_input("hidden","imagen_ant_2",$usuario["imagen_3"],"",$table,$agregado); 
														if($usuario["imagen_3"]!=""){ 
													?>
													<!-- 
														<img src="<?php echo "files/images/comprobantes/".$usuario["imagen_3"]; ?>" width="200" class="mgt15">
														-->
														<button type="button" class="abrir_modal_images" data-toggle="modal" data-target="<?php echo '#image_3';  ?>" > 
															<img style="height:50px;width:50px;"  class="img-responsive" src="<?php echo "files/images/comprobantes/".$usuario["imagen_3"]; ?>">
														</button>
														
													<?php } ?> 
												</div>
											</div>

											<div id="<?php echo 'image_3'; ?>" class="modal  bd-example-modal-lg  modal_images modal_images_practico " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display:none;">
													<div class="modal-dialog modal-lg">
														<div class="modal-content text-center">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLongTitle">Comprobante adjunto: </h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-20px;">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<img src="<?php echo 'files/images/comprobantes/'.$usuario["imagen_3"]; ?>"  class="img-responsive" style="max-width:600px;margin: auto;">								
															<div class="text-center" style="padding:30px 0 10px;">
																<a href="<?php echo 'files/images/comprobantes/'.$usuario["imagen_3"]; ?>"  target="_blank" class="btn btn-primary" style="max-width:600px;">	Ver imagen completa [Click aquí]</a>							
															</div>
														</div>
													</div>
											</div>
											<!-- ** end 3 ER data de voucher -->		

												

	
			
												
                      </div>
                    </div>
                  </div>
<!-- Data detalle pedido... -->                  
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                          Detalle Compra
                        </a>
                      </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                      <div class="panel-body">
															
									<div class="form-group">
										<?php 
										$sql_mis_cursos=	"select c.titulo as titulo_curso ,  c.id_curso,CONCAT(c.codigo,' - ',c.titulo) as curso, cat.id_cat,cat.titulo as categ, c.modalidad , c.id_tipo_curso
										from suscritos_x_cursos  sxc 
										INNER JOIN cursos c ON sxc.id_curso=c.id_curso 																 
										LEFT JOIN categoria_subcate_cursos csub ON csub.id_curso= c.id_curso   
										LEFT JOIN categorias cat ON cat.id_cat= csub.id_cat  
										where sxc.estado_idestado=1 and sxc.estado=1 and sxc.id_suscrito='".$cliente["id_suscrito"]."' ";

										$cursos_comprados=executesql($sql_mis_cursos); ?>

												
										<label for="inputEmail3" class="col-sm-4 control-label" style="float:none;text-align:left;">Selecciona los certificados a comprar:</label>
										<label for="inputEmail3" class="col-sm-12 control-label" style="float:none;text-align:left;"></br> <small>Mantener presionada la tecla "ctrl" para seleccionar varias cursos, esto dandoles click en el nombre del curso</small> </br></br></label>
										
										<div class="col-sm-6  ">
											<?php 
												// $sql= "SELECT cer.id_certificado, c.id_curso,CONCAT(c.codigo,' - ',c.titulo, ' :: Cert:',cer.id_certificado, '-',cer.titulo) as curso, cat.id_cat,cat.titulo as categ,
												
												$sql= "SELECT cer.id_certificado, c.id_curso,CONCAT(c.codigo,' - ',c.titulo) as curso, cat.id_cat,cat.titulo as categ, c.modalidad , c.id_tipo_curso 
												FROM certificados_x_cursos cerxc
													INNER JOIN certificados cer ON cerxc.id_certificado= cer.id_certificado 
													INNER JOIN suscritos_x_cursos sxc ON cerxc.id_curso=sxc.id_curso 
													LEFT JOIN cursos c ON cer.id_curso= c.id_curso 
													LEFT JOIN categoria_subcate_cursos csub ON csub.id_curso= c.id_curso 
													LEFT JOIN categorias cat ON cat.id_cat= csub.id_cat 
													WHERE sxc.id_suscrito='".$cliente["id_suscrito"]."' and cer.estado_idestado=1 
													GROUP by cer.id_certificado , cat.id_cat 
													ORDER BY c.id_curso desc 
												";																
													// group by ,

													// echo $sql;
												
												$certificados_x_cursos = executesql($sql);
												if( !empty($certificados_x_cursos)  ){   ?>
									
											<select	lect name="subcategorias[]" multiple="multiple"   class="form-control" required size="30">
									<?php 
													$grp1   = $grp2 = array();
													
													foreach($certificados_x_cursos as $row) $grp1[$row['categ']][$row['id_curso'].'_'.$row['id_certificado']] = $row['curso']; $modalidad=$row['id_tipo_curso'];
													
													$sql_linea_compra="SELECT * FROM linea_pedido WHERE id_pedido='".$usuario["id_pedido"]."'";
													// echo $sql_linea_compra;
													$curso_comprado = executesql($sql_linea_compra);
													foreach($curso_comprado as $row) $grp2[] = $row['id_curso'];
													foreach($grp1 as $label => $opt){
												?>
													<optgroup label="<?php echo $label; ?>">
												<?php	
														
														foreach($grp1[$label] as $id => $name){
															if(!empty($name)){
																//echo $id;
																$id_curso_listado=explode('_',$id); // id_curso_id_certificado :: [0]=id_curso ; [1] = id_certificado
																$selected = in_array( $id_curso_listado[0],$grp2) ? ' selected="selected"' : '';
												?>
															<option value="<?php echo $id; ?>"  style="<?php  // echo ($modalidad==1)?'background:green;color:#fff;padding:5px 3px;':'';?>" <?php echo $selected; ?>> 
																	<?php echo $name; ?>
															</option>
											<?php			 }
														} // end for 
												?>
													</optgroup>
								<?php 
													} // end for grp1 
								?>
											</select>	

								<?php 
										}else{
													echo "<p style='color:red;'>No hay certificado disponibles para sus cursos adquiridos. </p>";
										} // end if s existe certifiado para sus cursos 
								?>
									</div> <!--  end 6 -->
									

													<!--  muestro listado de cursos comprados  -->
													<div class="col-sm-6">
														<?php if( !empty($cursos_comprados) ){ ?> 
															<label for="inputEmail3" class="col-sm-4 control-label" style="float:none;text-align:left;color:blue;">Cursos adquiridos: <?php echo count($cursos_comprados); ?> </label>
															<select	  name="cursos_comprados[]" multiple="multiple"  disabled class="form-control" required size="30">
															<?php 
																$grp1   = $grp2 = array();
																	
																foreach($cursos_comprados as $row) $grp1[$row['categ']][$row['id_curso'].'_'.$row['id_certificado']] = $row['curso']; $modalidad=$row['id_tipo_curso'];
														
																foreach($grp1 as $label => $opt){
															
															?> 
																<optgroup label="<?php echo $label; ?>">

																<?php
																	foreach($grp1[$label] as $id => $name){
																		if(!empty($name)){
																?>
																			<option value="<?php echo $id; ?>"  > 
																					<?php echo $name; ?>
																			</option>
												<?php			 	}
																	} // end for 
												?>
																	
																</optgroup>	
												<?php 
																} // end for grp1 
												?>															
															</select>
														<?php  }else{  ?>
															<label for="inputEmail3" class="col-sm-4 control-label" style="float:none;text-align:left;color:blue;">No tienes cursos comprados activos  </label>
														<?php  } ?>
													</div>

												</div>

							
						<!-- ### Para vender Certificados sin  validacion alguna, asi no compro el curso se le puede vender.  -->							       								
						<div class="form-group" style="  padding-left:40px;" >
							<label for="inputEmail3" class="col-sm-4 control-label" style="float:none;text-align:left;font-size:20px;padding:30px 0 0px;">Selecciona los Certificados extras a vender:</label>
							<label for="inputEmail3" class="col-sm-12 control-label" style="float:none;text-align:left;padding:0 0 30px;"> <small>Escribe el codigo o nombre del certificado extra a vender y selecciona con un click</small> </br></label>							
																
							<div class="form-group" style="   " >
								<div class="col-sm-10 ">
									<label for="inputPassword3" class=" control-label">Buscar certificado:</label>
									<?php create_input("text","certificado_a_buscar",$data_producto["certificado_a_buscar"],"form-control",$table," autocomplete='off' onkeyup='autocompletar_certificado_venta()' ",''); ?>
									<ul id="listadobusqueda_certificados_a_vender" class="no-bullet"></ul>
								</div>
							</div>

							<div class="form-group data_dependientes" style="   ">	
								<div class="col-sm-12 " style="background: #ddd;padding: 5px 10px 10px;border-radius: 6px;">
									<div class="col-sm-3">
										<label for="inputPassword3" class=" control-label">Tipo:</label>                                 
                              			<input name="array_certificados_a_vender[]" id="array_certificados_a_vender" type="hidden">		
									</div>					
									<div class="col-sm-7">
										<label for="inputPassword3" class=" control-label">Certificado extra: </label>
									</div>
								</div>															
								<div id="cakes"  class="form-group resultados" style="	margin-bottom:0;"> <!-- sale data desde js .. -->  	</div>
														                        
						                            
							</div> <!-- *contenedor general listado dependientes -->
						</div> <!--  ** end colapse de ventas -->
						<!-- ### END vender certificado extra -->
				
		
						

<?php 
if($_GET["task"]=='edit' ){ 
$detallepro=executesql("select  sxc.*  from pedidos p
									INNER JOIN suscritos_x_certificados sxc ON p.id_pedido = sxc.id_pedido 
									WHERE p.id_pedido='".$_GET["id_pedido"]."' ");
									?>                        
                        <table  class="table table-bordered table-striped">
                          <thead>
                            <tr role="row">
                              <th class="sort cnone" width="50">Tipo</th>
                              <th class="sort cnone" width="50">Codigo</th>
                              <th class="sort ">Producto</th>
                              <th class="sort ">N°</th>
                              <th class="sort cnone">Precio</th>
                              <th class="sort cnone">Subtotal</th>
                              <th class="sort cnone">ESTADO</th>
                            </tr>
                          </thead>
                          <tbody id="sort">
            <?php foreach($detallepro as $rowdetalle){ ?>
                            <tr id="order_<?php echo $rowdetalle["id_linea"]; ?>">
                              <td ><?php
																	//  echo ($rowdetalle["talla"]=='9999')?'Certificado': '-- '; 
																	echo "Certificado";
															?></td>
                              <td ><?php echo $rowdetalle["id_certificado"]; ?></td>  <!--  ID CERTIFICADO -->
                              <td >
																	<?php $certificadox= executesql("select * from certificados where id_certificado='".$rowdetalle["id_certificado"]."' ");
																		echo $certificadox[0]["titulo"];
																	 ?>
															</td>
                              <td  ><?php   echo 1; // echo $rowdetalle["cantidad"]; ?></td>
                              <td class="cnone">S/ <?php echo $rowdetalle["precio"]; ?></td>
                              <td class="cnone"> S/<?php echo $rowdetalle["precio"]; ?></td>
                              <td class="cnone"> 
																<?php 
																	if( $rowdetalle["estado_entrega"] == 1 ){ 
																		echo  "ENTREGADO";
																	}else if( $rowdetalle["estado_entrega"] == 2 ){ 
																		echo "ENVIO PENDIENTE";
																	}else{
																		echo "-- ";
																	
																	}
																?>
															</td>
                            </tr>
            <?php } ?>
                          </tbody>
                        </table>
<?php } ?>
                       
                      </div>
                    </div>
                  </div>
                


                </div>

              </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 text-center">
									<?php if($_GET['task'] !='edit' ){ ?>
										 <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="GUARDAR">

									<?php } ?>
									
									<div class="col-sm-12 " style="padding-top:25px;" >											
										<div class="form-group">
											<label for="inputEmail3" class="col-sm-3 control-label">Motivo porque anula: *requerido</label>
											<div class="col-sm-9 ">
												<?php create_input("textarea","comentario",$usuario["comentario"],"form-control",$table,"  ",$agregado); ?>
												
											</div>																										                         
										</div>
									</div>
									
									<?php if($usuario['estado_pago'] != 3 && $task_=='edit' ){  ?>   
										<input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="ACTUALIZAR DATOS">
										<a href="javascript: fn_estado_rechazar_pago_certificado('<?php echo $usuario["id_pedido"]; ?>')" class="btn bg-red btn-flat">Rechazar</a>
									<?php } ?>
										
										<button type="button" class="btn bg- btn-flat" onclick="javascript:gotourl('<?php echo $link2; ?>');">CERRAR</button>

                  </div>
                </div>
              </div>

<script>
function aceptar(){
	var nam1=document.getElementById("total").value;	
	var nam2=document.getElementById("id_suscrito").value;	
	var nam3=document.getElementById("dni").value;	
	var fecha_pago_off=document.getElementById("fecha_pago_off").value;	
	var articulos=document.getElementById("articulos").value;	
	var banco_pago=document.getElementById("banco_pago").value;	
	var codigo_ope_off=document.getElementById("codigo_ope_off").value;	
	
	if(nam1 !='' && nam2 !='' && nam2 >0 && nam3 !='' && articulos !='' && fecha_pago_off !='' && banco_pago !=''  && codigo_ope_off !=''  && cursos !='' ){									
		alert("Asignando  .. Aceptar y espere unos segundos ..");							
		document.getElementById("btnguardar").disabled=true;	
		
	}else{		
		alert("Recomendación: Completa todos los datos, para finalizar! )");
		return false; //el formulario no se envia		
	}
	
}				
</script>								
							
							
            </form>

	<?php  
		}else{  // sino existe el cliente ?>
			<div class="form-group">
				<div class="col-sm-10 ">		
					<h3 style="color:red;padding-top:30px;"> DNI NO ENCONTRADO, CONSULTA TU REPORTE DE CLIENTES</h3>
				</div>
			</div>

<?php 
		}  // end sino existe cliwetne  
	} // end si GET== consulta_dni o edit?>

          </div><!-- /.box -->
        </div><!--/.col (right) -->
  </div>
	<script type="text/javascript" src="js/buscar-autocompletado.js?ud=<?php echo $unix_date; ?>"></script>

<script>
var link = "pedidos_manuales_certificado";/*la s final se agrega en js fuctions*/
var us = "pedido";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "id_pedido";
var mypage = "pedidos_manuales_certificados.php";
</script>



</section>
<!-- /.content -->

<?php
// Aprobamos pago
}elseif($_GET["task"]=='uestado_pago'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_pedido']) ? $_GET['id_pedido'] : $_GET['id_pedido'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $usuario = executesql("SELECT * FROM pedidos WHERE id_pedido IN (".$ide.")"); //
  if(!empty($usuario))
  foreach($usuario as $reg => $item)
	if( $item['estado_pago']==2 || $item['estado_pago']==3){
    $state = 1;
		// actualizando confirmando el pago: Pago Ok! 
		// asignamos cursos al alumno automaticamente: 
		if( !empty($_GET['id_pedido'] ) && $_GET['id_pedido'] > 0 ){ // si existe id_pedido hacemos el recorrido 
			$bd=new BD;  
			$sql_p='select ide, estado from suscritos_x_certificados  where  id_pedido="'.$_GET["id_pedido"].'" ';
			$linea_pedido=executesql($sql_p);
			if(!empty($linea_pedido) ){ 
				foreach($linea_pedido as $data ){
						//asignamos
						$_POST['estado'] = 1;
						$campos=array('estado');
						$bd->actualiza_(armaupdate('suscritos_x_certificados',$campos," id_pedido='".$_GET["id_pedido"]."'",'POST'));/*actualizo*/
			
				} // for
			} // if
			
		} // si exite id_pedido
  } // elseif 
  $num_afect=$bd->actualiza_("UPDATE pedidos SET estado_pago=".$state." WHERE id_pedido=".$ide."");
  echo $state;
  // echo $sql_p;	
  $bd->Commit();
  $bd->close();


// rechazamos pago
}elseif($_GET["task"]=='uestado_pago_rechazar_certificado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_pedido']) ? $_GET['id_pedido'] : $_GET['id_pedido'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;

  $usuario = executesql("SELECT * FROM pedidos WHERE id_pedido IN (".$ide.")"); //
  if(!empty($usuario) && !empty($_GET['comentario']) ){   // comentario motivo de rechazo obligatorio 

				foreach($usuario as $reg => $item){
					if ($item['estado_pago']==1 || $item['estado_pago']==2){
						$state = 3;
						// actualizando Rechazando la compra 
						// deshabilitamos estados de cursos asignados 
						if( !empty($_GET['id_pedido'] ) && $_GET['id_pedido'] > 0 ){ // si existe id_pedido hacemos el recorrido 
							$bd=new BD;  									

						} // si exite id_pedido
					} // elseif 
				} // end for 


				/*  suscritos_x_certificados  */
				$sql_cer='select ide, estado from suscritos_x_certificados  where  id_pedido="'.$_GET["id_pedido"].'" ';
				$certi=executesql($sql_cer);
				if(!empty($certi) ){ 
					foreach($certi as $data ){
							//asignamos
							$_POST['estado'] = 3;
							$campos=array('estado');
							$bd->actualiza_(armaupdate('suscritos_x_certificados',$campos," id_pedido='".$_GET["id_pedido"]."'",'POST'));/*actualizo*/
				
					} // for
				} // if


				/*  si tiene solicitudes   */
				$sql_p='select ide, estado from solicitudes  where  id_pedido="'.$_GET["id_pedido"].'" ';
				$linea_pedido=executesql($sql_p);
				if(!empty($linea_pedido) ){ 
					foreach($linea_pedido as $data ){
							//asignamos
							$_POST['estado'] = 3;  // rechazados 
							$campos=array('estado');
							$bd->actualiza_(armaupdate('solicitudes',$campos," id_pedido='".$_GET["id_pedido"]."'",'POST'));/*actualizo*/
				
					} // for
				} // if


				$_POST['estado_idestado']=3;
				$campo_vouchers=array('estado_idestado');
				$bd->actualiza_(armaupdate('vouchers',$campo_vouchers," id_pedido='".$_GET["id_pedido"]."'",'POST'));/*actualizo*/
				
				$num_afect=$bd->actualiza_("UPDATE pedidos SET estado_pago=".$state." WHERE id_pedido=".$ide."");
				echo $state;
			// echo $sql_p;	
				$bd->Commit();
				$bd->close();

	}else{   // si no puso comentario
			echo "sin_motivo_rechazo";
	}	 // end if si existe pedido 



}elseif($_GET["task"]=='finder'){
  $array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
  $sql= "SELECT pp.*,YEAR(pp.fecha_registro) as anho, MONTH(pp.fecha_registro) as mes, e.nombre AS estado ,s.email as email,  CONCAT(s.nombre,' ',s.ap_pa,' ',s.ap_ma )as suscritos, u.nomusuario as usuariox, ban.nombre as banco, s.dni, s.telefono  
	FROM pedidos pp 
  INNER JOIN estado e ON pp.estado_idestado=e.idestado 
  INNER JOIN suscritos s ON pp.id_suscrito=s.id_suscrito 
  LEFT JOIN usuario u ON pp.idusuario=u.idusuario  
  LEFT JOIN bancos ban ON pp.banco_pago=ban.id_banco   
	WHERE pp.tipo_pago='".$_GET["tipo_pago"]."' and pp.categoria_venta=2  ";   // catgoria de venta 2:: venta mahual de certificado 
  
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND ( s.nombre LIKE '%".$stringlike."%' or s.email LIKE '%".$stringlike."%'  or s.dni LIKE '%".$stringlike."%'  or s.telefono LIKE '%".$stringlike."%'   or pp.id_pedido LIKE '%".$stringlike."%' or pp.codigo LIKE '%".$stringlike."%' or pp.codreferencia LIKE '%".$stringlike."%' or pp.codigo_ope_off LIKE '%".$stringlike."%'  or pp.codigo_ope_off_2 LIKE '%".$stringlike."%' or pp.codigo_ope_off_3 LIKE '%".$stringlike."%' )"; 
  }else{
		if( empty($_GET['fechabus_1']) && empty($_GET['fechabus_2']) ) {
			$sql .= " AND DATE(pp.fecha_registro) = '" . fecha_hora(1) . "'";
		}
		
	}
	
	if( $_SESSION["visualiza"]["idtipo_usu"] ==4 ){  /* filtro solo ventas del vendedor : */
			$sql .= " AND pp.idusuario = '".$_SESSION["visualiza"]["idusuario"]."'";
	}

	if(!empty($_GET['estado_pago']) ){
			$sql .= " AND pp.estado_pago = '".$_GET['estado_pago']."'";
	}


		if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
			$sql .= " AND DATE(pp.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
	}

	
	if(isset($_SESSION['pagina2'])) {
			$_GET['pagina'] = $_SESSION['pagina2'];
	}
	
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
 $sql.= " ORDER BY pp.id_pedido DESC";
 // echo  $sql; 
 
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar=array("criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");
  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(1000);
  $paging->ejecutar();
  $paging->pagina_proceso="pedidos_manuales_certificados.php";
?>
  <table id="example1" class="table table-bordered table-striped">
    <tbody id="sort">
              
<?php 
		while ($detalles = $paging->fetchResultado()): 
			if(!in_array(array('mes' => $detalles['mes'], 'anho' => $detalles['anho']), $array)){
				$array[] = array('mes' => $detalles['mes'], 'anho' => $detalles['anho']);
?>
				<tr class="lleva-mes">
					<td colspan="9"><h6><?php echo strtoupper(strtr(date('M Y',strtotime($detalles['fecha_registro'])),$meses)); ?></h6></td>
				</tr>
				<tr role="row">
					<th width="30">Día</th>
          <th class="sort " >Cod  </th>
          <th class="sort cnone" >Cliente</th>
          <th class="sort cnone" >TEL</th>
          <th class="sort cnone">E-mail</th>
          <th class="sort cnone  "  width="100">Cod transac</th>
          <th class="sort cnone "  width="100">BANCO</th>
          <th class="sort cnone "  width="100">Fecha voucher</th>
          <th class="sort cnone"  width="95"> IMG </th>
          <th class="sort cnone"  width="95">PAGÓ?</th>
          <th class="sort ">Total</th>
          <th class="sort cnone" width="60">#cursos</th>
          <th class="sort cnone" width="100">USUARIO</th>
					<!-- 
					-->
          <th class="unafbe" width="70">Ver</th>
        </tr>
<?php }//if meses 

if( $detalles["estado_pago"] == 2){ // por revisar 
	$fondo_entregar ="background:#F0A105; color:#fff !important; ";
}elseif( $detalles["estado_pago"] == 1){  // aprobado
	$fondo_entregar ='';
}elseif( $detalles["estado_pago"] == 3){ // rechazado 
	$fondo_entregar ='background:rgba(255,0,0,0.6); color:#fff !important;';
}
?>        
       <tr >
        <td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>
        <td >	
					<span style="<?php echo $fondo_entregar; ?> border-radius:50%;height:12px;width:12px;position: absolute;"></span> 
					<span style="padding-left:20px;"><b><?php echo $detalles["id_pedido"]; ?></b></span> 


				</td>  
				<td class="cnone"><?php echo $detalles["dni"]; ?> - <?php echo $detalles["suscritos"]; ?></td>        
        <td class="cnone"><?php echo $detalles["telefono"]; ?></td>         
        <td class="cnone"><?php echo $detalles["email"]; ?></td>        
			     
        <td class=" cnone " ><?php 
					if(!empty($detalles["codreferencia"])){
						echo $detalles["codreferencia"];
						
					}else{ //codigo del pago off-line -transccion
						echo 'off-'.$detalles["codigo_ope_off"];
						
					}
				
				?></td>        
				<td class=" cnone " >        
					<span style="padding-left:20px;"><?php echo $detalles["banco"]; ?></span> 
				</td>   
				<td class="cnone"><?php echo $detalles["fecha_pago_off"]; ?></td>        
				
				<td class="cnone">
				
					<?php if($detalles["imagen"]!=""){  ?>													
						<button type="button" class="abrir_modal_images" data-toggle="modal" data-target="#img_<?php echo $detalles["id_pedido"];  ?>" > 
							<img style="height:50px;width:50px;"  class="img-responsive" src="<?php echo "files/images/comprobantes/".$detalles["imagen"]; ?>">
						</button>						
					<?php } ?> 
										
						<div id="img_<?php echo $detalles["id_pedido"];  ?>" class="modal  bd-example-modal-lg  modal_images modal_images_practico " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display:none;">
								<div class="modal-dialog modal-lg">
									<div class="modal-content text-center">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLongTitle">Comprobante adjunto: </h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-20px;">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<img src="<?php echo 'files/images/comprobantes/'.$detalles["imagen"]; ?>"  class="img-responsive img_flota "  style="max-width:600px;margin: auto;">								
										<div class="text-center" style="padding:30px 0 10px;">
											<a href="<?php echo 'files/images/comprobantes/'.$detalles["imagen"]; ?>"  target="_blank" class="btn btn-primary" style="max-width:600px;">	Ver imagen completa [Click aquí]</a>							
										</div>
									</div>
								</div>
						</div>

				</td>


				<td class="cnone">
					<a  style="color:#333;font-weight:800;">
						<?php if($detalles["estado_pago"]==2){ echo "Por verificar";
						}elseif($detalles["estado_pago"]==1){ echo "Aprobado";  
						}elseif($detalles["estado_pago"]==3){
							 echo "<span style='color:red;'>Rechazado </span>";
							 $rechazo=executesql("select * from usuario where idusuario='".$detalles["usuario_modifico"]."' ");
							 echo '<span>'.$rechazo[0]['nomusuario'].' - </br>'.$detalles["fecha_modificacion"]. ' </span>'; 

						}else{ echo "#no fount."; 
						} ?>
					</a>
				</td>
        <td > S/<?php echo $detalles["total"]; ?></td>
        <td class="cnone"> <?php echo $detalles["articulos"]; ?></td>
        <td class="cnone"> <?php echo $detalles["usuariox"]; ?>
						</br>
						<span style="border-top:1px solid #000;display:block;" ></span>
						<small><?php echo ($detalles["tipo_venta"] == 1 )?'PROPIA': $detalles["compartido_con"]; ?></small>
				</td>
        <!-- 
				<td class="cnone"><a href="javascript: fn_estado_pedido('<?php echo $detalles["id_pedido"]; ?>')"  style="color:#fff;font-weight:800;">
                <?php if($detalles["estado_entrega"]==2){ echo "Por entregar"; }elseif($detalles["estado_entrega"]==3){ echo "En camino"; }else{ echo "Entregado";} ?></a>
				</td>
				-->
        <td>
          <div class="btn-eai btr text-center" style="width:70px;">
            <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_pedido='.$detalles["id_pedido"]; ?>" style="color:#fff;"><i class="fa fa-eye"></i> ver</a>
           
          </div>
        </td>
      </tr>
<?php
	// $line=executesql("SELECT c.titulo, c.codigo FROM linea_pedido lp INNER JOIN cursos c ON lp.id_curso = c.id_curso WHERE lp.id_pedido = '".$detalles['id_pedido']."' ORDER BY lp.orden DESC");
	$line=executesql("SELECT c.titulo as titulo_curso, cer.id_certificado, cer.titulo as titulo_certificado,  c.codigo FROM suscritos_x_certificados lp INNER JOIN certificados cer ON lp.id_certificado=cer.id_certificado  INNER JOIN cursos c ON lp.id_curso = c.id_curso WHERE lp.id_pedido = '".$detalles['id_pedido']."' ORDER BY lp.ide DESC");
	if(!empty($line)){ 
		
		$n_solicitudes=executesql(" select * from solicitudes where  id_pedido='".$detalles["id_pedido"]."'" );  // calculo cuantas solkcitudes se generaron 

		foreach($line as $linea){
?>
	<tr>
		<td></td>
		<td><b>Cod. </b><?php echo $linea['codigo'] ?></td>
		<td><b> </b><?php echo $linea['titulo_curso'] ?></td>
		<td> <b> Certificado: </b> </td>
		<td>  <?php echo '<b>Cod: '.$linea["id_certificado"].' </b>  - '. $linea["titulo_certificado"]; ?></td>
		<td> <b> #certificad: </b></td>
		<td> <?php echo count($n_solicitudes); ?></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
<?php } }



		endwhile; ?>
    </tbody>
  </table>
  <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  // reordenar('pedidos_manuales_certificados.php');
  // checked();
  // sorter();
});
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <div class="bg-gray-light">
									<div class="col-sm-1 ">
										<div class="btn-eai">
											<a href="<?php echo $link2."&task=new"; ?>" title="Agregar" style="color:#fff;"> Agregar</a> 
										</div>
									</div>
				
								<?php 
								/*  tipo_pago:::4			 => compra manual */ 		
								$_GET["tipo_pago"]=4; 
								create_input('hidden','tipo_pago',$_GET["tipo_pago"],"form-control pull-right",$table,$agregados);
								?>
                <div class="col-sm-2 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
                </div>
								<div class="col-sm-2 criterio_buscar">
										<select name="estado_pago" id="estado_pago" class="form-control" >
												<option value="" >ver todo</option>
												<option value="1" >Aprobados</option>
												<option value="2" >Pendientes</option>
												<option value="3" >Rechazados</option>
										</select>
								</div>
								<div class="col-sm-7 criterio_mostrar">
									<div class="lleva_flechas" style="position:relative;">
										<label>Desde:</label>
										<?php create_input('date', 'fechabus_1', '', "form-control pull-right", $table, ''); ?>
									</div>
									<div class="lleva_flechas" style="position:relative;">
										<label>Hasta:</label>
										<?php create_input('date', 'fechabus_2', '', "form-control pull-right", $table, ''); ?>
									</div>
										<button>Buscar</button>
								</div>  
								<button style="color:#fff;margin-top:15px;">
									<a href="index.php?page=reportes_voucher&module=Buscar%20Vouchers&parenttab=Reportes" target="_blank" style="color:#fff;margin-top:15px;">
										Consultar voucher aquí
									</a>
								</button>
								
              
              </div>
            </form>
            <div class="row">
              <div class="col-sm-12">
                <div id="div_listar"></div>
                <div id="div_oculto" style="display: none;"></div>
              </div>
            </div>
            </div>
        </div>



<script>
var link = "pedidos_manuales_certificado"; /*la s final se agrega en js fuctions*/
var us = "compra manual";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e"; /* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "id_pedido";
var mypage = "pedidos_manuales_certificados.php";
</script>
<?php } ?>