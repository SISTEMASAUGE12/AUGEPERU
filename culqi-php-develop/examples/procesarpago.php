<?php 
header('Content-Type: application/json');

  require '../Requests-master/library/Requests.php';
  Requests::register_autoloader();
  require '../lib/culqi.php';

use Culqi\Culqi;

// $SECRET_API_KEY = 'sk_test_8f312378f44d1d56'; // // para integracion
$SECRET_API_KEY = 'sk_live_fb9aabe4a797d1c3';

$culqi = new Culqi(array('api_key' => $SECRET_API_KEY));

$_POST["email"]=( !empty($_POST["email"]) )?$_POST["email"]:'pasarela_proceso@educaauge.com';
$_POST["apellidos"]='Educa AUGE';
$_POST["direc"]=( !empty($_POST["direc"]) )?$_POST["direc"]:'av chiclayo 123 - Auge';
// $_POST["apellidos"]=( !empty($_POST["apellidos"]) )?$_POST["apellidos"]:' ape_AUGE';
// $_POST["ciudad"]=( !empty($_POST["ciudad"]) )?$_POST["ciudad"]:'Chiclayo - Auge';
$_POST["ciudad"]='Chiclayo - Auge';
$_POST["telef"]=( !empty($_POST["telef"]) )?$_POST["telef"]:'987999999';

try {
  // Creando Cargo a una tarjeta
  $charge = $culqi->Charges->create(
      array(
        "amount" => (double) $_POST['monto']*100,
        "currency_code" => "PEN",
        "email" => $_POST['email'],
        "source_id" => $_POST["token"],
        "antifraud_details" => array(
            "address" =>$_POST["direc"],
            "address_city"=> $_POST["ciudad"],
            "country_code" => "PE",
            "first_name" => $_POST["nombre"],
            "last_name" => $_POST["apellidos"],
            "phone_number" => $_POST["telef"]
          )
      )

  );
  // Response
  echo json_encode($charge);

} catch (Exception $e) {
  echo json_encode($e->getMessage());
}
