<div  class="callout banners text-left "><div class="fondo fondo3 " style="background-image:url(tw7control/files/images/webinars/<?php echo $webinars[0]['banner_2']; ?>);"><div class="row rel" style=" padding-bottom:25px;">
						<div class="medium-12  text-center columns"><img src="img/logo-rojo.png" class="rel " STYLE="z-index:99;"></div>
						<div class="medium-10 medium-centered columns">
							<h1 class="poppi-b  text-center">Hola 
								<?php echo (isset($_SESSION["suscritos"]["nombre"]) && !empty($_SESSION["suscritos"]["nombre"]) )?$_SESSION["suscritos"]["nombre"] : $perfil[0]["nombre"]; //$_SESSION["webinar"]["nombre"]; ?> ! 
								</br><small>¡Gracias por registrarte!</small>
							</h1>
						</div>
						<div class="medium-8 medium-centered data_principal text-center columns" style="float:none;">
							<?php if(!empty( $webinars[0]['link_gracias'])){  /* video trailer */ ?>
								<div class="rel lleva_vimeo_listado">
									<iframe src="	<?php echo $webinars[0]['link_gracias']; ?>"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
								</div>
								
							<?php }else if(!empty( $webinars[0]['link_externo'])){  /* video externo  */ 
												$imagen_ext=!empty( $webinars[0]['imagen_3'])?'tw7control/files/images/webinars/'.$webinars[0]['imagen_3']:'img/webinar_externo_1.jpg';
								?>
									<div class="ldata_principal text-center " style="float:none;">
										<div class="rel lleva_vimeo_listado" style="padding:60px 0 70px;">
											<h4 class="poppi-sb color1" style="padding-bottom:30px;"><?php echo $webinars[0]['texto_link_externo']; ?><h4>
											<!-- 
											<a href="<?php echo $webinars[0]['link_externo']; ?>"  target="_blank"><img src="<?php echo $imagen_ext; ?>"></a>
												-->
								<a href="<?php echo $webinars[0]['link_externo']; ?>" class="poppi-b " style="color:#00388a;" target="_blank"><?php echo $webinars[0]['link_externo']; ?> </a>
										</div>
									
							<?php }else{ 
											$imgproduct= !empty($webinars[0]['imagen_gracias'])?'tw7control/files/images/webinars/'.$webinars[0]['imagen_gracias']:'img/no_imagen.jpg';
							?>
								<figure class="rel ">
									<img src="<?php echo $imgproduct ?>" class="principal ">
								</figure>
							<?php } 

							
							include("inc/share_webinar_gracias.php");
							?>
						</div>
						
						<?php if( !empty($webinars[0]['pdf_1']) && !empty($webinars[0]['pdf_1_titulo']) ){   /* boton pdf */ ?> 
						<div class="large-12 text-center  columns" style="padding:15px 0 60px;">
							<a href="tw7control/files/images/webinars/<?php echo $webinars[0]['pdf_2']; ?>" class="poppi boton pulse btn_pdf "  target="_blank" style="margin:auto;" > 
								<?php echo $webinars[0]['pdf_2_titulo']; ?>
							</a>
						</div>
						<?php } ?>
				
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
	
					
					<div class="callout callout-testimonios  ingreso poppi "><div class="row">
								<?php $exitos=executesql(" select * from casos_de_exitos where estado_idestado=1 and link !='' order by orden desc ");
									if( !empty($exitos)){		
								?>
								<div class=" casos_exito text-center " >
									<h4 class="poppi-b  text-center "> <img src="img/iconos/ico-exito-azul.png" style="padding-right:10px;"> Casos de éxito </h4>
								
									<?php foreach( $exitos as $row ){		 ?>
										<?php if( !empty($row["imagen"])){ ?>
									<div class="large-3 medium-4 small-6  columns end " >
										<figure  CLASS="rel">
											<img src="tw7control/files/images/casos_de_exitos/<?php echo $row['imagen'] ?>" class="imagen_1" style="width:100%;">
												<?php if(!empty($row["link"]) ){ ?>
											<a class="abs mpopup-02" href="<?php echo $row['link'] ?>"><img src="img/iconos/ico-play-small.png" class="verticalalignmiddle"></a>
												<?php }?>

										</figure>
										<div class="lleva_name_testi"><p class="poppi texto ">	<?php echo $row['titulo']; ?> </p></div>
									</div>
										<?php } /* si registor un img  */ ?>
								<?php } /*for exitos */?>
									
								</div>
								<?php } /* si existe casos de exitos */?>
					</div></div>
	