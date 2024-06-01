<?php error_reporting(0);
$dni = $_POST['dni'];
// $dni = 73977134;
//OBTENEMOS EL VALOR
  $consulta = file_get_contents('https://dniruc.apisperu.com/api/v1/dni/'.$dni.'?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Imx1aXNtb3JpQHR1d2ViNy5jb20ifQ.E8EcTqiRd4jMYWkMktde_Wz5OpdkUNfsxlgn235ueqY');

 if(!empty($consulta)){ echo $consulta; 
 }else{ 
	echo json_encode(array(
		"error" => 'error'
	));
 }
 
?> 
