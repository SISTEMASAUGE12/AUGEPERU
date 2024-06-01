<?php session_start();
error_reporting(E_ALL);
include_once("../class/class.bd.php"); 
include_once("../class/functions.php");

 $url = 'http://'.$_SERVER['SERVER_NAME'].'/'.( ($_SERVER['SERVER_NAME'] == 'localhost') ? 'mori/cixx/' : 'cixx/' ); 
 

?>