<?php include('auten.php');
$pagina='gru';
$meta = array(
    'title' => 'Paga con Pago Efectivo | Educa Auge',
    'description' => ''
);
include ('inc/header.php');

$meses=array('January'=>'Enero','February'=>'Febrero','March'=>'Marzo','April'=>'Abril','May'=>'Mayo','June'=>'Junio','July'=>'Julio','August'=>'Agosto','September'=>'Septiembre','October'=>'Octubre','November'=>'Noviembre','December'=>'Diciembre');
?>
<main id="pago_efectivo">
	<div class="callout callout-1 poppi"><div class="row">
		<div class="medium-6 columns text-center "><div class="centro-plomo">
			<h3 class="poppi-b">Gracias!</h3>
			<p class="poppi">Tu codigo de pago es: </p>
			<h1 class=" poppi-b color2 "><?php echo $_GET["task"]; ?></h1>
			<!--
			<p class="poppi">Válido hasta: <?php echo  date("F j, Y, g:i a",$_GET["expi"]); ?></p>
			-->
			<p class="poppi">Válido hasta: <?php echo  strtoupper(strtr(date("F j, Y, g:i a",$_GET["expi"]),$meses )); ?></p>
			<h4 class=" poppi " style="font-size:20px;line-height:24px;"><small class="poppi ">
				Acerquese a un agente de la entidad bancaria seleccionada o un agente de Pago Efectivo y realizar el pago brindando el 
				<b>código de pago CIP:</b> <span class="color2 "><?php echo $_GET["task"]; ?></span> </br>

				Indica que vas a realizar un pago de <span class="poppi-b"> s/<?php echo $_GET["amount"]; ?></span> a Pago Efectivo 
				</br></br>
				* recuerda que tambien puedes pagar desde tu Banca movil o banca online del banco seleccionado. </small>
			</h4>
		</div></div>
		<div class="medium-6 columns"><img src="img/img_paga_con_efectivo.jpg"></div>
	</div></div>
</main>
<?php include ('inc/footer.php'); ?>