<?php 
// $pagina='cursos';
$pagina='trafico';

include('auten.php'); 
$_SESSION["url"]=url_completa(); 
	
	// if($_GET['rewrite']=='todos-los-libros' || $_GET['rewrite']=='libros'){
		// $ruta="Libros";
		// $text_titulo="Venta de Libros para docentes ";
	// }else{
		$ruta="Cursos";
		$text_titulo="Cursos de capacitación para docentes";
	// }
	
if(isset($_GET['rewrite4']) && !empty($_GET['rewrite4'])){ 
  $sql="SELECT * FROM cursos WHERE estado_idestado=1 and titulo_rewrite='".$_GET['rewrite4']."' order by orden desc  ";
  $rs = executesql($sql);
  if(!empty($rs)){
    $tit=$rs[0]["titulo"];
    $desss=$rs[0]["breve_detalle"];
    $imgtit='tw7control/files/images/capa/'.$rs[0]['imagen'];
  }else{
    $tit="  ";
    $desss="";
    $imgtit="";
  }	

  $meta= array(
		'title' => $tit.' | Cursos | GRUPO AUGE ',
		'keywords' => $desss,
		'description' => $desss,
		'image' => $imgtit
	);
    
}else{
  $meta= array('title' =>$text_titulo.' | GRUPO AUGE ',
	'keywords' =>'AUGE Perú Construyendo el camino a la Revolución Educativa.La filosofía que inspiró la fundación de la Asociación Universitaria de Gestión Emprendedora – Perú (AUGE Perú); se orienta a la búsqueda de la verdad científica y a la preparación de profesionales altamente capacitados, con cultura humanística y criterios de permanente actualización y superación.',
	'description' =>'AUGE Perú Construyendo el camino a la Revolución Educativa.La filosofía que inspiró la fundación de la Asociación Universitaria de Gestión Emprendedora – Perú (AUGE Perú); se orienta a la búsqueda de la verdad científica y a la preparación de profesionales altamente capacitados, con cultura humanística y criterios de permanente actualización y superación.');
}

include('inc/header_solo_logo.php'); 
?>
<main id="curso" class="<?php echo (isset($_GET['rewrite4']) && !empty($_GET['rewrite4']))?' dentro_detalle_curso ':''; ?>  ">

<?php
if(isset($_GET['rewrite4']) && !empty($_GET['rewrite4'])){
//DETALLE DEL CURSO
	include("detalle_cursos_trafico.php");
	
// LISTADO GENERAL DE CURSOS
}else{ 
// Si no existe Rewrite _ LIstamos Cursos
	// include('inc/listado_todos_los_cursos.php'); 
	echo "No se encontro información.. ";
}

?>
</main>
<?php 
$pagina="trafico";  /* para ocultar footer */
include('inc/footer.php'); ?>