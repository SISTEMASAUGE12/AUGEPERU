<?php  

// la variable $token sale o denbe ir en el archi de donde se llama a este include 


/* Establece su información de conexión */
$infusionsoft = new \Infusionsoft\Infusionsoft(array(
	'clientId' => 'hAgVQQ86FV2EeKZW7nhuhuI2GLnhaRnV',   
    'clientSecret' => 'sRa4sAqTDZjMI96G', 
    
));

/* token sale del arcgivo de donde se incluye este script */
if (!empty($token)) {
	$infusionsoft->setToken(unserialize($token)); //Establece el token que se utilizará en las llamadas
}


$campos= array(
			'FirstName' => $_POST['FirstName'],
			'LastName' => $_POST['LastName'],
			// '_nombres' => 'MISHOU 2',
			// 'numDNI' => '12345678',
			'_datosderegistro' => 	$registro_desde,
			'StreetAddress1' => $_POST['StreetAddress1'],
			'Phone1' => $_POST['Phone1'],
			'Email' => $_POST['correo']
);

/* $contactId= $infusionsoft->contacts('xml')->add($campos); */ 
/* validar si ya existe el correo en la api */
$des=$infusionsoft->contacts('xml')->findByEmail($_POST['correo'], array('Id') ); /* verifico si ya existe este correo registrado */
// echo "paso->".$_POST['correo'];

if( count($des) == 0){ 
	/* si el correo no figura en la BD de infusionsoft, lo registramos */
	$contactId= $infusionsoft->contacts('xml')->add($campos);  /* Registramos en la api */
	$infusionsoft->contacts('xml')->addToGroup($contactId, $tagId);  /* Asigno una etiqueta */	
	$infusionsoft->emails('xml')->optIn($_POST['correo'], "Home page newsletter subscriber"); /* permiso de consentiiento para e-mails */
	$infusionsoft->funnels()->achieveGoal('ik813', 'registroeducaaugev1', $contactId); /* FUNEL MAILS */

}else{
	/* si ya existe, obtengo su iD de insusion */
	$contactId=$des[0]['Id'];
}


// agregamos TAGS::::

if($contactId > 0){

	/* si se registro desde un un webinar asigno esta etiqueta */
	if( isset($_SESSION["url"]) && ($_SESSION["url"]=='webinar') && !empty($_SESSION["data_webinar"]["id_webinar"]) && !empty($_SESSION["data_webinar"]["etiqueta_infusion"]) ){  /* sol osi vienes desde webinar */
		$tagId_webinar=$_SESSION["data_webinar"]["etiqueta_infusion"];
		$infusionsoft->contacts('xml')->addToGroup($contactId, $tagId_webinar);  /* Asigno una etiqueta webinar */
	}
	
	if( $_POST['viene_desde'] == "trafico"){  // si viene desde trafico y ya existe normal enviamos al gracias, no se nuestran alertas: rpta:1
		$tagId_trafico= $_POST["tag_banner"];	
		$infusionsoft->contacts('xml')->addToGroup($contactId, $tagId_trafico);  /* Asigno una etiqueta webinar */
	
	}
}


/* Este es un ejemplo de cómo mostrar los datos de un contacto */
// $returnFields = array('Email', 'FirstName', 'LastName', '_numDNI'); //Los datos a devolver
// $contactId = 2482984; //El Id de contacto de Keap
// $conDat = $infusionsoft->contacts('xml')->load($contactId, $returnFields); //La llamada para devolver los datos
