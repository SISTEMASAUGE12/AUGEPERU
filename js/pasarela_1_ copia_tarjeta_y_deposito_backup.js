
function culqi(){
    if (Culqi.token) { // ¡Objeto Token creado exitosamente!
      var token = Culqi.token.id;
			// console.log('Se ha creado un token:' + token);

			var codigo_referencia='sin_pagar';
			var resultado_pago;
			var msj_exito;
			var msj_error;


			if(  typeof(token) == "undefined" || token == null || token == ""|| token == 0){
				console.log('error en datos tarjetas detectadas ...');
				$('#rptapago').removeClass('pagoespera');
				$('#rptapago').removeClass('pagoexito');
				$('#rptapago').addClass('pagoerror');
				msj_error="Verifique que los datos ingresados de la tarjeta sean correctos, por favor volver a internar.. ";
				resultdiv("Upps! "+msj_error);
				// console.log(result.merchant_message);
				$('#btn_pagar').removeClass('btn-pedidoencurso');
				document.getElementById("btn_pagar").disabled=false;
				console.log('libero _boton_pagar');

			}else{ // datos de tarjeta ok, token creado con exito

				console.log('todo ok con datos tarjetas ...');
				$('#rptapago').addClass('pagoespera');
				$('#rptapago').html("Procesando pago, espere unos segundos..");
				$('#rptapago').removeClass('pagoexito');
				$('#rptapago').removeClass('pagoerror');

				var proceso1=$.ajax({
						type: 'POST',
						url: 'culqi-php-develop/examples/procesarpago.php',
						data: {
							token: Culqi.token.id,
							monto: $('input[name="total_online"]').val()	,
							email: $('input[name="email"]').val(),
							nombre: $('input[name="name_perfil"]').val(),
							apellidos: $('input[name="name_apellidos"]').val(),
							direc: $('input[name="name_direc"]').val(),
							telef: $('input[name="name_telef"]').val(),
							ciudad: $('input[name="name_ciudad"]').val()
						},
						datatype: 'json',
						success: function(data){
							var result = "";
							if(data.constructor == String){
								result = JSON.parse(data);
							}
							if(data.constructor == Object){
								result = JSON.parse(JSON.stringify(data));
							}

							if(result.object === 'charge'){
								resultado_pago='charge';
								if(data.capture == true){
									codigo_referencia=data.reference_code;
									msj_exito=result.outcome.user_message;
								}
								// alert(codigo_referencia);
							}

							if(result.object === 'error'){
								$('#rptapago').removeClass('pagoespera');
								$('#rptapago').removeClass('pagoexito');
								$('#rptapago').addClass('pagoerror');
								msj_error=result.user_message;
								if(msj_error==="Undefined" || msj_error===""){
									msj_error="Verifique que los datos ingresados de la tarjeta sean correctos, porfavor volver a internar.. ";
								}
								// resultdiv("Upps! "+result.user_message);
								resultdiv("Upps! "+msj_error);
								console.log('error procesando ..');
								console.log(result.merchant_message);

								$('#btn_pagar').removeClass('btn-pedidoencurso');
								document.getElementById("btn_pagar").disabled=false;
								console.log('libero _boton_pagar');

							}

						},
						error: function(error){
							resultdiv(error)
						}

				});


				var direccion=$('input[name="name_direc"]').val();
				// var direccion='Chiclayo, Lambayeque Peru';
				var total_online= $('input[name="total_online"]').val(); /* si paga con tarjeta, aplicamos precio exclsivo por pago online  */

				proceso1.then(function(){
						if(resultado_pago === 'charge'){

							if(codigo_referencia != 'sin_pagar'){
									var str1="&action=registro&codreferencia="+codigo_referencia+"&direccion="+direccion+"&total="+total_online;
									// var str3="&tipo_comprobante="+tipo_comprobante+"&rason_social="+rason_social+"&ruc="+ruc+"&correo_ruc="+correo_ruc+"&destino_fact="+destino_fact+"&lugar_fact="+lugar_fact;

									var str=str1;

									$.ajax({url:'process_cart/insert_bd.php',data:str,type:'post',success:function(datos){
										// console.log(datos);
										var resultados = JSON.parse(datos);
										if(resultados.res == "ok"){
											$('#rptapago').removeClass('pagoerror');
											$('#rptapago').removeClass('pagoespera');
											$('#rptapago').addClass('pagoexito');
											$('#rptapago').html('<meta http-equiv="Refresh" content="3;url=perfil_inicio?task=gracias">');
											resultdiv("Genial! "+msj_exito);

										}else{
											$('#rptapago').removeClass('pagoespera');
											$('#rptapago').removeClass('pagoexito');
											$('#rptapago').addClass('pagoerror');
											resultdiv("Upps #2 error registrando.. ",'error');
										}

									}});
							}

						}
				});

			} //end valid token

		}else{
			console.log('error token:' + token);
			$('#registroError').removeClass('hide');
			$('#registroError').html(Culqi.error.merchant_message);
			$('#btn_pagar').removeClass('btn-pedidoencurso');
				document.getElementById("btn_pagar").disabled=false;
				console.log('libero _boton_pagar');

		}
};


