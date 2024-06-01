<?php include('auten.php');  $_SESSION["url"]=url_completa(); 
$pagina='cesta';

require("class/Carrito.class.php");
$carrito = new Carrito();

$meta = array(
    'title' => ' Gracias por tu compra| AugePerú.com',
    'description' => ''
);
include ('inc/header-cesta.php');

?>
<main id="cesta">
	<div class="callout banners callout-1"><div class="fondo fondo-cesta"><div class="row">

		<div class="large-8 large-centered text-center  columns"><div class="confi">
			<div class=" radius">
				
				<h3 class="poppi-sb " style="padding-top:100px;"> Gracias por tu  compra .. </h3>			
				<figure><img src="img/gracias-por-tu-compra.jpg"></figure>
				<p class="poppi-sb color1" style="padding:30px ;"> Inicia sesión para disfrutar de tus cursos en <?php echo $dominio;  ?> </p>			
				<a href="mis-cursos" class=" boton poppi-sb " style="margin:auto auto 80px;"> Ir a mis cursos</a>
			</div>
		</div></div>
		
	</div></div></div>
</main>
<?php include ('inc/footer.php'); ?>