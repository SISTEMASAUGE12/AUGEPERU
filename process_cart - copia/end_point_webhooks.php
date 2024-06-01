<?php 	
 // header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL);
require("../class/Carrito.class.php");


	$bd = new BD;
  $bd->Begin();
	
	$ide="id_orden_vacio";
	$sql_consulta="";


  /* Recuperar el cuerpo de la solicitud y parsearlo como JSON */
   $input = json_decode(file_get_contents('php://input'), true);
  
  /* Reconocer tipo de evento recibido */  
  if($input['type'] == 'order.status.changed') {
    
   /*  Obtener objeto Orden */ 
		$objectOrder = json_decode($input['data'], true);   
    
   /* Parametros  */
     $ide = trim($objectOrder['id']);    /* orden_live: codigo_ope_off */    
     $state = trim($objectOrder['state']);         

		/* Acciones según nuevo state */ 
    
		/*  Orden pagada */
    if($state == 'paid') { 
      /*  Aquí cambiar state de la orden en tu sistema ...  */
			include('webhooks_1_pago_realizado.php');
			
    }

   /* Orden expirada */
    if($state == 'expired') {     
      /* Aquí cambiar state de la orden en tu sistema ...  */	
			include('webhooks_2_rechazar_pago_orden_vencida.php');
    } 
    
		/*  Orden eliminada  */
			if($state == 'deleted') {     
				 /*  Aquì cambiar state de la orden en tu sistema ...  */ 
				include('webhooks_3_pago_eliminado.php');
			}        

  } /* end principal */
	

/* Respuesta a Culqi  */ 
	  //Respuesta a Culqi
  http_response_code(200);
  $array = array(
    "response" => "Webhook de Culqi recibido, => ".$ide." => ".$sql_consulta
  );
  echo json_encode($array);

?>