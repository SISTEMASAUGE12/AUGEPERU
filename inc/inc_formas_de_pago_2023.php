<div  class=" large-12 columns descripcion  "><div  class=" mostrar_cuentas">
	<h5 class="poppi-sb color1 text-center " > 
			Pagos con depósito bancario </br>
			<small class=" color4">Usted puede hacer efectivo sus pagos en las siguientes cuentas bancarias</small> 
	</h5>

<?php 
	$bancos= executesql(" select * from bancos where estado_idestado=1 order by orden desc "); 
	foreach( $bancos as $data_banca ){ 
?>
	<div class="bancos">		
		<div>
			<figure class=""><img src="tw7control/files/images/bancos/<?php echo $data_banca["imagen"]; ?>"></figure>
			<p class="poppi color4">
				<span class="poppi-sb color3"> <?php echo $data_banca["nombre"]; ?> </span> </br>
				Nº cuenta <?php echo $data_banca["cuenta"]; ?>
				<br>CCI: <?php echo $data_banca["cuenta_cci"]; ?>
				<br><span class="poppi-sb color3"> <?php echo $data_banca["titular"]; ?> </span>
			</p> 
		</div>
	</div>	
<?php } // end for  ?> 

	
<?php /* 	
<h5 class="poppi-sb color1 text-center " > Pagos por aplicativo </h5>
<div class="bancos lleva_yape  text-center ">
	<p class="poppi-sb color2">Pago con Yape - BCP </br>
			<small class="color1">AUGE GROUP CORPORATION SAC</small>
	</p>
	<div class="yape">
		<figure class="rel"> <img src="img/iconos/ico-paga-yape-3.jpg"></figure>
		<figure  class="rel"> <img src="img/iconos/ico-paga-yape-4.jpg"></figure>
	</div>
</div>
*/ ?>

	<div class="large-12 poppi  data_2_anexo columns">
		<h5 class="poppi-sb color4 text-center " style="padding-bottom:10px;"> Enviar Voucher de Pago </br>
				<span style="background:red;color:#fff;padding:6px 10px;border-radius:8px;font-size:20px;line-height:20px;">informes@<?php echo $_dominio; ?></span></br>
				<small class="ptop color4 text-left ">¿Cómo ver el número de operación en voucher?  </small> 
		</h5>
		<div class="rel  text-center ">
			<div class="rel ">
					Click en imagen para ampliar
				<figure class=" rel mpopup-01 " style="padding-top:10px;">
					<img src="img/foto_voucher.jpg" style="height:300px;">
					<a href="img/foto_voucher.jpg" class="abs ico_foto"></a>
				</figure>
			</div>
		</div>	
		<div style=" max-width:650px;margin:0 auto;"> 			
			<h5 style="padding:0;"><small class="poppi-sb color2 final">Nota importante:</small></h5>
			<p>- Enviar voucher nítido en buena resolución</p>
			<p>- En el asunto enviar el Nº de operación y entidad bancaria</p>
			<p>- No enviar voucher con borrones porque no aceptaremos.</p>
			<p>- No enviar voucher al whatsapp, todo voucher es al correo de <?php echo $_email_empresa; ?></p>
		</div>
	</div>

</div></div> 