<?php include('auten.php');  $_SESSION["url"]=url_completa(); 
$pagina='diplomas';

$meta = array(
    'title' => 'Diplomas | Educaauge.com',
    'description' => ''
);
include ('inc/header-diplomas.php');


?>

<main id="diplomas">
	<div class="callout poppi banners callout-1"><div class="fondo fondo-cesta"><div class="row">
<?php 
	
if( isset($_GET["rewrite"]) && !empty($_GET["rewrite"])  ){ 

	$sql="select * from solicitudes where estado !=3 and  ide='".$_GET["rewrite"]."' ";
	$solicitud=executesql($sql);

	if(!empty($solicitud) ){ 
?>
		<div class=" medium-6  columns  _ptop ">
			<h1 class="poppi-sb ">Tu diploma está listo </h1>
			<p>De parte del equipo de Educa Auge te felicitamos por tu esfuerzo. ¡Sigue aprendiendo todos los días!</p>			
			<h2 class="poppi "> Comparte tu certificado a cualquier red social y da a conocer tus habilidades al mundo. <b> ¡Celebra tus logros! </b> </h2>
			
			<div class="_enlace_diploma">
				<p id="enlace" class="  ">educaauge.com/diplomas/<?php echo $_GET["rewrite"]; ?> </p>
				<button id="boton_copiar" onclick="copiarAlPortapapeles('enlace')">Copiar!</button>
			</div>



			<script>
				function copiarAlPortapapeles(id_elemento) {
					var aux = document.createElement("input");
					aux.setAttribute("value", document.getElementById(id_elemento).innerHTML);
					document.body.appendChild(aux);
					aux.select();
					document.execCommand("copy");
					document.body.removeChild(aux);

					document.getElementById('boton_copiar').innerHTML='Copiado!';
					setTimeout(function () {
						document.getElementById('boton_copiar').innerHTML='Copiar';
					}, 3500); //msj desparece en 5seg.

				}
			</script>
		</div>

		<div class=" medium-6 columns "><div class="confi text-center ">			
			<figure class="rel ">
				<a href="https://www.educaauge.com/tw7control/pdf/examples/certificado/<?php echo $_GET["rewrite"];?>" target="_blank" class="abs  ">
					<img src="img/iconos/descargar_certificado.png" class=" ">
				</a>
				<img src="img/mi_diploma.jpg">
			</figure>
		</div></div>
	<?php 
	}else{
	?>
		<div class=" medium-6  columns  _ptop ">
			<h1 class="poppi-sb ">Este diploma no existe </h1>			
		</div>
		<div class=" medium-6 columns "><div class="confi text-center "></div></div>
<?php 
	} // end solictud 

}else{ ?>
		<div class=" medium-6  columns  _ptop ">
			<h1 class="poppi-sb ">Este diploma no existe </h1>			
		</div>
		<div class=" medium-6 columns "><div class="confi text-center "></div></div>
<?php }?>

	</div></div></div>
</main>


<?php 
include ('inc/footer.php'); 
?>