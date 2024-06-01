<?php
if(($pagina=='cesta') || ($pagina=='registro') || ($pagina=='docen') || ($pagina=='perfil') || ($pagina=='examen') || ($pagina=='webinar') || ($pagina=='actualiza-datos') ){
}else{
?>
  	<footer <?php echo ($pagina=='portada' || $pagina=="cont" || $pagina=="perfil" || $pagina=="certi" || $pagina=="blog") ? 'style="background:#F9FAFB;"' : ''; ?>>
  		<div class="callout final"><div class="row  text-left ">
			<?php  /* 
  			<div class="large-3 medium-6 columns">
  				<p class="bold titu">Cursos:</p>
  				<ul class="linka text-left ">
<?php
  				$curs_dest = executesql("SELECT c.*, ca.titulo_rewrite AS catrewri, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c
INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso
INNER JOIN categorias ca ON csc.id_cat = ca.id_cat
INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub
INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo
WHERE  c.id_tipo=1 and  c.estado_idestado = 1 and c.visibilidad=1 and c.precio > 0 AND c.tipo = 1 ORDER BY c.orden DESC LIMIT 0,6" );
  				if(!empty($curs_dest)){ foreach($curs_dest as $list){
?>
  					<li class="text-left "><span></span><a href="<?php echo 'curso/'.$list['tiprewri'].'/'.$list['catrewri'].'/'.$list['subrewri'].'/'.$list['titulo_rewrite']; ?>"><?php echo $list['titulo'] ?></a></li>
<?php
				} }
?>
  				</ul>
  			</div>
				<?php  */ ?> 
				
  			<div class="large-3 medium-6 columns">
  				<p class="bold titu">Educa Auge:</p>
  				<ul class="linka text-left">
						<li  class="text-left "><span></span><a href="perfil/mis-pedidos">Mis Compras</a></li>
  					<li class="text-left "><span></span><a href="blog">Blog</a></li>
  					<li class="text-left "><span></span><a href="libro/todos-los-libros">Libros</a></li>
  					<li class="text-left "><span></span><a href="coautoria">Couatoría</a></li>
  					<li class="text-left "><span></span><a href="nosotros">Nosotros</a></li>
  					<li class="text-left "><span></span><a href="contacto">Contáctanos</a></li>
  				</ul>
  			</div>
				
  			<div class="large-3 medium-6 columns">
  				<p class="bold titu">&nbsp;</p>
  				<ul class="linka text-left">
  					<li class="text-left "><span></span><a href="preguntas-frecuentes"><b>Preguntas Frecuentes</b></a></li>
  					<li class="text-left "><span></span><a href="formas-de-pago">Formas de Pago</a></li>
  					<li class="text-left "><span></span><a href="cesta-pago-deposito">Pago Deposito</a></li>
					  <li class="text-left "><span></span><a href="https://www.educaauge.com/unete-al-canal-de-whatsapp">Únete a nuestro canal de WhatsApp</a></li>

  					<li class="text-left "><span></span><a href="augeperu-telegram">Únete a nuestro canal de Telegram</a></li>
  					<li class="text-left "><span></span><a href="grupo-de-facebook">Grupo de facebook</a></li>
  					<li class="text-left "><span></span><a href="facebook-testimonios">Testimonios de facebook</a></li>
  				</ul>
  			</div>
  			<div class="large-3 medium-6 columns">
  				<p class="bold titu">&nbsp;</p>
  				<ul class="linka text-left">
  					<li class="text-left "><span></span><a href="politicas-de-datos-y-seguridad">Políticas de datos y privacidad</a></li>
  					<li class="text-left "><span></span><a href="politicas-de-privacidad" >Términos y condiciones</a></li>
  					<li class="text-left " style="list-style:none;">
							<a href="libro-de-reclamaciones"><img src="img/iconos/libro_reclamaciones.jpg" style="padding-right:10px;">Libro de reclamaciones</a>
						</li>
  				</ul>
  			</div>
        	<div class="large-3 medium-6 large-text-left medium-text-left text-center columns"><div class="social-item">
            	<a href="https://www.facebook.com/www.augeperu.org" target="_blank"><i class="fab fa-facebook-f"></i></a>
            	<a href="https://www.instagram.com/auge_peru" target="_blank"><i class="fab fa-instagram"></i></a>
            	<a href="https://www.linkedin.com/in/auge-per%C3%B9-centro-de-capacitaci%C3%B3n-actualizaci%C3%B3n-320a82a3/" target="_blank"><i class="fab fa-linkedin"></i></a>
            	<a href="https://www.youtube.com/c/AUGEPER%C3%9ACentrodeCapacitaci%C3%B3n" target="_blank"><i class="fab fa-youtube-square"></i></a>
							<!-- 
            	<a href="" target="_blank"><i class="fab fa-twitter"></i></a>
							-->
        	</div></div>
			<!--<div class="large-6 medium-6 columns"><ul class="no-bullet tarje float-right">
				<li><img src="img/iconos/visa.png"></li>
				<li><img src="img/iconos/mastecard.png"></li>
				<li><img src="img/iconos/american.png"></li>
				<li><img src="img/iconos/dinners-club.png"></li>
				<li><img src="img/iconos/pago-efectivo.png"></li>
			</ul></div>-->
    	</div></div>
    	<div class="callout fin"><div class="row">
    		<div class="large-6 medium-6 float-right columns"><ul class="no-bullet roboto">
				<!--
	    		<li><a>Políticas de cookies</a></li>
	    		<li><a>Términos y condiciones</a></li>
					-->
					<li class=" color1 <?php echo ($pagina=="blog") ? "active " : ""; ?>"><a href="blog">Publicaciones</a></li>					
					<li class="color1 "> <a href="politicas-de-datos-y-seguridad">Políticas de datos y privacidad</a></li>
	    		<li class=" color1" ><a href="politicas-de-privacidad">Términos y condiciones</a></li>
	    	</ul></div>
	    	<div class="large-6 medium-6 columns">
					<p class="texto roboto">Copyright © GRUPO AUGE <?php echo date('Y');?> -Todos los derechos reservados</p>
					<!-- 
					<p class="texto roboto" style="padding-top:5px;"><a href="https://www.tuweb7.com" target="_blank" >Desarrollado por <img src="img/iconos/by.png"></a></p>
					-->
					<p class="texto roboto" style="padding-top:5px;"><a href="https://www.educaauge.com/api_hola" target="_blank" >Token diario</a></p>
					<a href="https://app.toky.co/AUGEPER?callnow&option=3106" target="_blank" class="llama_gratis " ><img style="margin-top:10px;" src="img/iconos/llama_gratis.png"></a>
				</div>
	    </div></div>
	</footer>
<?php
}
?>
  	<p id="back-top" style="display:block;"><a href="#top"><span></span></a></p>
		<!--
  	<a class="oculw" href="https://api.whatsapp.com/send?phone=51999999999&text=Quiero%20Información" target="_blank"><img src="img/iconos/wspf.png"></a>
		-->
		
		
		
