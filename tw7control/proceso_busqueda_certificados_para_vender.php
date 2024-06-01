<?php include ("auten.php");
$nombre = $_POST['nombrebusqueda'];//recibe el nombre a buscar

$sql="SELECT c.* FROM certificados c 
		INNER JOIN certificados_x_cursos cxc ON c.id_certificado = cxc.id_certificado 
		WHERE c.estado_idestado=1 and  (c.id_certificado LIKE '%".$nombre."%' or c.titulo LIKE '%".$nombre."%' or cxc.id_curso LIKE '%".$nombre."%' ) ORDER BY c.titulo ASC";
$consulta=executesql($sql);

if($consulta){
	foreach ($consulta as $rs){
		$tipo_certificado= ($rs["id_tipo"] == '1')?'GENERAL':'ESPECIALIDAD';
		// se remplaza el termino buscado por el nombre del producto traido de la base de datos (reemplza termino a negrita)
		$nombre = str_replace($_POST['nombrebusqueda'], '<b>'.$_POST['nombrebusqueda'].'</b>', $rs['nombre']);	
?>			
		<li onclick="seleccionar_add_certificado_venta_manual(<?php echo $rs['id_certificado'].",'".$rs["id_certificado"].' - '.$rs["titulo"]."','".$tipo_certificado."' "; ?>)"><?php echo $rs["id_certificado"].' - '.$rs["titulo"].' - '.$tipo_certificado;?></li>
<?php		
	}
}else{
	echo '<li>'."No hay resultados".'</li>';
}

?>


