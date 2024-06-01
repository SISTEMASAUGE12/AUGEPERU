<?php include('auten.php');  $_SESSION["url"]=url_completa(); 
$pagina='cesta';

require("class/Carrito.class.php");
$carrito = new Carrito();

$meta = array(
    'title' => 'Carrito de compra | Grupo Auge',
    'description' => ''
);
include ('inc/header-cesta.php');

// if(!empty($_SESSION["suscritos"]["id_suscrito"])){
	// $repetir_js_reg_login="NO";
// }else{
	// $repetir_js_reg_login="";

// }

?>
<!--  * para tarjeta
<script>
 // Culqi.publicKey ='pk_test_1cd2fd1c6fd0dd2c'; //para integracion
Culqi.publicKey ='pk_live_fc1168d9cb0551fd';
Culqi.init();
</script>

-->

<?php 
// /* Cargamos Requests y Culqi PHP  */
// include_once dirname(__FILE__).'/culqi-efectivo/libraries/Requests/library/Requests.php';
// Requests::register_autoloader();
// include_once dirname(__FILE__).'/culqi-efectivo/libraries/culqi-php/lib/culqi.php';
// include_once dirname(__FILE__).'/culqi-efectivo/settings.php';


// $precio_total_efectivo=$carrito->precio_total();

// /**  * Crear una orden previamente, esta orden ser aconfirmada al selecionar pago efectivo y la repeust ala recibo en pagoefetivo.js  */
// if( isset($_SESSION["suscritos"]["id_suscrito"])){  	
	// if($carrito->precio_total() > 0 ){  
		// $culqi = new Culqi\Culqi(array('api_key' => SECRET_KEY));
		// $order = $culqi->Orders->create(
			// array(
				// "amount" => $precio_total_efectivo *100,
				// "currency_code" => "PEN",
				// "description" => 'Venta cursos educauage ',        
				// "order_number" => "#id-".$_SESSION["suscritos"]["id_suscrito"].strtotime(fecha_hora(2))."123991239",  
				// "client_details" => array( 
						// "first_name"=> (!empty($perfil[0]["nombre"])?$perfil[0]["nombre"]:"NAME AUGE"), 
						// "last_name" => (!empty($perfil[0]["ap_pa"])?$perfil[0]["ap_pa"]:"APE AUGE "),
						// "email" => (!empty($perfil[0]["email"])?$perfil[0]["email"]:"sinemail@tuweb7.com"), 
						// "phone_number" => (!empty($perfil[0]["telefono"])?$perfil[0]["telefono"]:"945250434")
				 // ),
				// "expiration_date" => time() + 24*60*60,   // Orden con un dia de validez
				// /*  "expiration_date" => time() + 1*15*15,   // Orden con un dia de validez - 5min  */
				// "confirm" => false
				// )
		// );
		// /* echo json_encode($order);  */
	// }
// } /* end si exit sesion */
?>

<main id="cesta">
	<input type='hidden' name='total_pago_efectivo' value='<?php echo $carrito->precio_total(); ?>'>
	<div class="callout banners callout-1"><div class="fondo fondo-cesta"><div class="row">
	
		<div class="large-4 medium-4 top-30 bot-100 tama float-right columns">
			<div class="content_cart panel radius "></div>
		</div>
		<div class="large-8 medium-8 top-30 rel tam tama bot-100 columns"><div class="confi">
			<div class="content_data_pedido_compra ptmr panel radius"></div>
			
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