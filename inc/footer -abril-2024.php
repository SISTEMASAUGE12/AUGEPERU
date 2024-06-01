<?php
if(($pagina=='cesta') || ($pagina=='diplomas') || ($pagina=='login_v2') || ($pagina=='registro') || ($pagina=='docen') || ($pagina=='perfil') || ($pagina=='examen') || ($pagina=='webinar') || ($pagina=='actualiza-datos') || ($pagina=='trafico') || ($pagina=='blog_trafico')  || ( $pagina == "landing_extra_larga") ){

}else{
?>
  	<footer <?php echo ($pagina=='portada' || $pagina=="cont" || $pagina=="perfil" || $pagina=="certi" || $pagina=="blog") ? '  ' : ''; ?>>
  		<div class="callout final"><div class="row  text-left ">				
  			<div class="large-3 medium-6 columns">
  				<p class="bold titu">Educa Auge:</p>
  				<ul class="linka text-left">
  					<li class="text-left "><span></span><a href="docentes">Docentes</a></li>
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
  					<li class="text-left "><span></span><a href="preguntas-frecuentes/otras-preguntas"><b>Preguntas Frecuentes</b></a></li>
  					<li class="text-left "><span></span><a href="vendedoras"><b>Ejecutivas de Ventas</b></a></li>
  					<li class="text-left "><span></span><a href="tutoriales">Tutoriales</a></li>
  					<li class="text-left "><span></span><a href="cesta-pago-deposito">Pago Deposito</a></li>
  					<li class="text-left "><span></span><a href="formas-de-pago">Formas de Pago</a></li>
  					<li class="text-left "><span></span><a href="https://www.educaauge.com/unete-al-canal-de-whatsapp">Únete a nuestro canal de WhatsApp</a></li>
  					<li class="text-left "><span></span><a href="augeperu-telegram">Únete a nuestro canal de Telegram</a></li>
  					<li class="text-left "><span></span><a href="grupo-de-facebook">Grupo de facebook</a></li>
  					<li class="text-left "><span></span><a href="facebook-testimonios">Testimonios de facebook</a></li>
  				</ul>
  			</div>
  			<div class="large-3 medium-6 columns">
  				<p class="bold titu">&nbsp;</p>
  				<ul class="linka text-left">
  					<li class="text-left "><span></span><a href="eventos">Eventos gratuitos</a></li>
  					<li class="text-left "><span></span><a href="convocatoria">Trabaja con nosotros</a></li>
  					<li class="text-left "><span></span><a href="politicas-de-datos-y-seguridad">Políticas de datos y privacidad</a></li>
  					<li class="text-left "><span></span><a href="politicas-de-privacidad" >Términos y condiciones</a></li>
  					<li class="text-left " style="list-style:none;">
						<a href="libro-de-reclamaciones" title="libre reclamaciones"> Libro de reclamaciones</a>
					</li>
					<li class="text-left   " style="margin-top:7px;">
						<a href="llamanos-gratis" alt="llamar" style=" padding: 9px 13px;background:transparent;color:#fff;border:0;" > <img src="img/iconos/call_4.png">  Llamar al (01) 7097855 </a>
					</li>
					<li class="text-left   " style="margin-top:7px;">
						<a class=" bold " href="mailto:informes@educaauge.com"> informes@educaauge.com </a> 					  	
					</li>
  					
  				</ul>
  			</div>
        	<div class="large-3 medium-6 large-text-left medium-text-left text-center columns">
				<div class="social-item">
					<a href="https://www.facebook.com/www.augeperu.org" title="facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
					<a href="https://www.instagram.com/auge_peru" title="instagram" target="_blank"><i class="fab fa-instagram"></i></a>
					<a href="https://www.linkedin.com/in/auge-per%C3%B9-centro-de-capacitaci%C3%B3n-actualizaci%C3%B3n-320a82a3/" title="linkedin" target="_blank"><i class="fab fa-linkedin"></i></a>
					<a href="https://www.youtube.com/@GRUPOAUGECapacitacionDocente" target="_blank" title="youtube"><i class="fab fa-youtube-square"></i></a>
								<!-- 
					<a href="" target="_blank"><i class="fab fa-twitter"></i></a>
								-->
        		</div>
				<div class="text-left  lleva_btn_grupo_wsp_footer " style="margin-top:7px;">
						<a  class=" _btn  text-center " href="https://api.whatsapp.com/send?phone=+51<?php echo $_num_wsp;?>&text=Hola%20Grupo%20AUGE%20Quiero%20Informaci%C3%B3n"  target="_blank" alt="whatsapp">
							<img src="img/iconos/whatsapp.png" alt="whatsapp" width="50px"> WhatsApp oficial  
						</a>  </br> 
				</div>
			</div>
    	</div></div>
    	<div class="callout fin"><div class="row">
    		<div class="large-6 medium-6 float-right columns"><ul class="no-bullet roboto">				
					<li class=" color1 <?php echo ($pagina=="blog") ? "active " : ""; ?>"><a href="blog">Publicaciones</a></li>					
					<li class="color1 "> <a href="politicas-de-datos-y-seguridad">Políticas de datos y privacidad</a></li>
	    		<li class=" color1" ><a href="politicas-de-privacidad">Términos y condiciones</a></li>
	    	</ul></div>
	    	<div class="large-6 medium-6 columns">
					<p class="  roboto">Copyright © GRUPO AUGE <?php echo date('Y');?> -Todos los derechos reservados</p>
					<!-- 
					<p class="texto roboto" style="padding-top:5px;"><a href="https://www.tuweb7.com" target="_blank" >Desarrollado por <img src="img/iconos/by.png"></a></p>
					-->
					<p class="  roboto" style="padding-top:5px;"></p>
				<?php if( $pagina != 'canal-whatsapp'){ ?>
					<a href="<?php echo $link_grupo_wasap; ?>" title="  canal_wsp_flota" target="_blank" class=" canal_wsp_flota  poppi  hide "  >
						<!-- <img src="img/iconos/canal_wsp.png" alt="Únete a nuestro  canal de whatsApp ">Canal de WhatsApp</span> -->
						<img src="img/iconos/btn_canal-6.png">
					</a>
				<?php } ?>

				</div>
	    </div></div>
	</footer>
<?php
}
?>
  	<p id="back-top" style="display:block;"><a href="#top" title="subir "><span></span></a></p>
		<!--
  	<a class="oculw" href="https://api.whatsapp.com/send?phone=51999999999&text=Quiero%20Información" target="_blank"><img src="img/iconos/wspf.png"></a>
		-->
		
		
		
