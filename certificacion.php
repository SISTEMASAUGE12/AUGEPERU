<main id="certi" <?php echo (isset($_GET['task2']) && ($_GET['task2']=='nuevo')) ? 'style="margin:0;"' : 'style="margin:0 0 0 -15px;"' ?>>
<?php
	if(isset($_GET['task2']) && ($_GET['task2']=='nuevo')){
?>
	<div class="callout callout-2"><div class="row text-center">
		<div class="large-12 columns">
			<h1 class="poppi-b color1">Solicita tu certificado</h1>
			<p class="poppi texto">Si  ha llevado algún curso con el Grupo Auge y requiere de su certificado, por favor ingrese su DNI y llene los datos solicitados.</p>
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
						
						
						
			<div class="large-4 medium-6 rel columns" style="padding-top:10px">
                <input type="file" name="voucher">
                <label class="poppi sub texto">Voucher</label>
            </div>
            <div class="clearfix"></div>
			<?php
			$suscur = executesql("SELECT * FROM suscritos_x_cursos WHERE id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."'");
            if(!empty($suscur)){
			?>
			<div class="large-12 columns"><h5 class="poppi-sb text-center color1" style="padding-top:40px;">Marque los cursos que participó </h5></div>
<?php
			foreach ($suscur as $data_asignacion){
			$detalles = executesql("SELECT * FROM cursos WHERE id_curso = '".$data_asignacion['id_curso']."'",0);
			$titulo=$detalles['titulo'];
?>
			<div class="large-4 medium-6 rel  columns">
				<input type="checkbox" name="cursos[]" value="<?php echo $detalles['id_curso'];?>" >
				<label class="poppi texto"><?php echo $detalles['titulo'];?></label>
			</div>

<?php
            }
			}else{
				echo '<div class="text-center" style="padding:40px 15px;">Aún no has comprado cursos .. </div>';
			}
			?>
			<div class="large-12 columns"><h5 class="poppi-sb text-center color1" style="padding-top:40px;">Datos de envío</h5></div>
			<div class="large-6 medium-6 nothing columns">
                <div class="large-8  rel medium-10 columns">
	                <input type="text" name="direccion">
	                <label class="poppi sub texto">Dirección de envío</label>
	            </div>
	            <div class="large-10 float-left medium-10 columns">
	                <label class="poppi sub texto texfinal ">GRUPO AUGE emite tu certificado por cada curso seleccionado, realizando el pago por derecho del certificado más envio por el monto de S/.50 soles por cada curso<br>Depositando en cualquiera de estos bancos:<br>Banco de la nación:<br>Cuenta soles: Nº 00-250-026129<br>Banco de credito del peru (BCP):<br>número de cuenta corriente 305–2581152–0–49<br><br>Enviar voucher escaneado al correo de capacitacion@augeperu.org</label>
	            </div>
            </div><div class="large-6 medium-6 nothing columns">
                <div class="large-8 rel float-right medium-10 columns">
	                <input type="text" name="agencia">
	                <label class="poppi sub texto">Agencia de envío</label>
	            </div>
	            <div class="large-8 float-right medium-10 columns"><div class="ultra">
	                <input type="checkbox" name="buscar">
	                <label class="poppi texto texfinal">Yo, <?php echo $suscri[0]['nombre'].' '.$suscri[0]['ap_pa'].' '.$suscri[0]['ap_ma']; ?> acepto en realizar el pago por cada certificado seleccionado, enviar el voucher del depósito para que se me haga el envío de lo solicitado.</label>
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
<?php
	}else{
?>
	<div class="callout callout-2"><div class="row">
		<div class="large-12 columns">
			<h1 class="poppi-b color1" style="padding-bottom:50px;">Certificados 
			<!-- 
				<a class="boton poppi-sb solicita " href="perfil/certificados/nuevo">Solicitar Nuevo</a>
				-->
			</h1>
		</div>
		<div class="large-12 columns nothing" style="background:#FDF7F7;min-height:500px;">
			<div class="tableta">
				<div class="cuadro cuadro1"><p class="color1 poppi-sb">Cursos</p></div>
				<div class="cuadro"><p class="color1 poppi-sb">Fecha de solicitud</p></div>
				<div class="cuadro"><p class="color1 poppi-sb">Estado</p></div>
				<div class="cuadro"><p class="color1 poppi-sb">Fecha de envío</p></div>
			</div>
<?php
			$list = executesql("SELECT * FROM solicitudes WHERE id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."' ORDER BY fecha_registro ASC");
            if(!empty($list)){ foreach($list as $lista){
            	$curs = executesql("SELECT * FROM cursos WHERE id_curso IN (".$lista['cursos'].") ORDER BY orden ASC");
            	$cursos = '';
            	if(!empty($curs)){ foreach($curs AS $cursi){
            		$cursos.='<br>'.$cursi['titulo'];
            	}}
            $html= '
            <div class="tableta tableta1">
				<div class="cuadro cuadro1"><p class="color1 poppi">'.$cursos.'</p></div>
				<div class="cuadro"><p class="color1 poppi">'.date('d/m/Y ',strtotime($lista['fecha_registro'])).'</p></div>
				<div class="cuadro"><p class="color1 poppi">';

					if($lista['estado'] == 1){
							$html.='<span class="color-blanco">Entregado</span>';
					}elseif($lista['estado'] == 2){
							$html.='<span class="ul">Pendiente</span>';
					}elseif($lista['estado'] == 3){
							$html.='<span class="ul">Rechazada</span>';
					}elseif($lista['estado'] == 4){
							$html.='<span class="ul">Procesando envio</span>';
					}elseif($lista['estado'] == 5){
							$html.='<span class="ul"> Enviado</span>';
					}else{
							$html.='<span class="ul"> Error_123</span>';
						
					}
							
				$html.='</p></div>
						<div class="cuadro"><p class="color1 poppi">'.(!empty($lista['fecha_envio']) ? $lista['fecha_envio'] : '').'</p></div>
					</div>';
			echo $html;
			
            } }
?>
		</div>
	</div></div>
<?php
	}
?>
</main>