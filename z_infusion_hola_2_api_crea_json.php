<?php session_start();
require_once 'vendor/autoload.php';

$infusionsoft = new \Infusionsoft\Infusionsoft(array(
	'clientId' => 'hAgVQQ86FV2EeKZW7nhuhuI2GLnhaRnV',
    'clientSecret' => 'sRa4sAqTDZjMI96G',
    'redirectUri' => 'https://jhocamoagencia.com/hola_2.php',
    // 'redirectUri' => 'https://www.educaauge.com/hola_2.php',
));

print_r($infusionsoft);

$token_salvo = file_get_contents("inc/tkn/token.json");

// If the serialized token is available in the session storage, we tell the SDK
// to use that token for subsequent requests.
if (!empty($token_salvo)) {
	$infusionsoft->setToken(unserialize($token_salvo));
}

// If we are returning from Infusionsoft we need to exchange the code for an
// access token.
if (isset($_GET['code']) and !$infusionsoft->getToken()) {
	$token = serialize($infusionsoft->requestAccessToken($_GET['code']));
	file_put_contents("inc/tkn/token.json", $token);
}

if ($infusionsoft->getToken()) {
	// Save the serialized token to the current session for subsequent requests
	$token_atual = serialize($infusionsoft->getToken());
    file_put_contents("inc/tkn/token.json",$token_atual); 
// MAKE INFUSIONSOFT REQUEST
			
			$_POST['FirstName']="TORIBIO";
			
	    // $nome = $infusionsoft->contacts('xml')->load(12, array("FirstName"));
			
					// echo $infusionsoft->contacts;
					// echo var_dump($infusionsoft->contacts());		
			    $infusionsoft->contacts('xml')->add(array('FirstName' => 'Eswin', 'LastName' => 'Mori'));
					
					
					//array_push($infusionsoft->contacts, "test");
					//$val = array('FirstName' => 'Goten', 'LastName' => 'Mori');
					//echo var_dump($val);					
					

	//cria o contato no infusion
	echo "Salvou token".$token_atual;
	
} else {
	echo '<a href="' . $infusionsoft->getAuthorizationUrl() . '">Autorizar</a>';
}


?>