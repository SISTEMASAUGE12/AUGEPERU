<?php 
header('Content-Type: application/json');

  require '../Requests-master/library/Requests.php';
  Requests::register_autoloader();
  require '../lib/culqi.php';

use Culqi\Culqi;

$SECRET_API_KEY = 'sk_test_GMiwyPFFT9DmdfJe';
$culqi = new Culqi(array('api_key' => $SECRET_API_KEY));
try {
  // Creando Cargo a una tarjeta
  $charge = $culqi->Charges->create(
      array(
        "amount" => 300,
        "currency_code" => "PEN",
        "email" => "adelgado112233@culqi.com",
        "source_id" => $_POST["token"] ,
        "antifraud_details" => array(
            "address" =>"Av. Lima 1234",
            "address_city"=> "Lima",
            "country_code" => "PE",
            "first_name" => "Jose",
            "last_name" => "Martinez",
            "phone_number" => 123456789
          )
      )

  );
  // Response
  echo json_encode($charge);

} catch (Exception $e) {
  echo json_encode($e->getMessage());
}
