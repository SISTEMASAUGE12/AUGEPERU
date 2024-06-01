<?php error_reporting(E_ALL); session_start();
include_once("../tw7control/class/functions.php");
include_once("../tw7control/class/class.bd.php"); 
$bd=new BD;
$select="";


$result_tipopago="<div class='data_primero_ingresa'> <div class='figu'><img src='img/muneco_auga.jpg'></div> <div class='contiene_info '> <h4 class='poppi color2' style='padding-top:10px;' ><span class='poppi-b color2 '>Listo</span> vamos bien </h4>
<!-- 
	<p class='poppi ' style='padding-bottom:27px;'>Sí pagas con tarjeta, desde la web</br> Ingresa tu <b>Código  o Cupón </b>Promocional:</p> 
	<input name='cupon' id='cupon' maxlength='6' class='cupon_descuento ' placeholder='Ingresa aquí tu cupón'> 
	<small> </br>*si no tiene cupón,  click en pagar con tarjeta<small>
-->

<p class='poppi ' style='padding-bottom:27px;'>Ahora seguimos con el <b>pago</b> </br> de los cursos:</p> 
<a class=' boton poppi-sb ' oncontextmenu='return false' onkeydown='return false'  href='cesta-pago-tarjeta'>Pagar con Tarjeta 
	<!-- <small style='font-size:60%;display:block;'>5% de descuento</small>  -->
</a>  
<a class=' boton poppi-sb ' oncontextmenu='return false' onkeydown='return false' href='cesta-pago-deposito' style='margin-top:20px;'>Paga con Deposito</a>  </div> <div style='padding-top:60px;'><img src='img/paga_seguro_aqui.jpg' class='apa_img_pc'> <img src='img/paga_seguro_aqui_movil.jpg' class='apa_img_movil'></div> </div> ";


