<?php include('auten.php');
$pagina='certi';
$meta = array(
    'title' => 'Auge: Certificación',
    'description' => ''
);
include ('inc/header.php');
?>
<main id="certi">
	<div class="callout callout-1"><div class="row text-center">
		<div class="large-12 columns">
			<h1 class="poppi-b color1">Solicita tu certificado</h1>
			<p class="poppi texto">Si  ha llevado algún curso con el Grupo Auge y requiere de su certificado, por favor ingrese su DNI y llene los datos solicitados.</p>
			<form class="formulario" method="POST">
                <input type="text" name="buscar" placeholder="Ingresar tu número de DNI" <?php echo (isset($_POST['buscar']) && !empty($_POST['buscar'])) ? 'value="'.$_POST['buscar'].'"' : '' ?>>
                <button class="button"><img src="img/iconos/lupa.png"></button>
            </form>
            <a href="certificacion2" class="poppi-sb boton">Consultar</a>
		</div>
	</div></div>

</main>
<?php include ('inc/footer.php'); ?>