<div  class="callout banners text-left "><div class="fondo fondo3 " style="background-image:url(tw7control/files/images/webinars/<?php echo $webinars[0]['banner']; ?>);"><div class="row rel">
							<div class="medium-12 columns">
								<img src="img/logo-rojo.png" class="rel " STYLE="z-index:99;">
							</div>
							<div class="medium-10 medium-centered columns">
								<h1 class="poppi-b  text-center">Hola <?php echo $perfil[0]["nombre"]; //$_SESSION["webinar"]["nombre"]; ?>! </br><small>Bienvenido al Grupo AUGE</small></h1>
							</div>
							
		<?php if(!empty( $webinars[0]['link_externo'])){  /* video externo  */ 
						$imagen_ext=!empty( $webinars[0]['imagen_3'])?'tw7control/files/images/webinars/'.$webinars[0]['imagen_3']:'img/webinar_externo_1.jpg';
		?>
									<div class="large-12 large-centered medium-10 medium-centered  data_principal text-center columns" style="float:none;">
										<div class="rel lleva_vimeo_listado" style="padding:60px 0 70px;">
											<!-- 
											<a href="<?php echo $webinars[0]['link_externo']; ?>"  target="_blank"><img src="<?php echo $imagen_ext; ?>"></a>
								-->
								<a href="<?php echo $webinars[0]['link_externo']; ?>"  target="_blank"><?php echo $webinars[0]['link_externo']; ?> </a>
										</div>
										<?php include("inc/share_webinar_mas_wsp.php"); ?>
									</div>
								
								<?php }else if(!empty( $webinars[0]['link_video'])){  /* video trailer */ ?>
									<div class="  <?php echo !empty($webinars[0]['link_chat'])?'medium-8 ':' medium-12 ';?>   medium data_principal text-center columns">
										<div class="rel lleva_vimeo_listado">
											<iframe src="<?php echo $webinars[0]['link_video']; ?>"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
										</div>
										<?php include("inc/share_webinar_mas_wsp.php"); ?>
									</div>
									
								<?php }else{ 
												$imgproduct= !empty($webinars[0]['imagen_3'])?'tw7control/files/images/webinars/'.$webinars[0]['imagen_3']:'img/no_imagen.jpg';
								?>
									<div class="medium-12  medium data_principal text-center columns">
										<figure class="rel ">
											<img src="<?php echo $imgproduct ?>" class="principal ">
										</figure>
										<?php include("inc/share_webinar_mas_wsp.php"); ?>
									</div> <!-- * este ciere de div-->
								<?php }  ?>
								
								
							<?php  
							if( !empty($webinars[0]['link_chat']) ){ 
							?>
							<div class="medium-4 medium columns">
								<div class="fond"><iframe src="	<?php echo $webinars[0]['link_chat']; ?>"  frameborder="0" class="lleva_chat_vimeo" allow="autoplay; fullscreen" allowfullscreen></iframe></div>
							</div>
							<?php } 
							
							?>
							
							
						<?php if( !empty($webinars[0]['pdf_1']) && !empty($webinars[0]['pdf_1_titulo']) ){   /* boton pdf */ ?> 
							<div class="large-12 text-center  columns" style="padding:50px 0;">
								<a href="tw7control/files/images/webinars/<?php echo $webinars[0]['pdf_1']; ?>" class="poppi boton pulse btn_pdf_webinar  btn_pdf "  target="_blank" style="margin:auto;"  > 
									<?php echo $webinars[0]['pdf_1_titulo']; ?>
								</a>
							</div>
								<?php } ?>
							
							
							<?php   /* boton ersonalizado */ 
							if( !empty($webinars[0]['titulo_boton_link']) &&  !empty($webinars[0]['link_boton_2']) ){ 
									$stiles_boton_bg='';
									$stiles_boton='';
									
									if( !empty($webinars[0]['color_fondo_boton_link']) ){ 
										$stiles_boton_bg= "background:".$webinars[0]['color_fondo_boton_link'].";";
									}
									if(  !empty($webinars[0]['color_boton_link']) ){ 
										$stiles_boton= "color:".$webinars[0]['color_boton_link'].";";
									}
									
							?>
							<div class="large-12 text-center  columns" style="padding:50px 0;">
								<a href="<?php echo $webinars[0]['link_boton_2']; ?>" class="poppi boton pulse "  target="_blank" style="margin:auto;<?php echo $stiles_boton_bg.$stiles_boton; ?>"  > 
									<?php echo $webinars[0]['titulo_boton_link']; ?>
								</a>
							</div>
							<?php } ?>
							
							

							
					</div></div></div>
					<div class="callout callout-1  ingreso poppi "><div class="row">
							<section class="social contenido medium-10 medium-centered  columns" style="float:none;">										
								<h6 class="osans" style="padding-top:30px;"><b>FORO:</b></h6>         
								<div class="fb-comments" data-href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" data-width="800" data-numposts="15"></div>
							</section>

					</div></div></div>

		