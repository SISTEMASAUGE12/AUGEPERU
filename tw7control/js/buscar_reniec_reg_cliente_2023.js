function manual_nose_encontro_info (){
	// registrar manual
	$("#nombre").val("No se encontro dato en reniec, ingrese manualmente ..");
	$("#ap_pa").val("No se encontro dato en reniec, ingrese manualmente ..");
	$("#ap_ma").val("No se encontro dato en reniec, ingrese manualmente ..");
	
	//si ya existe bloquear registro
	$("#cliente").val("");
	$('.label_dni small').text('* No se encontro dato en reniec, ingrese manualmente ..');
	$('input[name="dni"]').removeClass('text_ok_label');
	$('input[name="dni"]').addClass('error_label');
	
	
	document.getElementById("nombre").disabled=false;
	document.getElementById("ap_pa").disabled=false;
	document.getElementById("ap_ma").disabled=false;
	document.getElementById("field_client").disabled=false;
	$("#btnguardar").removeClass('hide');
	$(".btn_finalizar_reniec").removeClass('hide'); // en registro_v2 web publica

	console.log(" no encontro api la informacion procede de forma manual ...");
}

function reseteo_datos (){
	$('#cliente').val('');
	$('#nombre_cliente').val('');

	$('#nombre').val('');
	$('#ap_pa').val('');
	$('#ap_ma').val('');

}

function busque_cliente(){
	reseteo_datos(); //limpio campos a valor vacio '' 
	
  var dni=$('input[name="dni"]').val();
	if(dni != ""){
		$('input[name="dni"]').removeClass('error_label');
		$.ajax({
			// url: 'cotizars.php',
			url: link+'.php',
			data: '&task=buscardni&dni=' + dni,
			type: 'GET',
			success: function(datos) {
				var resultados = JSON.parse(datos);

			 if(  link == "suscrito" || link == "suscriptores" || link == "registrate_v2" || link == "actualiza-tus-datos"  || link == "clientes_x_apertura" ){
				if(resultados.res == 1){
					// si ya esta registrado ... 
					
					$('.label_dni small').text('* cliente ya registrado');
					$('input[name="dni"]').removeClass('text_ok_label');
					$('input[name="dni"]').addClass('error_label');
					// alert("pp");
					
					if(link == "apertura" || link == "clientes_x_apertura"){
						// mostrar datos del cliente que ya esta registrado .. para realizar ootro proceso ejemplo registrar  apaertura.. en auge aun no se usa esto, quiza a futuro
						$('#cliente').val(resultados.id);
						$('#nombre').val(resultados.nombre_solo);
						$('#ap_pa').val(resultados.ap_pa);
						$('#ap_ma').val(resultados.ap_ma);
						
						$('#nombre').removeClass('text_error_label');
						$('#nombre').addClass('text_ok_label');
						document.getElementById("field_client").disabled=false;
						$("#btnguardar").removeClass('hide');
						
						
						
					}else{
						
					//si ya existe bloquear registro
						document.getElementById("field_client").disabled=true;
						$("#btnguardar").addClass('hide');
						$(".btn_finalizar_reniec").addClass('hide'); // en registro_v2 web publica
					}
					
				}else if(resultados.res == 3){
				//si ya existe cliente ...  bloquear registro::: no se usa en auge aun quizas en algun proiceso con rpta 3 
					$('.label_dni small').text('* cliente ya registrado cc ');
					$('input[name="dni"]').removeClass('text_ok_label');
					$('input[name="dni"]').addClass('error_label');
					document.getElementById("field_client").disabled=true;
					$("#btnguardar").addClass('hide');
					$(".btn_finalizar_reniec").addClass('hide'); // en registro_v2 web publica



				}else{ //si cliente es nuevo registramos -...
					//cargamos datos de reniec por default..
					buscar_dni_reniec(dni);
					console.log("go reniec");
				}
			}


			}
		});

	}else{
		console.log("ingresa DNI");
		$('input[name="dni"]').addClass('error_label');
	}
}



