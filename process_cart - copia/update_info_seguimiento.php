<?php header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL); session_start();
require("../tw7control/class/class.bd.php"); 
require("../tw7control/class/functions.php");
require("../tw7control/class/class.upload.php");
$url = 'http://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? '/mori/yoemprendo/zsoli/' : '/' ); 


$_POST['action']=isset($_POST['action'])?$_POST['action']:'';
$rpta = 2;/*si es error*/
$bd= new BD;


if($_POST['action']=='actualizar'){
  // actualizamos estado 
  
  //$_POST["id_suscrito"]= $_GET["rewrite"];
  // $_POST["ide"]= $_GET["rewrite2"];
  
  $_POST["fecha_validacion_api"]= fecha_hora(2);
  $_POST["estado_api"]= 1;
  
  // $campos=array('api_nombre_editado','api_paterno_editado',"api_materno_editado",'iddpto','idprvc','iddist',"direccion",'id_agencia','id_sucursal','fecha_validacion_api','estado_api');
  $campos=array('api_nombre_editado','api_paterno_editado',"api_materno_editado",'fecha_validacion_api','estado_api');

  $bd->actualiza_(armaupdate('solicitudes',$campos," ide='".$_POST["ide_seguimiento"]."' and  id_suscrito='".$_POST["id_certi_cliente"]."' ",'POST'));/*actualizo*/

// echo var_dump(armaupdate('solicitudes',$campos," ide='".$_POST["ide"]."' and  id_suscrito='".$_POST["id_suscrito"]."' ",'POST'));


  $bd->close();
  $rpta = 1;/*si es OK*/


}

echo json_encode(array('rpta' => $rpta));

 ?>