<?php if($pagina !='pago_efectivo'){ ?>
  	<script src="js/vendor/jquery.min.js"></script>
<?php }else{ ?>		
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<?php } ?>
		
  	<script src="js/css3-animate-it.js"></script>
  	<script src="js/foundation.min.js"></script>
 	<script> $(document).foundation(); </script>
	<script src="js/vendor/rem.min.js"></script>
	

	<!-- Lightslider -->
	<script src="js/vendor/lightslider/lightslider.js"></script>
	<!-- Magnific Popup -->
	<script src="js/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
  	<script src="https://www.google.com/recaptcha/api.js"></script>
	<!-- Validate -->
	<script src="js/vendor/jquery.validate.min.js"></script>
	<script src="js/jquery.validate.tuweb7.js?ud=<?php echo $unix_date ; ?>"></script>

    <script src="js/sweetalert.min.js"></script>
<?php if($pagina=='blog'){ ?>
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-600b0d286d8e3385"></script>
<?php } ?>
	<!-- Own JS -->
	<script src="js/functions.js?ud=<?php echo $unix_date ; ?>"></script>
	<script src="js/main.js?ud=<?php echo $unix_date ; ?>"></script>
	<script src="js/coautoria.js?ud=<?php echo $unix_date ; ?>"></script>

<?php
/* esto es para registro login: facebook y google */
    // echo ($pagina=="cesta") ? '' : '<script src="js/llamar_registro_login.js?ud='.$unix_date.'"></script>'; // en la cesta este viene desde js.
    // echo ($pagina=="registro") ? '<script src="js/registro.js?ud='.$unix_date.'"></script>' : "";
