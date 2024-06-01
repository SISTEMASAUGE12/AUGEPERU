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
													
							?>
						</div>
						

						<div id="compi" style="padding-top:50px;" >
						<!-- 
								<div class="float-  text-center ">
									<a href="https://educaauge.com/augeperu-telegram/" target="_blank">
										<p class="poppi-sb  "    style="background: #EE0005 !important;color: #fff;padding: 15px;border-radius:20px;" >Unete a nuestro grupo exclusivo de TELEGRAM </br> para que no te pierdas ninguna de nuestras </br>conferencias, allí te enviaremos el link de acceso a</br> nuestras  conferencias GRATUITAS</p>
										<img src="img/unete_telegram_1.png">
									</a>
								</div>
								<?php 
										// echo '-->'.$curso[0]["link_grupo_wasap"];
										if( !empty($curso[0]["link_grupo_wasap"]) ){ /* se muestra boton wsp, si el curso tiene un link registrado::: */ ?>
								<div class=" text-center ">
									<a href="<?php echo $curso[0]["link_grupo_wasap"]; ?>" target="_blank">
										<img src="img/iconos/unete_wasap_2.png">
									</a>
								</div>
								<?php } ?>
							-->
								
								<figure class="text-center"><a href="<?php echo $webinars[0]['gracias_link_wsp']; ?>" target="_blank">
									<img src="img/iconos/wasap_w3.svg">
								</a></figure>

								
								<ul class="no-bullet poppi float-right color1" style="padding-top:60px;">
										<li class="poppi"><em style="display:inline-block;padding-right:10px;">Compartir: </em> 
										<a title="Twitter" href="javascript: void(0);" onclick="window.open('https://twitter.com/intent/tweet?text=&url='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/twitter-b.png"></a> <a title="Facebook" href="javascript: void(0);" onclick="window.open('http://www.facebook.com/sharer.php?u='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/face-b.png"></a> <a title="Telegram" href="javascript: void(0);" onclick="window.open('https://telegram.me/share/url?url='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/telegram-b.png"></a> <a href="https://api.whatsapp.com/send/?phone&text=<?php echo 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" target="_blank"><img src="img/iconos/wsp-b.png" style="margin-top:;"></a></li>
								</ul>
						</div>


						<!-- 
						<?php if( !empty($webinars[0]['pdf_1']) && !empty($webinars[0]['pdf_1_titulo']) ){   /* boton pdf */ ?> 
						<div class="large-12 text-center  columns" style="padding:15px 0 60px;">
							<a href="tw7control/files/images/webinars/<?php echo $webinars[0]['pdf_2']; ?>" class="poppi boton pulse btn_pdf "  target="_blank" style="margin:auto;" > 
								<?php echo $webinars[0]['pdf_2_titulo']; ?>
							</a>
						</div>
						<?php } ?>
						-->

					</div></div></div>
					
					<?php // include('inc/cronometro.php'); ?>

					<script>
						setTimeout(function () {
							console.log("redirecion a wsp ");
							location.href='<?php echo $webinars[0]['gracias_link_wsp']; ?>';
						}, 6000); //msj desparece en 5seg.
					</script>
				
					
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
	