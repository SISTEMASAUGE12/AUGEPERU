<div class="row _contenido_banner ">
	<div class="large-6 medium-6 columns medium-text-left text-center blanco ">
		<?php /*
		<p class="poppi _solo_movil_portada "> AQUÍ INICIA TU CAMINO HACIA EL ÉXITO</p>
		<img src="img/iconos/subyado_banner.png" class=" _subrayado_banner   _solo_movil_portada  ">

		<h3 class="poppi bold color-blanco">
			<?php
			if ($pagina == "cursos") {
				echo "Compra online";
			} else if ($pagina == "testimonios") {
				echo "Testimonios";
			} else if ($pagina == "noso") {
				echo "Conócenos";
			} else if ($pagina == "docentes") {
				echo "Nuestros docentes";
			} else if ($pagina == "preguntas_frecuentes") {
				echo "Preguntas frecuentes  ";
			} else if ($pagina == "gru") {
				echo "Grupo de Facebook     ";
			} else if ($pagina == "politicas") {
				echo "Protección de datos personales   ";
			} else if ($pagina == "terminos") {
				echo " Terminos y condiciones ";
			} else {
				echo  $banner['titulo'];
			}
			?>

		</h3>
		
		<?php if (!empty($banner['descripcion'])) { ?>
			<img src="img/iconos/subyado_banner.png" class=" _subrayado_banner ">
			<p class="poppi "><?php echo $banner['descripcion'] ?></p>
		<?php } 
		
		
		*/
		?>



		<?php
		/* ocultado xq tebgo va en imagen 
		if (isset($_SESSION["suscritos"]["id_suscrito"]) and !empty($_SESSION["suscritos"]["id_suscrito"]) && empty($_GET['rewrite4'])) {		?>
			<div style="padding:40px 0 ;max-width:320px;">
				<a href="mis-cursos">
					<p class="nro_pedidos poppi-sb  boton botones wow pulse  " style="padding: 10px;color: #fff;border-radius: 8px;text-align:center;">Mis cursos comprados <img src="img/iconos/icono_click_banner.png"></p>
				</a>
			</div>
		<?php } else {  ?>

			<?php
			if (!isset($_SESSION["suscritos"]["id_suscrito"]) and empty($_SESSION["suscritos"]["id_suscrito"])) {
				if (!empty($banner['link'])) { ?>
					<a class="btn bold wow pulse  " href="<?php echo $banner['link'] ?>">
						<?php echo $banner['boton'] ?> 
						<img src="img/iconos/icono_click_banner.png">
						<img src="img/iconos/icono_click_banner_rojo.png" class=" _solo_movil_portada ">
					</a>
			<?php
				}
			}
			?>

		<?php }
		*/
		 ?>
		 
	</div>
	
	<div class=" large-4  medium-6  columns medium-text-right text-center blanco ">
		<?php include('inc/formulario_registro_banner.php'); ?>
	</div><!-- end l4 -->
</div>