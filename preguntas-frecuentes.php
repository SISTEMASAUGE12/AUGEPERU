<?php include('auten.php');
$pagina = "preguntas_frecuentes";
$meta = array(
	'title' => 'Preguntas frecuentes | Educaauge.com ',
	'description' => ' '
);
include('inc/header.php');
$notimg = 'img/img1-no-disponible.jpg';

?>


<main id="preguntas_frecuentes" class="-interno">
	<?php
	// if (isset($_GET["rewrite"]) && !empty($_GET["rewrite"])) { ?>

		<div class="callout callout-4 poppi rel text-left">
			<div class="row texto ">
				<div class="medium-9 medium-centered columns ">

					<?php $categ = executesql("select * from preguntas_categorias where estado_idestado=1 order by titulo asc");
					
					if (!empty($categ)) {
					?>
						<div class="row ">
							<div class="large-6  medium-6 end  columns ">
								<span>Categoría: </span>
								<select name="album" id="album" onchange="javascript: window.location.href=this.value">
									<option value="" selected="selected"> -- Selecione categoría --</option>
									<?php foreach ($categ as $row) {  ?>
										<option value="<?php echo 'preguntas-frecuentes/' . $row["titulo_rewrite"] ?>"><?php echo $row["titulo"] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					<?php } ?>

					<?php
					$sql_ = "SELECT p.*, pc.titulo as categ FROM preguntas_frecuentes p INNER JOIN preguntas_categorias pc ON p.id_cat=pc.id_cat where p.estado_idestado=1 and pc.titulo_rewrite='" . $_GET["rewrite"] . "' order by p.orden desc ";
					// echo $sql_;
					$preguntas = executesql($sql_);
					?>

					<?php
					if (!empty($preguntas)) {
						$i = 1; ?>
						<h3 class="poppi-b color-1">Preguntas Frecuentes: <small><?php echo $preguntas[0]['categ']; ?></small> </h3>
						<ul class="accordion" data-accordion>

							<?php
							foreach ($preguntas as $pregunta) {
							?>
								<li class="accordion-item <?php echo ($i == 1) ? ' is-active  ' : ''; ?> " data-accordion-item>
									<!-- Accordion tab title -->
									<a href="#" class="accordion-title poppi-sb blanco ">
										<small><b>Pregunta #<?php echo $i; ?>.</b> <span class="float-right"> creado el: <?php echo $pregunta['fecha_registro']; ?> </span> </small></br>
										<?php echo $pregunta['titulo']; ?>
									</a>
									<!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
									<div class="accordion-content" data-tab-content>
										<div class="detalle poppi ">
											<?php echo $pregunta['descripcion'];; ?>
										</div>
									</div>
								</li>
								<!-- ... -->
							<?php $i++;
							} /* end for */
							?>

						</ul>
				</div>
			<?php
					} //else { /* sino exite */  ?>
				<!-- <h3 class="poppi-b color-1">Preguntas Frecuentes: <small><?php //echo $_GET['rewrite']; ?></small> </h3>
				<p class='poppi'>No se encontro info.. </p> -->
			<?php //} 		?>
			</div>
		</div>

	<?php //} 
	
	//else { /* listado de categorias */ ?>

		<?php
		//  include("inc/banners_portadas.php"); 
		?>
		<!-- <div class="callout banners callout-2   hide ">
			<div class="fondo banner-preguntas" style="background-color:#333;">
				<div class="capa" style="padding: 70px 10px 80px;height: 100%;">
					<div class="row">
						<div class="large-12 columns text-center">
							<h4 class="poppi-b color-blanco">¿Cómo podemos ayudarte?</h4>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="callout callout-5 poppi rel text-center ">
			<div class="row texto ">
				<div class="medium-11 medium-centered columns ">
					<h3 class="poppi-sb  color-1">¿Cómo podemos ayudarte? Ver todas las categorías</h3>
					<?php
					//$preguntas_categ = executesql("SELECT pc.* FROM preguntas_categorias pc where pc.estado_idestado=1 order by pc.orden desc ");
					//if (!empty($preguntas_categ)) {
						//$i = 1;
						//foreach ($preguntas_categ as $categ) {
					?>
							<div class="large-4 medum-6 poppi small-6 columns poppi  end ">
								<div class="contiene">
									<figure class="rel"><img src="tw7control/files/images/preguntas_categorias/<?php //echo $categ["imagen"]; ?>" class="verticalalignmiddle"></figure>
									<a class="boton " style="background:<?php //echo $categ["color"]; ?>" href="preguntas-frecuentes/<?php //echo $categ["titulo_rewrite"]; ?>">
										<?php //echo $categ["titulo_boton"]; ?>
									</a>
									<h2><?php //echo $categ["titulo"]; ?></h2>
								</div>
							</div>
					<?php //$i++;
						//} /* end for */
					//}
					?>
				</div>
			</div>
		</div> -->
	<?php //} ?>

</main>

<?php include('inc/footer.php'); ?>