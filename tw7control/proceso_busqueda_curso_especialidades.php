<?php include ("auten.php");
$nombre = $_POST['nombrebusqueda'];//recibe el nombre a buscar

echo $sql="SELECT c.*, tp.titulo as tipo_curso, sub.titulo as subcategoria  
				FROM cursos c 
				INNER JOIN categoria_subcate_cursos  csc ON c.id_curso=csc.id_curso  
				INNER JOIN subcategorias sub  ON csc.id_sub=sub.id_sub   
				INNER JOIN tipo_cursos tp ON c.id_tipo=tp.id_tipo 
				WHERE  c.id_tipo_curso =2 and c.estado_idestado=1 and c.titulo LIKE '%".$nombre."%' 
				ORDER BY c.titulo ASC";
$consulta=executesql($sql);

if($consulta){
	foreach ($consulta as $rs){
		// se remplaza el termino buscado por el nombre del producto traido de la base de datos (reemplza termino a negrita)
		$nombre = str_replace($_POST['nombrebusqueda'], '<b>'.$_POST['nombrebusqueda'].'</b>', $rs['nombre']);	
?>			
		<li onclick="set_item_search_datos_cli(<?php echo $rs["id_curso"].",'".$rs["titulo"]."','".$rs["tipo_curso"]."' "; ?>)"><?php echo $rs["titulo"].' - '.$rs['tipo_curso'];?></li>
<?php		
	}
}else{
	echo '<li>'."No hay resultados".'</li>';
}

?>


