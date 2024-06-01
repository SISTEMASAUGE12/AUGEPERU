<?php 
	// $ruta="curso";
	// if($_GET['rewrite']=='todos-los-libros' || $_GET['rewrite']=='libros'){
	
	// }
?>
<div class="curso-list  list_categoría ">
<?php    
		if( !empty( $detalles['imagen']) ){ ?>
    <figure class="rel ">
			<img src="<?php echo $imgproduct ?>" class="principal ">
	<?php if(!empty( $detalles['link_video'])){  /* video trailer */ ?>
			<a class="abs mpopup-03 " href="detalle/<?php echo $detalles['titulo_rewrite'] ; ?>"><img src="img/iconos/ico-play-small.png" class="verticalalignmiddle"></a>
	<?php }  ?>
		</figure>
<?php }elseif(!empty( $detalles['link_video'])){  /* video trailer */ ?>
						<div class="rel lleva_vimeo_listado">
								<iframe src="<?php echo $detalles['link_video']; ?>"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
						</div>
<?php }  ?>

    <div class="deta">
        <h2 class="color1 poppi _categorias_name "><?php echo $titulo ?></h2>
        <p class="texto poppi-l"><?php echo short_name($detalles['detalle'],111) ?></p>
				
        <div class="lleva_botones_curso">
					<a href="<?php echo $link ?>" class="boton poppi-sb">Ver <?php echo $ruta.'s'; ?></a>					
        </div>
    </div>
</div>