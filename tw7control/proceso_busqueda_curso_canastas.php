<?php include ("auten.php");
$nombre = $_POST['nombrebusqueda'];//recibe el nombre a buscar

/*   c.id_tipo_curso=1  ==> tipo curso: generales; valida que no se listen cursos de especilidad   */ 
$sql="SELECT c.*, tp.titulo as tipo_curso FROM cursos c INNER JOIN tipo_cursos tp ON c.id_tipo=tp.id_tipo WHERE  c.id_tipo_curso=1 and c.estado_idestado=1 and ( c.titulo LIKE '%".$nombre."%' or c.codigo LIKE '%".$nombre."%' ) ORDER BY c.titulo ASC";

// echo $sql; 

$consulta=executesql($sql);

if($consulta){
	foreach ($consulta as $rs){
		// se remplaza el termino buscado por el nombre del producto traido de la base de datos (reemplza termino a negrita)
		$nombre = str_replace($_POST['nombrebusqueda'], '<b>'.$_POST['nombrebusqueda'].'</b>', $rs['nombre']);	
?>			
		<li onclick="set_item_search_datos_cli_canasta(<?php echo $rs["id_curso"].",'".$rs["titulo"]."','".$rs["tipo_curso"]."','".$rs["codigo"]."' "; ?>)"><?php echo $rs["codigo"].' - '.$rs["titulo"].' - '.$rs['tipo_curso'];?></li>
<?php		
	}
}else{
	echo '<li>'."No hay resultados".'</li>';
}

?>