function buscar_dni_reniec(dni){
	// let dni="48431448";
	console.log("busco en reniec .. ");
	$("#nombre").val(" un momento, estamos consultando reniec .. ");
	$("#ap_pa").val(" un momento, estamos consultando reniec ..");
	$("#ap_ma").val(" un momento, estamos consultando reniec .. ");
	
	let str="dni="+dni;
	let _url_z_reniec='z_consultar_reniec_clientes_2023';

	if(   link == "registrate_v2" ||  link == "actualiza-tus-datos"  ){ // para formulario de registro en web publica 
		_url_z_reniec= 'tw7control/z_consultar_reniec_clientes_2023.php'; 
	}

	$.ajax({url: _url_z_reniec ,data:str,type:'post',success:function(datos){
		if(datos){
				console.log(datos);
				var resultados = JSON.parse(datos);
				
				if(resultados.success == false ){
					manual_nose_encontro_info();
					busque_cliente_sin_reniec();
					
					
				}else if(resultados.dni != "" && typeof resultados.dni != 'undefined'){
						// si todo okey encontro dato en reniec 
						console.log(resultados.dni);
						console.log(resultados.apellidoPaterno);
						console.log(resultados.apellidoMaterno);
						console.log(resultados.nombres);

						if( resultados.apellidoMaterno == '[object HTMLInputElement]'){ // si api no devuelve ese dato 
							resultados.apellidoMaterno='---';
						}

						$("#nombre").val(resultados.nombres);
						$("#ap_pa").val(resultados.apellidoPaterno);
						$("#ap_ma").val(resultados.apellidoMaterno);
						
						$("#api_dni").val(resultados.dni);
						$("#api_nombre").val(resultados.nombres);
						$("#api_ap_pa").val(resultados.apellidoPaterno);
						$("#api_ap_ma").val(resultados.apellidoMaterno);
						
						// para que no puedan altera rla info manualmente .. bloqueamos 
						document.getElementById("dni").disabled=true;
						document.getElementById("nombre").disabled=true;
						document.getElementById("ap_pa").disabled=true;
						document.getElementById("ap_ma").disabled=true;


						document.getElementById("field_client").disabled=false;
						$("#btnguardar").removeClass('hide');
						$(".btn_finalizar_reniec").removeClass('hide'); // en registro_v2 web publica

						$('.label_dni small').text('');
						$('input[name="dni"]').removeClass('error_label');
						$('input[name="dni"]').addClass('text_ok_label');


				}else if(resultados.error == "error"){
					console.log('_error busqueda :: error en api reniec');					
					manual_nose_encontro_info();
					//si ya existe bloquear registro											
				}

		}else{
			console.log('	error reniec .. no devuelve datos');
			$("#nombre").val(" 	error reniec .. no devuelve datos ");
			$("#ap_pa").val(" 	error reniec .. no devuelve datos ");
			$("#ap_ma").val(" 	error reniec .. no devuelve datos ");
			alert("api no encontro");
			//si ya existe bloquear registro
			$("#cliente").val(""); // id cliente 
			$('.label_dni small').text('* No se encontro dato en reniec, ingrese manualmente ..');
			$('input[name="dni"]').removeClass('text_ok_label');
			$('input[name="dni"]').addClass('error_label');
			document.getElementById("field_client").disabled=false; // para q registre manualente
			// $("#btnguardar").addClass('hide');
			$("#btnguardar").removeClass('hide');
			$(".btn_finalizar_reniec").removeClass('hide'); // en registro_v2 web publica

					
		}

	}});
}


function busque_cliente_sin_reniec(){  // ingresa manualmente el cliente 
	console.log(" No se encontro dato en reniec, ingrese manualmente ..:  busque_cliente_sin_reniec ");
  var dni=$('input[name="dni"]').val();
	if(dni != ""){
		$('input[name="dni"]').removeClass('error_label');
		$.ajax({
			// url: 'cotizars.php',
			url: link+'.php',
			data: '&task=buscardni&dni=' + dni,
			type: 'GET',
			success: function(datos) {
				var resultados = JSON.parse(datos);
			if(link == "lead" || link == "suscriptores" || link=="registro_v2" || link == "actualiza-tus-datos"  ){
				if(resultados.res == 1){
				//si ya existe bloquear registro
					$('.label_dni small').text('* cliente ya registrado');
					$('input[name="dni"]').removeClass('text_ok_label');
					$('input[name="dni"]').addClass('error_label');
					document.getElementById("field_client").disabled=true;
					$("#btnguardar").addClass('hide');
					$(".btn_finalizar_reniec").addClass('hide'); // en registro_v2 web publica


				}else{ //si cliente es nuevo registramos -... SIN RENIEC
					//cargamos datos de reniec por default..
					document.getElementById("field_client").disabled=false;
					$("#btnguardar").removeClass('hide');
					$(".btn_finalizar_reniec").removeClass('hide'); // en registro_v2 web publica

					$('.label_dni small').text('');
					$('input[name="dni"]').removeClass('error_label');
					$('input[name="dni"]').addClass('text_ok_label');

				}
			}

			}
		});

	}else{
		console.log("ingresa DNI");
		$('input[name="dni"]').addClass('error_label');
	}
}

