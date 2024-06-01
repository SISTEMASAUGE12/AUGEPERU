
// /* para movil mostrar listado paises */
$(document).on('click','.ocultar_listado_paises',function(){
	var contentwidth = $(window).width();
	if(contentwidth < 1024){
		$("#select-color").removeClass("ocultar_listado_paises");
		console.log("movil:: seleccionaste un pais.."); 
	}
	
});



$(document).ready(function(){
	// registramos total
	$("#finalizar").click(function(){
		
			$('#rptapago_2').removeClass('hide');
			$('#rptapago_2').removeClass('pagoerror');
			$('#rptapago_2').removeClass('pagoexito');
			$('#rptapago_2').addClass('pagoespera');
					
		console.log('click en finalizar registro.. ');
		//enviamos data completar registro de alumno
			/*
			var dni=$('input[name="dni"]').val();
			var nombre=$('input[name="nombre"]').val();
			var ap_pa=$('input[name="ap_pa"]').val();
			var ap_ma=$('input[name="ap_ma"]').val();
			*/
	
			var telefono=$('input[name="telefono"]').val();

			var id_especialidad=$('select[name="id_especialidad"]').val();
			// var id_escala_mag=$('select[name="id_escala_mag"]').val();
			var id_tipo_cliente=$('select[name="id_tipo_cliente"]').val();

			var email=$('input[name="email"]').val();
			var clave=$('input[name="clave"]').val();
			
			// var ciudad=$('input[name="ciudad"]').val();
			// var direccion=$('input[name="direccion"]').val();
			// var nam7="";
			
			let id_pais;
			const radioButtons = document.querySelectorAll('input[name="id_pais"]');
			for (const radioButton of radioButtons) {
				if (radioButton.checked) {
						id_pais = radioButton.value;
						break;
				}
			}
			console.log('pais->'+id_pais);

			var dni=$('input[name="dni"]').val();
			var nombre=$('input[name="nombre"]').val();
			var ap_pa=$('input[name="ap_pa"]').val();
			var ap_ma=$('input[name="ap_ma"]').val();

			//if( id_pais==1){					
				
				if( dni ==''){
					dni=$('input[name="api_dni"]').val();					
				}
				if( nombre ==''){
					nombre=$('input[name="api_nombre"]').val();					
				}
				if( ap_pa ==''){
					ap_pa=$('input[name="api_ap_pa"]').val();					
				}
				if( ap_ma ==''){
					ap_ma=$('input[name="api_ap_ma"]').val();					
				}

			// }
			
	var isChecked = document.getElementById('consentimiento').checked;
	if(isChecked){
		
			
		$('#rptapago_2').removeClass('hide');
		// if( id_pais.length != '' && nombre.length != ''  && ap_pa.length != ''  && ap_ma.length != ''  && telefono.length != ''  && dni.length != ''   && email.length != ''  && id_especialidad.length != '' && id_tipo_cliente.length != ''  && clave.length != '' ){
		
		if( id_pais.length != '' && nombre.length != ''  && ap_pa.length != ''  && ap_ma.length != ''  && telefono.length != ''  && dni.length != ''   && email.length != ''  && id_especialidad.length != ''  && clave.length != '' ){
			
			let cadena= "action=registro"+"&id_pais="+id_pais+"&nombre="+nombre+"&ap_pa="+ap_pa+"&ap_ma="+ap_ma+"&telefono="+telefono+"&dni="+dni+"&email="+email+"&id_especialidad="+id_especialidad+"&id_tipo_cliente="+id_tipo_cliente+"&clave="+clave;

			$('#rptapago_2').text('procesando ...');
			
			$.ajax({url:'process_cart/registro_v2_completo_suscrito.php',data:cadena,type:'post',success:function(datos){
				var jotas = JSON.parse(datos);
				console.log('reg completo --> '+jotas.rpta);


				if(jotas.rpta=="ok"){
					// redireccionamos a inicio. o al perfil suscrito

						document.getElementById("finalizar").disabled=true;
						$('#rptapago_2').removeClass('pagoespera');$('#rptapago_2').removeClass('ingresa_gmail');
						$('#rptapago_2').addClass('pagoexito');
						$('#rptapago_2').text('Registrado correctamente ..');
						setTimeout(function () {
							$("#rptapago_2").addClass("hide");
							// location.href='perfil_inicio';
							
							if(jotas.link_go !=''){
									location.href=jotas.link_go;
							}else{
								location.href='mis-cursos';
								
							}
							
						}, 2000); //msj desparece en 5seg.

				}else if(jotas.rpta=="existe_telefono"){   /* si el dni ya esta registradao y el usuaior habilitado */
					document.getElementById("finalizar").disabled=false;
					
					$('#rptapago_2').text('Como su TELEFONO ya se encuentra registrado, comuniquese con un asesor de venta. ');
					
					console.log("error telefono ya registrado ");
					// alert("error dni ya registrado ");
					
					// si existe algun error
					$('#rptapago_2').addClass('pagoerror');
					$('#rptapago_2').removeClass('hide');
					$('#rptapago_2').removeClass('pagoespera');
					$('#rptapago_2').removeClass('ingresa_gmail');
					$('#rptapago_2').removeClass('pagoexito');
					// alert("dni ya registrado");
					setTimeout(function () {
						location.href='actualiza-tus-datos/'+jotas.id_suscrito;
					}, 2000); //msj desparece en 5seg.
				
				
				}else if(jotas.rpta=="existe_dni"){   /* si el dni ya esta registradao y el usuaior habilitado */
					document.getElementById("finalizar").disabled=false;
					
					$('#rptapago_2').text('Como su DNI ya se encuentra registrado si no recuerdas tu usuario y contraseña actualiza tus datos ');
					
					console.log("error dni ya registrado ");
					// alert("error dni ya registrado ");
					
					// si existe algun error
					$('#rptapago_2').addClass('pagoerror');
					$('#rptapago_2').removeClass('hide');
					$('#rptapago_2').removeClass('pagoespera');
					$('#rptapago_2').removeClass('ingresa_gmail');
					$('#rptapago_2').removeClass('pagoexito');
					// alert("dni ya registrado");
					setTimeout(function () {
						location.href='actualiza-tus-datos/'+jotas.id_suscrito;
					}, 2000); //msj desparece en 5seg.

					
				}else if(jotas.rpta=="existe_email"){   /* si el dni ya esta registradao y el usuaior habilitado */
					$('#rptapago_2').text('Como su Email ya se encuentra registrado si no recuerdas tu usuario y contraseña actualiza tus datos');
					document.getElementById("finalizar").disabled=false;
					// si existe algun error
					$('#rptapago_2').removeClass('hide');
					$('#rptapago_2').removeClass('pagoespera');$('#rptapago_2').removeClass('ingresa_gmail');
					$('#rptapago_2').removeClass('pagoexito');
					$('#rptapago_2').addClass('pagoerror');
					setTimeout(function () {
						location.href='actualiza-tus-datos/'+jotas.id_suscrito;
					}, 2000); //msj desparece en 5seg.
					
				}else if(jotas.rpta=="ingresa_email_gmail"){   /* si un correo gmail para registrarte */
					document.getElementById("finalizar").disabled=false;
					// si existe algun error
					$('#rptapago_2').removeClass('hide');
					$('#rptapago_2').removeClass('pagoespera');
					$('#rptapago_2').removeClass('pagoexito');
					$('#rptapago_2').removeClass('pagoerror');
					$('#rptapago_2').addClass('ingresa_gmail');
					$('#rptapago_2').text('Ingresa un correo gmail para registrarse!');
				
				}else if(jotas.rpta=="email_no_valido"){   /* ingresa un correo valido */
					document.getElementById("finalizar").disabled=false;
					// si existe algun error
					$('#rptapago_2').removeClass('hide');
					$('#rptapago_2').removeClass('pagoespera');$('#rptapago_2').removeClass('ingresa_gmail');
					$('#rptapago_2').removeClass('pagoexito');
					$('#rptapago_2').addClass('pagoerror');
					$('#rptapago_2').text('Ingresa un correo válido!');
					
				}else if(jotas.rpta=="soy_robot"){   /* si el dni ya esta registradao y el usuaior habilitado */
					document.getElementById("finalizar").disabled=false;
					// si existe algun error
					$('#rptapago_2').removeClass('hide');
					$('#rptapago_2').removeClass('pagoespera');$('#rptapago_2').removeClass('ingresa_gmail');
					$('#rptapago_2').removeClass('pagoexito');
					$('#rptapago_2').addClass('pagoerror');
					$('#rptapago_2').text('Selecciona "No soy un Robot"');
					
					
				}else{
					document.getElementById("finalizar").disabled=false;
					// si existe algun error
					$('#rptapago_2').removeClass('hide');
					$('#rptapago_2').removeClass('pagoespera');$('#rptapago_2').removeClass('ingresa_gmail');
					$('#rptapago_2').removeClass('pagoexito');
					$('#rptapago_2').addClass('pagoerror');
					$('#rptapago_2').text('Lo sentimos se perdio la conexion con el servidor error#22 ');

				}

			}});


		}else{
					document.getElementById("finalizar").disabled=false;
					// si existe algun error
					$('#rptapago_2').removeClass('hide');
					$('#rptapago_2').removeClass('pagoespera');$('#rptapago_2').removeClass('ingresa_gmail');
					$('#rptapago_2').removeClass('pagoexito');
					$('#rptapago_2').addClass('pagoerror');
					$('#rptapago_2').text('*Completa todos los datos ');
				console.log("completa todos los datos");
		}
		
	}else{
			document.getElementById("finalizar").disabled=false;
			// si existe algun error
					$('#rptapago_2').removeClass('hide');
			$('#rptapago_2').removeClass('pagoespera');$('#rptapago_2').removeClass('ingresa_gmail');
			$('#rptapago_2').removeClass('pagoexito');
			$('#rptapago_2').addClass('pagoerror');
			$('#rptapago_2').text('* Acepta recibir mensajes promocionales ');
			console.log("marca aceptar ");
		
	} /* end if checked */
	
	});
});