if(isset($_POST["tipodepago"]) && !empty($_POST["tipodepago"]) ){

	// $result_tipopago="vacio_csm";
  $recibido=$_POST["tipodepago"];
  if(!empty($_SESSION["suscritos"]["id_suscrito"])){

	$bancos=executesql("select * from bancos where estado_idestado=1 order by orden desc ");

		if($recibido == 1){
			$result_tipopago='
			<div  class=" mostrar_cuentas">
			<h5 class="poppi-sb color1 text-center " > 
					Pagos con depósito bancario
					<small class=" color4">Usted puede hacer efectivo sus pagos en las siguientes cuentas bancarias</small> 
			</h5>

			';
if(!empty($bancos)){
foreach($bancos as $data_bancos){						
	$select.='<option value="'.$data_bancos["id_banco"].'">'.$data_bancos["nombre"].'</option>';
	
	$result_tipopago.=' <div class="bancos"><div>
		<figure class=""><img src="tw7control/files/images/bancos/'.$data_bancos["imagen"].'"></figure>
		<p class="poppi color4">
		<span class="poppi-sb color3">'.$data_bancos["nombre"].'</span>
		Nº cuenta '.$data_bancos["cuenta"].'
		<br>CCI: '.$data_bancos["cuenta_cci"].'
		<br><span class="poppi-sb color3"> '.$data_bancos["titular"].' </span>
		</p> 									
	</div></div>	
	';
}
}


$result_tipopago.='
				

			';
			
$result_tipopago.='					
		<div class="large-12 poppi  data_2_anexo columns color1 ">
			<h5 class="poppi-sb color4 text-center " style="padding-bottom:10px;"> Enviar Voucher de Pago
					<small class="ptop color4 text-left ">¿Cómo ver el número de operación en voucher?  </small> 
			</h5>
			<div class="rel color1 ">
						<div class="rel ">
									Click en imagen para ampliar
								<figure class=" rel mpopup-01 " style="padding-top:10px;">
									<img src="img/foto_voucher.jpg" style="height:300px;">
									<a href="img/foto_voucher.jpg" class="abs ico_foto"></a>
								</figure>
								
						</div>
				</div>	
								
				<h5 style="padding:0;"><small class="poppi-sb color2 final">Nota importante:</small></h5>
				<p class=" color1 " >- No olvides de registrar el Nº de operación del voucher</p>
				<p class=" color1 ">- Verificaremos los datos del pago y confirmaremos su compra del curso.</p>
				<p class=" color1 " >- Podrás ver el curso desde su panel de cursos.</p>
		 </div>
			
                    <div class="large-12 columns form ">
                        <fieldset><p class="rel poppi-sb color4 lleva_xy "><small class="btn_xy">CONFIRMACIÓN DE PAGO:</small> <span>Datos del pago</span></p></fieldset>
                        <fieldset class="mita1 poppi">
												<select name="banco_pago" requerid>
                            <option value="">Seleccionar cuenta o YAPE </option>
												'.$select.'
                        </select>
												</fieldset>
                        <fieldset class="mita2"><input type="text" name="codigo_ope_off" class="poppi" placeholder="Número operación" onkeypress="javascript:return soloNumeros(event,0);"> <label class="label_paga_con_yape" style="font-size:13px;color:red;">* si pagaste con YAPE, ingresa el número de tu celular </label></fieldset>
                        <fieldset class="mita1"><label style="padding:30px 0 2px;">Fecha del pago: </label> <input type="date" name="fecha_pago_off" class="poppi"> </fieldset>
                        <fieldset><label class="labelfoto rel">
                            <input type="file" name="imagen" id="imagen">
                            <a class="btnfoto poppi-sb">Subir foto</a>
                            <p id="lista_imagenes" class="nose poppi">No se elegió archivo</p>
                            <a onclick="holi()" style="position:absolute;left:0;top:0;width:100%;height:100%;"></a>
                        </label></fieldset>

                   </div>
						
					</div>  	
					<script>     if($(".mpopup-01").length){ $(".mpopup-01").magnificPopup({ type : "image", delegate : "a", gallery : { enabled:true } }); }</script>
				';

		}else if($recibido == 2){  /* pasarela */
			// toma valor inicial
							$result_tipopago='
					<div  class=" form_pago mostrar_pasarela ">
						<h5 class="poppi-sb color4">Ingresa los  datos de tu tarjeta</h5>
						<div class="form">
							<input name="email" autocomplete="off" type="hidden" required  size="50" data-culqi="card[email]" id="card[email]" value="'.$_SESSION["suscritos"]["email"].'" >
							<fieldset><input type="text" name="card" class="poppi" placeholder="90.." onkeypress="javascript:return soloNumeros(event,0);" size="20" data-culqi="card[number]" required  maxlength="16" minlength="16" id="card[number]"><span class="poppi-l">Número de tarjeta débito/crédito</span></fieldset>

							<fieldset class="mita1 rel">
							<!-- <input type="text"  class="poppi" placeholder="MM / AA" maxlength="5" onkeypress="javascript:return soloNumeros(event,0);"> -->
								 <input size="2" style="width:35px;display:inline-block;"  class="fech fecha_mes" type="text" name="fch1" data-culqi="card[exp_month]" onkeypress="javascript:return soloNumeros(event,0);" maxlength="2" minlength="2" id="card[exp_month]" placeholder="MM">

								 <span style="position:absolute;left:28px;top:14px;z-index:99;">/</span>
								 <input style="width:calc(100% - 35px);display:inline-block;float:right;" class="fech fecha_ano" type="text" name="fch2" onkeypress="javascript:return soloNumeros(event,0);"   maxlength="4" minlength="4" size="4" data-culqi="card[exp_year]" id="card[exp_year]" placeholder="AAAA">
							</fieldset>

							<fieldset class="mita2"><input type="text" class="poppi" name="cvv" maxlength="3" minlength="3" data-culqi="card[cvv]" id="card[cvv]" size="4" placeholder="cvv" maxlength="3" onkeypress="javascript:return soloNumeros(event,0);"></fieldset>
							<fieldset><input type="text" name="titular" class="poppi" placeholder="Titular de la tarjeta (opcional)"></fieldset>
							<fieldset class="ulti"><p><input type="checkbox" class="chk" name="chk" value="1" checked></p><label><a class="poppi-sb">Acepto expresamente todos los Términos y condiciones</a></label></fieldset>
						</div>
					</div>
							 ';
							 
		}else{  /* end tipo_pago  */
			/* checkout js *  */
		}
		
	}else{ 
		$result_tipopago="Por favor inicie sesión..."; 
	}


}

 echo json_encode(array(
    "result_tipopago" => $result_tipopago,
    "codigo_tipopago" => $_POST["tipodepago"]
  ));
 ?>