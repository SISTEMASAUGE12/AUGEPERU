<?php include('auten.php');
$pagina='perfil';
$meta = array(
    'title' => 'Solicita el envio de tu certificado aquí | Grupo Auge ',
    'description' => ''
);
include ('inc/header.php');
?>
<main id="perfil">
	<div id="certi" <?php echo (isset($_GET['task2']) && ($_GET['task2']=='nuevo')) ? 'style="margin:0;"' : 'style="margin:0 0 0 -15px;"' ?>>

		<div class="callout callout-2"><div class="row text-center">
			<div class="large-12 columns">
				<h1 class="poppi-b color1">Solicita la entrega de tu certificado</h1>
				<p class="poppi texto">Si  ha completado algún curso con el Grupo Auge y requiere de su certificado, por favor ingrese su DNI y llene los datos solicitados.</p>
				<!--
				<a href="certificacion" class="retor"><< Nueva consulta</a>
				-->
				<div class="clearfix"></div>
			</div>
			<div class="large-12 nothing columns"><div class="centro-plomo" >
				<h5 class="poppi-sb color1">Revisa los siguientes datos</h5>
				<span class="poppi texto" >Verifique que sus datos esten ingresados correctamente, estos datos seran tomados para la emision de su(s) certificado(s), GRUPO AUGE no se responsabiliza si los datos estan mal ingresados.</span>
				<form id="solicitar_certificado" class="formulario text-left" method="POST">
				<div class="large-4 medium-6 rel  columns">
									<input type="text" name="nombre" value="<?php echo $suscri[0]['nombre'] ?>" >
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
				<div class="large-4 medium-6 rel  columns">
									<input type="text" name="dni" value="<?php echo $suscri[0]['dni'] ?>">
									<label class="poppi sub texto">Número DNI</label>
							</div>
				<div class="large-4 medium-6 rel  columns">
									<input type="text" name="telefono" value="<?php echo $suscri[0]['telefono'] ?>">
									<label class="poppi sub texto">Número de celular</label>
							</div>
				<div class="large-4 medium-6 rel  columns">
									<input type="text" name="email" value="<?php echo $suscri[0]['email'] ?>">
									<label class="poppi sub texto">Correo electrónico</label>
							</div>

							
					<div class="large-4 medium-6 rel columns">
						<?php crearselect("iddpto","select iddpto, titulo from dptos order by titulo asc",'class="form-control" required onchange="javascript:display(this.value,\'cargar_prov\',\'idprvc\')"','',"Seleccionar"); ?>
						<label class="poppi sub texto">Departamento</label>

					</div>
					<div class="large-4 medium-6 rel columns">
						<select name="idprvc" required id="idprvc" class="form-control" onchange="javascript:display(this.value,'cargar_dist','iddist')"><option value="" selected="selected">Selecciona</option></select>
						<label class="poppi sub texto">Provincia</label>
					</div>
					<div class=" large-4 medium-6 rel columns">
						<select name="iddist" id="iddist" required class="form-control"><option value="" selected="selected">Selecciona</option></select>
						<label class="poppi sub texto">Distrito</label>
					</div>
													
				<!-- 		
				<div class="large-4 medium-6 rel columns" style="padding-top:10px">
					<input type="file" name="voucher">
					<label class="poppi sub texto">Voucher</label>
				</div>
				-->
				<div class="clearfix"></div>
				
				<?php
				$sql_certificados="SELECT sxc.*, c.titulo as curso, cer.titulo as certificado 
						FROM  suscritos_x_certificados sxc 
						INNER JOIN certificados cer ON sxc.id_certificado=cer.id_certificado 
						INNER JOIN cursos c ON sxc.id_curso=c.id_curso 
						WHERE sxc.estado=1 and sxc.id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."'";
				
				$certificados_pagados = executesql($sql_certificados);
							if(!empty($certificados_pagados)){
				?>
				<div class="large-12 columns"><h5 class="poppi-sb text-center color1" style="padding-top:40px;">Marque los certificados a solicitar </h5></div>
	<?php
				foreach ($certificados_pagados as $detalles){ 
	?>
				<div class="large-4 medium-6 rel  columns">
					<input type="checkbox" name="cursos[]"  id="casilla<?php echo $detalles['id_certificado'];?>" value="<?php echo $detalles['id_certificado'];?>" >
					<label for="casilla<?php echo $detalles['id_certificado'];?>" class="poppi texto">
						<?php echo $detalles['certificado'];?> </br>
						curso: <small><?php echo $detalles['curso'];?></small>
					</label>
				</div>

	<?php
							}
				}else{
					echo '<div class="text-center" style="padding:40px 15px;">Aún no has pagado algún certificado .. </div>';
				}
				?>
				<div class="large-12 columns"><h5 class="poppi-sb text-center color1" style="padding-top:40px;">Datos de envío</h5></div>
				<div class="large-6 medium-6 nothing columns">
									<div class="large-8  rel medium-10 columns">
										<input type="text" name="direccion">
										<label class="poppi sub texto">Dirección de envío</label>
								</div>
								<div class="large-10 float-left medium-10 columns">
										<label class="poppi sub texto texfinal ">GRUPO AUGE emite tu certificado por cada curso seleccionado, si ya has realizando el pago por derecho del certificado </label>
								</div>
							</div><div class="large-6 medium-6 nothing columns">
									<div class="large-8 rel float-right medium-10 columns">
										<input type="text" name="agencia">
										<label class="poppi sub texto">Agencia de envío</label>
								</div>
								<div class="large-8 float-right medium-10 columns"><div class="ultra">
										<input type="checkbox" name="buscar">
										<label class="poppi texto texfinal">Yo, <?php echo $suscri[0]['nombre'].' '.$suscri[0]['ap_pa'].' '.$suscri[0]['ap_ma']; ?> confirmo haber realizado el pago por cada certificado seleccionado, para que se me haga el envío de lo solicitado.</label>
								</div></div>
							</div>
							<div class="large-12 columns">
								<blockquote class="poppi texto" style="margin-top:30px;">GRUPO AUGE, solicita que verifiques bien los datos ingresados antes de enviarlos, estos serán tomados para la impresion de tu CERTIFICADO y el envio a la dirección indicada.<br>Una vez revisado, dale click en el boton "SOLICITAR CERTIFICADO" para que se envien los datos.</blockquote>
							</div>
							<div class="large-12 columns">
								<button class="poppi-sb boton">Solicitar</button>
					<div class="callout primary hide" id="reportInfo">Procesando datos...</div>
					<div class="callout alert hide" id="reportError">No se pudo actualizar.</div>
					<div class="callout success hide" id="reportSuccess">OK! solicitud enviada ...</div>
							</div>
							</form>
			</div></div>
		</div></div>


</main>
<?php include ('inc/footer.php'); ?>