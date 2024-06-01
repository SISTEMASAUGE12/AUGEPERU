<?php $pagina='webinar';$pagina_2='webinar_3';
include('auten.php');   
$_SESSION["url"]='webinar'; // redireciona aui el registro 


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

include('inc/header-webinar-4.php');
?>

<main id="land" class="poppi webinar_3 ">    
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
			$curso = executesql(" SELECT c.*, ca.titulo as categoria, ca.titulo_rewrite AS catrewri, sc.titulo as subcategoria, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso INNER JOIN categorias ca ON csc.id_cat = ca.id_cat INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo WHERE c.estado_idestado = 1  and c.id_curso = '".$webinars[0]['id_curso']."' ORDER BY c.orden DESC ");
			
		
		/* GRACIAS: FECHA MENOR AL WEBINAR */
					include("inc/webinar_gracias_registro_w3.php");
			
			
		}else{ 
		/* SI NO EXISTE UNA SESSION DEL WEBINAR AUN, */
		
			/* en caso exista una sesion, la eliminamos para aperturar un nuevo registro */
			if(isset($_SESSION["webinar"]["rewrite"])){  
				unset($_SESSION["webinar"]);
			}
?>


<?php 
// $img_banner='background-image:url(tw7control/files/images/webinars/'.$webinars[0]['banner'].')';
$img_banner='img/banners/w4.png';
?>
<div  class="callout banners text-left  "><div class="fondo fondo3 " style="<?php echo $img_banner;?>"><div class="row rel">
		<div class="medium-12 columns">
			<!-- <img src="img/logo-rojo.png" class="rel " STYLE="z-index:99;"> -->
			<blockquote class=" poppi-b " style="background:<?php echo $webinars[0]['color_fondo_boton_link']; ?>;color:<?php echo $webinars[0]['color_boton_link']; ?>;"><?php echo $webinars[0]['etiqueta_registro_1']; ?></blockquote>
		</div>
		<div class="medium-10 medium-centered columns" style="float:none!important;">
			<div class=" titulo_principal poppi-sb text-center blanco ">
				<?php echo $webinars[0]['titulo_1']; ?>
			</div>
		</div>
		<div class="medium-6 medium data_principal registro text-center columns">
		<?php if(!empty( $webinars[0]['link_vimeo_formulario'])){  /* video trailer */ ?>
				<div class="rel lleva_vimeo_listado">
					<iframe src="	<?php echo $webinars[0]['link_vimeo_formulario']; ?>"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
				</div>
		<?php }else{ 
						$imgproduct= !empty($webinars[0]['imagen_1'])?'tw7control/files/images/webinars/'.$webinars[0]['imagen_1']:'img/no_imagen.jpg';
		?>
				<figure class="rel ">
					<img src="<?php echo $imgproduct ?>" class="principal ">
				</figure>
		<?php }  ?>				
		</div>

		<div class="medium-6 medium columns end ">
			<div class=" cuaro_1 poppi-sb blanco text-center ">
				<?php echo $webinars[0]['detalle_1']; ?>

				<a data-open="exampleModal1" class="poppi-b btn_cuadrado text-center "> <?php echo $webinars[0]['titulo_boton_action']; ?></a>
			</div>
		</div>	
	</div></div></div>
	



	
	<!-- *reveal -->
	<div class="reveal reveal_webinar_3 " id="exampleModal1" data-reveal>
		<div class="fond_reveal ">
			<form  method="post" enctype="multipart/form-data"><fieldset><div class="row text-left">
				<h3 class=" poppi text-center">
					<b>Ingresa tus datos para reservar tu cupo GRATUITO al <?php echo $webinars[0]['titulo']; ?></b>
					</br></br>
				</h3>
				<input type="hidden" required name="id_webinar" value="<?php echo $webinars[0]['id_webinar']; ?>" autocomplete="off">
				<input type="hidden" required name="rewrite" value="<?php echo $webinars[0]['titulo_rewrite']; ?>" autocomplete="off">
				<input type="hidden" required name="webinar" value="<?php echo $webinars[0]['titulo']; ?>" autocomplete="off">
				<div class="large-12 columns">
					<input type="text" required name="nombre_completo" placeholder="Nombre completo" autocomplete="off">
					<input type="text" required name="telefono" autocomplete="off" placeholder="Teléfono o Celular">
					<input type="email" required name="email" autocomplete="off" placeholder="Tu mejor correo">
				</div>
				<div class="large-12 text-center  columns">
					<a id="registro_al_webinar_3"  class="poppi boton btn_cuadrado pulse "> Registrarme GRATIS</a>
					<div class='hide monset pagoespera ' id='rptapago_w3'>Procesando ...</div>
				</div>	
			</div></fieldset></form>
		</div>
		<button class="close-button" data-close aria-label="Close modal" type="button">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
<!--  * end reveal -->

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