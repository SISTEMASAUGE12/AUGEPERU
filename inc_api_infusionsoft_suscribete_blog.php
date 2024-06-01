<?php 
$registro_desde="blog_suscribirse";
$campos= array(
			'FirstName' => $_POST['FirstName'],
			'_datosderegistro' => 	$registro_desde,
			'Email' => $_POST['correo']
);
			
/* validar si ya existe el correo en la api */
$des=$infusionsoft->contacts('xml')->findByEmail($_POST['correo'], array('Id') ); // verifico si ya existe este correo registrado 												
if( count($des) == 0){				/* si el correo no figura en la BD de infusionsoft, lo registramos */
	$contactId= $infusionsoft->contacts('xml')->add($campos);  /* Registramos en la api */
	$infusionsoft->contacts('xml')->addToGroup($contactId, $_tag_blog);  /* Asigno una etiqueta webinar */								
	$infusionsoft->emails('xml')->optIn($_POST['correo'], "Home page newsletter subscriber"); /* permiso de consentiiento para recibir e-mails */
	
	//  para embviar un corero de biennida 
	// $infusionsoft->funnels()->achieveGoal('ik813', 'registroeducaaugev1', $contactId);				

}else{
	$contactId=$des[0]['Id'];
	$infusionsoft->contacts('xml')->addToGroup($contactId, $_tag_blog);  /* Asigno una etiqueta webinar */								
}

?>