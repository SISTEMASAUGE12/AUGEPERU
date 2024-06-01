<?php 
	$ban = executesql("SELECT * FROM banners where estado_idestado=1 order by orden desc  ");
	if(!empty($ban)){ 
 ?> 
	<div class="callout banners  _mostrar_solo_pc  " > 
		<ul class="no-bullet hide  " id="carousel-1">
			<div class="esperando-slider fondo banner-1"></div>
	<?php  foreach($ban as $banner){ ?>		
			<li class=" fondo   "  style=" background: url(tw7control/files/images/banners/<?php echo $banner["imagen"]; ?> ">
				<?php  include("inc/banners_portadas_contenido.php"); ?>
			</li>
	<?php }   // END FOR ?> 
		</ul>
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
