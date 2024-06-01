<?php include('auten.php');
$pagina='noso';
$meta = array(
    'title' => 'Error Usuario ',
    'description' => ''
);
unset($_SESSION["suscritos"]);
unset($_SESSION["url_webinar"]);
unset($_SESSION["webinar"]);
include ('inc/header.php');
?>
<main id="nosotros">
	<div class="callout callout-1" style="padding:80px 0 100px"><div class="row">
		<div class="large-6 large-centered medium-10 medium-centered text-center columns">
			<h1 class="poppi-b color1" style="background:transparent;margin:0">OTRO USUARIO LOGUEADO</h1>
			<p class="texto poppi">Se reporta que otro usuario esta conectado con esta cuenta.</p>
			<a href="" style="margin:30px auto 0" class="boton">IR A INICIO</a>
		</div>
	</div></div>
</main>
<?php include ('inc/footer.php'); ?>