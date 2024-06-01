
  	<p id="back-top" style="display:block;"><a href="#top"><span></span></a></p>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>


  	<script src="js/foundation.min.js"></script>
 	<script> $(document).foundation(); </script>
	<script src="js/vendor/rem.min.js"></script>
	<script src="js/vendor/jquery.validate.min.js"></script>
	<script src="js/jquery.validate.tuweb7.js"></script>

	<script src="js/functions.js?ud=<?php echo $unix_date ; ?>"></script>
 <script src="js/llamar_registro_login.js?ud='.$unix_date.'"></script>
	<script src="js/carrito_efectivo.js?ud=<?php echo $unix_date ; ?>"></script>
	<!--
	<script src="js/pasarela.js?ud=<?php echo $unix_date ; ?>"></script>
	-->
	
	
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://checkout.culqi.com/js/v3"></script>
	<script src="js/pasarela.js?ud=<?php echo $unix_date ; ?>"></script>
	<script src="js/pagoefectivo.js?ud=<?php echo $unix_date ; ?>"></script>
	
<?php 
			if( isset($_SESSION["suscritos"]["id_suscrito"])){  	
					if($carrito->precio_total() > 0 ){  ?>
<script>
	
	let total_pago_efectivo;
	total_pago_efectivo= $('input[name="total_pago_efectivo"]').val();
	console.log('==>'+total_pago_efectivo);
				
	function resultdiv(message) {
		$('#response').html(message);
	} 
	function resultpe(message) {
		$('#response').html(message);
	}
        
	$(document).ready(function() {
		Culqi = new culqijs.Checkout();
		Culqi.publicKey = '<?php echo PUBLIC_KEY ?>'; 
		Culqi.options({
			lang: 'es',
			modal: true,
			installments: true,
			customButton: 'Pagar con pago efectivo',
			style: {
				bgcolor: '#f0f0f0',
				maincolor: '#53D3CA',
				disabledcolor: '#ffffff',
				buttontext: '#ffffff',
				maintext: '#4A4A4A',
				desctext: '#4A4A4A',
				logo: 'https://www.educaauge.com/img/logo-rojo.png'		  
			}
		})
		Culqi.settings({
			title: 'Auge Perú',
			currency: 'PEN',
			description: 'Accede a los mejores Cursos online para docentes',
			amount: parseFloat(total_pago_efectivo)*100,
			order: '<?php echo trim($order->id); ?>'  // el codigo de pre_orden que se genera en efectivo.php 
		});
		
				// Culqi.open();
		$('#miBoton').on('click', function (e) {
				Culqi.open();
				e.preventDefault();
		});
		
	});
</script>
<?php }
		}
?>

</body>
</html>