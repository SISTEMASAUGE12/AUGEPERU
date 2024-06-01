<?php   // proceso de insercion y recorrido de lina de pedido
// aqui se crean las solicitudes, las linea de pedidos y los certificados x clientes .


/* enviar los datos ::: id_certificado, id_curso, talla;  salen de la pagina desde donde se hace la inclusion a este archivo::: ejemplo: pedido_manuales_certificados 
 $_POST["id_certificado"] = $division[1];
$_POST["id_curso"] = $division[0]; // id del curso vinculado con el certificado

talla: 	$_POST['talla']='9999'; // certificado venta normal y 9998:: para certificado desde venta extra 
*/

										// $_POST['orden'] = _orden_noticia("","linea_pedido","");
										$_POST['orden'] = 1;
										$_POST['cantidad']=  1;
										$_POST['dependiente'] = 2; // por defecto que no son dependientes 
										$_POST['especialidades'] = 2; // por defecto que no son especiales 																				
										
										$data_curso=executesql("select * from certificados where id_certificado='".$_POST["id_certificado"]."' ",0);
										// $_POST['id_tipo']=  $data_curso['id_tipo']; /* si es libro o curso, etc */	
										$_POST['id_curso_del_certificado']=  $data_curso['id_curso']; /* si es libro o curso, etc */											
										$_POST['id_tipo']= '9999'; /* si es libro o curso, etc */	

										/* Infusion */
										$tag_id_campana_shop=$data_curso['tag']; ;	/* cod.curso 555 - */
										/* Infusion */


										$precio_linea=(  $data_curso['costo_promo'] >0  )?$data_curso['costo_promo']: $data_curso['precio'];
										$_POST['precio']=$_POST['subtotal']=  $precio_linea;									
										$campos_detalle=array('id_pedido','id_curso','cantidad','precio','subtotal','talla','fecha_registro','orden','estado_idestado'); 
										
										/** REGISTRAMOS LA SOLICITUD  */						
										$_POST["tipo"]=1;
										$_POST["estado"]=2; // pendinete 
										$_POST["nombre"]=strtoupper($nclient[0]["nombre"]);
										$_POST["email"]=$nclient[0]["email"];
										$_POST["telefono"]=$nclient[0]["telefono"];
										$_POST["ap_pa"]=  strtoupper($nclient[0]["ap_pa"]);
										$_POST["ap_ma"]= strtoupper($nclient[0]["ap_ma"]) ;
										$_POST["dni"]=strtoupper($nclient[0]["dni"]);
										
										$_POST["api_nombre"]=strtoupper($_POST["api_nombre"]);
										$_POST["api_paterno"]=strtoupper($_POST["api_paterno"]);
										$_POST["api_materno"]=strtoupper($_POST["api_materno"]);
										$_POST["estado_api"]=2;

										// $campos_solicitudes=array('tipo','id_certificado','id_pedido','id_curso','id_suscrito','nombre','ap_pa','ap_ma','dni','api_nombre','api_paterno','api_materno','telefono','email','agencia','id_agencia','id_sucursal','direccion','estado','fecha_registro','iddpto','idprvc','iddist','orden','estado_idestado','estado_api'); 
										
										$campos_solicitudes=array('tipo','id_certificado','id_pedido','id_curso','id_suscrito','nombre','ap_pa','ap_ma','dni','api_nombre','api_paterno','api_materno','telefono','email','estado','fecha_registro','orden','estado_idestado','estado_api','iddpto','idprvc','iddist','agencia','id_agencia','id_sucursal','direccion'); 
										$id_seguimiento = $bd->inserta_(arma_insert("solicitudes",$campos_solicitudes,"POST"));

									
										/** GENBERAMOS EL QR por cada solicitud generada a certificado */
										// libreria esta declarada en arriba 
										$codesDir = "qr/codes/certificados/";   
										$codeFile = $id_seguimiento.'.png';
										$_POST['ecc']='H'; // calidadd imagen , H -M Q -L (low - peor baja)
										$_POST['size']=3; // [1-5] // rango de tamaño
										$_POST['contenido_a_codificar']= 'https://www.educaauge.com/diplomas/'.$id_seguimiento;
									
										QRcode::png($_POST['contenido_a_codificar'], $codesDir.$codeFile, $_POST['ecc'], $_POST['size']); // crea la imagen qr y la guarda en la ruta asignada 
										// echo $imagen_qr= '<img class="img-thumbnail" src="'.$codesDir.$codeFile.'" />';
										/** END QR */
								
										/*  
										echo var_dump(arma_insert("linea_pedido",$campos_detalle,"POST"));
										exit();
										/*  */
										$bd->inserta_(arma_insert("linea_pedido",$campos_detalle,"POST"));
																				
									/* REGISTRO SUSCRITO X CERTIFICADO */
										$_POST['validez_meses']='99';
										$_POST['orden'] =1;
										$_POST['dependiente'] = 2;
										$_POST['estado'] = 1; 
										// $_POST['id_pedido']='000';
										// $_POST['fecha_registro'] = fecha_hora(2);
										// $_POST['estado_idestado'] = 1;										
										$_POST['habilitar_solicitar_directo'] = 1; //   1::  no respeta validacion de terminar clase 
										
										// saco orden para PDF										
										$orden_pdf=executesql("select * from suscritos_x_certificados where  id_certificado='".$_POST["id_certificado"]."' and estado=1 and estado_idestado=1 "); // cuantos pagados ya tiene el certificado 
										$_POST["order_pdf"]=   !empty($orden_pdf) ?count($orden_pdf) +1 : 1;
										
										$campos_asignacion=array('id_suscrito','id_certificado',array('id_curso',$_POST['id_curso_del_certificado']),'id_pedido','precio','orden','id_tipo','habilitar_solicitar_directo','fecha_registro','estado','estado_idestado','order_pdf');										
										$bd->inserta_(arma_insert('suscritos_x_certificados',$campos_asignacion,'POST'));										
										/*  
										echo var_dump(arma_insert('suscritos_x_certificados',$campos_asignacion,'POST'));
										exit();
										*/
											
									/* END REGISTRO SUSCRITO X CURSO */
								
									/* 2. API INFUSION ADD TAG CURSO COMPRADO  :: para certificados no hay tag aun 
										if( !empty($tag_id_campana_shop) && $tag_id_campana_shop > 0  ){ // si es pago tarjeta y  se detecto los cursos de campaña se activa esta parte 
											include('../inc_api_infusion_compro_curso_todos_tags.php');
										}
									/* API INFUSION */
									
										/* Api correo validar datos para seguimieto / 
										$dpto=executesql(" select titulo from dptos where  iddpto='".$_POST["iddpto"]."' ");
										$_POST['dpto']=$dpto[0]['titulo'];

										$provincia=executesql(" select titulo from prvc where  idprvc='".$_POST["idprvc"]."' ");
										$_POST['provincia']=$provincia[0]['titulo'];

										$distrito=executesql(" select titulo from dist where  iddist='".$_POST["iddist"]."' ");
										$_POST['distrito']=$distrito[0]['titulo'];
										*/

										include("inc/inc_correo_validar_certificado_venta.php"); // por cada certificado se le envia un mail para confirmar
										/* END Api correo validar datos para seguimieto / */
										
?>										