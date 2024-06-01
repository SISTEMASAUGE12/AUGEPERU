<?php include('auten.php');
$pagina="cont";
$meta = array(
    'title' => 'Formas de pago | '.$_dominio,
    'description' => ''
);
include('inc/header.php'); ?>
<main id="contacto"  style="padding-top:40px;">

  	<div class="callout callout-2 "><div class="row text-center">
  		<div class="large-12 columns  text-center " >
  			<h3 class="color2 poppi-b ">FORMAS DE PAGO</h3>
  			<p class="color1 poppi" style="margin:0 auto;">Para matricularte debes seguir los siguientes pasos:</p>
  		</div>
  		<div class="large-4 medium-4 columns"><div class="cuadro">
  			<figure class="rel"><img class="" src="img/forma_pago_1.png"></figure>
				<h3 class="poppi-sb " style="color:#056FA0;">Regístrate</h3>
  			<p class="color1 poppi"><b>Registrate e inicia sesión en  www.<?php echo $_dominio; ?></b> </br>	Agrega al carrito de compra los cursos a pagar.
				</p>
  		</div></div>
			
  		<div class="large-4 medium-4 columns"><div class="cuadro">
  			<figure class="rel"><img class="" src="img/forma_pago_2.png"></figure>
				<h3 class="poppi-sb " style="color:#FF6600;">Paga</h3>
  			<p class="color1 poppi"><b>Escoje una de las 3  opciones de Pago que ofrece <?php echo $_dominio; ?></b> </br> Efectúa tus pagos con tarjeta, Pago Efectivo o en un agente / ventanilla, en nuestras cuentas bancarias.
				</p>
  		</div></div>
			
  		<div class="large-4 medium-4 columns"><div class="cuadro">
  			<figure class="rel"><img class="" src="img/forma_pago_3.png"></figure>
				<h3 class="poppi-sb " style="color:#6AA308;">Confirma</h3>
  			<p class="color1 poppi"> <b>Pago Deposito VOUCHER</b> </br> Si realiza un pago offline en  agente o ventanilla, sírvase <b>enviarnos el voucher</b>  y los datos del pago en el sgte link <a href="https://www.<?php echo $_dominio; ?>/cesta-pago-deposito" target="_blank" >[ click aquí ] </a>
				 O envia tu voucher de pago al correo <b><?php echo $_email_empresa; ?></b>
				</p>
  		</div></div>
			
		<div class="large-12 columns  text-center " >
  			<h3 class="color2 poppi-b p_top">Pagos con depósito bancario</h3>
  			<p class="color1 poppi" style="margin:0 auto;">Usted puede hacer efectivo sus pagos en las siguientes cuentas bancarias</p>
  		</div>

<?php 
		$bancos= executesql(" select * from bancos where estado_idestado=1 order by orden desc "); 
		foreach( $bancos as $data_banca ){ 
		?>
  		<div class="large-6 columns  end   text-left ">
				<div class="data_banco  rel ">
					<div class="lleva_banco  rel ">
						<figure class=" "> <img src="tw7control/files/images/bancos/<?php echo $data_banca["imagen"]; ?>"></figure>
						<p class="color1 poppi">
								<b><?php echo $data_banca["nombre"]; ?></b> </br>
								*Nº <?php echo $data_banca["cuenta"]; ?> </br>
								CCI: <?php echo $data_banca["cuenta_cci"]; ?> </br>
								<b> <?php echo $data_banca["titular"]; ?> </b>
							 </br>	Después de realizado el depósito en el Banco, Iniciar sesión en <?php echo $_dominio; ?>, agregar los cursos pagados al carrito de compras y enviar los datos de pago mediante la opción: </br>
								<b><a href="https://www.<?php echo $_dominio; ?>/cesta-pago-deposito" target="_blank" >Pago Deposito [click aquí]</a> </b></br> 
								para proceder a realizar su matrícula en el curso. 
						</p>
					</div>
				</div>
  		</div>
	<?php } // end for  ?>   	
			
		<div class="large-12 columns  text-center end " >
  			<h4 class="color1 poppi-b " style="padding-bottom:50px;">Envia tu voucher de pago al correo </br> </br>
			<a class="blanco " style="background:#EE0005;padding: 6px 10px; border-radius: 12px;">informes@<?php echo $_dominio; ?> </a> </h4>

			<h3 class="color2 poppi-b p_top   hide " style="padding-bottom:50px;">Pagos por aplicativo</h3>
		</div>
<?php /*
			<div class="large-6 columns    text-center ">
				<figure><img src="img/iconos/yape_2.png"></figure>
			</div>
			<div class="large-6 columns    text-center ">
				<figure><img src="img/iconos/data_bn_2.png"></figure>
			</div>
			*/ ?>
			
			<div class="large-6 large-centered medium-8 medium-centered  poppi  data_2_anexo columns">
				<h5 class="poppi-sb color4 text-center " style="padding-bottom:10px;display:inline-block;"> 
						<small class="ptop color4 text-left ">¿Cómo ver el número de operación en voucher?  </small> 
				</h5>
				<div class="rel ">
					<div class="rel ">
							Click en imagen para ampliar
						<figure class=" rel mpopup-01 " style="padding-top:10px;">
							<img src="img/foto_voucher.jpg" style="height:300px;">
							<a href="img/foto_voucher.jpg" class="abs ico_foto"></a>
						</figure>
					</div>
				</div>	
								
				<h5 style="padding:0;"><small class="poppi-sb color1 final">Nota importante:</small></h5>
				<div class=" text-left ">

					<p>- Enviar voucher nítido en buena resolución </br> 
					- En el asunto enviar el Nº de operación y entidad bancaria </br> 
					- No enviar voucher con borrones porque no aceptaremos. </br> 
					- No enviar voucher al whatsapp, todo voucher es al correo de <?php echo $_email_empresa; ?></p>
				</div>
			</div>

				<div class="large-12 columns form "></div> 



	</div></div>
</main>
<?php include('inc/footer.php'); ?>