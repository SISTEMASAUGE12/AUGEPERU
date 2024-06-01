<?php $pagina='webinar';
include('auten.php');   
// $_SESSION["url"]='webinar'; // redireciona aui el registro 


if(isset($_GET['rewrite']) && !empty($_GET['rewrite'])){
	
	$sql="SELECT * FROM webinars WHERE estado_idestado=1 and titulo_rewrite='".$_GET['rewrite']."' order by orden desc limit 0,1 ";
	$webinars = executesql($sql);
	if(!empty($webinars[0])){
		$tit=$webinars[0]["titulo_seo"].' | GRUPO AUGE ';
		$desss=$webinars[0]["detalle_1"];
		$imgtit='tw7control/files/images/webinars/'.$webinars[0]['imagen'];
		
		// /* sirve para reegistro de suscrito x webinar */
		// $_SESSION["url_webinar"]["id_webinar"]=$webinars[0]["id_webinar"]; // redireciona aui el registro 
		// $_SESSION["url_webinar"]["rewrite"]=$_GET["rewrite"]; // redireciona aui el registro 
		
		/* sirve para reegistro de suscrito x webinar */
		$_SESSION["data_webinar"]["etiqueta_infusion"]=$webinars[0]["etiqueta_infusion"]; // redireciona aui el registro 
		$_SESSION["data_webinar"]["id_webinar"]=$webinars[0]["id_webinar"]; // redireciona aui el registro 
		$_SESSION["data_webinar"]["rewrite"]=$_GET["rewrite"]; // redireciona aui el registro 

	}else{
		$tit="Webinar no encontrado | GRUPO AUGE ";
		$desss="";
		$imgtit="";
	}

	$meta= array(
		'title' => ''.$tit,
		'keywords' => $desss,
		'description' => $desss,
		'image' => $imgtit
	);
	
}else{ 	
	$meta = array(
			'title' => '	Webinar: | Grupo Auge',
			'description' => ''
	);
}

include('inc/header.php');

?>

<main id="land" class="poppi">    
<?php 
if( !empty($_GET["rewrite"]) ){ 

	// echo $_SESSION["suscritos"]["id_suscrito"].'=====>>';
	// echo $_SESSION["webinar"]["rewrite"].'=====>>';
	
	if( !empty($webinars) ){
		
		// if( isset($_SESSION["webinar"]) && !empty($_SESSION["webinar"])  && $_SESSION["webinar"]["rewrite"]==$_GET["rewrite"]){
		if( (isset($_SESSION["suscritos"]["id_suscrito"]) && $_SESSION["suscritos"]["id_suscrito"] > 0 ) && isset($_SESSION["webinar"]["rewrite"])  && $_SESSION["webinar"]["rewrite"]==$_GET["rewrite"]){
			/* tiene acceso al webinar */

			$hoy=fecha_hora(1);
			$hora_hoy=fecha_hora(0);

			/* DATA DEL CURSO Y PARA CARRITO DE COMPRA */
			$sql_gracias=" SELECT c.*, ca.titulo as categoria, ca.titulo_rewrite AS catrewri, sc.titulo as subcategoria, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso INNER JOIN categorias ca ON csc.id_cat = ca.id_cat INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo WHERE c.estado_idestado = 1  and c.id_curso = '".$webinars[0]['id_curso']."' ORDER BY c.orden DESC ";

		//			echo $sql_gracias;
		//	exit();

			$curso = executesql($sql_gracias);

				// echo "HOLA 	EN VIVO ";			
				include("inc/webinar_gracias_registro_w5.php");

			}else{ 
		/* SI NO EXISTE UNA SESSION DEL WEBINAR AUN, */
		
		
				// en caso exista una sesion, la eliminamos para aperturar un nuevo registro 
				if(isset($_SESSION["webinar"]["rewrite"])){  
					unset($_SESSION["webinar"]);
				}
						
				include('inc/data_webinar_5_curso.php');

				
?>


	
<?php 
		} /* end si no exite sesion webinar aun */
		
	}else{
		echo '<section class="callout text-center "><div class="row"><div class="large-12 columns" style="padding:190px 0;"> <h3 class="poppi-sb" style="padding-bottom:30px;"> Lo sentimos: webinar no encontrado .. </br></h3><a href="'.$url.'"><img src="img/logo_auge.png"></a></div> </div> </section>';
	}
}else{
	echo '<section class="callout text-center"><div class="row"> <div class="large-12 columns" style="padding:190px 0;"> <h3 class="poppi-sb" style="padding-bottom:30px;">Ingresa un enlace válido </h3><a href="'.$url.'"><img src="img/logo_auge.png"></a></div></div> </section>';
}
?>
</main>
<?php include ('inc/footer.php'); ?>