<?php 
$pagina='coautoria';
include('auten.php');
$meta = array(
    'title' => 'Libros de CoAutoría | Grupo Auge Perú ',
    'description' => ''
);
include ('inc/header.php');
?>
<main id="certi"  class="coautoria   <?php if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){ echo "logeado"; }?> ">
<?php
	if( isset($_SESSION["coautoria"]) && !empty($_SESSION["coautoria"])  && $_SESSION["coautoria"]["rewrite"]==1){
			/* tiene acceso al webinar */
			// unset($_SESSION["coautoria"]);
			// echo "Hola ";
?>


<?php
	}else{   /* Sino existe sesion coautorioa (si aun no registra en este formualrio ), muestro forulario de lead, capatar estos datos ...  */
		/* si aun no envia una solciitud, mostramos el formulario ..  */
				/* Consulto con la Bd:: Tabla docente magsterio */
				if( !empty($suscri[0]['dni']) ){
					$data_magisterio=executesql("SELECT * FROM data_docente_magisterios where documento='".$suscri[0]['dni']."' ");
				}
?>
	<div class="callout callout-2"><div class="row text-center">
		<div class="large-12 columns">
			<h1 class="poppi-b color1"><img src="img/libro_img.jpg"> Solicita la coautoría de un Libro</h1>
			<p class="poppi texto">¿Te gustaría ser coautor de un libro el cual suma puntos en tu Nombramiento, Ascenso de escala y Directivos ?</p>
			<!--
			<a href="certificacion" class="retor"><< Nueva consulta</a>
			-->
			<div class="clearfix"></div>
		</div>
		<div class="large-12 nothing columns"><div class="centro-plomo" >
			<h5 class="poppi-sb color1">Revisa los siguientes datos</h5>
			<span class="poppi texto" >Si estás interesado déjanos tus datos para contactarnos contigo Grupo Auge Construyendo el camino a la Revolución Educativa.</span>
			<form id="solicitar_coautoria" class="formulario text-left" method="POST">
			
			<?php if( !empty($data_magisterio) ){ ?>
				<div class="large-12 medium-6 rel  columns">
						<input type="hidden" name="nombre_magisterio" style="width:100%;" value="<?php echo $data_magisterio[0]['titulo']; ?>" >
						<input type="text" name="nombre_magisterio_mostrar" style="width:100%;" disabled value="<?php echo $data_magisterio[0]['titulo']; ?>" >
						<label class="poppi sub texto">Nombre completo</label>
						<!-- * si encontro data en tabla magisterio -->
						<input type="hidden" name="nombre" value="000" >
						<input type="hidden" name="ap_pa" value="000">
						<input type="hidden" name="ap_ma" value="000">
				</div>
				
			<?php }else{ ?>
				<div class="large-4 medium-6 rel  columns">
						<input type="text" name="nombre" value="<?php echo $suscri[0]['nombre']; ?>" >
						<label class="poppi sub texto">Nombre</label>
				</div>
				<div class="large-4 medium-6 rel  columns">
						<input type="text" name="ap_pa" value="<?php echo $suscri[0]['ap_pa'] ?>">
						<label class="poppi sub texto">Apellido Paterno</label>
				</div>
				<div class="large-4 medium-6 rel  columns">
						<input type="text" name="ap_ma" value="<?php echo $suscri[0]['ap_ma'] ?>">
						<label class="poppi sub texto">Apellido Materno</label>
				</div>
			<?php } ?>
						
			<div class="large-4 medium-6 rel  columns">
                <input type="text" name="dni" value="<?php echo !empty($_SESSION["suscritos"]["id_suscrito"])?$suscri[0]['dni']:''; ?>">
                <label class="poppi sub texto">Número DNI</label>
            </div>
			<div class="large-4 medium-6 rel  columns">
                <input type="text" name="telefono" value="<?php echo !empty($_SESSION["suscritos"]["id_suscrito"])?$suscri[0]['telefono']:''; ?>">
                <label class="poppi sub texto">Número de celular</label>
            </div>
			<div class="large-4 medium-6 rel  columns">
                <input type="text" name="email" value="<?php echo !empty($_SESSION["suscritos"]["id_suscrito"])?$suscri[0]['email']:''; ?>">
                <label class="poppi sub texto">Correo electrónico</label>
            </div>

						
				<div class="large-4 medium-6 rel columns">
					<?php crearselect("iddpto","select iddpto, titulo from dptos order by titulo asc",'class="form-control" required onchange="javascript:display(this.value,\'cargar_prov\',\'idprvc\')"','',"Seleccione Departamento"); ?>
					<label class="poppi sub texto">Departamento</label>
				</div>
				<div class="large-4 medium-6 rel columns">
					<select name="idprvc" required id="idprvc" class="form-control" onchange="javascript:display(this.value,'cargar_dist','iddist')"><option value="" selected="selected">Seleccione Provincia</option></select>
					<label class="poppi sub texto">Provincia</label>
				</div>
				<div class=" large-4 medium-6 rel columns">
					<select name="iddist" id="iddist" required class="form-control"><option value="" selected="selected">Seleccione Distrito</option></select>
					<label class="poppi sub texto">Distrito</label>
				</div>
						
						
						
			<div class="large-4 medium-6 rel columns" style="padding-top:10px">
				 <input type="text" name="direccion" value="<?php echo !empty($_SESSION["suscritos"]["id_suscrito"])?$suscri[0]['direccion']:''; ?>">
					<label class="poppi sub texto">Dirección actual</label>
			</div>
			<div class="large-4 medium-6 rel columns" style="padding-top:10px">
					<?php
					$val_espe=!empty($_SESSION["suscritos"]["id_suscrito"])?$suscri[0]['id_especialidad']:'';
					crearselect("id_especialidad","select * from especialidades where estado_idestado=1 order by titulo asc",'class="" required',$val_espe,"-- seleccione especialidad--"); ?>					
					<label class="poppi sub texto">Especialidad</label>
			</div>
			<div class="clearfix"></div>
			
			<div class="large-4 medium-6 rel columns" style="padding-top:10px">
				 <input type="date" name="fecha_nac" >
					<label class="poppi sub texto">Fecha de Nacimiento</label>
			</div>
			<div class="large-4 medium-6 rel columns" style="padding-top:10px">
				 <input type="text" name="direccion_nac" value="">
					<label class="poppi sub texto">Dirección de nacimiento</label>
			</div>
			<div class="clearfix"></div>
			
            <div class="large-12 columns">
            	<blockquote class="poppi texto" style="margin-top:30px;">Si estás interesado déjanos tus datos para contactarnos contigo Grupo Auge Construyendo el camino a la Revolución Educativa.</blockquote>
            </div>
            <div class="large-12 columns">
            	<button class="poppi-sb boton">Enviar</button>
				<div class="callout primary hide" id="reportInfo">Procesando datos...</div>
				<div class="callout alert hide" id="reportError">No se pudo actualizar.</div>
				<div class="callout success hide" id="reportSuccess">OK! solicitud enviada ...</div>
            </div>
            </form>
		</div></div>
	</div></div>
<?php
	}
?>

</main>
<?php include("inc/footer.php");?>