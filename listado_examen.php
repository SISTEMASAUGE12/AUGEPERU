<?php  // include('auten.php');

/** LISTADO DE EXAMENES PARA PAGINA DE VENTAS -- / */


$_POST['categoria']=$_GET['rewrite2'];

 
$sql = "SELECT c.*, ca.titulo as categoria, ca.titulo_rewrite AS catrewri 
FROM examenes c
INNER JOIN categoria_examenes ca ON c.id_cate = ca.id_cate
WHERE    c.estado_idestado = 1 and c.privacidad=3  ";


if(isset($_POST['categoria']) && !empty($_POST['categoria'])){
	
	$sql.=" AND ca.titulo_rewrite='".$_POST['categoria']."'  "; /* muestra cursos depenientes en categoria */
	
}
if(isset($_POST['busque']) && !empty($_POST['busque'])) $sql.=" AND (c.id_examen LIKE '%".$_POST['busque']."%' or c.titulo LIKE '%".$_POST['busque']."%' ) ";
$sql.="  ORDER BY c.orden ASC";

 // echo $sql; 
 
?>


<?php 
$respuesta=executesql($sql);
if( !empty($respuesta) ){ 
	foreach($respuesta as $detalles){
    $titulo=$detalles['titulo'];
    $imgproduct= !empty($detalles['imagen'])?'tw7control/files/images/capa/'.$detalles['imagen'] :'img/examen-generico.jpg';  /* mostramos la img pequeña */
    //$imgproduct= 'img/examen-generico.jpg';  /* mostramos la img pequeña */
?>

    <div class="large-4 medium-4 columns   end "><?php include("inc/examen.php") ?></div>
<?php
	}
	?>

<?php
	// echo '<div class="large-12 columns"><div class="pagination text-right" role="navigation" arial-label="Pagination">'.$paging->fetchNavegacion().'</div></div>';
	
}else echo '<p class="text-center osans color1" style="padding:110px 0;">No se encontro examen </p>'; ?>