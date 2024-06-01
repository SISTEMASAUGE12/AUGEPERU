<?php 


echo 'NAVEGADOR: '.$_SERVER['HTTP_USER_AGENT']; 

//Utilizamos api de geolocalizacion
$data = @file_get_contents("https://api.ipgeolocationapi.com/geolocate/". $_SERVER['REMOTE_ADDR']);
$items = json_decode($data, true);
 
echo "<p>La visita se realiza desde : ";
echo $items["continent"];
echo ", ";
echo $items["name"];
echo "</p>";


$ip = $_SERVER['REMOTE_ADDR']; // your ip address here
$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
if($query && $query['status'] == 'success')
{
      return $query['city'];
}
?>