
	<div class="descrip text-right medium-6 columns ">
			<span class="poppi-b blanco ">
				<?php echo $testi['titulo'] ?> 
				<small class="poppi blanco "><?php echo $testi['cargo']; ?></small>
			</span>
			<div class="poppi blanco "><?php echo short_name($testi['descripcion'],270); ?></div>
			<p class="poppi blanco  curso"></p>
			<!-- 
			-->
	</div>
	<div class="foto medium-6 columns rel">
		<figure  CLASS="rel">
		<?php if( !empty($testi["imagen"])){ ?>
			<img src="tw7control/files/images/testimonios/<?php echo $testi['imagen'] ?>" class="imagen_1" style="width:100%;">
				<?php if(!empty($testi["link"]) ){ ?>
			<a class="abs mpopup-02" href="<?php echo $testi['link'] ?>"><img src="img/iconos/ico-play.png" class="verticalalignmiddle"></a>
				<?php }?>
		
		<?php }elseif( !empty( $testi['link']) || empty( $testi['imagen']) ){  /* video trailer */ ?>
			<div class="rel lleva_vimeo_listado">
				<iframe src="	<?php echo $testi['link']; ?>"  frameborder="0"  allow="autoplay; fullscreen; picture-in-picture" allowfullscreen  width="884" height="497"></iframe>
				<a class="abs mpopup-02" href="<?php echo $testi['link'] ?>"><img src="img/iconos/ico-play.png" class="verticalalignmiddle"></a>
			</div>
		<?php }?>
		</figure>
	</div>
	
<!--
	<iframe src="https://player.vimeo.com/video/533883864?h=9d35236e19&color=ffffff&title=0&byline=0&portrait=0&badge=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>
	
-->