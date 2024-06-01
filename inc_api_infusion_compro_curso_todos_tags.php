<?php   
/* Establece su información de conexión */
$infusionsoft = new \Infusionsoft\Infusionsoft(array(
	'clientId' => 'hAgVQQ86FV2EeKZW7nhuhuI2GLnhaRnV',   
		'clientSecret' => 'sRa4sAqTDZjMI96G', 	
));

/* token sale del arcgivo de donde se incluye este script */
if (!empty($token)) {
	$infusionsoft->setToken(unserialize($token)); //Establece el token que se utilizará en las llamadas
}
						

/* validar si tenemos el ID del cliente de infusion */
if( !empty($contactId) ){
	/* asigno las etiquetas al contacto */
	
	$infusionsoft->contacts('xml')->addToGroup($contactId,$tag_id_campana_shop);  /* Asigno una etiqueta de campaña de compra  */		
} 
			
// echo '-->'.$contactId;
// exit();