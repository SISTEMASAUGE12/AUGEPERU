<?php include ("auten.php");
$nombre = $_POST['nombrebusqueda'];//recibe el nombre a buscar

if( $_SESSION["visualiza"]["idtipo_usu"] ==4){

	/*
 $sql_consulta="SELECT s.*, esp.titulo as id_especialidad FROM suscritos s INNER JOIN especialidades esp ON s.id_especialidad=esp.id_especialidad 
WHERE (s.dni LIKE '%".$nombre."%'  or  s.email LIKE '%".$nombre."%' ) 
			and s.idusuario='".$_SESSION["visualiza"]["idusuario"]."'
ORDER BY s.nombre ASC";


*/

$sql_consulta="SELECT s.*, esp.titulo as id_especialidad FROM suscritos s INNER JOIN especialidades esp ON s.id_especialidad=esp.id_especialidad 
WHERE (s.dni LIKE '%".$nombre."%'  or  s.email LIKE '%".$nombre."%' ) ORDER BY s.nombre ASC";


}else{
$sql_consulta="SELECT s.*, esp.titulo as id_especialidad FROM suscritos s INNER JOIN especialidades esp ON s.id_especialidad=esp.id_especialidad WHERE s.dni LIKE '%".$nombre."%'  or  s.email LIKE '%".$nombre."%' ORDER BY s.nombre ASC";
	
}

// echo $sql_consulta;

$consulta=executesql($sql_consulta);

if($consulta){
	foreach ($consulta as $rs){
		// se remplaza el termino buscado por el nombre del producto traido de la base de datos (reemplza termino a negrita)
		$nombre = str_replace($_POST['nombrebusqueda'], '<b>'.$_POST['nombrebusqueda'].'</b>', $rs['nombre']);	
?>			
		<li onclick="set_item_search_datos_cli(<?php echo $rs["id_suscrito"].",'".$rs["dni"]." / ".$rs["nombre"]." ".$rs["ap_pa"]." ".$rs["ap_ma"]."','".$rs["email"]."','".$rs["telefono"]."',".$rs["estado_idestado"]." ,'".$rs["id_especialidad"]."' ,'".$rs["dni"]."' "; ?>)"> <?php echo $rs["dni"]." / ".$rs["nombre"]." ".$rs["ap_pa"]." ".$rs["ap_ma"]." / ".$rs["email"]." / ".$rs["telefono"];?></li>
<?php		
	}
}else{
	echo '<li>'."No hay resultados, o pertenece a otro vendedor ".'</li>';
}

?>


