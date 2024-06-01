<?php  
$pagina='cursos';
include('auten.php'); 
$_SESSION["url"]=url_completa(); 
	
	if($_GET['rewrite']=='todos-los-libros' || $_GET['rewrite']=='libros'){
		$ruta="Libros";
		$text_titulo="Venta de Libros para docentes ";
	}else{
		$ruta="Cursos";
		$text_titulo="Cursos de capacitación para docentes";
	}
	
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
    
	$pagina='detalle_curso';

}else{
  $meta= array('title' =>$text_titulo.' | GRUPO AUGE ',
	'keywords' =>'AUGE Perú Construyendo el camino a la Revolución Educativa.La filosofía que inspiró la fundación de la Asociación Universitaria de Gestión Emprendedora – Perú (AUGE Perú); se orienta a la búsqueda de la verdad científica y a la preparación de profesionales altamente capacitados, con cultura humanística y criterios de permanente actualización y superación.',
	'description' =>'AUGE Perú Construyendo el camino a la Revolución Educativa.La filosofía que inspiró la fundación de la Asociación Universitaria de Gestión Emprendedora – Perú (AUGE Perú); se orienta a la búsqueda de la verdad científica y a la preparación de profesionales altamente capacitados, con cultura humanística y criterios de permanente actualización y superación.');
}

include('inc/header.php'); 
?>
<main id="curso" class="<?php echo (isset($_GET['rewrite4']) && !empty($_GET['rewrite4']))?' dentro_detalle_curso ':''; ?>  <?php if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){ echo "logeado"; }?> ">

<?php
if(isset($_GET['rewrite4']) && !empty($_GET['rewrite4'])){
//DETALLE DEL CURSO

// valido si exite sesion y si el alumno ya  compro este curso. 
	if(isset($_SESSION["suscritos"]["id_suscrito"]) and !empty($_SESSION["suscritos"]["id_suscrito"]) ){ 
//Validamos suscripcion al curso
		$valido_suscrito=executesql("select * from suscritos_x_cursos where id_tipo=1 and estado!=3 and estado_idestado=1 and id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."' and id_curso='".$rs[0]["id_curso"]."' ");
		if(!empty($valido_suscrito)){
			// redireccionamos al perfil vista del contenido de curso. ..
			$cadena='perfil/mis-cursos/'.$rs[0]["titulo_rewrite"];		
			echo '<script type="text/javascript"> location.href="'.$cadena.'";</script>';// redirecciono al curso_detalle_clases; 
		
	// Si el suscrito no compro  este curso, muestro detalle 
		}else{ //Si el suscrito no esta en este curso 
			include("detalle_cursos.php");
		} 
		
	}else{ // validacion si NO exite sesion alumnos
			include("detalle_cursos.php");
	}
	
// LISTADO GENERAL DE CURSOS
}else{ 
// Si no existe Rewrite _ LIstamos Cursos
	include('inc/listado_todos_los_cursos.php'); 
}

?>
</main>
<?php include('inc/footer.php'); ?>