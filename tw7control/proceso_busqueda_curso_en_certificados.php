<?php include ("auten.php");
$nombre = $_POST['nombrebusqueda'];//recibe el nombre a buscar

$sql="SELECT c.*, tp.titulo as tipo_curso FROM cursos c INNER JOIN tipo_cursos tp ON c.id_tipo=tp.id_tipo WHERE  c.id_tipo=1 and id_tipo_curso=1 and (c.codigo LIKE '%".$nombre."%' or c.titulo LIKE '%".$nombre."%' ) ORDER BY c.titulo ASC";
$consulta=executesql($sql);

if($consulta){
	foreach ($consulta as $rs){
		// se remplaza el termino buscado por el nombre del producto traido de la base de datos (reemplza termino a negrita)
		$nombre = str_replace($_POST['nombrebusqueda'], '<b>'.$_POST['nombrebusqueda'].'</b>', $rs['nombre']);	
?>			
		<li onclick="seleccionar_add_curso_venta_manual(<?php echo $rs['id_curso'].",'".$rs["codigo"].' - '.$rs["titulo"]."','".$rs["tipo_curso"]."' "; ?>)"><?php echo $rs["codigo"].' - '.$rs["titulo"].' - '.$rs['tipo_curso'];?></li>
<?php		
	}
}else{
	echo '<li>'."No hay resultados".'</li>';
}

?>