<?php if($pagina !='pago_efectivo'){ ?>
<!-- 
	<script src="js/vendor/jquery.min.js?ud=<?php echo $unix_date ; ?>"></script>
	<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
-->
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>

<?php }else{ ?>		
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	
	<?php } ?>
	
	
<?php if( $pagina !='login_v2'){ ?>
  	<script src="js/css3-animate-it.js"></script>
<?php } ?>
  	<script src="js/foundation.min.js"></script>
 	<script> $(document).foundation(); </script>
	<script src="js/vendor/rem.min.js"></script>
	
<?php if( $pagina !='login_v2'){ ?>
	<!-- Lightslider -->
	<script src="js/vendor/lightslider/lightslider.js"></script>
	<!-- Magnific Popup -->
	<script src="js/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
	<script src="https://www.google.com/recaptcha/api.js"></script>
<?php } ?>
	
	<!-- Validate -->
	<script src="js/vendor/jquery.validate.min.js"></script>
	<script src="js/jquery.validate.tuweb7.js?ud=<?php echo $unix_date ; ?>"></script>

<?php if( $pagina !='login_v2'){ ?>
	<script src="js/sweetalert.min.js"></script>
<?php } ?> 

<?php if($pagina=='blog'){ ?>
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-600b0d286d8e3385"></script>
	<?php } ?>


	<!-- Own JS -->
	<script src="js/functions.js?ud=<?php echo $unix_date ; ?>"></script>
	<script src="js/main.js?ud=<?php echo $unix_date ; ?>"></script>

<?php if( $pagina !='login_v2'){ ?>
	<script src="js/coautoria.js?ud=<?php echo $unix_date ; ?>"></script>
<?php } ?> 

<?php
/* esto es para registro login: facebook y google */
    // echo ($pagina=="cesta") ? '' : '<script src="js/llamar_registro_login.js?ud='.$unix_date.'"></script>'; // en la cesta este viene desde js.
    // echo ($pagina=="registro") ? '<script src="js/registro.js?ud='.$unix_date.'"></script>' : "";