function procesando_pedido(){
	// console.log('corriendo fn proceso pedidos');
	var resultado_pago;
	var msj_exito;
	var msj_error;

	$('#rptapago').addClass('pagoespera');
	$('#rptapago').html("Procesando pedido, espere unos segundos..");
	$('#rptapago').removeClass('pagoexito');
	$('#rptapago').removeClass('pagoerror');


	var direccion=$('input[name="name_direc"]').val();
	// var direccion='Chiclayo, Lambayeque Peru';
	var banco_pago=$('select[name="banco_pago"]').val();
	var fecha_pago_off=$('input[name="fecha_pago_off"]').val();
	var codigo_ope_off=$('input[name="codigo_ope_off"]').val();
	var total= $('input[name="total"]').val();  /* aca procesa el pago normal; sin beneficio del pago online */
	var imagen=$('#imagen').val();
	var formData = new FormData();
	var files = $('#imagen')[0].files[0];

	formData.append('action',"registro");
	formData.append('direccion',direccion);
	formData.append('banco_pago',banco_pago);
	formData.append('codigo_ope_off',codigo_ope_off);
	formData.append('fecha_pago_off',fecha_pago_off);
	formData.append('total',total);
	formData.append('file',files);

	var str=formData;

	$.ajax({url:'process_cart/insert_bd.php',data:str,type:'post',contentType: false,processData: false, success:function(datos){
		// console.log(datos);
		var resultados = JSON.parse(datos);
		if(resultados.res == "ok"){
			$('#rptapago').removeClass('pagoerror');
			$('#rptapago').removeClass('pagoespera');
			$('#rptapago').addClass('pagoexito');
			$('#rptapago').html('<meta http-equiv="Refresh" content="3;url=perfil_inicio?task=gracias">');
			resultdiv("Genial! Pedido realizado con éxito. ");

		}else if(resultados.res == 5){ /* alerta de codigo de pago y banco ya existe; bloquea el proceso de registro */
			$('#rptapago').removeClass('pagoespera');
			$('#rptapago').removeClass('pagoexito');
			$('#rptapago').addClass('pagoerror');
			resultdiv("Upps #33 Este codigo de pago y banco asociado, ya esta previamente registrado, asegurate de completar los campos correctamente! ",'error');
			
			document.getElementById("btn_pedido").disabled=false;
			console.log("re habilito boton principal ");
			
			setTimeout(function () {
				$('#rptapago').addClass('hide');
			}, 4000); //msj desparece en 5seg.
	
		
		}else{
			$('#rptapago').removeClass('pagoespera');
			$('#rptapago').removeClass('pagoexito');
			$('#rptapago').addClass('pagoerror');
			resultdiv("Upps #22 error registrando.. ",'error');
			document.getElementById("btn_pedido").disabled=false;
			console.log("re habilito boton principal ");
			
			setTimeout(function () {
				$('#rptapago').addClass('hide');
			}, 9000); //msj desparece en 5seg.
			
		}

	}});

};



function resultdiv(message,tipo){
	$('#rptapago').removeClass('hide');
	$('#rptapago').html(message);
	

}



//al cargar la página mostramos el contenido del carrito o un mensaje
//si no tiene contenido, como veremos vamos llamando a esta función
//en cada proceso ya que es la encargada de actualizar el carrit

