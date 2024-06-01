<?php
require_once 'vendor/autoload.php';
include_once("tw7control/class/functions.php");
include_once("tw7control/class/class.bd.php");

$bd = new BD;
$bd->Begin();


$infusionsoft = new \Infusionsoft\Infusionsoft(array(
	'clientId' => 'hAgVQQ86FV2EeKZW7nhuhuI2GLnhaRnV',   
    'clientSecret' => 'sRa4sAqTDZjMI96G', 
    'redirectUri' => 'https://www.educaauge.com/renova.php', 
));

$sql=" select * from tokens ORDER by orden desc ";  /* token diario generate */
$token_del_dia =executesql($sql,0);


$token = str_replace('InfusionsoftToken', 'Infusionsoft\Token', $token_del_dia['token']); 

$infusionsoft->setToken(unserialize($token));

if (isset($_GET['code']) and !$infusionsoft->getToken()) {
    $infusionsoft->requestAccessToken($_GET['code']);
}

if (!$infusionsoft->getToken()) {
    echo '<a href="' . $infusionsoft->getAuthorizationUrl() . '">Autorizar</a>';
}


$infusionsoft->refreshAccessToken();

if ($infusionsoft->getToken()) {

    $toknvar = serialize($infusionsoft->getToken());
    file_put_contents("token.json", $toknvar); 
    
    //$token_array=array('token','fecha_registro','fecha_hora',0);
				
	//$insertado=$bd->actualiza_(arma_insert("tokens",$token_array,"POST")); 

}
