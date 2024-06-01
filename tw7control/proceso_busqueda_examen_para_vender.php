<?php include ("auten.php");
$nombre = $_POST['nombrebusqueda'];//recibe el nombre a buscar

$sql="SELECT c.* FROM examenes c 
		WHERE c.estado_idestado=1 and  privacidad=3 and  (c.id_examen LIKE '%".$nombre."%' or c.titulo LIKE '%".$nombre."%') ORDER BY c.titulo ASC";
$consulta=executesql($sql);

if($consulta){
	foreach ($consulta as $rs){
		$tipo_certificado= 1; // no es necesario pero va por la funcio js de relleno- por ahora se podria reutilzar 
		// se remplaza el termino buscado por el nombre del producto traido de la base de datos (reemplza termino a negrita)
		$nombre = str_replace($_POST['nombrebusqueda'], '<b>'.$_POST['nombrebusqueda'].'</b>', $rs['nombre']);	
?>			
		<li onclick="seleccionar_add_certificado_venta_manual(<?php echo $rs['id_examen'].",'".$rs["id_examen"].' - '.$rs["titulo"]."','".$tipo_certificado."' "; ?>)"><?php echo $rs["id_examen"].' - '.$rs["titulo"].' - '.$tipo_certificado;?></li>
<?php		
	}
}else{
	echo '<li>'."No hay resultados".'</li>';
}

?>