/* end reg. redes sociales */		

    echo ($pagina=="registro" || $pagina=="cesta") ? '<script src="js/registro_v2_consulta.js?ud='.$unix_date.'"></script>' : "";
    echo ($pagina=="registro" || $pagina=="cesta") ? '<script src="js/registro_v2_guardar_update_consulta.js?ud='.$unix_date.'"></script>' : "";
    echo ($pagina=="registro" || $pagina=="cesta") ? '<script src="js/registro_v2.js?ud='.$unix_date.'"></script>' : "";
    echo ($pagina=="registro" || $pagina=="cesta") ? '<script src="js/llamar_v2_registro_login.js?ud='.$unix_date.'"></script>' : "";

    
		echo ($pagina=="portada") ? '<script src="js/portada.js?ud='.$unix_date.'"></script>' : "";
    echo ($pagina=="perfil" || $pagina=="coautoria") ? '<script src="js/perfil.js?ud='.$unix_date.'"></script>' : "";
    echo ($pagina=="examen") ? '<script src="js/examen.js?ud='.$unix_date.'"></script>' : "";
    echo ($pagina=="webinar") ? '<script src="js/webinar.js?ud='.$unix_date.'"></script>' : "";
?>

	<script src="js/carrito.js?ud=<?php echo $unix_date ; ?>"></script>
	
<?php if(isset($pagina_2) && $pagina_2 =='cesta_pago_deposito'){ 
				// solo pago con deposito (*vouchers )
?>
	<script src="js/pasarela_solo_deposito.js?ud=<?php echo $unix_date ; ?>"></script>

<?php }else if($pagina=='cesta'){ 
			/* se listan 2 opciones: tarjeta y pago efectivo */
?>
	<script src="js/pasarela.js?ud=<?php echo $unix_date ; ?>"></script>
	<script src="https://checkout.culqi.com/js/v3"></script>

	<script src="js/pagoefectivo.js?ud=<?php echo $unix_date ; ?>"></script>
						
	<?php 
		if( isset($_SESSION["suscritos"]["id_suscrito"])){  	
			if($carrito->precio_total() > 0 ){  ?>
					<script>
						
						let total_pago_efectivo;
						total_pago_efectivo= $('input[name="total_pago_efectivo"]').val();
						console.log('==>'+total_pago_efectivo);
									
						$(document).ready(function() {
							Culqi = new culqijs.Checkout();
							Culqi.publicKey = '<?php echo PUBLIC_KEY ?>'; 
							Culqi.options({
								lang: 'es',
								modal: true,
							excluded_payment_types: {
								id:'credit_cart'
							},
								installments: false,
								customButton: 'Pagar',
								customButton2: 'Pagar con pago efectivo',
								style: {
									bgcolor: '#DB271C',
									maincolor: '#DB271C',
									disabledcolor: '#ffffff',
									buttontext: '#ffffff',
									maintext: '#333333',
									desctext: '#333333',
									logo: 'https://www.educaauge.com/img/logo-rojo-culqi-2.png'		  
								}
							})
							Culqi.settings({
								title: 'GRUPO AUGE',
								currency: 'PEN',
								description: 'Accede a los mejores Cursos online',
								amount: parseFloat(total_pago_efectivo)*100,
								order: '<?php echo trim($order->id); ?>'  // el codigo de pre_orden que se genera en efectivo.php 
							});
							
									// Culqi.open();
							// $('#pagar_pago_efectivo').on('click', function (e) {
									// Culqi.open();
									// e.preventDefault();
							// });
							
						});
					</script>
					<?php }
							}
					?>

<?php } // si estamos en cesta ?>





<?php if($pagina=='perfil_home'){ ?>
	<script>
	console.log("muestro modal de gracias, despues de comprar ");
	$('#exampleModal1').foundation('open');

	$(".close-button").find('.gracias').click(function(){
		location.reload();
	});
		
	</script>
<?php } // si estamos en cesta


if(isset( $_SESSION["suscritos"]["id_suscrito"] )){  ?>
<script src="js/suscribir_curso_gratis.js?ud=<?php echo $unix_date ; ?>"></script>
<?php }  ?>

<script src="js/update_info_para_certificado_seguimiento.js?ud=<?php echo $unix_date ; ?>"></script>



<?php /* cierro conexiones de BD */ 
// $bd->close();

?>
</body>
</html>