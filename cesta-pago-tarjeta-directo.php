<?php   
include('auten.php');  $_SESSION["url"]=url_completa(); 
$pagina='cesta';
require("class/Carrito.class.php");
$meta = array(
    'title' => 'Compra ahora mismo con tarjeta débito o crédito | EducaAuge.com',
    'description' => ''
);
include('inc/header-cesta.php');

if(  isset( $_GET["rewrite"])  && !empty($_GET["rewrite"]) ){ 
	$curso=executesql(" select * from cursos where estado_idestado=1 and id_curso='".$_GET["rewrite"]."' ");
	if(  !empty($curso) ){ 
		$fecha_actual = strtotime(date("d-m-Y"));
		$fecha_entrada = strtotime($curso[0]["fecha_fin_promo"]);

		/* 
		if($fecha_actual < $fecha_entrada  &&  (!empty($curso[0]["costo_promo"]) && $curso[0]["costo_promo"]!="0.00") ){
			$precio=$curso[0]["costo_promo"];
		}else{
			$precio=$curso[0]["precio"];
		}
		*/

		$precio=$curso[0]["precio_online"];

		// $dcto= $precio * 0.05;  /* descuento con tarjeta: 0.05 = 5%  */
		$dcto= 0;  /* SIN descuento  */
		$monto= ($precio - $dcto) * 100;
		$psarela_izi= "";

		echo 'Cargando .. '.$monto;


if($precio > 0){ 
	echo "entro isi ";

	include_once dirname(__FILE__).'/izipay/vendor/autoload.php';
	include_once dirname(__FILE__).'/izipay/keys.php';
	include_once dirname(__FILE__).'/izipay/helpers.php';
	/**  * Initialize the SDK * see keys.php  */
	$client = new Lyra\Client();

	// $_POST["tipo_comprobante"]=!empty($_POST["tipo_comprobante"])?$_POST["tipo_comprobante"]:'';
	// $_POST["rason_social"]=!empty($_POST["rason_social"])?$_POST["rason_social"]:'';
	// $_POST["ruc"]=!empty($_POST["ruc"])?$_POST["ruc"]:'';
	// $_POST["lugar_fact"]=!empty($_POST["lugar_fact"])?$_POST["lugar_fact"]:'';
	// $_POST["destino_fact"]=!empty($_POST["destino_fact"])?$_POST["destino_fact"]:'';
	// $_POST["correo_ruc"]=!empty($_POST["correo_ruc"])?$_POST["correo_ruc"]:'';
	// $_POST["comentario"]=!empty($_POST["comentario"])?$_POST["comentario"]:'';
	

	$_POST["direccion"]= 'actualiza tu direccion: av.avenida  #123 - peru ';
	// $_POST["referencia"]=!empty($_POST["referencia"])?$_POST["referencia"]:'';
	$_POST["nombre_anexo"]=' AUGE Peru';
	$_POST["apellidos_anexo"]=' compra directa';
	$_POST["telefono_anexo"]= '';
	$_POST["celular_anexo"]= '';
	// $_POST["id_envio"]=!empty($_POST["id_envio"])?$_POST["id_envio"]:'';

	/** * I create a formToken */
	$store = array(
		"amount" => $monto, 
		"currency" => "PEN", 
		// "orderId" => uniqid($ultima_venta),
		"orderId" => '000'.strtotime(fecha_hora(2)).'000',	
		"customer" => array(
			"email" => 'compradirecta@educaauge.com',
			"reference" => 'cliente id:  - compra directa izipay ',
			// "billingDetails" => array(
				// "zipCode" => $_POST["tipo_comprobante"], // boleta / factura 
				// "legalName" => $_POST["rason_social"],
				// "identityCode" => $_POST["ruc"],
				// "address" => $_POST["lugar_fact"],  // direccion legal
				// "city" => $_POST["destino_fact"],  // ciudad/dpto
				// "lastName" => $_POST["correo_ruc"]  // correo ruc referencia 
			// ),	
			"shippingDetails" => array (
				"address" => $_POST["direccion"],
				//"address2" => '',
				"firstName" => $_POST["nombre_anexo"],
				"lastName" => $_POST["apellidos_anexo"],
				"identityCode" => $_POST["telefono_anexo"],   // DNI
				"phoneNumber" => $_POST["celular_anexo"],
				
				"address2" => $precio, // envio precio enmascarado aqui 
				"city" => $_GET["rewrite"]   // aca envio el id_curso enmascarado 
			)			
		),
		"metadata" => array(
			"cybersource_mdd_13" => "0606060606"
		)
	);
	$response = $client->post("V4/Charge/CreatePayment", $store);

	/* I check if there are some errors */
	if ($response['status'] != 'SUCCESS') {
		/* an error occurs, I throw an exception */
		display_error($response);
		$error = $response['answer'];
		throw new Exception("error " . $error['errorCode'] . ": " . $error['errorMessage'] );
	}

	/* everything is fine, I extract the formToken */
	$formToken = $response["answer"]["formToken"];

} /* monto a pagar es > 0 */ 		
		

if( $precio > 0 ){

	//$psarela_izi= "";						

} 


 ?>
 
<main id="cesta">
	<input type='hidden' name='total_pago_efectivo' value='<?php echo $precio; ?>'>
	<div class="callout banners callout-1 _pago_directo"><div class="fondo fondo-cesta"><div class="row">
	
		<div class="large-4 medium-4 top-30 bot-100 tama float-right columns">
			<div class="  panel radius ">
				<div class="detalle">
					<figure class="img-cesta rel">
						<img src="tw7control/files/images/capa/<?php echo $curso[0]["imagen"]; ?>">
						<div class="capa abs"></div>
					</figure>				
					<div class="titulo">
						<p class="poppi-b color1"><?php echo $curso[0]["codigo"]; ?> - <?php echo $curso[0]["titulo"]; ?> </p>
						<span class="color1 poppi">precio efectivo: s/<?php echo $precio; ?></span>
						<span class=" poppi red">precio online: s/ <?php echo $precio; ?></span>
					</div>
				</div>					
				<div class="detalle">
					<div class="clearfix"></div>
					<div class="pagar">
						<p class="poppi-sb color4">Total a pagar</p><p class="poppi-b color1 total_a_pagar_texto"> <?php echo $precio; ?></p>
					</div> 
						
					<!-- <div class="pagar"> <p class="poppi-sb color4">Total a pagar tarjeta</p><p class="poppi-b color1 total_a_pagar_texto_online ">s/ 149.90</p> </div> -->
					<ol class="no-bullet roboto uni">
						<li><img src="img/iconos/pago1.png"></li>
						<li><img src="img/iconos/pago2.png"></li>
						<li><img src="img/iconos/pago3.png"></li>
					</ol>
					<blockquote class="poppi texto uni"><img src="img/iconos/candado3.png"> Pago 100% Seguro</blockquote>
					<blockquote class="poppi texto uni"><img src="img/iconos/estrella_pago_directo.png"> Garantía de reembolso 100%</blockquote>
					<blockquote class="poppi texto uni"><img src="img/iconos/estrella_pago_directo.png"> Transacciones seguras</blockquote>
					<blockquote class="poppi texto uni"><img src="img/iconos/estrella_pago_directo.png"> Soporte 24/7</blockquote>
		


					<span class="texto poppi uni">Este sitio cumple con los estándares de seguridad de la industria de medio de pago PCI-DSS para proteger su información personal y la de su tarjeta.</span> 
					<div class="text-center">
						<p class="poppi-sb color1 " style="padding:20px 0 10px;">¿Cómo comprar mis cursos en el grupo AUGE?</p>
						<div class="rel">
							<img src="img/ver_video_compra.jpg">
							<a href="https://player.vimeo.com/video/665416920" class="abs mpopup-02 "></a>
						</div>
					</div> 
				</div> 
				<script>    $(".mpopup-02").magnificPopup({ type : "iframe" }); /* efecto ventana emergente ara video*/</script>
				<div class="small reveal modal_gracias " id="exampleModal1" data-reveal="">
					<p class="poppi-sb color1 text-center " style="padding:20px 0 10px;">¿Cómo comprar tus cursos en el grupo AUGE?</p>
					<div class="large-12 columns">
						<div class="rel  modal_de_gracias_por_compra ">
							<div class="para-video">
								<iframe width="100%" class="height-video-you" src="https://player.vimeo.com/video/665416920?h=6ed187ca84" frameborder="0" allowfullscreen="" name="1941F1B806921EE6E3A4C4E7B004729E-0"></iframe>
							</div>
						</div>
					</div>
					<button class="close-button gracias_close" data-close="" aria-label="Close modal" type="button">
						<span aria-hidden="true">×</span>
					</button>
				</div>
			</div>
		</div>
	
		<div class="large-8 medium-8 top-30 rel tam tama bot-100 columns"><div class="confi">		
			<?php
			if($precio > 0){
					// echo $psarela_izi; 		
		?>

				
			<script src='https://api.micuentaweb.pe/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js'  kr-public-key='<?php echo $client->getPublicKey(); ?>'  kr-post-url-success='process_cart/insert_bd_izi_directo.php' kr-language='es-ES'> </script>			
			<link rel='stylesheet' href='https://api.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic-reset.css'>
		   	<script src='https://api.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic.js'> </script> 
		   

					  <div  class='form_pago text-center mostrar_pasarela _pago_directo poppi  '> 	
					   <!-- <h4  class='color-1 poppi-b bold text-left '><img src='img/iconos/tarjeta.png' style='padding-right:7px;'>Pagar con tarjeta de crédito o débito </h4> -->
					   <h4  class='color-1 poppi-b bold text-left '> Información </h4>							
					   <div class=' pago_online_formus '>				
								   <!-- payment form -->  
							  <div class='kr-embedded  '
							   kr-form-token='<?php echo $formToken; ?>'>
		  
							   <!-- custom text field -->
								  <input type='text' name='acme-nombre' placeholder='Ingresa tu Nombre completo' class='kr-theme' kr-icon='fas fa-user' required/>  <!-- * puedo enviar datos y los recibo cn post -->
								  <input type='text' name='acme-email' placeholder='Ingresa tu email' class='kr-theme' kr-icon='fas fa-envelope' required/>  <!-- * puedo enviar datos y los recibo cn post -->
								  <input type='text' name='acme-dni' placeholder='Ingresa tu DNI' class='kr-theme ' kr-icon='fas fa-id-card' required/>  <!-- * puedo enviar datos y los recibo cn post -->
								  <input type='hidden' name='acme-id_curso' value='<?php echo $_GET["rewrite"]; ?>'/>						  								  
								  <?php crearselect("acme-id_especialidad","select id_especialidad, titulo  from especialidades where estado_idestado=1 order by orden desc ",'class="poppi  kr-theme " required',''," Selecciona tu especialidad "); ?>
		  
								  								  										  
								  <h4  class='color-1 poppi-b bold text-left v_2 '><img src='img/iconos/tarjeta.png' style='padding-right:7px;'>Compra ahora con tarjeta de crédito o débito </h4>									  
								  <!-- 
								  <div class='kr-card-holder-name'></div>  
								  <div class='kr-identity-document-type'></div>  
								  <div class='kr-identity-document-number'></div>  
								  -->
		  
								  <!-- payment form fields -->
								  <div class='kr-pan'></div>
								  <div class='kr-expiry'></div>
								  <div class='kr-security-code'></div>  
		  						  
								  <!-- custom hidden field  :: sirve para enviar datos ocultos -->
								  <input type='hidden' name='acme-hidden' value='my hidden value'/>
		  		  
								  <!-- payment form submit button -->
								  <button  class='kr-payment-button'></button>
								  <!-- error zone -->
								  <div class='kr-form-error'></div>
							  </div>
					   </div>  
					  <div style='padding-top:60px;' class='text-left '>
						  <img src='img/pago_directo_extra.jpg' class=' '  style='padding:10px 0 30px;'> 
						  <p style='padding-bottom:30px;' class='hide '>* Pagando con tarjeta, obtienes un <b>descuento del 5%</b>:  </br> Total de descuento, ahorraras:  s/".$dcto."</p>				
					  </div> 


		<?php
			}else{ // si esta vacio  ?>
				<div  class="content_data_pedido_compra ptmr panel radius"></div>

			<?php } ?>
			<!-- *icono de cargando   -->
			<div class="cargando_pago  hide ">
				<div class=" flotante_cargando  text-center " >
					<figure> <img src="img/ico_cargando.png">
					</figure>
					<h3 class="poppi-sb ">Espere, procesando la compra .. </h3>
				</div>
			</div>
			
		</div></div>
		
	</div></div></div>

<?php 
	}else{  // sino existe rewrite 
		echo " <div class=' text-center ' style='padding-top:150px;'>  <h3> El curso no existe o se ecnuentra deshabilitado. Comunicarse con una asesora de venta. </h3></div>";
	} 
}else{  // sino existe rewrite 
	echo " <div class=' text-center ' style='padding-top:150px;'>  <h3>Solicita un link de pago directo con un curso asignado </h3></div>";
} 
?>
</main>
<?php include ('inc/footer.php'); ?>