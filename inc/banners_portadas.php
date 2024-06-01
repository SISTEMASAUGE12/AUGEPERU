<?php 
	$banner = executesql("SELECT * FROM banners where estado_idestado=1 order by orden desc  ",0);
	if(!empty($banner)){ 
 ?> 
	<div class="callout banners     " > 
				<div class=" lleva_imagen_fondo ">
					<figure>
						<img src="tw7control/files/images/banners/<?php echo $banner["imagen"]; ?>" class="imagen_banner_fondo _mostrar_solo_pc ">
						<img src="tw7control/files/images/banners/<?php echo $banner["imagen2"]; ?>" class="imagen_banner_fondo  _mostrar_solo_movil ">
					</figure>
				</div>
				<?php  include("inc/banners_portadas_contenido.php"); ?>

	</div>  <!-- end banner  PC -->

<?php /* ?>
	<div class="callout banners  _mostrar_solo_movil  _en_portada_no_mostrar " > 
		<ul class="no-bullet hide  " id="carousel-1-movil">
			<div class="esperando-slider fondo banner-1"></div>
	<?php  foreach($ban as $banner){ ?>		
			<li class=" fondo   "  style=" background-image: url(tw7control/files/images/banners/<?php echo $banner["imagen2"]; ?> ">
				<?php  include("inc/banners_portadas_contenido.php"); ?>
			</li>
	<?php }   // END FOR ?> 
		</ul>
	</div>  <!-- end banner   MOVIL -->


<?php 
		*/

}	 // end banner ?>			
