<?php $token = file_get_contents("../token/token/token.json");
$infusionsoft = new \Infusionsoft\Infusionsoft(array(
	'clientId' => 'hAgVQQ86FV2EeKZW7nhuhuI2GLnhaRnV',   
		'clientSecret' => 'sRa4sAqTDZjMI96G', 	
));

if (!empty($token)) {
	$infusionsoft->setToken(unserialize($token)); //Establece el token que se utilizará en las llamadas
}
						
$campos_infusion= array(
			'FirstName' => $_POST['FirstName'],
			'LastName' => $_POST['LastName'],
			// '_nombres' => 'MISHOU 2',
			// 'numDNI' => '12345678',
			'_datosderegistro' => 	$registro_desde,
			'StreetAddress1' => $_POST['StreetAddress1'],
			'Phone1' => $_POST['Phone1'],
			'Email' => $_POST['correo']
);


/* validar si ya existe el correo en la api */
if( !empty($correo_cliente_api) ){
	
	$des=$infusionsoft->contacts('xml')->findByEmail($correo_cliente_api, array('Id')); /* verifico si ya existe este correo registrado */
	if( count($des) == 0){
		
		$contactId= $infusionsoft->contacts('xml')->add($campos_infusion);  /* Registramos en la api */
		$infusionsoft->contacts('xml')->addToGroup($contactId, $tagId);  /* Asigno una etiqueta de registro */
		$infusionsoft->emails('xml')->optIn($_POST['correo'], "Home page newsletter subscriber"); /* permiso de consentiiento recibir e-mails */
		
	}else{
		/* si ya existe */
		$contactId=$des[0]['Id'];
		
		if( !empty($tag_id_campana_shop) && $tag_id_campana_shop >0 ){ /* si un tag antes lo agrega */
			$infusionsoft->contacts('xml')->addToGroup($contactId,$tag_id_campana_shop);  /* Asigno una etiqueta de campaña de compra  */			
		}
		
	}
} /* end if si existe correo de cliente  */
			
