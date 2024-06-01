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

include('inc/header.php');
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
			
			if(fecha_hora(1) == $webinars[0]['fecha_inicio'] && $hora_hoy >= $webinars[0]['hora_inicio'] ){
				/* FECHA DEL WEBINAR */
				// echo "HOLA 	EN VIVO ";
				include("inc/webinar_hoy.php");

		/* CARTAS:  FECHA MAYOR AL WEBINAR */
			// }else if(fecha_hora(1) > $webinars[0]['fecha_inicio'] || $webinars[0]['acabo_webinar_en_vivo']==1 ){  /* si paso a la fecha o si marcaron que ya acabo */
				
			// 	$_SESSION["url"]='cesta';  // aca mando para que compre , xq webianr envivo ya paso 	
			// 	include('inc/webinar_data_compra_para_carrito.php'); /* para vender el curso  */
				
			// 	if($webinars[0]['activar_carta_2']=='2'){
			// 		include('inc/webinar_curso_corto.php');
					
			// 	}else{ /* activar_carta_2==1 : carta larga.  */
			// 		include('inc/webinar_carta_larga.php');	
			// 	}  /* end webinar carta _ larga. */
				
		/* GRACIAS: FECHA MENOR AL WEBINAR */
			}else{
		/* GRACIAS: FECHA MENOR AL WEBINAR */
					include("inc/webinar_gracias_registro_w3.php");
			} /* END SI YA SE LOGEO */ 
			
			
		}else{ 
		/* SI NO EXISTE UNA SESSION DEL WEBINAR AUN, */
		
			/* en caso exista una sesion, la eliminamos para aperturar un nuevo registro */
			if(isset($_SESSION["webinar"]["rewrite"])){  
				unset($_SESSION["webinar"]);
			}
?>

<div  class="callout banners text-left  "><div class="fondo fondo3 " style="background-image:url(tw7control/files/images/webinars/<?php echo $webinars[0]['banner']; ?>);"><div class="row rel">
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
	
	<?php if(!empty( $webinars[0]['img_callout_1'])){  
		$img_call_1= !empty($webinars[0]['img_callout_1'])?'tw7control/files/images/webinars/'.$webinars[0]['img_callout_1']:'img/no_imagen.jpg';
		$img_call_1_m= !empty($webinars[0]['img_callout_1_m'])?'tw7control/files/images/webinars/'.$webinars[0]['img_callout_1_m']:'img/no_imagen.jpg';
	?>
		<section class="callout callout-0  poppi "><div class="row">
			<div class="medium-9 medium-centered columns animatedParent text-center ">
				<figure class=" img_pc "><img src="<?php echo $img_call_1 ?>"></figure>
				<figure class=" img_movil "><img src="<?php echo $img_call_1_m ?>"></figure>
			</div>
		</div></section>
	<?php }  ?>	



	<section class="callout callout-1  poppi "><div class="row">
		<div class="medium-12 columns animatedParent text-center ">
			<a data-open="exampleModal1" class="poppi-b btn_cuadrado text-center "><?php echo $webinars[0]['titulo_boton_action']; ?></a>
		</div>
	</div></section>
	
	
	<section class="callout callout-2  poppi "><div class="row">
			<article class=" medium-6 columns  text-left">
				<h4 class="poppi-sb "><?php echo $webinars[0]['titulo_2']; ?></h4>
				<div class="lleva_sudbrayado"><div class="sudbrayado"></div></div>
				<div class="poppi detalle"><?php echo $webinars[0]['detalle_2']; ?></div>		
			</article>
		<article class="medium-6 columns text-center ">
			<?php if( !empty($webinars[0]['imagen_2']) ){  ?> 
				<figure>	<img src="tw7control/files/images/webinars/<?php echo $webinars[0]['imagen_2']; ?>"></figure>	
			<?php } ?>
		</article>
		
			<?php if( !empty($webinars[0]['pdf_1']) && !empty($webinars[0]['pdf_1_titulo']) ){  ?> 
		<div class="large-12 text-center  columns" style="padding:50px 0;">
			<a href="tw7control/files/images/webinars/<?php echo $webinars[0]['pdf_1']; ?>" class="poppi boton pulse btn_pdf_webinar  btn_pdf "  target="_blank" style="margin:auto;"  > 
				<?php echo $webinars[0]['pdf_1_titulo']; ?>
			</a>
		</div>
			<?php } ?>				
		</div></section> 
		

	<section class="callout callout-3  poppi "><div class="row">
		<div class="medium-10 medium-centered columns animatedParent">
			<?php if( !empty($webinars[0]['img_callout_3']) ){  ?> 
				<figure class=" img_pc text-center ">	<img src="tw7control/files/images/webinars/<?php echo $webinars[0]['img_callout_3']; ?>"></figure>	
			<?php } ?>
			<?php if( !empty($webinars[0]['img_callout_3_m']) ){  ?> 
				<figure class=" img_movil text-center ">	<img src="tw7control/files/images/webinars/<?php echo $webinars[0]['img_callout_3_m']; ?>"></figure>	
			<?php } ?>

			<p class="text-center "><?php echo $webinars[0]['callout_3_texto_1']; ?> </p>
			<p class=" _borde text-center "><?php echo $webinars[0]['callout_3_texto_2']; ?></p>
			
		</div>
	</div></section>

	<section class="callout callout-4  poppi "><div class="row">
		<div class="medium-10 medium-centered columns animatedParent text-center">
			<h4 class="poppi-sb "><?php echo $webinars[0]['callout_4_texto_1']; ?></h4>
			<?php if( !empty($webinars[0]['img_callout_4']) ){  ?> 
				<div class="medium-6  columns animatedParent">
					<figure class="  ">
						<img src="tw7control/files/images/webinars/<?php echo $webinars[0]['img_callout_4']; ?>">
					</figure>
				</div>
			<?php } ?>

			<?php if( !empty($webinars[0]['img_callout_4_2']) ){  ?> 
				<div class="medium-6  columns animatedParent">
					<figure class="  ">
						<img src="tw7control/files/images/webinars/<?php echo $webinars[0]['img_callout_4_2']; ?>">
					</figure>
				</div>
			<?php } ?>
<!--
			<img src="img/w/muchomas.svg">
			-->
		</div>
	</div></section>
	
	<section class="callout callout-5  poppi "><div class="row">
		<div class="medium-10 medium-centered columns animatedParent text-center">
			<h4 class="poppi-sb "><?php echo $webinars[0]['callout_5_texto_1']; ?></h4>
			<p class="poppi "><?php echo $webinars[0]['callout_5_texto_2']; ?></p>

			<?php if( !empty($webinars[0]['img_callout_5']) ){  ?> 
			<div class="medium-6  columns animatedParent medium-text-right">
				<figure class="  "><img src="tw7control/files/images/webinars/<?php echo $webinars[0]['img_callout_5']; ?>"></figure>
			</div>
			<?php } ?>

			<?php if( !empty($webinars[0]['img_callout_5_2']) ){  ?> 
			<div class="medium-6  columns animatedParent  medium-text-left">
				<figure class="  "><img src="tw7control/files/images/webinars/<?php echo $webinars[0]['img_callout_5_2']; ?>"></figure>
			</div>
			<?php } ?>

		</div>
	</div></section>

	
	<section class="callout callout-6  poppi "><div class="row">
		<div class="medium-10 medium-centered columns animatedParent text-center">
			<h4 class="poppi-sb "> <?php echo $webinars[0]['callout_6_texto_1']; ?></h4>
			<p class="poppi text_intro "><?php echo $webinars[0]['callout_6_texto_2']; ?> </p>
		
		<?php $exponentes=executesql("select * from webinars_x_expositores where id_webinar='".$webinars[0]['id_webinar']."' and estado_idestado=1 "); 
			if(!empty($exponentes)){ 

				// echo count($exponentes);
				if(count($exponentes) == 1){
					$value=" medium-5 medium-centered ";
					$_float="style='float:none;'";
				}elseif(count($exponentes) == 2){
					$value=" medium-6  ";
					$_float="";
				}elseif(count($exponentes) == 3){
					$value=" large-4  medium-6 ";
					$_float="";
				}elseif(count($exponentes) > 3){
					$value=" large-3 medium-6 ";
					$_float="";
				}
				
				foreach($exponentes as $row){ 
		?>
			<div class=" <?php echo $value; ?> columns animatedParent text-center end " <?php echo $_float; ?>>
				<figure class="  "><img src="tw7control/files/images/webinars/<?php echo $row["id_webinar"];?>/<?php echo $row["imagen"];?>"></figure>
				<h2 class=" poppi-sb "><?php echo $row['titulo']; ?></h2>
				<div class=" poppi _profe "><?php echo $row['descripcion']; ?></div>
			</div>
		<?php }} ?>
			
		</div>
	</div></section>
	
	<section class="callout callout-7  poppi "><div class="row">
		<div class="medium-10 medium-centered columns animatedParent text-center">
			<h4 class="poppi-sb "> <?php echo $webinars[0]['callout_7_texto_1']; ?></h4>
			<p class="poppi "> <?php echo $webinars[0]['callout_7_texto_2']; ?></p>
			<div class="medium-12  columns animatedParent medium-text-right">
				<?php if( !empty($webinars[0]['img_callout_7']) ){  ?> 
					<figure class=" img_pc "><img src="tw7control/files/images/webinars/<?php echo $webinars[0]['img_callout_7']; ?>"></figure>
				<?php } ?>
				
				<?php if( !empty($webinars[0]['img_callout_7_2']) ){  ?> 
					<figure class=" img_movil "><img src="tw7control/files/images/webinars/<?php echo $webinars[0]['img_callout_7_2']; ?>"></figure>
				<?php } ?>
					
			</div>
		</div>
	</div></section>

<?php include("inc/webinar_3_callout_8.php"); ?>

<?php $pestanas=executesql("select * from pestanhas_webinars_inicios where id_webinar='".$webinars[0]['id_webinar']."' and estado_idestado=1 "); 
	if(!empty($pestanas)){ 
?>
	<section class="callout callout-9  poppi "><div class="row">
		<?php foreach($pestanas as $linea){ ?>
		<div class="medium-12 _contenido medium-centered columns animatedParent text-center"><div class="row">
			<div class="large-4 medium-5   columns animatedParent medium-text-left text-center ">
				<h4 class="poppi-sb  "><?php echo $linea['titulo']; ?></h4>
			</div>
			<div class="large-8 medium-7  columns animatedParent text-left">
				<div class="_detalle ">
				<?php echo $linea['descripcion']; ?>
				</div>
			</div>
		</div></div>
		<?php }  ?>
	</div></section>
	<?php } /* end pestañas */ ?>
	
	<section class="callout callout-1  poppi "><div class="row">
		<div class="medium-12 columns animatedParent text-center ">
			<h4 class="poppi-sb blanco ">	<?php echo $webinars[0]['titulo_boton_action_2']; ?></h4>
			<a data-open="exampleModal1" class="poppi-b btn_cuadrado text-center "> <?php echo $webinars[0]['titulo_boton_action_3']; ?></a>
		</div>
	</div></section>
	
	<?php include("inc/webinar_3_callout_8.php"); ?>

	<?php $exitos=executesql(" select * from casos_de_exitos where estado_idestado=1 and link !='' order by orden desc ");
		if( !empty($exitos)){		
	?>
	<section class="callout callout-10  poppi "><div class="row">
		<div class="medium-12 columns animatedParent text-center ">
			<h4 class="poppi-sb  ">	Lo que dicen de nuestros programas</h4>
		</div>
	
		<?php foreach( $exitos as $row ){		 ?>
		<?php if( !empty($row["imagen"])){ ?>
		<div class="large-4 medium-6 columns animatedParent text-center end ">
				<figure  CLASS="rel">
				<img src="tw7control/files/images/casos_de_exitos/<?php echo $row['imagen'] ?>" class="imagen_1" style="width:100%;">
					<?php if(!empty($row["link"]) ){ ?>
				<a class="abs mpopup-02" href="<?php echo $row['link'] ?>"><img src="img/iconos/ico-play-small.png" class="verticalalignmiddle"></a>
					<?php }?>

			</figure>
			<blockquote class="poppi-sb  "><?php echo $row['titulo']; ?></blockquote>
			<!-- 
			<p class="poppi  ">Luis Carlos es un experto en lanzamientos digitales, un referente.</p>
					-->
		</div>
		<?php } } ?>
		
		<!-- 
		<div class="large-4 medium-6 columns animatedParent text-center end ">
			<div class="lleva_video">
				<iframe title="vimeo-player" src="https://player.vimeo.com/video/610406819?h=41a9e288d5" width="640" height="640" frameborder="0" allowfullscreen></iframe>
			</div>
			<blockquote class="poppi-sb  ">Luis Carlos Flores</blockquote>
			<p class="poppi  ">Luis Carlos es un experto en lanzamientos digitales, un referente.</p>
		</div>
				-->
	</div></section>
	<?php } /* si existe casos de exitos */?>


	<section class="callout callout-1  poppi "><div class="row">
		<div class="medium-12 columns animatedParent text-center ">
			<blockquote class="poppi-sb blanco ">	<?php echo $webinars[0]['titulo_boton_action_2']; ?></blockquote>
			<a data-open="exampleModal1" class="poppi-b btn_cuadrado text-center "><?php echo $webinars[0]['titulo_boton_action_3']; ?></a>
		</div>
	</div></section>

	<section class="callout callout-11  poppi "><div class="row">
		<div class="medium-5 columns animatedParent text-center ">
			<figure style=" padding-bottom:40px; "><img src="img/logo.png"></figure>
		</div>
		<div class="medium-7 columns animatedParent text-center ">
			<ul>
				<li><a href="https://www.youtube.com/c/GRUPOAUGECapacitaci%C3%B3nDocente" target="_blank"><img src="img/iconos/yt.png"></a>	</li>
				<li><a href="https://www.facebook.com/www.augeperu.org" target="_blank"><img src="img/iconos/fb.png"></a>	</li>
			<!-- 
				<li><a href="" target="_blank"><img src="img/iconos/instagram-01.png"></a>	</li>
				-->
			</ul>
		</div>
		<div class="medium-12 columns animatedParent text-center ">
			<p class="blanco ">Copyright © GRUPO AUGE <?php echo date('Y');?> -Todos los derechos reservados</br>
					educaauge.com
			</p>
		</div>
	</div></section>
	
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