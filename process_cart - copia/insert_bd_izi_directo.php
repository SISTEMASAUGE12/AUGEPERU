<?php header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL);
require("../class/Carrito.class.php");

include_once dirname(__FILE__).'/../izipay/vendor/autoload.php';
include_once dirname(__FILE__).'/../izipay/keys.php';
include_once dirname(__FILE__).'/../izipay/helpers.php';
$client = new Lyra\Client();
			

require_once '../vendor/autoload.php';
require('../vendor/infusionsoft/php-sdk/src/Infusionsoft/Api/ContactService.php');
$token = file_get_contents("../token/token/token.json");

$correo_cliente_api=( isset($_POST["id_curso"]) && !empty($_POST["id_curso"]) )? $_POST["acme-email"]:'';
/* Infusion*/


$url_completa = url_completa();
$url = 'http://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? ':88/mori/tuweb7/w2019/withlove/' : '/' ); 

$dominio='educaauge.com';
$_POST['action']=isset($_POST['action'])?$_POST['action']:'';
$rpta = 2;/*si es error*/
$rpta_pago="";

$bd=new BD;
/* si recibo respuesta del pago */
if (!empty($_POST)) {

	/* Use client SDK helper to retrieve POST parameters */ // aca verifico la respuesta de la transaccion..
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
		$_POST["direccion"]=$formAnswer['kr-answer']['customer']['shippingDetails']["address"];
		$_POST["nombre_anexo"]=$formAnswer['kr-answer']['customer']['shippingDetails']["firstName"];
		$_POST["apellidos_anexo"]=$formAnswer['kr-answer']['customer']['shippingDetails']["lastName"];
		$_POST["telefono_anexo"]=$formAnswer['kr-answer']['customer']['shippingDetails']["identityCode"];  // DNI
		$_POST["celular_anexo"]=$formAnswer['kr-answer']['customer']['shippingDetails']["phoneNumber"];		
		$_POST["codreferencia"]=$formAnswer['kr-answer']['transactions'][0]['uuid'];		

		$_POST["id_curso"]= $_POST['acme-id_curso'];  /* *aca envio id_curso  */
		$_POST["email"]= $email= $_POST['acme-email'];  /* *aca envio id_curso  */
		$_POST["id_especialidad"]= $_POST['acme-id_especialidad'];  /* *aca envio id_curso  */
		$_POST["dni"]= $_POST['acme-dni'];  /* *aca envio id_curso  */
		$_POST["nombre"]= $_POST['acme-nombre'];  /* *aca envio id_curso  */
		$_POST["precio_pagado"]=$formAnswer['kr-answer']['customer']['shippingDetails']["address2"]; /* *aca envio id_curso  */			

		if(isset($_POST["id_curso"]) && !empty($_POST["id_curso"])){

			$email_cliente=$_POST["email"]; // email del cliente 			
			$_POST["estado_pago"]=1; // pago - pago omnline
			$_POST['estado']='1';  /* habiloitado */
			$_POST['estado_idestado']='1';
			$_POST['tipo_pago']='2'; //online
			$_POST["envio"] = 0;
			$_POST["subtotal"] = $_POST["precio_pagado"];
			
			// DESCUENTO PAGO TARJETA ONLINE
			// $dscto_10=($carrito->precio_total() * 0.1); 
			$dscto_10= 0; 
			$_POST["total"] = $_POST["precio_pagado"] - $dscto_10;							
			$_POST["articulos"] = 1;
			$_POST['fecha_registro'] = fecha_hora(2);
			$_POST['hora'] = fecha_hora(0);

			//DATA CURSO  
			$data_curso=executesql("select * from cursos where id_curso='".$_POST["id_curso"]."'");
			$_POST["id_tipo"]=$data_curso[0]["id_tipo"];
			$_POST["validez_meses"]=$data_curso[0]["validez_meses"];
			$_POST["tag"]=$data_curso[0]["tag"];

			/** VALIDO SI EXISTE CLIENTE O E SNUEVO PARA REGISTRARLO  */
			$nombre_suscritos=$_POST["nombre"];
			$nclient=executesql("select * from suscritos where email='".$_POST["email"]."'");
			if( !empty($nclient) ){
				$_POST["id_suscrito"]=$nclient[0]["id_suscrito"];
				$_POST['correo']= $email_cliente;

			}else{ // si cliente es nuevo lo registro 
				
				$_POST['orden']='1'; /* canal::: online default  */
				$_POST['fecha_registro']= fecha_hora(2); /* canal::: online default  */
				$_POST['hora_registro']= fecha_hora(2); /* canal::: online default  */
				$_POST['id_canal']='1'; /* canal::: online default  */
				$_POST['estado'] = $_POST['estado_idestado']='1'; /* canal::: online default  */
				$_POST['registro_desde']='6'; /* DESDE LANDING PAGO DIRECTO */
				$_POST['clave']= md5($_POST["dni"]); /* DESDE LANDING PAGO DIRECTO */
				$campos=array("nombre","email","dni","id_especialidad",'clave',"estado",'estado_idestado','registro_desde','id_canal');
				
				// echo var_dump(arma_insert('suscritos',array_merge($campos,array('orden','fecha_registro','hora_registro')),'POST')); 

				$id_suscrito= $_POST["id_suscrito"]=$bd->inserta_(arma_insert('suscritos',array_merge($campos,array('orden','fecha_registro','hora_registro')),'POST'));
				
				
				$tagId=2100;	// formulariao _web 
				$registro_desde="compra directa  landing ";		
				$_POST['correo']=$_POST["email"];			
				
					
				$tagId=2100;	// formulariao _web 
				$registro_desde="formulario v2";
				$_POST['FirstName']=$_POST["nombre"];
				$_POST['LastName']='';
				$_POST['StreetAddress1']='not';
				$_POST['Phone1']='--';
				$_POST['correo']=$_POST["email"];			
				include('../inc_generar_add_contacts_api_infusionsoft.php');
				/* infusion registro cliente */
			}			
					 
				
			/* 1. API INFUSION CLIENTE: Obtener ID si ya existe o registrar sino esta en infusion aun  :: para los clientes ya registrados o simple se vuelve arevalidar  */ 
			if( !empty($correo_cliente_api) &&  $_POST['tipo_pago']=='2' ){ // si es pago tarjeta y  tenemos correo del cliente  
				$tagId=2100;	
				$registro_desde="compra_online_directo";
				$_POST['FirstName']= $nclient[0]["nombre"];
				$_POST['LastName']= $nclient[0]["ap_pa"].' '.$nclient[0]["ap_ma"];
				$_POST['StreetAddress1']='';
				$_POST['Phone1']= $nclient[0]["telefono"];					
				$_POST['correo']=$email_cliente;													
				include('../inc_api_infusion_compro_curso.php');
			}
			/* API INFUSION */		

					
			//Generando - Cod venta
			$end_venta=executesql("select * from pedidos order by orden desc limit 0,1");
			// "CH".1000000.1=> sumar el ultimo valor o count mejor dicho  y sumarle 1 , luegio sumarlo con los 100000 y concatenar y listo guardar .. 
			if(!empty($end_venta)){
				$ultima_venta=$end_venta[0]["id_pedido"]+1;  
			}else{
				$ultima_venta=1;  
			}

			if($ultima_venta<10){
				$_POST["codigo"]= "AU000000".$ultima_venta;
			}else if($ultima_venta<100){
				$_POST["codigo"]= "AU00000".$ultima_venta;
			}else if($ultima_venta<1000){
				$_POST["codigo"]= "AU0000".$ultima_venta;
			}else if($ultima_venta<10000){
				$_POST["codigo"]= "AU000".$ultima_venta;
			}else if($ultima_venta<100000){
				$_POST["codigo"]= "AU00".$ultima_venta;
			}else if($ultima_venta<1000000){
				$_POST["codigo"]= "AU0".$ultima_venta;
			}else if($ultima_venta<10000000){
				$_POST["codigo"]= "AU".$ultima_venta;
			}
	 
			
			//Registramos BD
			if(  !empty($_POST["id_curso"]) && $_POST["precio_pagado"] > 0 ){				
				$_POST['orden'] = 1;
				$_POST['estado_idestado']='1';						
				$campos_pedido=array('estado_pago','tipo_pago','id_suscrito','codigo','envio','total','subtotal','articulos','direccion','hora','estado_idestado','fecha_registro','orden');
											
				if(isset($_POST['codreferencia']) && !empty($_POST['codreferencia'])){
					$campos_pedido = array_merge($campos_pedido,array('codreferencia'));
				}				
				$_POST['id_pedido']=$bd->inserta_(arma_insert("pedidos",$campos_pedido,"POST"));      
								
				//Detalle Pedido
				if( $_POST["id_curso"] ){ //recorro carrito
						
					$_POST['orden'] = _orden_noticia("","linea_pedido","");
					$_POST['dependiente'] = 2; // por defecto que no son dependientes 
					$_POST['especialidades'] = 2; // por defecto que no son especiales 						
					$_POST['talla']='';
					if( $_POST['id_tipo']== '9999'){ /* id_tipo::9999 => venta de un certificado */
						$_POST['talla']= '9999'; /* si es libro o curso, etc */									
					}

					/* Infusion */
					$tag_id_campana_shop=$_POST['tag']; ;	/* cod.curso 555 - */
					/* Infusion */
												
					$_POST['cantidad']=  1; 
					$_POST['precio']=  $_POST['precio_pagado']; 
					$_POST['subtotal']=  $_POST['precio']*$_POST['cantidad']; 
					$campos_detalle=array('id_pedido','id_curso','cantidad','precio','subtotal','talla','fecha_registro','orden','estado_idestado'); 
					$bd->inserta_(arma_insert("linea_pedido",$campos_detalle,"POST"));
																												
					if( empty($_POST['validez_meses']) ){ // si viene vacio asigno 6m por default 									
						$_POST['validez_meses']=  6; 															
					}
											
					/* si se compro un certificado, solo se registra en suscritos_x_certificasos*/
					if( $_POST['id_tipo']== '9999'){ /* id_tipo::9999 => venta de un certificado */
						// asigno cursos _x _ alumnos 
						$_POST['id_certificado']=  $_POST['id_curso']; 
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
					
					}else{ 
						/* validamos si ya tiene asignado el  curso */
						$validate_curso_existente=executesql("select * from suscritos_x_cursos where id_curso='".$_POST['id_curso']."' and id_suscrito='".$_POST['id_suscrito']."' and estado_idestado=1 and estado!=3 ");
						if(!empty($validate_curso_existente)){ 
							/* si ya existe este curso en la lista del cliente ya no lo volvemos a asignar.. */
						}else{
							
							/* asigno cursos _x _ suscritos  */ 
							$_POST['orden'] = 1;
							$campos=array('id_suscrito','id_curso','id_tipo','id_pedido','orden','fecha_registro','dependiente','especialidades','validez_meses','estado','estado_idestado');												

							$bd->inserta_(arma_insert('suscritos_x_cursos',$campos,'POST'));						
							
							// infusion para curso natural - add TAG curso general 									
							/* 2. API INFUSION ADD TAG CURSO COMPRADO  */ 
							if( !empty($tag_id_campana_shop) && $tag_id_campana_shop > 0 &&  $_POST['tipo_pago']=='2' ){ // si es pago tarjeta y  se detecto los cursos de campaña se activa esta parte 
								include('../inc_api_infusion_compro_curso_todos_tags.php');
							}
							/*  API INFUSION */
								

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
		
					

							include('../tw7control/inc/inc_cursos_dependientes_y_especialidades.php');  /* todo okey 10-08-2023 */

							
					}	/* End validate asignacion de curso  */
							
				} /* END: registrando sucritos_x_cursos */											
												
       		 } // fin foreach del  carrito.. 
// Endd linea_pedido
      $bd->close();
	}// if $carrito
					
			//Enviamos el mensaje y comprobamos el resultado

			if($_POST['id_pedido']>0){												
				include('correo_venta_online_exitosa_directo.php');		
				if(@mail($email_to_cli, $asunto, $contenido, $cabeceras_cli)){}//envio para cliente msj
				if(@mail($email_to, $asunto, $contenido, $cabeceras)){}  //envio para withlove msj						
				
				$rpta=1;
				$rpta_pago="ok";										
				
				$cel_mensaje_texto= $nclient[0]["telefono"];
				include('envio_mensaje_exto_venta_okey.php'); // mensaje de texto 				
	?>
				<script type='text/javascript'>
					location.href='https://www.educaauge.com/gracias-por-tu-compra';
					console.log("ok venta okey ");
				</script>
<?php 
			}
					
		}else{  // si no existe sesion deusuario ?>
			<script type='text/javascript'>
				<?php   echo "alert('Ingresa todos los datos para poder comprar. ');document.location=('".$url."');"; ?>
			</script>
		<?php 
		}  

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
