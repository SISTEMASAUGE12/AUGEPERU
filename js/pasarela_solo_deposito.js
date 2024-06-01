


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
			$('#rptapago').html('<meta http-equiv="Refresh" content="3;url=mis-cursos?task=gracias">');
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
		let texto_paga_seguro='<ol class="no-bullet roboto dos"><li><img src="img/iconos/pago1.png"></li><li><img src="img/iconos/pago2.png"></li><li><img src="img/iconos/pago3.png"></li></ol><blockquote class="poppi texto dos"><img src="img/iconos/candado3.png"> Pago 100% Seguro</blockquote><span class="texto poppi dos">Este sitio cumple con los estándares de seguridad de la industria de medio de pago PCI-DSS para proteger su información personal </span>';

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
html += " <form id='fincompra' method='post' class='monset' enctype='multipart/form-data' autocomplete='off'><fieldset> ";
// html +='<h1 class="poppi-b color1 uni">Total a pagar: S/'+totalfinal+' </h1><h5 class="poppi-sb color4">Método de pago: Depósito a cuenta del Banco de la Nación o YAPE</h5>';

html +='  <ul class="tabs poppi" data-tabs id="example-tabs">';
// <li id="tipodepago_2" class="tabs-title is-active tipodepagos "><a href="#panel1v" aria-selected="true"><p class="img text-left"><img src="img/iconos/tarjeta.png"></p><p class="poppi-sb color4 text-left last texto_largo">Paga con tarjeta</p><p class="poppi-sb color4 text-left last texto_corto">Crédito/Debito</p></a></li>';

// html +='<li id="tipodepago_3" class="tabs-title tipodepagos"><a href="#panel2v"><p><img src="img/iconos/paypal.png"></p></a></li><li id="tipodepago_4" class="tabs-title tipodepagos"><a href="#panel3v"><p><img src="img/iconos/efectivo.png"></p></a></li>';

// html +='<li id="tipodepago_1" class="tabs-title is-active tipodepagos"><a href="#panel4v"><p class="img text-left"><img src="img/iconos/banco.png"></p><p class="poppi-sb color4 text-left last texto_largo "> Pago deposito al Banco de la Nación o YAPE</p><p class="poppi-sb color4 text-left last texto_corto"> cuenta</p></a></li></ul>';