function content_data_pedido_compra(){
	$.get("process_cart/content_cart.php", function(data_data){
		// var clave = elemento;
		var jsonsss = JSON.parse(data_data);
		var html = "";
		var xy = 0,i = 0,colori="";
		let texto_paga_seguro='<ol class="no-bullet roboto dos"><li><img src="img/iconos/pago1.png"></li><li><img src="img/iconos/pago2.png"></li><li><img src="img/iconos/pago3.png"></li></ol><blockquote class="poppi texto dos"><img src="img/iconos/candado3.png"> Pago 100% Seguro</blockquote><span class="texto poppi dos">Este sitio cumple con los estándares de seguridad de la industria de medio de pago PCI-DSS para proteger su información personal y la de su tarjeta.</span>';

		if(jsonsss.res == "ok")
		{

var totalfinal = jsonsss.precio_total.toFixed(2);
var totalfinal_online = jsonsss.precio_total_online.toFixed(2);
var cliente = jsonsss.id_suscrito;
if( typeof(cliente) == "undefined" || cliente == null || cliente == ""|| cliente == 0){  //sino esta registrado se abre ventana de registro

// si no existe sesion ..
html += "  <div class='large-9 medium-12 columns data_primero_ingresa'> <div class='row'><h4 class='poppi-sb ' >Para realizar tu compra de forma segura, necesitamos que inicies sesión o que te crees una cuenta. </h4> <p class='rel'><img src='img/iconos/candado.png' > No almacenamos datos bancarios</p>   <div class='large-6  medium-6 text-center  columns'>  <a  href='iniciar-sesion' class='llama_al_login poppi-sb boton boton2' oncontextmenu='return false' onkeydown='return false' >Ingresa</a> <p>Si ya tienes una cuenta en auge </p></div> <div class='large-6  medium-6 text-center columns'>  <a  href='registro' class='llama_al_registro poppi-sb boton boton2' oncontextmenu='return false' onkeydown='return false' >Regístrate</a> <p>SI eres nuevo</p></div>  </div></div>  ";

}else{

$('.total_a_pagar_texto').text('s/ '+totalfinal);
$('.total_a_pagar_texto_online').text('s/ '+totalfinal_online);

html += "     <input type='hidden' name='total' value='"+totalfinal+"'>";
html += "     <input type='hidden' name='total_online' value='"+totalfinal_online+"'>";
html += " <form id='fincompra' method='post' class='monset' enctype='multipart/form-data' autocomplete='off'><fieldset> ";
html +='<h1 class="poppi-b color1 uni">Total pagando en efectivo: S/'+totalfinal+' </br> Total pagando con tarjeta: S/'+totalfinal_online+' </br> <!-- <small class="poppi color2">73% Dto. S/ 149</small> --></h1><h5 class="poppi-sb color4">Elige tu método de pago</h5>';

html +='  <ul class="tabs poppi" data-tabs id="example-tabs"><li id="tipodepago_2" class="tabs-title is-active tipodepagos "><a href="#panel1v" aria-selected="true"><p class="img text-left"><img src="img/iconos/tarjeta.png"></p><p class="poppi-sb color4 text-left last texto_largo">Paga con tarjeta</p><p class="poppi-sb color4 text-left last texto_corto">Crédito/Debito</p></a></li>';
// html +='<li id="tipodepago_3" class="tabs-title tipodepagos"><a href="#panel2v"><p><img src="img/iconos/paypal.png"></p></a></li><li id="tipodepago_4" class="tabs-title tipodepagos"><a href="#panel3v"><p><img src="img/iconos/efectivo.png"></p></a></li>';
html +='<li id="tipodepago_1" class="tabs-title tipodepagos"><a href="#panel4v"><p class="img text-left"><img src="img/iconos/banco.png"></p><p class="poppi-sb color4 text-left last texto_largo "> Pago efectivo</p><p class="poppi-sb color4 text-left last texto_corto"> cuenta</p></a></li></ul>';

html +='            <div class="tabs-content" data-tabs-content="example-tabs"> ';
html +='                <div class="tabs-panel is-active" id="panel1v"><div class="result_tipopagos_online"><div class="descripcion"><div class=" result_destino_tipopagos large-12 columns" ></div></div></div></div> ';
html +='                <div class="tabs-panel" id="panel4v"><div class="result_tipopagos_offline"><div class="descripcion"><div class=" result_destino_tipopagos large-12 columns "></div></div></div></div> ';
html +='            </div>';


    html += "     </fieldset>";

    var cliente = jsonsss.id_suscrito;
    if( typeof(cliente) == "undefined" || cliente == null || cliente == ""|| cliente == 0){  //sino esta registrado se abre ventana de registro

    html += "  <a  href='iniciar-sesion' class='llama_al_login poppi-sb boton boton2' oncontextmenu='return false' onkeydown='return false''>Ingresa</a> ";

    }else{
			// html += " <button id='btn_pedido' class='mostrar_cuentas hide btn botones bold monset enviar-pedido' oncontextmenu='return false' onkeydown='return false'>FINALIZAR PEDIDO</button>";
			// html += "		<button id='btn_pagar' class='mostrar_pasarela hide btn botones bold monset enviar-pedido' oncontextmenu='return false' onkeydown='return false'>PAGAR</button> ";

			html += "<fieldset><button id='btn_pedido'  class=' mostrar_cuentas hide boton poppi-sb disable enviar-pedido ' oncontextmenu='return false' onkeydown='return false' >Enviar suscripción</button></fieldset>";
			html += "			<fieldset><button id='btn_pagar'  class='boton poppi-sb disable mostrar_pasarela hide enviar-pedido' oncontextmenu='return false' onkeydown='return false' >Comprar ahora</button></fieldset>  ";

    }
		html += "   </form> ";


		html += " <div class='hide monset' id='rptapago'>Procesando pago, espere unos segundos..</div>";
		html += " <div class='hide monset' id='rptaok'>..</div>";

		html += " <div class='hide monset' id='registroInfo'>Procesando ...</div>";
    html += " <div class='hide monset' id='registroSuccess'>Ok! Pedido realizado con éxito ..</div>";
    html += " <div class='hide monset' id='registroError'>Lo sentimos se perdio la conexion con el servidor ...</div>   ";




}//if si existe session


	html += " <script src='js/foundation.min.js'></script>";
	html += " <script>$(document).foundation();</script>";
	html += " <script src='js/llamar_registro_login.js'></script>";


		}else{ //si carrito esta vacio
			// $(".titulo_cesta_data").html("");
			// html += "<tbody class='monset'>";
			// html += "<tr>";
			// html += "<td>El carrito está vacío.</td>";
			// html += "</tr>";
			// html += "</tbody>";
		}

		$(".content_data_pedido_compra").html("").append(html);
    $('.mpopup-01').magnificPopup({ type : 'image', delegate : 'a', gallery : { enabled:true } });
    $('.mpopup-03').magnificPopup({ type : 'ajax' });

		 carga_pasarela_origen_cero();


		$('#cesta').find('.tipodepagos').on('click',function(e){
			e.preventDefault();
			var el = $(this);
			var str='', div = el.attr('id').split('_');
			if(div[0]=="tipodepago"){
				str= '&tipodepago='+div[1];
			}

			$.ajax({url:'process_cart/select_tipopagos.php',data:str,type:'post',success:function(datatipopago){
				var jotas = JSON.parse(datatipopago);
				el.find('.result_destino_tipopagos').text(jotas.result_tipopago);
				$(".result_destino_tipopagos").html(jotas.result_tipopago);

				// console.log(jotas.result_tipopago);
				console.log(jotas.codigo_tipopago);
					if(jotas.codigo_tipopago==1){
						// Si pago es OFFLINE
						$(".result_tipopagos_online").find('.result_destino_tipopagos').html("cangando ..");
						$('.mostrar_pasarela').addClass('hide');
						$('.mostrar_cuentas').removeClass('hide');

					}else if(jotas.codigo_tipopago==2){
						// Si pago es ON LINE
						$(".result_tipopagos_offline").find('.result_destino_tipopagos').html("cangando ..");
						$('.mostrar_pasarela').removeClass('hide');
						$('.mostrar_cuentas').addClass('hide');
					}else{
						// si es otro medio de pago
						$(".result_tipopagos_offline").find('.result_destino_tipopagos').html("cangando ..");
						$(".result_tipopagos_online").find('.result_destino_tipopagos').html("cangando ..");
						$('.mostrar_cuentas').addClass('hide');
						$('.mostrar_pasarela').addClass('hide');

					}

				console.log(jotas.codigo_tipopago);

			}});

		});


		$('#btn_pagar').on('click', function(e) {
				var nam1=$('input[name="email"]').val();
				var nam2=$('input[name="card"]').val();
				var nam3=$('input[name="cvv"]').val();
				var nam4=$('input[name="fch1"]').val();
				var nam5=$('input[name="fch2"]').val();
				// var nam7="";
				let cadena="nam1="+nam1+"nam2="+nam2+"nam3="+nam3+"nam4="+nam4+"nam5="+nam5;

			if(nam1 !='' ){
				if(nam1 !='' && nam2 !=''  && nam3 !='' && nam4 !='' && nam5 !=''   ){
					if(nam1.length > 6 && nam2.length >15  && nam3 >2 && nam4 > 1 && nam5 >3 ){
						$('#btn_pagar').removeClass('btn-pedidoencurso');
						document.getElementById("btn_pagar").disabled=false;
						// alert(nam1);
						Culqi.createToken(); //// Crea el objeto Token con Culqi JS
						$('#rptapago').removeClass('hide');
						$('#rptapago').removeClass('pagoerror');
						$('#rptapago').removeClass('pagoexito');
						$('#rptapago').addClass('pagoespera');
						document.getElementById("btn_pagar").disabled=true;
						$('#rptapago').addClass('btn-pedidoencurso');

					}else{
						console.log(cadena);
						alert("Completa todos los campos de la tarjeta correctamente _");
					}

				}else{
					alert("Por favor, completa todos los campos de la tarjeta, son obligatorios (*) ");
				}

			}else{
				alert("Por favor, completa tu perfil, registra un correo válido, los campos: email, telefono, ciudad, direccion son obligatorios (*) ");
			}
			e.preventDefault();
		});



		//pedidos
		$('#btn_pedido').on('click', function(e){		 //registro e pedidos
			// console.log("dentro de pedidoss");
			var nam8=$('input[name="codigo_ope_off"]').val();
			var nam9=$('select[name="banco_pago"]').val();
			var nam10=$('input[name="fecha_pago_off"]').val();
			var imagen=$('#imagen').val();
			var files = $('#imagen')[0].files[0];

			if(imagen ==""){
				$('#lista_imagenes').addClass('classerror');
				console.log("ingresa tu imagen 1");
			}

			if( nam8 !='' && nam9 !='' && nam10 !='' &&  imagen !="" ){
						$('#btn_pedido').removeClass('btn-pedidoencurso');
						document.getElementById("btn_pedido").disabled=false;
						procesando_pedido(); ////llamo funcion
						$('#rptapago').removeClass('hide');
						$('#rptapago').removeClass('pagoerror');
						$('#rptapago').removeClass('pagoexito');
						$('#rptapago').addClass('pagoespera');
						document.getElementById("btn_pedido").disabled=true;
						$('#rptapago').addClass('btn-pedidoencurso');

			}else{
				alert("Por favor, completa todos los campos obligatorios (*) ");
			}
			e.preventDefault();
		}); //end pedido

	});
}




