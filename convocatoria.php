<?php 
$pagina="cont";
include('auten.php');
$meta = array(
    'title' => ' Convocatoria | EducaAuge  ',
    'description' => ''
);
include('inc/header.php'); ?>
<main id="contacto"  style="padding-top:0;">



  	<div class="callout callout-1"><div class="row text-center">
  		<div class="large-12 columns">
  			<h3 class="color1 poppi-sb">Trabaja con nosotros </h3>
  			<p class="color1 poppi">Contáctanos por alguno de nuestros medios que gustosamente te atenderemos.</p>
  		</div>
  	
  		
  		<div class="large-6 medium-6 columns">
				<!-- 
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126780.84326867611!2d-79.91891011725981!3d-6.781858954414008!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x904cef232963dfff%3A0xa703e3454a7814bb!2sChiclayo!5e0!3m2!1ses-419!2spe!4v1616043088976!5m2!1ses-419!2spe" class="mapa" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
					-->
					<?php 
					$ajuste=executesql("select * from ajustes where id=1 ");
					if( !empty($ajuste[0]['img_contacto']) ){
					?>
					<figure><img src="tw7control/files/ajustes/<?php echo $ajuste[0]['img_contacto'];?>"></figure>
					
					<?php 
					}else{ 
					?>
					
					<figure><img src="img/convocatoria.jpeg"></figure>
					<?php 
					} 
					?>
			</div>

	  	<div class="large-6 medium-6 text-left columns">
			
			<form  action="sendmessage.php" method="post" enctype="multipart/form-data">
			<div class="large-12 columns" style="padding-top:30px;"><div class="rel">
			  	<input type="hidden" class="poppi" id="action" name="action" value="convocatoria">
			  	<input type="text" class="poppi" id="nombre" name="nombre" placeholder="Nombre y apellido">
			</div></div>
			<div class="large-12 columns"><div class="rel">
			  	<input type="email" class="poppi" name="correo" id="correo" placeholder="Correo electrónico">
			</div></div>
			<div class="large-12 columns"><div class="rel">
			  	<input type="text" class="poppi" name="fono" id="fono" required onkeypress="javascript:return soloNumeros(event,0);" placeholder="Número de celular">
			</div></div>
			<div class="large-12 columns"><div class="rel">
			  	<input type="text" class="poppi" id="asunto" name="asunto" placeholder="Asunto"  required >
			</div></div>
			<div class="large-12 columns"><div class="rel">
			  	<textarea id="mensaje" class="poppi" name="mensaje" placeholder="Déjanos aquí tu mensaje..."></textarea>
			</div></div>
			
			<div class="large-12 columns"><div class="rel">
					<label>Adjuntar CV: </label>
			  	<input type="file" class="poppi" id="imagen" name="imagen" >
			</div></div>

			<div class="large-12 columns"  style="padding-top:30px;">
					<div class="g-recaptcha" data-sitekey="6LfUxLcdAAAAAHwBF9sOotrRnU1zOQpETNnSENXH"></div>

			  	<button class="boton poppi-sb">Enviar</button>
			  	<div class="callout primary hide" id="contacInfo">Procesando datos...</div>
					<div class="callout alert hide" id="contacError">Correo no enviado<br>intentelo más tarde.</div>
					<div class="callout success hide" id="contacSuccess">Correo enviado correctamente...</div>
					<script src='https://www.google.com/recaptcha/api.js?hl=es'></script>

			</div>
	  	</form></div>
	</div></div>
</main>
<?php include('inc/footer.php'); ?>