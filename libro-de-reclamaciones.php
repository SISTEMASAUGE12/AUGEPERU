<?php
include('auten.php');
$pagina='reclamacion';
$detalle='cambiar';
$meta = array(
    'title' => 'Libro de reclamaciones',
    'description' => ''
);
include ('inc/header.php');
?>
<main id="reclamo">
  	<div class="callout callout-1"><div class="row">
      	<div class="large-12 text-center columns">
			<h1 class="osansb color5">LIBRO DE RECLAMACIONES</h1>
			<p class="texto"><em>Ponemos a tu disposición nuestro libro de reclamaciones, aplicativo de atención de reclamos y solicitudes en línea.</em></p>
      	</div>
      	<div class="large-8 large-offset-2 medium-10 medium-offset-1 float-left columns">
<form  action="libro.php" method="post" enctype="multipart/form-data"><fieldset><div class="row text-left">
	      	<div class="large-12 columns">
				<h4 class="osansb color1">1.- INFORMACIÓN DE CONSUMIDOR RECLAMANTE</h4>
	      	</div>
	      	<div class="large-6 medium-6 columns">
	      		<label>Nombre:</label>
				<input type="text" required name="nombre">
	      	</div>
	      	<div class="large-6 medium-6 columns">
	      		<label>Apellido Paterno:</label>
	      		<input type="text" required name="apellidop">
	      	</div>
	      	<div class="large-12 columns" style="padding:0;"><div class="large-6 medium-6 columns">
	      		<label>Apellido Materno:</label>
	      		<input type="text" required name="apellidom">
	      	</div></div>
	      	<div class="large-6 medium-6 columns">
	      		<label>Tipo de Documento:</label>
	      		<select name="tipodoc">
	      	  		<option value="dni">DNI</option>
	      	  		<option value="ruc">RUC</option>
	      		</select>
	      	</div>
	      	<div class="large-6 medium-6 columns">
	      		<label>Número de Documento:</label>
	      		<input type="text" required name="documento"onkeypress='javascript:return soloNumeros(event,0);' >
	      	</div>
	      	<div class="large-6 medium-6 columns">
		      	<label>Correo Electrónico:</label>
		      	<input type="email" required name="correo">
	      	</div>
		    <div class="large-6 medium-6 columns">
		      	<label>Número Telefónico:</label>
		      	<input type="text" required maxlength="9" onkeypress='javascript:return soloNumeros(event,0);' name="telefono">
		    </div>
	      	<div class="large-4 medium-4 columns">
	      		<label>Departamento:</label>
				<?php crearselect("dpt","select iddpto,titulo from dptos",'onchange="javascript:display(this.value,\'cargar_prov\',\'prv\',\'Provincia\');"','',"Seleccione"); ?>
	      	</div>
	      	<div class="large-4 medium-4 columns">
	      		<label>Provincia:</label>
				<select name="prv" id="prv" onchange="javascript:display(this.value,'cargar_dist','dis','Distrito');"><option value="">Seleccione</option></select>
	      	</div>
	      	<div class="large-4 medium-4 columns">
	      		<label>Distrito:</label>
				<select name="dis" id="dis"><option value="">Seleccione</option></select>
	      	</div>
		    <div class="large-12 columns">
		      	<label>Dirección:</label>
		      	<input type="text" required name="direccion">
		    </div>
	      	<div class="large-12 columns">
	      		<label>Padre / Madre (para el caso de menores de edad):</label>
	      		<input type="text" required name="direccion">
	      	</div>
	      	<div class="large-12 columns">
				<h4 class="color1 osansb" style="padding-top:25px;">2.- IDENTIFICACIÓN DEL BIEN  CONTRATADO</h4>
	      	</div>
	      	<div class="large-12 columns">
	      		<label class="uni" style="display:inline-block;">Producto</label>
				<input type="radio" class="do" name="biencontra" value="producto" checked>
				<label class="uni" style="padding-left:15px;margin-right:0;">Servicio</label>
				<input type="radio" class="do" name="biencontra" value="servicio">
	      	</div>
	      	<div class="large-12 columns">
	      		<label>Descripción:</label>
	      		<textarea name="descripcionbien"></textarea>
	      	</div>
	      	<div class="large-12 columns">
				<h4 class="osansb color1"style="padding-top:25px;">3.- DETALLE DE LA RECLAMACIÓN Y PEDIDO DEL CONSUMIDOR</h4>
	      	</div>
	      	<div class="large-12 columns">
		      	<label class="osans uni" style="display:inline-block;">Reclamo <sup>(1)</sup></label>
			    <input type="radio" class="do" name="tiporeclamo" value="reclamo" checked>
			    <label class="osans uni" style="padding-left: 15px;margin-right:0;">Queja <sup>(2)</sup></label>
			    <input type="radio" class="do" name="tiporeclamo" value="queja">
	      	</div>
	      	<div class="large-12 columns">
		      	<label>Detalle:</label>
		      	<textarea name="detallerecla"></textarea>
		      	<label style="margin:5px 0 15px;line-height: 20px;color:#666;"><b class="osansb">(1) RECLAMO:</b>  Disconformidad relacionada a los productos o servicios.<br><b class="osansb">(2) QUEJA:</b> Disconformidad no relacionada a los productos o servicios; o, malestar o descontento respecto a la atención al público.</label>
	      	</div>
	      	<div class="large-12 columns">
		      	<label class="osans">Pedido del Consumidor:</label>
		      	<textarea name="pedidoconsu"></textarea>
	      	</div>
	      	<div class="large-12 columns">
	      		<label class="osans"><input type="checkbox" required name="aceptar" value="1"> Me encuentro conforme con los términos de mi reclamo o queja.</label>
	      	</div>
	      	<div class="large-12 columns">
	      		<label style="line-height: 20px;color:#666;padding-bottom: 10px;">
	      	    * El proveedor deberá dar respuesta al reclamo en un plazo no mayor de treinta (30) días calendario, pudiendo ampliar el plazo hasta por treinta días más, previa comunicación al consumidor.<br>
	      	    * La formulación del reclamo no impide acudir  a otras vías de solución de controversias ni es requisito previo para interponer una denuncia ante el INDECOPI.<br>
                * El proveedor deberá dar respuesta al reclamo en un plano no mayor a (30) días calendario, pudiendo ampliar el plazo hasta treinta (30) días más, previa comunicación al consumidor.</label>
	      	</div>
	      	<div class="large-12 columns"><button class="boton">ENVIAR</button></div>
	    </div></fieldset></form></div>
    </div></div>
</main>
<?php include('inc/footer.php'); ?>