function valbtnpago(){
	console.log("validando boton");
	document.getElementById("btn_pagar").disabled=true;
	$('#btn_pagar').addClass('btn-pedidoencurso');

	var nam1=$('input[name="email"]').val();
	var nam2=$('input[name="card"]').val();
	var nam3=$('input[name="cvv"]').val();
	var nam4=$('input[name="fch1"]').val();
	var nam5=$('input[name="fch2"]').val();

	if(nam1 !='' && nam2 !=''  && nam3 !='' && nam4 !='' && nam5 !='' ){
			if(nam1.length > 6 && nam2.length >15  && nam3.length >2 && nam4.length > 1 && nam5.length >2 ){
				$('#btn_pagar').removeClass('btn-pedidoencurso');
				document.getElementById("btn_pagar").disabled=false;
				console.log('okas');
				// alert('email:'+nam1);
			}else{
				$('#btn_pagar').addClass('btn-pedidoencurso');
				document.getElementById("btn_pagar").disabled=true;
				console.log('error btn');
			}
	}

}



function carga_pasarela_origen_cero(){
	str= '&tipodepago=2';
	$.ajax({url:'process_cart/select_tipopagos.php',data:str,type:'post',success:function(datatipopago){
		var jotas = JSON.parse(datatipopago);

		$('.result_tipopagos_online').find('.result_destino_tipopagos').html(jotas.result_tipopago);
		// $('.result_tipopagos_online').find('.result_destino_tipopagos').html('fiiiiii');
		// $(".result_tipopagos_online").html(jotas.result_tipopago);

		console.log(jotas.result_tipopago);
		console.log(jotas.codigo_tipopago);

		if(jotas.codigo_tipopago==2){ // Si pago es ON LINE
				$(".result_tipopagos_offline").find('.result_destino_tipopagos').html("cangando ..");
				$('.mostrar_pasarela').removeClass('hide');
				$('.mostrar_cuentas').addClass('hide');
			}

	}});
}

function holi(){
	document.getElementById("imagen").addEventListener("change", archivo, false);
}

function archivo(evt){
    let foto = evt.target.files; // FileList object
    for(let i = 0, f; f = foto[i]; i++){
        if(!f.type.match('image.*')){ continue; }
        let reader = new FileReader();
        reader.onload = (function(theFile){
            return function(e){
                $('input[name="imagen"]').removeClass('classerror');
                console.log(foto)
                //Insertamos la imagen
                document.getElementById("lista_imagenes").innerHTML = ['1 archivo cargado'].join('');
            };
        })(f);
        reader.readAsDataURL(f);
    }
}
function cargar(){ alert("Hola alerta de carga..!!"); }


// al carga la web _
$(document).ready(function(){
	if($('#cesta').length){
		content_data_pedido_compra();  // cargamos data de pasarela desde pasarela .js

	}
});
