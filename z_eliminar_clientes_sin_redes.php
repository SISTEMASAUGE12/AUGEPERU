<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

  $bd = new BD;
  $bd->Begin();
 

	$conteo=0;
	$ides='';
/* Recorro las preguntas del bnaco seleecionadas */
	// $sql=" SELECT id_suscrito FROM suscritos  WHERE id_fb is null and fecha_registro between '2021-01-20' and '2021-12-23' ";
	// $leads_wwebi=executesql($sql);
	// if( !empty($leads_wwebi) ){
		// foreach($leads_wwebi as $data){
				 
				 $si_tiene_compra=executesql("  select sc.id_pedido, sc.id_suscrito, sc.tipo_pago from pedidos sc INNER JOIN suscritos s ON sc.id_suscrito=s.id_suscrito  WHERE s.id_fb is NULL and sc.estado_pago=1 and s.fecha_registro between '2021-01-20' and '2021-12-23' and sc.id_suscrito='".$data["id_suscrito"]."' ");
				 
				 
				if( !empty($si_tiene_compra) ){
					$conteo++;
					$ides.=','.$data["id_suscrito"];
				}else{
					/* eliminar */
					  // $bd->actualiza_("DELETE FROM suscritos WHERE id_suscrito IN (".$data["id_suscrito"].")");

				}
				 

		// }
	// }
	
	echo $conteo; 
	echo $ides; 
	
	
	// echo var_dump();
	// exit();
	
  $bd->Commit();

?>