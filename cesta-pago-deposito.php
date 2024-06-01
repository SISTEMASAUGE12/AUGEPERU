<?php include('auten.php');  $_SESSION["url"]=url_completa(); 
$pagina='cesta';
$pagina_2='cesta_pago_deposito';
$meta = array(
    'title' => 'Pago Deposito - Carrito de compra | AugePerú.com',
    'description' => ''
);
include ('inc/header-cesta.php');

// if(!empty($_SESSION["suscritos"]["id_suscrito"])){
	// $repetir_js_reg_login="NO";
// }else{
	// $repetir_js_reg_login="";

// }

?>
<script>
 Culqi.publicKey ='pk_test_1cd2fd1c6fd0dd2c'; //para integracion
// Culqi.publicKey ='pk_live_fc1168d9cb0551fd';
Culqi.init();
</script>
<main id="cesta">

    <div class="callout banners callout-1"><div class="fondo fondo-cesta"><div class="row">
        <div class="large-4 medium-4 top-30 bot-100 tama float-right columns">
					<div  class="content_cart panel radius "></div>
				</div>

        <div class="large-8 medium-8 top-30 tam tama bot-100 columns"><div class="confi">
			<div  class="content_data_pedido_compra ptmr panel radius"></div>
        </div></div>
    </div></div></div>
</main>
<?php include ('inc/footer.php'); ?>