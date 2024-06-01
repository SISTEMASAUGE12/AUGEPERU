<?php 
$pagina='blog';
include('auten.php'); $_SESSION["url"]=url_completa(); 
$fecha=fecha_hora(2);

$tit="Eventos de Educacauge ";
$desss="";
$imgtit="";

$meta= array(
	'title' => $tit.'  | GRUPO AUGE ',
	'keywords' => $desss,
	'description' => $desss,
	'image' => $imgtit
);
	
include ('inc/header.php');
?>
<main id="blog" class=" _capacitaciones " >

	<div class="callout callout-1 lleva_eventos "><div class="row row3">

		<div class="large-4 medium-4 catego columns " >
			<div class=" opciones_eventos " >
				<h5 class="poppi-b color2 "> ¿Cuándo? </h5>

				<div class="separar">
					<a href="eventos" class="poppi-sb color1 "> Todas las fechas </a>
				</div>
				<div class="separar <?php echo ($_GET["rewrite"] == "esta_semana")?' active ':''; ?> ">
					<a href="eventos/esta_semana" class="poppi-sb color1 "> Esta semana </a>
				</div>
				<div class="separar <?php echo ($_GET["rewrite"] == "semana_sgte")?' active ':''; ?> ">
					<a href="eventos/semana_sgte" class="poppi-sb color1 "> Semana siguiente </a>
				</div>
				<div class="separar <?php echo ($_GET["rewrite"] == "mes")?' active ':''; ?> ">
					<a href="eventos/mes" class="poppi-sb color1 "> Este mes </a>
				</div>
			</div>
<!--
			<a class="bota">Leer más</a>
			-->
		</div>
		<div class="large-8 medium-8    columns">
			<h5 class=" poppi-sb color1  large-text-left text-center " >Conferencias Virtuales Gratuitas del Grupo Auge  </h5>
			<h3 class=" poppi-b color1  large-text-left text-center " > Próximas actividades  </h3>
			
<?php  if(isset($_GET['rewrite']) && !empty($_GET['rewrite'])){   ?>
			<?php include("listado_eventos_x_filtros.php"); ?>
<?php }else{ ?> 
			<div id="listado_eventos" class="load-content"><p class="text-center" style="padding:110px 0;">Espere mientras listado se va cargando...</p></div>
<?php } ?> 

		</div>
		<!-- 
		<div class="clearfix clearfix2"></div>
		-->
	</div></div>
</main>
<?php include ('inc/footer.php'); ?>