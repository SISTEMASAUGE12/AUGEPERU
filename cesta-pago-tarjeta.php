<?php   
include('auten.php');  $_SESSION["url"]=url_completa(); 
$pagina='cesta';
require("class/Carrito.class.php");
$carrito = new Carrito();

// $dcto= $carrito->precio_total() * 0.05;  /* descuento con tarjeta: 0.05 = 5%  */
$dcto= 0;  /* SIN descuento  */
$monto= ($carrito->precio_total() - $dcto) * 100;
$psarela_izi= "";

echo 'Cargando .. '.$monto;

$meta = array(
    'title' => 'Paga con tarjeta débito o crédito | EducaAuge.com',
    'description' => ''
);
include('inc/header-cesta.php');

/**  * To run the example, go to * 44  */
/**  * To run the example, go to * https://github.com/lyra/rest-php-example  */

/**  I initialize the PHP SDK  */
// require_once __DIR__ .'../izipay/vendor/autoload.php';
// require_once __DIR__ .'../izipay/keys.php';
// require_once __DIR__ .'../izipay/helpers.php';

if($carrito->precio_total() > 0){ 
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
$_POST["direccion"]=!empty($perfil[0]["direccion"])?$perfil[0]["direccion"]:'chiclayo 123 - peru ';
// $_POST["referencia"]=!empty($_POST["referencia"])?$_POST["referencia"]:'';
$_POST["nombre_anexo"]=!empty($perfil[0]["nombre"])?$perfil[0]["nombre"]:'';
$_POST["apellidos_anexo"]=!empty($perfil[0]["ape_pa"])?$perfil[0]["ape_pa"]:'';
$_POST["telefono_anexo"]=!empty($perfil[0]["telefono"])?$perfil[0]["telefono"]:'';
$_POST["celular_anexo"]=!empty($perfil[0]["telefono"])?$perfil[0]["telefono"]:'';
// $_POST["id_envio"]=!empty($_POST["id_envio"])?$_POST["id_envio"]:'';

echo $_SESSION["suscritos"]["email"]; 

/** * I create a formToken */
$store = array("amount" => $monto, 
"currency" => "PEN", 
// "orderId" => uniqid($ultima_venta),
"orderId" => $_SESSION["suscritos"]["id_suscrito"].'000'.strtotime(fecha_hora(2)).'000'.$_SESSION["suscritos"]["id_suscrito"],
"customer" => array(
	"email" => $_SESSION["suscritos"]["email"],
	"reference" => 'cliente id:'.$_SESSION["suscritos"]["id_suscrito"].' - compra izipay ',
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
		// "address2" => $_POST["referencia"],
		"address2" => '',
		"firstName" => $_POST["nombre_anexo"],
		"lastName" => $_POST["apellidos_anexo"],
		"identityCode" => $_POST["telefono_anexo"],   // DNI
		"phoneNumber" => $_POST["celular_anexo"]
		// "city" => $_POST["id_envio"]
	)
	
));
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
		

if(!empty($_SESSION["suscritos"]["id_suscrito"]) && $carrito->precio_total() > 0 ){

$psarela_izi= "
	<script src='https://api.micuentaweb.pe/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js'  kr-public-key='".$client->getPublicKey()."'  kr-post-url-success='process_cart/insert_bd_izi.php' kr-language='es-ES'> </script>
			

  <link rel='stylesheet' href='https://api.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic-reset.css'>
 <script src='https://api.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic.js'> </script> 
 
				<div  class='form_pago text-center mostrar_pasarela poppi  '> 	
			 <h4  class='color-1 poppi-b bold text-center '><img src='img/iconos/tarjeta.png' style='padding-right:7px;'>Pagar con tarjeta de crédito o débito </h4>							
			 <div class=' pago_online_formus '>				
						 <!-- payment form -->
					<div class='kr-embedded'
					 kr-form-token='".$formToken."'>
						<!-- payment form fields -->
						<div class='kr-pan'></div>
						<div class='kr-expiry'></div>
						<div class='kr-security-code'></div>  
						<!-- payment form submit button -->
						<button  class='kr-payment-button'></button>
						<!-- error zone -->
						<div class='kr-form-error'></div>
					</div>
			 </div>  
			<div style='padding-top:60px;'>
				<p style='padding-bottom:30px;'>* Pagando con tarjeta, obtienes un <b>descuento del 5%</b>:  </br> Total de descuento, ahorraras:  s/".$dcto."</p>
				<img src='img/paga_seguro_aqui.jpg' class='apa_img_pc'> 
				<img src='img/paga_seguro_aqui_movil.jpg' class='apa_img_movil'>
			</div> 
			 
			 ";						

} 


 ?>
 
<main id="cesta">
	<input type='hidden' name='total_pago_efectivo' value='<?php echo $carrito->precio_total(); ?>'>
	<div class="callout banners callout-1"><div class="fondo fondo-cesta"><div class="row">
	
		<div class="large-4 medium-4 top-30 bot-100 tama float-right columns">
			<div class="content_cart panel radius "></div>
		</div>
		<div class="large-8 medium-8 top-30 rel tam tama bot-100 columns"><div class="confi">
			<?php
			if($carrito->precio_total() > 0){
					echo $psarela_izi; 
			}else{ ?>
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
</main>
<?php include ('inc/footer.php'); ?>