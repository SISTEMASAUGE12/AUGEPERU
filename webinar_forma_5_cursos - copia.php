<?php $pagina='webinar';
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
			$curso = executesql(" SELECT c.*, ca.titulo as categoria, ca.titulo_rewrite AS catrewri, sc.titulo as subcategoria, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso INNER JOIN categorias ca ON csc.id_cat = ca.id_cat INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo WHERE c.estado_idestado = 1  and c.id_curso = '".$webinars[0]['id_curso']."' ORDER BY c.orden DESC ");

				// echo "HOLA 	EN VIVO ";			
				include("inc/webinar_gracias_registro_w5.php");

			}else{ 
		/* SI NO EXISTE UNA SESSION DEL WEBINAR AUN, */
		
				/* en caso exista una sesion, la eliminamos para aperturar un nuevo registro */
				if(isset($_SESSION["webinar"]["rewrite"])){  
					unset($_SESSION["webinar"]);
				}
?>
<div  class="callout banners text-left "><div class="fondo fondo3 " style="background-image:url(tw7control/files/images/webinars/<?php echo $webinars[0]['banner']; ?>);"><div class="row rel">
		<div class="medium-12 columns">
			<img src="img/logo-rojo.png" class="rel " STYLE="z-index:99;">
		</div>
		<div class="medium-10 medium-centered columns" style="float:none!important;">
			<h3 class="poppi-b  text-left color2 " style="padding:95px 0 0;line-height:20px;"><?php echo $webinars[0]['ante_titulo']; ?></h3>
			<h1 class="poppi-b  text-center" style="padding-top:10px;"><?php echo $webinars[0]['titulo_1']; ?></h1>
		</div>
		<div class="medium-7 medium data_principal registro text-center columns">
		<!--
			<p class=" poppi text-left"><?php echo $webinars[0]['detalle_1']; ?></p>
			<?php if( !empty($webinars[0]['imagen_1']) ){  ?> 
					<img src="tw7control/files/images/webinars/<?php echo $webinars[0]['imagen_1']; ?>">
			<?php } ?>
			-->
			
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
		<div class="medium-5 medium columns end ">
			<div class="fond">
				<form  method="post" enctype="multipart/form-data"><fieldset><div class="row text-left">
					<h3 class=" poppi text-center"><b>
							<?php echo !empty($webinars[0]['titulo_formulario'])?$webinars[0]['titulo_formulario']:'¿Deseas recibir más información?'; ?>
						</b></br>
					</h3>
						<input type="hidden" required name="id_webinar" value="<?php echo $webinars[0]['id_webinar']; ?>" autocomplete="off">
						<input type="hidden" required name="rewrite" value="<?php echo $webinars[0]['titulo_rewrite']; ?>" autocomplete="off">
						<input type="hidden" required name="webinar" value="<?php echo $webinars[0]['titulo']; ?>" autocomplete="off">
<!--				
					<div class="large-12 columns">
						<input type="text" required name="nombre_completo" placeholder="Nombre completo" autocomplete="off">
					</div>
					<div class="large-12 columns">
						<input type="text" maxlength="12" autocomplete="off" onkeypress="javascript:return soloNumeros(event,0);" name="telefono" required placeholder="Teléfono / celular">
					</div>
					<div class="large-12 columns">
							<select id="tipo" name="tipo" class="form-control" required > 
								<option value="1" >NOMBRADO</option>  
								<option value="2" >CONTRATADO</option>
							</select>
					</div>
					<div class="large-12 columns"><input type="email" required name="email" autocomplete="off" placeholder="Correo"></div>
	-->
	<!--
					<div class="large-12 text-center  columns">
						<a href="registro" class="poppi boton pulse "> ¡Sí, quiero participar!</a>
						<div class='hide monset pagoespera ' id='rptapago'>Procesando ...</div>
					</div>
					-->
					
					<div class="large-12 columns">
						<input type="text" required name="nombre_completo" placeholder="Nombre completo" autocomplete="off">
						<!-- 
						<input type="text" required name="telefono" id="telefono" autocomplete="off"  onkeypress="javascript:return soloNumeros(event,0);" max-lenght="9" min-lenght="9" placeholder="Teléfono o Celular">
						-->
						<input type="tel" required name="telefono" id="telefono" autocomplete="off"    maxlength="9" minlength="9"    placeholder="Teléfono o Celular">

						<input type="email" required name="email" autocomplete="off" placeholder="Correo">
						<div class="g-recaptcha" data-sitekey="6LfUxLcdAAAAAHwBF9sOotrRnU1zOQpETNnSENXH"></div>
						<script src='https://www.google.com/recaptcha/api.js?hl=es'></script>
					</div>
					<div class="large-12 text-center  columns">
						<a id="registro_al_webinar_2"  class="poppi boton pulse "> 
							<?php echo !empty($webinars[0]['boton_formulario'])?$webinars[0]['boton_formulario']:'¡Si quiero recibir más información!'; ?>
						</a>
						<div class='hide monset pagoespera ' id='rptapago_w2'>Procesando ...</div>
					</div>
					
				</div></fieldset></form>
			</div>
		</div>	
	</div></div></div>
	
	<?php include('inc/cronometro.php'); ?>

	<section class="callout callout-data-1  poppi "><div class="row">
		<div class="medium-4 columns animatedParent"><div class="cuad animated fadeInUpShort">
				<div><img src="img/iconos/ico-webinar.png"></div>
				<div><p class="color1 nunitob"><?php echo $webinars[0]['etiqueta_registro_1']; ?><small class="color1 nunito"><?php echo $webinars[0]['etiqueta_registro_2']; ?></small></p></div>
		</div></div>
		<div class="medium-4 columns animatedParent"><div class="cuad animated fadeInUpShort">
				<div><img src="img/iconos/ico-fecha.png"></div>
				<div><p class="color1 nunitob"><?php echo $webinars[0]['fecha_en_texto']; ?><small class="color1 nunito"><?php echo $webinars[0]['hora_en_texto']; ?></small></p></div>
		</div></div>
		<div class="medium-4 columns animatedParent"><div class="cuad animated fadeInUpShort">
		<?php  
			$img_pon=!empty($webinars[0]['imagen_ponente'])?'tw7control/files/images/webinars/'.$webinars[0]['imagen_ponente']:'img/iconos/ico-ponente.png';
		?>
				<div><img src="<?php echo $img_pon; ?>"></div>
				<div><p class="color1 nunitob"><?php echo $webinars[0]['encargado_webi']; ?><small class="color1 nunito">Ponente</small></p></div>
		</div></div>
	</div></section>
	
	
	<section class="callout callout-1  poppi " style="padding-bottom:90px;" ><div class="row">
		<article class=" medium-12 columns  text-center">
			<h4 class="poppi "><?php echo $webinars[0]['titulo_2']; ?></h4>
		<!-- 
			-->
		</article>
		<article class=" medium-6 columns  text-left">
		<!-- 
				<h3 class="color-5 poppi-sb text-left"><?php echo $webinars[0]['titulo_2']; ?></h3>
				-->
				<div class="poppi detalle"><?php echo $webinars[0]['detalle_2']; ?></div>		
		</article>
		<article class="medium-6 columns text-center ">
			<?php if( !empty($webinars[0]['imagen_2']) ){  ?> 
							<figure>	<img src="tw7control/files/images/webinars/<?php echo $webinars[0]['imagen_2']; ?>"></figure>	
			<?php } ?>
		</article>
		
		<!-- 
			<?php if( !empty($webinars[0]['pdf_1']) && !empty($webinars[0]['pdf_1_titulo']) ){  ?> 
		<div class="large-12 text-center  columns" style="padding:50px 0 100px;">
			<a href="tw7control/files/images/webinars/<?php echo $webinars[0]['pdf_1']; ?>" class="poppi boton pulse btn_pdf_webinar  btn_pdf "  target="_blank" style="margin:auto;"  > 
				<?php echo $webinars[0]['pdf_1_titulo']; ?>
			</a>
		</div>
			<?php } ?>
			-->
	</div></section> 
	
	
	<!-- secciones adminsitrables -->
	
<?php $pestañas=executesql("select * from pestanhas_webinars_inicios where estado_idestado=1 and id_webinar='".$webinars[0]['id_webinar']."' ORDER by orden asc "); 
if( !empty($pestañas) ){ $i=1;
	foreach( $pestañas as $row){ 
		$i++;	
		$img="tw7control/files/images/webinars/".$webinars[0]['id_webinar']."/".$row['imagen'];
		
		if($i ==2 ){
?>
<!-- pestañas landing -->
<div class="callout callout-3   poppi  "><div class="row"><div class="large-12 columns ">
	<div class="medium-6 columns  lleva_data_right ">
		<h3 class="poppi-sb "><?php echo $row["titulo"]; ?></h3>
		<div class="poppi desc_detalle "><?php echo $row["descripcion"]; ?></div>
	</div>
	<div class="medium-6 text-center columns ">
		<?php if(!empty($row["titulo"])){  ?>
		<figure class="rel" ><img src="<?php echo $img; ?>"></figure>
	<?php } ?>
	</div>
</div></div></div>
<?php 		$i=0;
			}else{  /* INMG I<QUIERDA  */ ?>
			
<div class="callout callout-3  daforma poppi  "><div class="row"><div class="large-12 columns ">
	<div class="medium-6  text-center columns ">
		<?php if(!empty($row["titulo"])){  ?>
		<figure class="rel" ><img src="<?php echo $img; ?>"></figure>
	<?php } ?>
	</div>
	<div class="medium-6 columns lleva_data_left ">
		<h3 class="poppi-sb "><?php echo $row["titulo"]; ?></h3>
		<div class="poppi desc_detalle "><?php echo $row["descripcion"]; ?></div>
	</div>
</div></div></div>		
			
<?php } 
}} /* end pestañas inicio  **/
?>
	<!-- end secciones adminsitrables -->
	<!-- end secciones adminsitrables -->
	

	
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