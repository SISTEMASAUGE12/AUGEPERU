<?php  // include('auten.php');
$_POST['tipa']=$_GET['rewrite'];
$_POST['categoria']=$_GET['rewrite2'];
$_POST['subcategoria']=isset($_GET['rewrite3']) ? $_GET['rewrite3'] : '';
// $_POST['busque']=$_GET['buscar'];
 
$sql = "SELECT c.*, ca.titulo as categoria, ca.titulo_rewrite AS catrewri, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso 
FROM cursos c
INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso
INNER JOIN categorias ca ON csc.id_cat = ca.id_cat
INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub
INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo
WHERE    c.estado_idestado = 1 and c.visibilidad=1 and c.id_tipo_curso=1 ";


if( $_GET['rewrite2'] == "gratis" ){
	$sql.= "  and c.id_tipo=4  and c.id_tipo_curso=1 ";   // listado solo de generales 
}else{
	$sql.= " and  c.id_tipo=1 and c.precio > 0  ";

}


// WHERE  ".( $_GET['rewrite2']=="gratis")?" c.id_tipo=4   ":" c.id_tipo=1   ". " and  c.estado_idestado = 1 and c.visibilidad=1 and c.precio > 0   ";


if(isset($_POST['tipa']) && !empty($_POST['tipa']) && ($_POST['tipa']!='todos')) $sql.=" AND tc.titulo_rewrite='".$_POST['tipa']."'";
if(isset($_POST['categoria']) && !empty($_POST['categoria'])){
	
	if( $_POST['categoria']=="packs"){
		$sql.=" AND cursos_dependientes !='' ";
	
	}else if( $_POST['categoria']=="gratis"){  // no aplico filtro por categoria;  muetro todos los gratuitos 
		$sql.="   ";

	}else{	
		// $sql.=" AND ca.titulo_rewrite='".$_POST['categoria']."' AND cursos_dependientes ='' "; /* no muestra cursos dependietes en la categoria */ 
		$sql.=" AND ca.titulo_rewrite='".$_POST['categoria']."'  "; /* muestra cursos depenientes en categoria */
	}
}
if(isset($_POST['subcategoria']) && !empty($_POST['subcategoria'])) $sql.=" AND sc.titulo_rewrite='".$_POST['subcategoria']."'";
if(isset($_POST['busque']) && !empty($_POST['busque'])) $sql.=" AND (c.codigo LIKE '%".$_POST['busque']."%' or c.titulo LIKE '%".$_POST['busque']."%' ) ";

// $sql.=" Group BY c.id_curso ORDER BY c.orden DESC";
$sql.="  ORDER BY c.orden DESC";

  // echo $sql; 
 
?>


<?php 
$respuesta=executesql($sql);
if( !empty($respuesta) ){ 
	foreach($respuesta as $detalles){
    $titulo=$detalles['titulo'];
    $link='curso/'.$detalles['tiprewri'].'/'.$detalles['catrewri'].'/'.$detalles['subrewri'].'/'.$detalles['titulo_rewrite'];
    $imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen'];  /* mostramos la img pequeña */
    // $imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen2'];
?>

    <div class="large-4 medium-4 columns   end "><?php include("inc/curso.php") ?></div>
<?php
	}
	?>
	<!-- 
		<script >
			    // Magnific Popup
			if($('.mpopup-01').length){ $('.mpopup-01').magnificPopup({ type : 'image', delegate : 'a', gallery : { enabled:true } }); }
			if($('.mpopup-02').length){ $('.mpopup-02').magnificPopup({ type : 'iframe' }); } /* efecto ventana emergente ara video*/
			$('.mpopup-03').magnificPopup({ type : 'ajax' });//emergente
		</script>
		<script src="js/carrito.js"></script>
		-->

<?php
	// echo '<div class="large-12 columns"><div class="pagination text-right" role="navigation" arial-label="Pagination">'.$paging->fetchNavegacion().'</div></div>';
	
}else echo '<p class="text-center osans color1" style="padding:110px 0;">No se encontro curso</p>'; ?>