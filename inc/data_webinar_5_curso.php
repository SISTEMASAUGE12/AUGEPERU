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
						<input type="hidden" required name="link_rewrite" value="capacitate/<?php echo $webinars[0]['titulo_rewrite']; ?>" autocomplete="off">
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
	
