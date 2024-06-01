<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once("auten.php"); // Asegúrate de que este archivo contiene la inclusión de la clase BD

$bd = new BD;

// Abrimos la conexión a la base de datos
$bd->open();

$result = $bd->Execute("SELECT * FROM webinars_x_becas ", 'assoc');


$bd->close();
?>