<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if( isset($_GET["ide"]) && !empty($_GET["ide"]) ){
  $bd=new BD;
  $_POST['id_usuario_valido']=$_SESSION["visualiza"]["idusuario"];
  $_POST['estado_api']=1;
  $_POST['fecha_validacion_manual']=fecha_hora(2);

  // $campos=array('estado','empresa_envio',"comentario"); 
  $campos=array('estado_api','fecha_validacion_manual','id_usuario_valido'); 

	/*
	 echo var_dump(armaupdate('solicitudes',$campos," ide='".$_POST["ide"]."'",'POST'));
	 exit(); 
	*/
  
	$bd->actualiza_(armaupdate('solicitudes',$campos," ide='".$_GET["ide"]."'",'POST'));/*actualizo*/
  $bd->close();
  
  echo "
  OK SOLICITUD VALIDADA:: ".$_GET["ide"]." - REGRESAR Y ACTUALIZAR .
  <script> alert('OK SOLICITUD VALIDADA:: ".$_GET["ide"]."');</script>";


}else{
  echo "<script> alert('NO VALIDO');</script>";
}
  ?>