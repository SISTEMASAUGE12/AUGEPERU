<?php 	
/* Infusion*/
$tag_id_campana_shop=''; /*Infusion soft api */
$link_api='https://www.educaauge.com/process_cart/webhooks_1_pago_realizado.php'; /* pagina donde se va a utilizar el token */
require_once '../vendor/autoload.php';
require('../vendor/infusionsoft/php-sdk/src/Infusionsoft/Api/ContactService.php');
/* Infusion*/


$fecha_de_pago = trim($objectOrder['paid_at']);         

// {
  // "creation_date": 1637853261677,
  // "id": "evt_live_32e2824e15742aca",
  // "object": "event",
  // "data": "{\"payment_code\":\"88735579\",\"state\":\"paid\",\"id\":\"ord_live_gH9a37SZvy5QL6kq\",\"amount\":5000,\"order_number\":\"#id-206\",\"available_on\":null,\"paid_at\":1637853201000,\"description\":\"Venta cursos educauage \",\"expiration_date\":1637939304,\"creation_date\":1637852905,\"fee_details\":null,\"object\":\"order\",\"metadata\":{},\"currency_code\":\"PEN\",\"total_fee\":413,\"updated_at\":1637853261,\"net_amount\":4587}",
  // "type": "order.status.changed"
// }


	$sql_consulta="SELECT p.*, s.email as email, s.nombre as nombre, s.telefono FROM pedidos p INNER JOIN suscritos s ON p.id_suscrito=s.id_suscrito WHERE p.codigo_ope_off ='".$ide."' ";
  $usuario = executesql($sql_consulta,0); //
  if(!empty($usuario)){
		$_GET['id_pedido']=$usuario['id_pedido'];
		$correo_cliente_api=( isset($usuario["email"]) && !empty($usuario["email"]) )? $usuario["email"]:'';

		
		if( !empty($_GET['id_pedido'] ) && $_GET['id_pedido'] > 0 ){ // si existe id_pedido hacemos el recorrido 
			
			$_POST["estado_pago"]=1;
			$_POST["fecha_pago_off"]= date('Y-m-j H:i:s',$fecha_de_pago);
			$_POST["comentario"]=$state;

			$campos_pedido=array('estado_pago','fecha_pago_off','comentario');	
		
			//asignamos
			$_POST['estado'] = 1;
			$campos=array('estado');
			
			/* deshabilito las posibles detalle de compra realizado. */
			$bd->actualiza_(armaupdate('suscritos_x_cursos',$campos," id_pedido='".$_GET["id_pedido"]."'",'POST'));/*actualizo*/
			$bd->actualiza_(armaupdate('suscritos_x_certificados',$campos," id_pedido='".$_GET["id_pedido"]."'",'POST'));/*actualizo*/
			
			/* marcamos como parobado el ticket de pago en tabla voacuhers */
			$_POST['estado_idestado']=1;
			$campo_vouchers=array('estado_idestado');
			$bd->actualiza_(armaupdate('vouchers',$campo_vouchers," id_pedido='".$_GET["id_pedido"]."'",'POST'));/*actualizo*/
			
			// $bd->actualiza_("UPDATE pedidos SET estado_pago=".$estado_pago." WHERE id_pedido=".$_GET['id_pedido']."");
			$bd->actualiza_(armaupdate('pedidos',$campos_pedido," id_pedido='".$_GET["id_pedido"]."'",'POST'));/*actualizo*/
			// echo $estado_pago;	
			
			
			/* Agrego etiqueta de INFUSION SOFT */
			/* recorrer linea del pedido, si encuentro los cursos de campaña continuamos */
			
				$linea_pedido=executesql(" select * from linea_pedido where id_pedido='".$_GET["id_pedido"]."' ");
				if( !empty($linea_pedido) ){
						foreach( $linea_pedido as $row ){
							
							/* Infusion */
								 if( $row['id_curso']== '555'){
										$tag_id_campana_shop=2110;	/* cod.curso 555 - */
										
								 }else if( $row['id_curso']== '487'){  /* Curso test: 487      */
										$tag_id_campana_shop=2110;	/* cod.curso 487 -test  - */
										
								 }else if( $row['id_curso']== '561'){ 
										$tag_id_campana_shop=2106;	/* cod.curso 561 - */
										
								 }else{
										$tag_id_campana_shop='';
								}
								/* Infusion */
								
								
								/* API INFUSION */
								if( !empty($tag_id_campana_shop) && !empty($correo_cliente_api) ){ /* si  se detecto los cursos de campaña se activa esta parte */
									$_POST['FirstName']= $usuario["nombre"];
									$_POST['LastName']= '';
									$_POST['StreetAddress1']='';
									$_POST['Phone1']= $usuario["telefono"];
									$_POST['correo']= $correo_cliente_api;
									
									$tagId_registro=2100;	
									include('../inc_api_infusion_compro_curso.php');
								}
								// /* API INFUSION */
								
								
						} /* end for linea pedido*/
				} /* end if linea */
				
			
			/* END infusion */
			
		} // si exite id_pedido
			
	}
	?>