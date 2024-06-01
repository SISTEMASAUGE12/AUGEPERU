<?php 
include('auten.php'); 

$_SESSION["url"]=url_completa(); 
$pagina='cesta';

require("class/Carrito.class.php");
$carrito = new Carrito();

$meta = array(
    'title' => 'Pago Efectivo | Carrito de compra | AugePerú.com',
    'description' => ''
);
include('inc/header-cesta.php');


// Cargamos Requests y Culqi PHP
include_once dirname(__FILE__).'/culqi-efectivo/libraries/Requests/library/Requests.php';
Requests::register_autoloader();
include_once dirname(__FILE__).'/culqi-efectivo/libraries/culqi-php/lib/culqi.php';
include_once dirname(__FILE__).'/culqi-efectivo/settings.php';


$precio_total_efectivo=$carrito->precio_total();

/**
 * Crear una orden previamente, esta orden ser aconfirmada al selecionar pago efectivo y la repeust ala recibo en pagoefetivo.js 
 */
if( isset($_SESSION["suscritos"]["id_suscrito"])){  	
	if($carrito->precio_total() > 0 ){  
	
		$culqi = new Culqi\Culqi(array('api_key' => SECRET_KEY));
		$order = $culqi->Orders->create(
		array(
			"amount" => $precio_total_efectivo *100,
			// "amount" => 30000,
			"currency_code" => "PEN",
			"description" => 'Venta cursos educauage ',        
			"order_number" => "#id-".rand(1,9999),  
			"client_details" => array( 
					"first_name"=> (!empty($perfil[0]["nombre"])?$perfil[0]["nombre"]:""), 
					"last_name" => (!empty($perfil[0]["ap_pa"])?$perfil[0]["ap_pa"]:"AUGE"),
					"email" => (!empty($perfil[0]["email"])?$perfil[0]["email"]:"sinemail@tuweb7.com"), 
					"phone_number" => (!empty($perfil[0]["telefono"])?$perfil[0]["telefono"]:"945250434")
			 ),
			"expiration_date" => time() + 24*60*60,   // Orden con un dia de validez
			"confirm" => false
			)
		);
echo json_encode($order);
 
	}
} /* end si exit sesion */
?>

<main id="cesta">
	<input type='hidden' name='total_pago_efectivo' value='<?php echo $carrito->precio_total(); ?>'>
	<div class="callout banners callout-1"><div class="fondo fondo-cesta"><div class="row">
			<div class="large-4 medium-4 top-30 bot-100 tama float-right columns">
					<div  class="content_cart panel radius "></div>
			</div>

			<div class="large-8 medium-8 top-30 tam tama bot-100 columns"><div class="confi">
				
				<?php 
			if( isset($_SESSION["suscritos"]["id_suscrito"])){  	
					if($carrito->precio_total() > 0 ){  ?>
					<div class="container">
						<h1>CHECKOUT MULTIPAGO (Tarjetas + Pago Efectivo + Pago en Cuotas</h1>
						<a id="miBoton" class="btn btn-primary" href="#" >Pagar</a>
						<br/><br/><br/>
						<div class="panel panel-default" id="response-panel">
							<div class="panel-heading">Respuesta</div>
							<div class="panel-body" id="response">
							</div>
						</div>
					</div>
					
					<!-- 
					
					<iframe src="https://checkout.culqi.com?public_key=pk_test_1cd2fd1c6fd0dd2c&amp;title=QXVnZSBQZXLDug%3D%3D&amp;currency=UEVO&amp;description=QWNjZWRlIGEgbG9zIG1lam9yZXMgQ3Vyc29zIG9ubGluZSBwYXJhIGRvY2VudGVz&amp;amount=MTQwMDA%3D&amp;logo=aHR0cHM6Ly93d3cuZWR1Y2FhdWdlLmNvbS9pbWcvbG9nby1yb2pvLnBuZw%3D%3D&amp;installments=true&amp;orders=b3JkX3Rlc3RfcHZoTGhtc2ZZbE9oWllhUQ%3D%3D" id="culqi_checkout_frame" name="checkout_frame" class="culqi_checkout" allowtransparency="true" frameborder="0" style="background-color: rgba(0, 0, 0, 0.62); overflow: hidden auto; margin: 0px; z-index: 99999; position: fixed; visibility: collapse; height: 0px; width: 0px; left: 0px; top: 0px; display: block;"></iframe>
					
						
					<iframe src="https://checkout.culqi.com?public_key=pk_test_1cd2fd1c6fd0dd2c;" id="culqi_checkout_frame" name="checkout_frame" class="culqi_checkout" allowtransparency="true" frameborder="0" style="background-color: rgba(0, 0, 0, 0.62); overflow: hidden auto; margin: 0px; z-index: 99999; position: fixed; visibility: collapse; height: 0px; width: 0px; left: 0px; top: 0px; display: block;"></iframe>
					
					-->
					
					
					
					
					
					
					
					
					
					
					
					
					
					
				<?php }else{ ?> 
					<p class="poppi " style="padding:50px 0;" >La cesta esta vacia, valor del carrito s/0.00 </p>
				<?php } ?> 	
				
		<?php }else{ ?> 
					<p class="poppi " style="padding:50px 0;"> <a href="iniciar-sesion" >Inicia sesión</a> para poder pagar. </p>
		<?php } ?> 	
					
				</div></div>
    </div></div></div>
</main>



<?php include ('inc/footer.php'); ?>
<script>
		$('#miBoton').on('click', function (e) {
				Culqi.open();
				e.preventDefault();
		});
		
</script>

  