html +='            <div class="tabs-content" data-tabs-content="example-tabs"> ';
// html +='                <div class="tabs-panel is-active " id="panel1v"><div class="result_tipopagos_online"><div class="descripcion"><div class=" result_destino_tipopagos large-12 columns" ></div></div></div></div> ';
html +='                <div class="tabs-panel is-active" id="panel4v"><div class="result_tipopagos_offline"><div class="descripcion"><div class=" result_destino_tipopagos large-12 columns "></div></div></div></div> ';
html +='            </div>';


    html += "     </fieldset>";

    var cliente = jsonsss.id_suscrito;
    if( typeof(cliente) == "undefined" || cliente == null || cliente == ""|| cliente == 0){  //sino esta registrado se abre ventana de registro

    html += "  <a  href='iniciar-sesion' class='llama_al_login poppi-sb boton boton2' oncontextmenu='return false' onkeydown='return false''>Ingresa</a> ";

    }else{
			// html += " <button id='btn_pedido' class='mostrar_cuentas hide btn botones bold monset enviar-pedido' oncontextmenu='return false' onkeydown='return false'>FINALIZAR PEDIDO</button>";
			// html += "		<button id='btn_pagar' class='mostrar_pasarela hide btn botones bold monset enviar-pedido' oncontextmenu='return false' onkeydown='return false'>PAGAR</button> ";

			html += "<fieldset class='lleva_boton_enviar_deposito'><button id='btn_pedido'  class=' mostrar_cuentas  boton poppi-sb disable enviar-pedido ' oncontextmenu='return false' onkeydown='return false' >Enviar confirmación </button>";
			// html += "			<fieldset><button id='btn_pagar'  class='boton poppi-sb disable mostrar_pasarela hide enviar-pedido' oncontextmenu='return false' onkeydown='return false' >Comprar ahora</button></fieldset>  ";

    }
		html += "   </form> ";


		html += " <div class='hide monset' id='rptapago'>Procesando pago, espere unos segundos..</div>";
		html += " <div class='hide monset' id='rptaok'>..</div>";

		html += " <div class='hide monset' id='registroInfo'>Procesando ...</div>";
    html += " <div class='hide monset' id='registroSuccess'>Ok! Pedido realizado con éxito ..</div>";
    html += " <div class='hide monset' id='registroError'>Lo sentimos se perdio la conexion con el servidor ...</div>   ";

		html += "   </fieldset> ";



}//if si existe session


	html += " <script src='js/foundation.min.js'></script>";
	html += " <script>$(document).foundation();</script>";
	html += " <script src='js/llamar_registro_login.js'></script>";


		}else{ /* si carrito esta vacio */ 
			let id_suscrito_js= $('#id_suscrito_js').val();
			// alert(id_suscrito_js);
			
			html += "  <div class='large-9 medium-12 columns data_primero_ingresa'> <div class='row'> <div class='figu'><img src='img/muneco_auga.jpg'></div> <div class='contiene_info '> <h4 class='poppi color2 ' >El <span class='poppi-b color2 '>carrito</span> esta vacio  </br> </h4> <p class='poppi '> Compra nuestros cursos ahora. Necesitamos que des el <b>primer paso</b> para tu compra segura:</p> </div>  ";
			// si no existe sesion ..
			if( typeof(id_suscrito_js) == "undefined" || id_suscrito_js == null || id_suscrito_js == ""|| id_suscrito_js == 0){  //sino esta registrado se abre ventana de registro
			html +=" <div class='large-6  medium-6 text-center  columns'> <p class='anexo poppi '>Si <b>ya tienes</b> una cuenta </br>en auge... </p> <a  href='iniciar-sesion' class='llama_al_login poppi-sb boton boton2' oncontextmenu='return false' onkeydown='return false' >Ingresa aquí</a> </div> <div class='large-6  medium-6 text-center columns'> <p class='anexo poppi '>Si eres <b>nuevo</b> en auge </br> entonces...</p>  <a  href='registro' class='llama_al_registro poppi-sb boton boton2' oncontextmenu='return false' onkeydown='return false' >Regístrate aquí</a> </div> ";
			}else{
				html += "<div class='large-12 text-center columns'> <a  href='curso/todos' class='llama_al_registro poppi-sb boton boton2' oncontextmenu='return false' onkeydown='return false' >ver todos los cursos</a> </div> ";
			}
			html +=" </div></div>  ";

		}  /* end carrito vacio */

		$(".content_data_pedido_compra").html("").append(html);
    $('.mpopup-01').magnificPopup({ type : 'image', delegate : 'a', gallery : { enabled:true } });
    $('.mpopup-03').magnificPopup({ type : 'ajax' });

		 carga_pasarela_origen_cero();


		// Si pago es OFFLINE
		// $(".result_tipopagos_online").find('.result_destino_tipopagos').html("cangando ..");
		$('.mostrar_pasarela').addClass('hide');
		$('.mostrar_cuentas').removeClass('hide');


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



function carga_pasarela_origen_cero(){
	str= '&tipodepago=1'; // llamo a pago deposito 
	$.ajax({url:'process_cart/select_tipopagos.php',data:str,type:'post',success:function(datatipopago){
		var jotas = JSON.parse(datatipopago);

		$('.result_tipopagos_offline').find('.result_destino_tipopagos').html(jotas.result_tipopago);

		console.log(jotas.result_tipopago);
		console.log(jotas.codigo_tipopago);

		if(jotas.codigo_tipopago==2){ // Si pago es ON LINE
				$(".result_tipopagos_online").find('.result_destino_tipopagos').html("cangando ..");
				$('.mostrar_pasarela').addClass('hide');
				$('.mostrar_cuentas').removeClass('hide');
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
