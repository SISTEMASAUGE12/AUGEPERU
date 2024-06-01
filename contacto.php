<?php 
$pagina="cont";
include('auten.php');
$meta = array(
    'title' => 'Auge Perú: Contacto',
    'description' => ''
);
include('inc/header.php'); ?>
<main id="contacto"  style="padding-top:0;">



  	<div class="callout callout-1"><div class="row text-center">
  		<div class="large-12 columns">
  			<h3 class="color1 poppi-sb">Contáctanos</h3>
  			<p class="color1 poppi">Si tiene alguna duda o consulta, contáctanos por alguno de nuestros medios que gustosamente te atenderemos.</p>
  		</div>
  		<div class="large-4 medium-4 columns"><div class="cuadro">
			<!-- 
  			<figure class="rel"><img class="verticalalignmiddle" src="img/iconos/fonoc.png"></figure> 
-->
  			<p class="color1 poppi"> 
			  <a class=" bold _btn " href="llamanos-gratis"> <img src="img/iconos/telfijo.png" style="padding-right:4px;"> Llama gratis </a>  </br></br>
			  <a  class=" _btn " href="https://api.whatsapp.com/send?phone=+51<?php  echo $_num_wsp; ?>&text=Hola%20Grupo%20AUGE%20Quiero%20Informaci%C3%B3n"  target="_blank" alt="whatsapp"><img src="img/iconos/whatsapp.png" alt="whatsapp" width="50px"> WhatsApp</a>  </br> 
				<br>Horario de atención: Lunes - Sabado (9am-8pm)
			</p>
  		</div></div>
  		<div class="large-4 medium-4 columns"><div class="cuadro">
  			<figure class="rel"><img class="verticalalignmiddle" src="img/iconos/cartac.png"></figure>
  			<p class="color1 poppi">Email: <a href="mailto:informes@educaauge.com">informes@educaauge.com</a><br>Web: www.educaauge.com</p>
  		</div></div>
  		<div class="large-4 medium-4 columns"><div class="cuadro">
  			<figure class="rel"><img class="verticalalignmiddle" src="img/iconos/ubicac.png"></figure>
  			<p class="color1 poppi">Chiclayo, Lambayeque<br>Peru</p>
  		</div></div>
  		<div class="large-12 columns">
  			<span class="color1 poppi-sb">Formulario de consultas</span>
  			<p class="color1 poppi">Si deseas dejar alguna consulta, puedes hacerlo llenando el formulario y te atenderemos a la brevedad.</p>
  		</div>
  		<div class="large-6 medium-6 columns">
				
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d499488.98411433224!2d-77.31814405047362!3d-12.025772448015996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c5f619ee3ec7%3A0x14206cb9cc452e4a!2sLima!5e0!3m2!1ses!2spe!4v1713975396413!5m2!1ses!2spe" class="mapa" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
					

					<?php  /*
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
					*/
					?>
			</div>

	  	<div class="large-6 medium-6 text-left columns">
			
			<form  action="sendmessage.php" method="post" enctype="multipart/form-data">
			<div class="large-12 columns" style="padding-top:30px;"><div class="rel">
			  	<input type="text" class="poppi" id="nombre" name="nombre" placeholder="Nombre y apellido">
			</div></div>
			<div class="large-12 columns"><div class="rel">
			  	<input type="email" class="poppi" name="correo" id="correo" placeholder="Correo electrónico">
			</div></div>
			<div class="large-12 columns"><div class="rel">
			  	<input type="text" class="poppi" name="fono" id="fono" onkeypress="javascript:return soloNumeros(event,0);" placeholder="Número de celular">
			</div></div>
			<div class="large-12 columns"><div class="rel">
			  	<input type="text" class="poppi" id="asunto" name="asunto" placeholder="Asunto">
			</div></div>
			<div class="large-12 columns"><div class="rel">
			  	<textarea id="mensaje" class="poppi" name="mensaje" placeholder="Déjanos aquí tu mensaje..."></textarea>
			</div></div>
			
			<!-- 
			<div class="large-12 columns"><div class="rel">
					<label>Adjuntar CV: </label>
			  	<input type="file" class="poppi" id="imagen" name="imagen" >
			</div></div>

				-->

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