<?php include('auten.php');  $_SESSION["url"]=url_completa(); 
$pagina='cesta';

require("class/Carrito.class.php");
$carrito = new Carrito();

$meta = array(
    'title' => ' Llámanos gratis a nuestro número | Educaauge.com',
    'description' => ''
);
include ('inc/header-cesta.php');
?>

<style>
	header .float-right{display:none;}
</style>

<main id="cesta">
	<div class="callout banners     " > 
		<div class=" lleva_imagen_fondo "  style=" margin-left:0;">
			<figure>
				<img src="img/llamanos-aqui-pc.webp" class="imagen_banner_fondo  _mostrar_solo_pc  ">
			</figure>
		</div>				

	</div>  <!-- end banner  PC -->
	<!-- 
	<div class="callout banners callout-1"><div class="fondo fondo-cesta"><div class="row">
		<div class="large-8 large-centered text-center  columns"><div class="confi">
			<div class=" radius">				
				<h3 class="poppi-sb " style="padding-top:70px;"> Gracias por registrarte .. </h3>			
				<figure><img src="img/gracias-por-tu-compra.jpg"></figure>
				<p class="poppi color1" style="padding:30px ;"> Inicia sesión para disfrutar de tus cursos, te compartimos tus datos de acceso: </br></br> 
					<b>Usuario:</b> <?php echo $_GET["email"]; ?> </br>
					<b>Clave:</b> <?php echo $_GET["dni"]; ?>  </br> </br>
					* Te recomendamos actualizar tu clave para mayor seguridad, puedes hacerlo en la opción "Recuperar clave", que se encuentra dando clik en el siguiente botón: 
				</p>			
				<a href="iniciar-sesion_v2" class=" boton poppi-sb " style="margin:auto auto 80px;"> Iniciar sesión</a>
			</div>
		</div></div>		
	</div></div></div>
-->

	<script> /*
		setTimeout(function () {
			console.log("redirecion a wsp ");
			location.href='http://wa.me/51957668571';
		}, 6000); //msj desparece en 5seg.
		
		*/
	</script>
				

</main>
<?php 


//$pagina='portada';
$pagina='portada_llamanos';


include ('inc/footer.php'); ?>