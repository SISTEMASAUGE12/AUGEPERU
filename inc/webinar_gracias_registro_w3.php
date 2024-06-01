				<div  class="callout banners text-left _paso_2 "><div class="fondo fondo3 " style="background-image:url(tw7control/files/images/webinars/<?php echo $webinars[0]['banner_2']; ?>);"><div class="row rel" style=" padding-bottom:25px;">
						<div class="medium-12  text-center columns">
							<figure><img src="img/logo-rojo.png" class="rel " STYLE="z-index:99;padding-bottom:15px;"></figure>
							<figure><img src="img/iconos/w_paso_2.svg" class="rel " STYLE="z-index:99;padding-bottom:35px;"></figure>
						</div>
						<div class="medium-10 medium-centered columns" style="float:none;">
							<h3 class="poppi-b color-w3 paso_2 text-center">PASO 2 </h3>
							<h1 class="poppi-b  blanco text-center _paso_2 "><?php echo $webinars[0]['titulo_gracias']; ?> </h1>
							<figure class="text-center"><a href="<?php echo $webinars[0]['gracias_link_wsp']; ?>" target="_blank">
								<img src="img/iconos/wasap_w3.svg">
							</a></figure>
							<p class="blanco poppi text-center">Si tienes alguna duda o necesitas información adicional, no dudes en contactarnos:</p>
							<div class="row blanco poppi ">
								<div class="medium-6 columns text-center  medium-text-right">
									<img src="img/iconos/wspf.png" style="height:50px;padding:0 10px;"> <?php echo $webinars[0]['gracias_cel']; ?>
								</div>
								<div class="medium-6 columns text-center medium-text-left ">
									<img src="img/iconos/email.png" style="height:40px;padding:0 10px;" ><?php echo $webinars[0]['gracias_email']; ?>
								</div>
							</div>
						</div>
				</div></div></div>
					
					<?php
					//  include('inc/cronometro.php'); 
					 ?>
					
	<section class="callout callout-5  poppi "><div class="row">
		<div class="medium-10 medium-centered columns animatedParent text-center">
			<!--
			<h4 class="poppi-sb "><?php echo $webinars[0]['callout_5_texto_1']; ?></h4>
						-->
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
					
	<div class="callout callout-testimonios  ingreso poppi "><div class="row">
				<?php $exitos=executesql(" select * from casos_de_exitos where estado_idestado=1 and link !='' order by orden desc ");
					if( !empty($exitos)){		
				?>
				<div class=" casos_exito text-center " >
					<h4 class="poppi-b  text-center "> Lo que dicen de nuestros programas</h4>
				
					<?php foreach( $exitos as $row ){		 ?>
						<?php if( !empty($row["imagen"])){ ?>
					<div class="large-3 medium-4 small-6  columns end " >
						<figure  CLASS="rel">
							<img src="tw7control/files/images/casos_de_exitos/<?php echo $row['imagen'] ?>" class="imagen_1" style="width:100%;">
								<?php if(!empty($row["link"]) ){ ?>
							<a class="abs mpopup-02" href="<?php echo $row['link'] ?>"><img src="img/iconos/ico-play-small.png" class="verticalalignmiddle"></a>
								<?php }?>

						</figure>
						<div class="lleva_name_testi text-center "><p class="poppi texto  text-center ">	<?php echo $row['titulo']; ?> </p></div>
					</div>
						<?php } /* si registor un img  */ ?>
				<?php } /*for exitos */?>
					
				</div>
				<?php } /* si existe casos de exitos */?>
	</div></div>
	
	<div  class="callout banners text-left _paso_2 "><div class="fondo fondo3 " style="background-image:url(tw7control/files/images/webinars/<?php echo $webinars[0]['banner_2']; ?>);padding-top:50px;"><div class="row rel" style=" padding-bottom:25px;">

			<div class="medium-8 medium-centered columns" style="float:none;">
				<h1 class="poppi-b  blanco text-center _paso_2 ">No olvides unirte a nuestro grupo de WhatsApp para completar tu registro</h1>
				<figure class="text-center"><a href="<?php echo $webinars[0]['gracias_link_wsp']; ?>" target="_blank">
					<img src="img/iconos/wasap_w3.svg">
				</a></figure>				
	</div></div></div>
				

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
