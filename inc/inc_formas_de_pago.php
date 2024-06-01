<div  class=" large-12 columns text-center   ">
	<h3 class="poppi-b blanco text-center " > 
		MÉTODOS <span class=" poppi-b  "> DE  PAGO </span> 
	</h3>
	<p class=" blanco "> Puedes hacer efectivo tus pagos en las siguientes cuentas bancarias</p>

<?php 
//	$bancos= executesql(" select * from bancos where estado_idestado=1 order by orden desc "); 
//	foreach( $bancos as $data_banca ){ 
?>
	<div class=" large-3 medium-6 columns end  poppi  ">		
		<div class=" _contiene_banco  _f_rojo _bn_nacion ">		
			<h4 class=" poppi-b "> BANCO DE LA NACIÓN</h4>
			<div class=" _subrayado_center "></div>
			<div class=" _data_cuentas ">
				<p>
					<b>Nº cuenta de ahorro: </b>  </Br>
					04-581-552039 </Br>
					<span class=" poppi-sb ">CCI: </span> 
					01132400010003427311
				</p>
				<p>
					<b>Nº cuenta corriente: </b>  </Br>
					00-525-028941</Br>
					<span class=" poppi-sb ">CCI: </span> 
					01852500052502894169
				</p>			
			</div>
			<figure class=""><img src="img/icon_2024_nacion.png"></figure>			
		</div>	
	</div>	
	
	<div class=" large-3 medium-6 columns end  poppi  ">		
		<div class=" _contiene_banco ">		
			<h4 class=" poppi-b ">  BANCO CONTINENTAL</h4>
			<div class=" _subrayado_center "></div>
			<div class=" _data_cuentas ">
				<p>
					<b>Nº cuenta: </b>  </Br>
					0011-0324-01-00034273 </Br>
					<span class=" poppi-sb ">CCI: </span> 
					01132400010003427311
				</p>
			</div>					
			<figure class=""><img src="img/icon_2024_bbva.png"></figure>			
		</div>	
	</div>	
	
	<div class=" large-3 medium-6 columns end  poppi  ">		
		<div class=" _contiene_banco  _f_rojo ">		
			<h4 class=" poppi-b ">  BANCO DE CRÉDITO</h4>
			<div class=" _subrayado_center "></div>
			<div class=" _data_cuentas ">
				<p>
					<b>Nº cuenta: </b>  </Br>
					585-2584128-0-91 </Br>
					<span class=" poppi-sb ">CCI: </span> 
					00258500258412809187
				</p>					
			</div>
			<figure class=""><img src="img/icon_2024_bcp.png"></figure>			
		</div>	
	</div>	
	
	<div class=" large-3 medium-6 columns end  poppi  ">		
		<div class=" _contiene_banco ">		
			<h4 class=" poppi-b "> YAPE</h4>
			<div class=" _subrayado_center "></div>
			<div class=" _data_cuentas ">				
				<p>
					<b style="padding-bottom:8px;display:block;">Nº cuenta: </b>		
					▪ 908 827 889  </Br>
					▪ 908 827 823  </Br>
					▪ 908 827 909  </Br>
					▪ 957 668 571
				</p>
			</div>				
			<figure class=""><img src="img/icon_2024_yape.png"></figure>			
		</div>	
	</div>	



<?php // } // end for  ?> 


	<div class="large-12 poppi  data_2_anexo columns  hide ">
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

</div>