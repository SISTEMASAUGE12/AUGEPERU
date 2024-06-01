<?php
/**
 * Crear un charge a una tarjeta usando Culqi PHP.
 */

try {
  // Cargamos Requests y Culqi PHP
  include_once dirname(__FILE__).'/../libraries/Requests/library/Requests.php';
  Requests::register_autoloader();
  include_once dirname(__FILE__).'/../libraries/culqi-php/lib/culqi.php';



$SECRET_KEY = "sk_test_bDrQQp8qZ2cwAchZ";
$culqi = new Culqi\Culqi(array('api_key' => $SECRET_KEY));

  // Creando Cargo a una tarjeta
  $charge = $culqi->Charges->create(
      array(
        "amount" => 30000,
        "installments" => $_POST['cuotas'],
        "currency_code" => "PEN",
        "email" => "soporte.culqi0810@culqi.com",
        "source_id" => $_POST['token'],
		"description" => "Venta Producto/Servicio S/300.00",
		"antifraud_details" => array(
            "address" =>"Av. Lima 124",
            "address_city"=> "Lima",
            "country_code" => "PE",
            "first_name" => "Jorge",
            "last_name" => "Martinez",
            "phone_number" => 987654121
          ),
			"metadata" => array (
				"order_id" => "COD00011",
				"user_id" => "42052001"
			)
      )
  );
  // Respuesta
  echo json_encode($charge);

} catch (Exception $e) { 
  
  error_log($e->getMessage()); 

  echo $e->getMessage(); 


}
