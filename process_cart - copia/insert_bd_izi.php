<?php header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL);
require("../class/Carrito.class.php");

include_once dirname(__FILE__).'/../izipay/vendor/autoload.php';
include_once dirname(__FILE__).'/../izipay/keys.php';
include_once dirname(__FILE__).'/../izipay/helpers.php';
$client = new Lyra\Client();
			

require_once '../vendor/autoload.php';
require('../vendor/infusionsoft/php-sdk/src/Infusionsoft/Api/ContactService.php');
$correo_cliente_api=( isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"]) )? $_SESSION["suscritos"]["email"]:'';
/* Infusion*/


$url_completa = url_completa();
$url = 'http://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? ':88/mori/tuweb7/w2019/withlove/' : '/' ); 

$dominio='educaauge.com';
$_POST['action']=isset($_POST['action'])?$_POST['action']:'';
$rpta = 2;/*si es error*/
$rpta_pago="";


/* si recibo respuesta del pago */
if (!empty($_POST)) {

/* Use client SDK helper to retrieve POST parameters */
// aca verifico la respuesta de la transaccion..
 
$formAnswer = $client->getParsedFormAnswer();
	/* Check the signature */
	if (!$client->checkHash()) {
			//something wrong, probably a fraud ....
			signature_error($formAnswer['kr-answer']['transactions'][0]['uuid'], $hashKey, 
											$client->getLastCalculatedHash(), $_POST['kr-hash']);
			throw new Exception("invalid signature");
	}

	/* I check if it's really paid */
	if ($formAnswer['kr-answer']['orderStatus'] != 'PAID') {
			 $title = "Transaction not paid !";
			 
	}else{
		// la transaccion fue pagada con exito ... guardar en BD..
		// echo $title = "Transaction paid !";
		
		
		
		// $_POST["tipo_comprobante"]=$formAnswer['kr-answer']['customer']['billingDetails']['zipCode'];
		// $_POST["rason_social"]=$formAnswer['kr-answer']['customer']['billingDetails']['legalName'];
		// $_POST["ruc"]=$formAnswer['kr-answer']['customer']['billingDetails']['identityCode'];
		// $_POST["lugar_fact"]=$formAnswer['kr-answer']['customer']['billingDetails']['address'];
		// $_POST["destino_fact"]=$formAnswer['kr-answer']['customer']['billingDetails']['city'];
		// $_POST["correo_ruc"]=$formAnswer['kr-answer']['customer']['billingDetails']['lastName'];
		
		// $_POST["comentario"]=	$formAnswer['kr-answer']['customer']['reference'];
		$_POST["direccion"]=$formAnswer['kr-answer']['customer']['shippingDetails']["address"];
		// $_POST["referencia"]=$formAnswer['kr-answer']['customer']['shippingDetails']["address2"];
		$_POST["nombre_anexo"]=$formAnswer['kr-answer']['customer']['shippingDetails']["firstName"];
		$_POST["apellidos_anexo"]=$formAnswer['kr-answer']['customer']['shippingDetails']["lastName"];
		$_POST["telefono_anexo"]=$formAnswer['kr-answer']['customer']['shippingDetails']["identityCode"];  // DNI
		$_POST["celular_anexo"]=$formAnswer['kr-answer']['customer']['shippingDetails']["phoneNumber"];
		// $_POST["id_envio"]=$formAnswer['kr-answer']['customer']['shippingDetails']["city"];
		// $_POST["codreferencia"]=$formAnswer['kr-answer']['shopId'];
		$_POST["codreferencia"]=$formAnswer['kr-answer']['transactions'][0]['uuid'];


			if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){

				$_POST["id_suscrito"]=$_SESSION["suscritos"]["id_suscrito"] ;
				$_POST["estado_pago"]=1; // pago - pago omnline
				$_POST['estado']='1';  /* habiloitado */
				$_POST['estado_idestado']='1';
	
				$email= $_SESSION["suscritos"]["email"];
				
				$_POST['tipo_pago']='2'; //online
				$email= $_SESSION["suscritos"]["email"];
				$carrito = new Carrito();
				$_POST["envio"] = $carrito->precio_envio();
				$_POST["subtotal"] = $carrito->precio_subtotal();
				
				// DESCUENTO PAGO TARJETA ONLINE
				// $dscto_10=($carrito->precio_total() * 0.1); 
				$dscto_10= 0; 
				$_POST["total"] = $carrito->precio_total() - $dscto_10;
				
				
				$_POST["articulos"] = $carrito->articulos_total();
				$_POST['fecha_registro'] = fecha_hora(2);
				$_POST['hora'] = fecha_hora(0);
	
				//name client
				$nclient=executesql("select * from suscritos where id_suscrito='".$_POST["id_suscrito"]."'");
				$nombre_suscritos=$nclient[0]["nombre"];
				$_POST['correo']= $_SESSION["suscritos"]["email"];
					 
				
				/* 1. API INFUSION CLIENTE: Obtener ID si ya existe o registrar sino esta en infusion aun  */
				if( !empty($correo_cliente_api) &&  $_POST['tipo_pago']=='2' ){ /* si es pago tarjeta y  tenemos correo del cliente  */
			
					$tagId=2100;	
					$registro_desde="compra_online";
					$_POST['FirstName']= $nclient[0]["nombre"];
					$_POST['LastName']= $nclient[0]["ap_pa"].' '.$nclient[0]["ap_ma"];
					$_POST['StreetAddress1']='';
					$_POST['Phone1']= $nclient[0]["telefono"];					
					$_POST['correo']=$_SESSION["suscritos"]["email"];
					
			
					
					include('../inc_api_infusion_compro_curso.php');
				}
				// /* API INFUSION */
				


				
				
			// $_POST['tipo_pago']=	$_POST['tiempo'];
			// if($_POST['tipo_pago']==2){
					
			// }
			// $_POST['tipo_pago']='1'; //depotrans
			//Generando - Cod venta
			$end_venta=executesql("select * from pedidos order by orden desc limit 0,1");
			// "CH".1000000.1=> sumar el ultimo valor o count mejor dicho  y sumarle 1 , luegio sumarlo con los 100000 y concatenar y listo guardar .. 
			if(!empty($end_venta)){
				$ultima_venta=$end_venta[0]["id_pedido"]+1;  
			}else{
				$ultima_venta=1;  
			}

			IF($ultima_venta<10){
				$_POST["codigo"]= "AU000000".$ultima_venta;
			}ELSE IF($ultima_venta<100){
				$_POST["codigo"]= "AU00000".$ultima_venta;
			}ELSE IF($ultima_venta<1000){
				$_POST["codigo"]= "AU0000".$ultima_venta;
			}ELSE IF($ultima_venta<10000){
				$_POST["codigo"]= "AU000".$ultima_venta;
			}ELSE IF($ultima_venta<100000){
				$_POST["codigo"]= "AU00".$ultima_venta;
			}ELSE IF($ultima_venta<1000000){
				$_POST["codigo"]= "AU0".$ultima_venta;
			}ELSE IF($ultima_venta<10000000){
				$_POST["codigo"]= "AU".$ultima_venta;
			}
	 
			
			//Registramos BD
				if($carrito->get_content()){
						// echo var_dump( $carrito->get_content() );
						// exit();
						$bd=new BD;      
			// *Add PEDidos
						// $_POST['orden'] = _orden_noticia("","pedidos","");
						$_POST['orden'] = 1;
						$_POST['estado_idestado']='1';
						
						$campos_pedido=array('estado_pago','tipo_pago','id_suscrito','codigo','envio','total','subtotal','articulos','direccion','hora','estado_idestado','fecha_registro','orden');
						
				
						// if($_POST['id_envio']!='1000'){ //si es envio
							// $campos_pedido = array_merge($campos_pedido,array('referencia','nombre_anexo','apellidos_anexo','telefono_anexo','celular_anexo'));			
						// }
						
						// if($_POST['tipo_comprobante']!='1'){ //si es factura
							// $campos_pedido = array_merge($campos_pedido,array('rason_social','ruc','correo_ruc','destino_fact','lugar_fact'));			
						// }
									
						// $campos_pedido = array_merge($campos_pedido,array('codreferencia'));			
						if(isset($_POST['codreferencia']) && !empty($_POST['codreferencia'])){
							$campos_pedido = array_merge($campos_pedido,array('codreferencia'));
						}
						
						// echo var_dump(arma_insert("pedidos",$campos_pedido,"POST"));
						// exit();
						$_POST['id_pedido']=$bd->inserta_(arma_insert("pedidos",$campos_pedido,"POST"));      
								
//Detalle Pedido
       foreach($carrito->get_content() as $row){ //recorro carrito
           
			$_POST['orden'] = _orden_noticia("","linea_pedido","");
			$_POST['dependiente'] = 2; // por defecto que no son dependientes 
			$_POST['especialidades'] = 2; // por defecto que no son especiales 
            $_POST['id_curso']=  $row['id']; 
            $_POST['id_tipo']=  $row['id_tipo']; /* si es libro o curso, etc */
						
						$_POST['talla']='';
					 if( $_POST['id_tipo']== '9999'){ /* id_tipo::9999 => venta de un certificado */
						$_POST['talla']= '9999'; /* si es libro o curso, etc */
							
					 }

					 if( $_POST['id_tipo']== '7777'){ /* id_tipo::7777 => venta de un examen */
						$_POST['talla']= '7777'; /* si es libro o curso, etc */							
					 }

				

					/* Infusion */
						$tag_id_campana_shop=$row['tag']; ;	/* cod.curso 555 - */
					/* Infusion */
						
						
            $_POST['cantidad']=  $row['cantidad']; 
            $_POST['precio']=  $row['precio']; 
            $_POST['subtotal']=  $row['precio']*$row['cantidad']; 
            $campos_detalle=array('id_pedido','id_curso','cantidad','precio','subtotal','talla','fecha_registro','orden','estado_idestado'); 
            $bd->inserta_(arma_insert("linea_pedido",$campos_detalle,"POST"));
						
						
						
						// echo $row['validez_meses'];
						
						if( empty($row['validez_meses']) ){
								
							$_POST['validez_meses']=  12; 
						}else{
							$_POST['validez_meses']=  $row['validez_meses']; 
							
						}
						
						
					/* si se compro un certificado, solo se registra en suscritos_x_certificasos*/
					if( $_POST['id_tipo']== '9999'){ /* id_tipo::9999 => venta de un certificado */
								// asigno cursos _x _ alumnos 
								$_POST['id_certificado']=  $row['id']; 
								$_POST['id_curso']=  $row['validez_meses']; /* solo se eusa esta varibale para venta de certificados .. */
								$_POST['orden'] = _orden_noticia("","suscritos_x_certificados","");
								
								/* validamos si ya tiene asignado el  certificado*/
								$validate_certi=executesql("select * from suscritos_x_certificados where id_certificado='".$_POST['id_certificado']."' and id_suscrito='".$_POST['id_suscrito']."' and estado_idestado=1 and estado!=3 "); /* si tiene un pago rechazado se le permite volver a pagarlo */
								if(!empty($validate_certi)){ /* si ya existe este certificado en la lista del cliente ya no lo volvemos a sgnar.. */
								}else{
									/* si no tiene este certificado asignado, lo registramos */
									/* si no tiene este certificado asignado, lo registramos */
									/* si no tiene este certificado asignado, lo registramos */

									$orden_pdf=executesql("select * from suscritos_x_certificados where id_certificado='".$_POST["id_certificado"]."' and estado_idestado=1 and estado=1 ");
									$_POST["order_pdf"]=   !empty($orden_pdf) ?count($orden_pdf) +1 : 1;

									$campos_compra_de_certi=array('id_suscrito','id_certificado','id_curso','id_tipo','id_pedido','precio','orden','fecha_registro','estado','estado_idestado','order_pdf');
									$bd->inserta_(arma_insert('suscritos_x_certificados',$campos_compra_de_certi,'POST'));
								}
								/* End validate certificado */


					}else if( $_POST['id_tipo']== '7777'){ /* id_tipo::7777 => venta de un examen */
								// asigno cursos _x _ alumnos 
								$_POST['id_examen']=  $row['id']; 
								$_POST['estado']=  1;  // aprobado rirecto el pago  apr obar 

								$_POST['orden'] = _orden_noticia("","suscritos_x_examenes","");
								
								/* validamos si ya tiene asignado el  examen */
								$validate_certi=executesql("select * from suscritos_x_examenes where id_examen='".$_POST['id_examen']."' and id_suscrito='".$_POST['id_suscrito']."' and estado_idestado=1"); /* si tiene un pago rechazado se le permite volver a pagarlo */
								if(!empty($validate_certi)){ /* si ya existe este w examen en la lista del cliente ya no lo volvemos a sgnar.. */
								}else{
									/* si no tiene este examen asignado, lo registramos */
									$campos_examenes=array('id_suscrito','id_examen','id_pedido','fecha_registro','estado','estado_idestado');
									$bd->inserta_(arma_insert('suscritos_x_examenes',$campos_examenes,'POST'));
								}
								/* End validate examen */
							
					}else{ 
								/* validamos si ya tiene asignado el  curso */
								$validate_curso_existente=executesql("select * from suscritos_x_cursos where id_curso='".$_POST['id_curso']."' and id_suscrito='".$_POST['id_suscrito']."' and estado_idestado=1 and estado!=3 ");
								if(!empty($validate_curso_existente)){ 
									/* si ya existe este curso en la lista del cliente ya no lo volvemos a asignar.. */
								}else{
									
									/* asigno cursos _x _ suscritos  */ 
									// $_POST['orden'] = _orden_noticia("","suscritos_x_cursos","");
									$_POST['orden'] = 1;
									$campos=array('id_suscrito','id_curso','id_tipo','id_pedido','orden','fecha_registro','dependiente','especialidades','validez_meses','estado','estado_idestado');
									// echo var_dump(arma_insert('suscritos_x_cursos',$campos,'POST'));
									// exit();
								
										$bd->inserta_(arma_insert('suscritos_x_cursos',$campos,'POST'));						
										
										/* infusion para curso natural - add TAG curso general */
													
									// /* 2. API INFUSION ADD TAG CURSO COMPRADO */
										if( !empty($tag_id_campana_shop) && $tag_id_campana_shop > 0 &&  $_POST['tipo_pago']=='2' ){ /* si es pago tarjeta y  se detecto los cursos de campaña se activa esta parte */
											include('../inc_api_infusion_compro_curso_todos_tags.php');
										}
										// /* API INFUSION */
										
										// asigno clases por curso del _ alumnos con estado pendiente: estado:2 pendiente, 1. finalizada ..
										$_POST['orden'] = _orden_noticia("","avance_de_cursos_clases","");
										$_POST['estado_idestado']='1';
										$_POST['estado_fin']='2';
										// recorremos las clases del curso ..
										$sql_n_clase="select d.id_detalle,d.id_sesion from detalle_sesiones d 
																				INNER JOIN sesiones s  ON s.id_sesion=d.id_sesion 
																				INNER JOIN cursos c  ON c.id_curso=s.id_curso 
																				WHERE d.estado_idestado=1 and c.id_curso='". $_POST['id_curso']."' ";
										$n_clases=executesql($sql_n_clase);
										if( !empty($n_clases)){
											foreach($n_clases as $rowe){
												// recorremos y agregamos 
													$_POST['id_detalle']=$rowe['id_detalle'];
													$_POST['id_sesion']=$rowe['id_sesion'];
													$campos_avances=array('id_suscrito','id_curso','id_sesion','id_detalle','id_pedido','orden','fecha_registro','estado_fin','estado_idestado');
													$bd->inserta_(arma_insert('avance_de_cursos_clases',$campos_avances,'POST'));								
											}
										}																				
									
												/*		los ocmento xq falla al momento de asignar especiaoidades de los cursos q  forman  parte de un pack, el de abajo inc ya esta coregio y todo okey 																	
									// ... dependientes scrip 
									include('add_cursos_dependientes.php');									
									// add especialidades --> si es que tiene .. 
									include('add_cursos_especialidades.php');
									*/

									include('../tw7control/inc/inc_cursos_dependientes_y_especialidades.php');  /* todo okey 10-08-2023 */

									
							}	/* End validate asignacion de curso  */
							
					} /* END: registrando sucritos_x_cursos */	
					
					
					// /* API INFUSION */
					// if( !empty($tag_id_campana_shop) && $tag_id_campana_shop > 0 &&  $_POST['tipo_pago']=='2' ){ /* si es pago tarjeta y  se detecto los cursos de campaña se activa esta parte */
						// $_POST['FirstName']= $nclient[0]["nombre"];
						// $_POST['LastName']= $nclient[0]["ap_pa"].' '.$nclient[0]["ap_ma"];
						// $_POST['StreetAddress1']=$nclient[0]["direccion"];
						// $_POST['Phone1']= $nclient[0]["telefono"];
						// $_POST['correo']= $_SESSION["suscritos"]["email"];
						
						// $tagId_registro=2100;	
						// include('../inc_api_infusion_compro_curso.php');
					// }
					/* API INFUSION */
					
					
							
        } // fin foreach del  carrito.. 
// Endd linea_pedido
      $bd->close();
		}// if $carrito
					
			//Enviamos el mensaje y comprobamos el resultado

					if($_POST['id_pedido']>0){												
						include('correo_venta_online_exitosa.php');
						
						if(@mail($email_to_cli, $asunto, $contenido, $cabeceras_cli)){}//envio para cliente msj
						if(@mail($email_to, $asunto, $contenido, $cabeceras)){}  //envio para withlove msj						
						
						unset($_SESSION["carrito"]);//despues de todo el proceso reinicio el carrito
						$rpta=1;
						$rpta_pago="ok";
												
						
						$cel_mensaje_texto= $nclient[0]["telefono"];
						include('envio_mensaje_exto_venta_okey.php'); // mensaje de texto 
						
						// echo "redirigir ";
						// header('Location:https://www.educaauge.com/mis-cursos?task=gracias');
						?>
			<script type='text/javascript'>
										location.href='https://www.educaauge.com/mis-cursos?task=gracias';
					console.log("ok venta okey ");
			</script>

<?php 
					}
					
				}else{  // si no existe sesion deusuario ?>
			<script type='text/javascript'>
			<?php   echo "alert('Inicie sesion para poder comprar');document.location=('".$url."');"; ?>
			</script>
			<?php }  
	} // else estado de estatus del pago 


}else{
	 // si no recibo respuestas del pago online
	    throw new Exception("no post data received!");

}


// echo json_encode(array(
	// 'rpta' => $rpta, 
	// "res" => $rpta_pago	
// ));

?>
