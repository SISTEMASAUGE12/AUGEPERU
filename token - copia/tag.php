<?php

require_once '../vendor/autoload.php';

//Establece su información de conexión
$infusionsoft = new \Infusionsoft\Infusionsoft(array(
	'clientId' => 'hAgVQQ86FV2EeKZW7nhuhuI2GLnhaRnV',   
    'clientSecret' => 'sRa4sAqTDZjMI96G', 
    
));


$token = file_get_contents("token/token.json"); //Obtiene el token del archivo (se puede cambiar a su base de datos)

 
if (!empty($token)) {
	$infusionsoft->setToken(unserialize($token)); //Establece el token que se utilizará en las llamadas
}

//Este es un ejemplo de cómo mostrar los datos de un contacto
$returnFields = array('Email', 'FirstName', 'LastName', '_numDNI'); //Los datos a devolver

$contactId = 2565350; //El Id de contacto de Keap
$tag_id_campana_shop = 2270; //El Id de contacto de Keap
$infusionsoft->contacts('xml')->addToGroup($contactId,$tag_id_campana_shop);  /* Asigno una etiqueta de campaña de compra  */			

$contactId = 2565350; //El Id de contacto de Keap
$tag_id_campana_shop = 2574; //El Id de contacto de Keap
$infusionsoft->contacts('xml')->addToGroup($contactId,$tag_id_campana_shop);  /* Asigno una etiqueta de campaña de compra  */			



?>