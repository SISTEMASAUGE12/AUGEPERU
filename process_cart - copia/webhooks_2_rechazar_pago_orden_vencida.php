<?php 	
	$fecha_expiracion = trim($objectOrder['expiration_date']);         

	$sql_consulta="SELECT * FROM pedidos WHERE codigo_ope_off ='".$ide."' ";
  $usuario = executesql($sql_consulta,0); //
  if(!empty($usuario)){
		$_GET['id_pedido']=$usuario['id_pedido'];
		
		if( !empty($_GET['id_pedido'] ) && $_GET['id_pedido'] > 0 ){ // si existe id_pedido hacemos el recorrido 
			
			$_POST["estado_pago"]=3;
			// $_POST["fecha_pago_off"]= date('Y-m-j H:i:s',$fecha_expiracion); /* fecha de expiraacion */
			$_POST["fecha_pago_off"]= date('Y-m-j',$fecha_expiracion); /* fecha de expiraacion */
			$_POST["comentario"]=$state.' - '.$_POST["fecha_pago_off"];

			$campos_pedido=array('estado_pago','comentario');	
		
			//asignamos
			$_POST['estado'] = 3;
			$campos=array('estado');
			
			/* deshabilito las posibles detalle de compra realizado. */
			$bd->actualiza_(armaupdate('suscritos_x_cursos',$campos," id_pedido='".$_GET["id_pedido"]."'",'POST'));/*actualizo*/
			$bd->actualiza_(armaupdate('suscritos_x_certificados',$campos," id_pedido='".$_GET["id_pedido"]."'",'POST'));/*actualizo*/
			
			$_POST['estado_idestado']=3;
			$campo_vouchers=array('estado_idestado');
			$bd->actualiza_(armaupdate('vouchers',$campo_vouchers," id_pedido='".$_GET["id_pedido"]."'",'POST'));/*actualizo*/
			
			// $bd->actualiza_("UPDATE pedidos SET estado_pago=".$estado_pago." WHERE id_pedido=".$_GET['id_pedido']."");
			$bd->actualiza_(armaupdate('pedidos',$campos_pedido," id_pedido='".$_GET["id_pedido"]."'",'POST'));/*actualizo*/
			// echo $estado_pago;	
			
		} // si exite id_pedido
			
	}
	?>