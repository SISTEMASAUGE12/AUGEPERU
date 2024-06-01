<?php 
	$banner = executesql("SELECT * FROM banners where estado_idestado=1 order by orden desc  ",0);
	if(!empty($banner)){ 
 ?> 
	<div class="callout banners     " > 
				<div class=" lleva_imagen_fondo ">
					<?php  foreach($banner as $banners){ ?>		
						<img src="tw7control/files/images/banners/<?php echo $banners["imagen"]; ?>" class="imagen_banner_fondo _mostrar_solo_pc ">
						<img src="tw7control/files/images/banners/<?php echo $banners["imagen2"]; ?>" class="imagen_banner_fondo  _mostrar_solo_movil ">
				<?php  include("inc/banners_portadas_contenido.php"); }?>
			

	</div>  <!-- end banner  PC -->

	<?php 
	}
 ?> 			
