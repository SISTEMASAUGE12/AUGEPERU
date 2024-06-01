<?php
require_once '../vendor/autoload.php';

// Este archivo debe ser configurado con un cronjob para que se ejecute cada 20h


//Establece su información de conexión
$infusionsoft = new \Infusionsoft\Infusionsoft(array(
	'clientId' => 'hAgVQQ86FV2EeKZW7nhuhuI2GLnhaRnV',   
    'clientSecret' => 'sRa4sAqTDZjMI96G', 
    'redirectUri' => 'https://www.educaauge.com/token/renova.php', 
));

$token = file_get_contents("token/token.json"); //Obtiene el token del archivo (se puede cambiar a su base de datos)

$token = str_replace('InfusionsoftToken','Infusionsoft\Token',$token); // si se ha eliminado el carácter \ al guardar, hay que volver a añadirlo

$infusionsoft->setToken(unserialize($token));  //Establece el token que se utilizará en las llamadas


$infusionsoft->refreshAccessToken();  // Renueva el token
	
//Si la ficha fue renovado, guárdelo en el mismo lugar que el anterior
	if ($infusionsoft->getToken()) {
	
	$toknvar = serialize($infusionsoft->getToken());	 
	file_put_contents("token/token.json", $toknvar);
	
	}else{
		echo "no renovo? ";
	}