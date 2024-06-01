<?php 

session_start();
require_once '../vendor/autoload.php';


//Establece su información de conexión
$infusionsoft = new \Infusionsoft\Infusionsoft(array(
	'clientId' => 'hAgVQQ86FV2EeKZW7nhuhuI2GLnhaRnV',  
    'clientSecret' => 'sRa4sAqTDZjMI96G', 
    'redirectUri' => 'https://www.educaauge.com/keap/autoriza.php', 
));


$token = file_get_contents("token/token.json");  //Obtiene el token del archivo (se puede cambiar a su base de datos)  



if (!empty($token)) {  //Si no está vacío, establece el token que se utilizará
	$infusionsoft->setToken(unserialize($token)); //Establece el token que se utilizará en las llamadas
}

//Si se devuelve la autorización, genera el token utilizando el código devuelto y guarda el token
if (isset($_GET['code']) and !$infusionsoft->getToken()) {  
	$token = serialize($infusionsoft->requestAccessToken($_GET['code']));
	file_put_contents("token/token.json", $token); 
}


//Si se genera el token, guárdelo
if ($infusionsoft->getToken()) {
	
	$token_atual = serialize($infusionsoft->getToken());
    file_put_contents("token/token.json", $token_atual); 
	
	
	echo "Token se ha guardado";  
	
} else {
	echo '<a href="' . $infusionsoft->getAuthorizationUrl() . '">Autorizar</a>'; 
}