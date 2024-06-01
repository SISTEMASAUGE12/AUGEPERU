<div  class="callout banners curso_gratis text-left "><div class="fondo fondo3 " style="background-image:url(tw7control/files/images/landing_gratis/<?php echo $landing_gratis[0]['banner']; ?>);"><div class="row rel">
	<div class="medium-12  text-center columns">
	<!-- 
		<img src="img/logo-rojo.png" class="rel " STYLE="z-index:99;">
		-->
		<img src="img/paso_2_gratis.svg" class="rel " STYLE="z-index:99;">
	</div>
	<div class="medium-10 medium-centered columns">
		<h1 class="poppi-b  text-center">
			<small>PASO 2</small> </br>
			Únete a nuestro grupo de WhatsApp para completar tu registro y recibir notificaciones del curso
		</h1>
	</div>
	<div class="medium-8 medium-centered data_principal text-center columns" style="float:none;">
		<?php if(!empty( $landing_gratis[0]['link_gracias'])){  /* video trailer */ ?>
			<div class="rel lleva_vimeo_listado">
				<iframe src="	<?php echo $landing_gratis[0]['link_gracias']; ?>"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
			</div>
		<?php }else{ 
						$imgproduct= !empty($landing_gratis[0]['imagen_gracias'])?'tw7control/files/images/landing_gratis/'.$landing_gratis[0]['imagen_gracias']:'img/no_imagen.jpg';
		?>
			<figure class="rel ">
				<img src="<?php echo $imgproduct ?>" class="principal ">
			</figure>
		<?php }  
	
	/* link wasap curso */
	$curso=executesql("select * from cursos where estado_idestado=1 and id_curso='".$landing_gratis[0]['id_curso']."' ");
	if(!empty($curso[0]['link_grupo_wasap']) ){ ?>
		<li class="text-center " style="list-style:none;">
			<a href="<?php echo $curso[0]['link_grupo_wasap']; ?>"  class="unete_wsp" target="_blank">
				<img src="img/iconos/unete_wasap.png">
			</a>
		</li>
	<?php } ?>
	
	
	</div>
</div></div></div>


<?php  if(!empty($landing_gratis[0]['titulo_gracias']) ){ ?>
<div  class="callout callout-azul text-left "><div class="row rel"><div class="medium-12  text-center columns">
	<p class="poppi-sb blanco "><?php echo $landing_gratis[0]['titulo_gracias']; ?></p>
</div></div></div>
<?php } ?>

<div  class="callout callout-gracias-1 text-center "><div class="row rel"><div class=" large-12 columns ">
	<h3 class="poppi-sb ">MI REGALO</h3>
	<?php 
	$imgproduct_2= !empty($landing_gratis[0]['banner_2'])?'tw7control/files/images/landing_gratis/'.$landing_gratis[0]['banner_2']:'img/no_imagen.jpg';
		?>
			<figure class="rel ">
				<img src="<?php echo $imgproduct_2 ?>" class="principal ">
			</figure>
		
</div></div></div>


<?php $agenda=executesql("select * from silabos_landing_gratis where estado_idestado=1 and id_curso='".$landing_gratis[0]['id_curso']."' "); 
if( !empty($agenda) ){ 
?>
<div  class="callout callout-agenda text-left "><div class="row rel">
	<h3 class="poppi-sb text-center ">Agenda del Curso</h3>
	<div class=" large-9 large-centered  columns " style="float:none;">
	
<?php foreach($agenda as $data_agenda){ ?>	
	<div class=" large-12 linea_content columns ">
		<div class="large-4 medium-4 columns ">
			<?php 	$img_agenda= !empty($data_agenda['imagen'])?'tw7control/files/images/silabos_landing_gratis/'.$data_agenda['imagen']:'img/no_imagen.jpg'; ?>
			<figure class="rel ">
				<img src="<?php echo $img_agenda ?>" class="principal ">
			</figure>
		</div>

		<div class="large-8 medium-8 columns  ">
			<div class=" borde_contiene ">
				<h2 class="poppi-b"><?php echo $data_agenda['titulo']; ?></h2>
				<p class=" poppi-sb"><?php echo $data_agenda['descripcion']; ?></p>
			</div>
		</div>
	</div>
<?php }  /* end for agenda */  ?> 	
	
	</div>
</div></div>
<?php } /* end if agenda */?> 


<div  class="callout callout-gracias-1 text-left "><div class="row rel"><div class=" large-12 columns ">
	<h3 class="poppi-sb text-center ">Certificado de Asistencia</h3>
	
	<div class="medium-6 columns ">
		<p><?php echo $landing_gratis[0]['titulo_2']; ?></p>
	</div>

	<div class="medium-6 columns ">
		<?php 
		$imgproduct_2= !empty($landing_gratis[0]['imagen_2'])?'tw7control/files/images/landing_gratis/'.$landing_gratis[0]['imagen_2']:'img/no_imagen.jpg';
			?>
				<figure class="rel ">
					<img src="<?php echo $imgproduct_2 ?>" class="principal ">
				</figure>
	</div>
</div></div></div>


<?php if(!empty($curso[0]['link_grupo_wasap']) ){ ?>	
<div  class="callout callout-azul text-center "><div class="row rel"><div class="medium-12  text-center columns">
	<p class="poppi-sb blanco ">Únete a nuestro grupo de Whatsapp para completar tu registro y recibe novedades y avisos sobre el curso</p>
	<li class="text-center " style="list-style:none;">
		<a href="<?php echo $curso[0]['link_grupo_wasap']; ?>"  class="unete_wsp" target="_blank">
			<img src="img/iconos/unete_wasap.png">
		</a>
	</li>
</div></div></div>
<?php } ?>


<?php if( !empty($landing_gratis[0]['imagen_3']) ){ ?>
<div  class="callout banners curso_gratis text-left "><div class="fondo fondo_final " style="background-image:url(tw7control/files/images/landing_gratis/<?php echo $landing_gratis[0]['imagen_3']; ?>);"><div class="row rel"><div class="medium-12  text-center columns">

</div></div></div>
<?php } ?>