/* end reg. redes sociales */		

	echo '<script src="js/registro_v2_portada.js?ud='.$unix_date.'"></script>';
	echo '<script src="js/registro_v2_leads.js?ud='.$unix_date.'"></script>';
	
    echo ($pagina=="cesta") ? '' : '<script src="js/llamar_v2_registro_login.js?ud='.$unix_date.'"></script>'; // en la cesta este viene desde js.
		
    echo ($pagina=="registro" || $pagina=="cesta") ? '<script src="js/registro_v2_consulta.js?ud='.$unix_date.'"></script>' : "";
    echo ($pagina=="registro" || $pagina=="cesta") ? '<script src="js/registro_v2_guardar_update_consulta.js?ud='.$unix_date.'"></script>' : "";
    echo ($pagina=="registro" || $pagina=="cesta") ? '<script src="js/registro_v2.js?ud='.$unix_date.'"></script>' : "";
    
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

	<!-- 
	<script src="https://checkout.culqi.com/js/v3"></script>
	<script src="js/pagoefectivo.js?ud=<?php echo $unix_date ; ?>"></script>
-->				
	<?php 
		if( isset($_SESSION["suscritos"]["id_suscrito"])){  	
			/* ocultamos pago efectivo culqui, creoq  hyay error ,. cambio formato de culqi 
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
					*/
							}  // end si existe sesion 
					?>

<?php } // si estamos en cesta 

?>





<?php if($pagina=='perfil_home'){ ?>
	<script>
		console.log("muestro modal de gracias, despues de comprar ");
		$('#exampleModal1').foundation('open');
		
		$(".close-button").find('.gracias').click(function(){
			location.reload();
		});
			
	</script>
<?php } // si estamos en cesta ?>


<?php 
if($pagina=='portada'){   // emergente tipo de opcion a escoger al usuario 	
	if( !isset( $_SESSION["suscritos"]["id_suscrito"] )){			
?>	
    <div id="ventana_emergente_opciones_acceso" class=" modal_gracias_cerra_opciones ">
		<div class=" _contiene_emergente  text-center ">              
			<button class="close-button gracias_close_ventana_opciones " data-close aria-label="Close modal" type="button"><img src="img/iconos/icono_cerrar_index_flota.png" aria-hidden="true"> </button>
			<h3 class="poppi-b color1  ">¡Bienvenido!</h3>
			<h4 class="poppi-b color1  ">¿QUÉ QUIERES HACER HOY?</h4>
			<div class=" large-6 medium-6 columns text-center poppi-b ">
				<a href="iniciar-sesion_v2">
					<div CLASS=" _div f_gris "> <h5 class="poppi-b blanco  ">Ingresar a </br> clases </h5> </div>
				</a>
			</div>
			<div class=" large-6 medium-6 columns text-center poppi-b  ">
				<a href="https://educaauge.com/curso/todos">
					<div CLASS=" _div f_red "><h5 class="poppi-b blanco  ">Más información sobre nuestros cursos</h5>	</div>
				</a>
			</div>
        </div>
    </div>	
	<script>
		console.log("muestro modal emergente ");
		$(document).on('click','.modal_gracias_cerra_opciones',function(){										
			document.getElementById('ventana_emergente_opciones_acceso').style.display = "none"; 
		});
	</script>
<?php
	}
}  // end pagina portda  venyana_emergente ?>



<?php  
if($pagina=='portada' || $pagina=='mis_cursos'){   // emergente 	adminstrbles 
	//if(isset( $_SESSION["suscritos"]["id_suscrito"] )){
		$flotantes=executesql("select * from flotantes where  id_especialidad=0 and  estado_idestado=1 order by orden desc limit 0,1"); 
		if(!empty($flotantes)){
			include("inc_modal_emergente.php"); 
		} // end cosulta floantes 
?>
		<script>
			console.log("muestro modal emergente ");
			$(document).on('click','.gracias_close',function(){		
				console.log("close emergente adminst6rables");								
				document.getElementById('ventana-emergente-1').style.display = "none"; 
			});
		</script>
<?php
//	}
}  // end pagina portda  venyana_emergente 

?>


<?php if( ($pagina=='miembros' && isset($_GET["rewrite"])) || ($pagina=='testimonios' && isset($_GET["rewrite2"])) ){ ?>
	<script>
	console.log("muestro modal de tutoriales.. ");
	$('#exampleModal1').foundation('open');

	$(".close-button").find('.gracias').click(function(){
		location.reload();
	});
		
	</script>
<?php } // si estamos en cesta ?>

<?php
if(isset( $_SESSION["suscritos"]["id_suscrito"] )){  ?>
<script src="js/suscribir_curso_gratis.js?ud=<?php echo $unix_date ; ?>"></script>
<?php }  ?>

	

<?php /* cierro conexiones de BD */ 
 // $bd->close();

?>

</body>
</html>