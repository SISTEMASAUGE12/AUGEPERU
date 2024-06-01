<?php 

{
  "creation_date": 1637966022391,
  "id": "evt_live_80a7932e5c53a8c8",
  "object": "event",
  "data": "{\"payment_code\":null,\"state\":\"created\",\"id\":\"ord_live_lpTuPgxccRdgPcLM\",\"amount\":10000,\"order_number\":\"#id-3247\",\"available_on\":null,\"paid_at\":null,\"description\":\"Venta cursos educauage \",\"expiration_date\":1638052421,\"creation_date\":1637966022,\"fee_details\":null,\"object\":\"order\",\"metadata\":null,\"currency_code\":\"PEN\",\"total_fee\":null,\"updated_at\":1637966022,\"net_amount\":null}",
  "type": "order.creation.succeeded"
}


  /* Recuperar el cuerpo de la solicitud y parsearlo como JSON */
   $input = json_decode(file_get_contents('php://input'), true);
  
	
/* Respuesta a Culqi  */ 
	  //Respuesta a Culqi
  http_response_code(200);
  $array = array(
    "response" => "Webhook creacion de orden pagoefectivo recibido, => ".$ide." => ".$sql_consulta
  );
  echo json_encode($array);
	
	
?>