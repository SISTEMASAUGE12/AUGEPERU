

$(document).ready(function(){
	// registramos total
	$("#finalizar_portada").click(function(){

			$('#rptapago_portada').removeClass('hide');
			$('#rptapago_portada').removeClass('pagoerror');
			$('#rptapago_portada').removeClass('pagoexito');
			$('#rptapago_portada').addClass('pagoespera');
					
		console.log('click en finalizar_portada registro.. ');
		//enviamos data completar registro de alumno
			var viene_desde=$('input[name="viene_desde"]').val(); // si demanda mostrar alerta validaciones o no , si viene desde trafico, no se necesita mostrar las alaertas
			
			var tag_trafico=$('input[name="tag_trafico"]').val();
			var link_wsp=$('input[name="link_wsp"]').val();

			var nombre=$('input[name="nombre"]').val();
			var ap_pa=$('input[name="ap_pa"]').val();
			var telefono=$('input[name="telefono"]').val();
			 var dni=$('input[name="dni"]').val();

			var id_especialidad=$('select[name="id_especialidad"]').val();
			var email=$('input[name="email"]').val();
			
			// var ciudad=$('input[name="ciudad"]').val();
			// var direccion=$('input[name="direccion"]').val();
			// var nam7="";
			var id_escala_mag=1;
			
			/*
			let id_pais;
			const radioButtons = document.querySelectorAll('input[name="id_pais"]');
			for (const radioButton of radioButtons) {
				if (radioButton.checked) {
					id_pais = radioButton.value;
					break;
				}
			}
			console.log('pais->'+id_pais);
			*/
			var id_pais=$('select[name="id_pais"]').val();
			var ap_ma=' - ';
			var tag_banner='2572';

			if(viene_desde == "trafico"){
				tag_banner=tag_trafico;
			}

			var registro_desde='4';
			var clave=dni;
			
	var isChecked = document.getElementById('consentimiento').checked;
	if(isChecked){
		
		// alert(id_pais+'-'+dni+'-'+nombre+'-'+ap_pa+'-'+telefono+'-'+email+'-'+id_especialidad+'-');	

		$('#rptapago_portada').removeClass('hide');
		if( id_pais.length != '' && dni.length != ''  && nombre.length != ''  && ap_pa.length != ''  && telefono.length != ''  && email.length != ''  && id_especialidad.length != '' ){
			
			let cadena= "action=registro"+"&id_pais="+id_pais+"&nombre="+nombre+"&ap_pa="+ap_pa+"&ap_ma="+ap_ma+"&telefono="+telefono+"&dni="+dni+"&email="+email+"&id_especialidad="+id_especialidad+"&id_escala_mag="+id_escala_mag+"&registro_desde="+registro_desde+"&clave="+clave+"&tag_banner="+tag_banner+"&viene_desde="+viene_desde+"&link_wsp="+link_wsp;

			

			$('#rptapago_portada').text('procesando ...');
			
			$.ajax({url:'process_cart/registro_v2_completo_suscrito.php',data:cadena,type:'post',success:function(datos){
				var jotas = JSON.parse(datos);
				console.log('reg completo --> '+jotas.rpta);


				if(jotas.rpta=="ok"){
					// redireccionamos a inicio. o al perfil suscrito

						document.getElementById("finalizar_portada").disabled=true;
						$('#rptapago_portada').removeClass('pagoespera');$('#rptapago_portada').removeClass('ingresa_gmail');
						$('#rptapago_portada').addClass('pagoexito');
						$('#rptapago_portada').text('Registrado correctamente ..');
						setTimeout(function () {
							$("#rptapago_portada").addClass("hide");
							// location.href='perfil_inicio';
							
							
							if(jotas.link_go !=''){
									location.href=jotas.link_go;
							}else{
								location.href='mis-cursos';
								
							}
							
							
						}, 2000); //msj desparece en 5seg.

				}else if(jotas.rpta=="existe_telefono"){   /* si el dni ya esta registradao y el usuaior habilitado */
					document.getElementById("finalizar_portada").disabled=false;
					
					$('#rptapago_portada').text('Como su TELEFONO ya se encuentra registrado, comuniquese con un asesor de venta. ');
					
					console.log("error telefono ya registrado ");
					// alert("error dni ya registrado ");
					
					// si existe algun error
					$('#rptapago_portada').addClass('pagoerror');
					$('#rptapago_portada').removeClass('hide');
					$('#rptapago_portada').removeClass('pagoespera');
					$('#rptapago_portada').removeClass('ingresa_gmail');
					$('#rptapago_portada').removeClass('pagoexito');
					// alert("dni ya registrado");
					setTimeout(function () {
						location.href='actualiza-tus-datos/'+jotas.id_suscrito;
					}, 2000); //msj desparece en 5seg.
				
				
				}else if(jotas.rpta=="existe_dni"){   /* si el dni ya esta registradao y el usuaior habilitado */
					document.getElementById("finalizar_portada").disabled=false;
					
					$('#rptapago_portada').text('Como su DNI ya se encuentra registrado si no recuerdas tu usuario y contraseña actualiza tus datos ');
					
					console.log("error dni ya registrado ");
					// alert("error dni ya registrado ");
					
					// si existe algun error
					$('#rptapago_portada').addClass('pagoerror');
					$('#rptapago_portada').removeClass('hide');
					$('#rptapago_portada').removeClass('pagoespera');
					$('#rptapago_portada').removeClass('ingresa_gmail');
					$('#rptapago_portada').removeClass('pagoexito');
					// alert("dni ya registrado");
					setTimeout(function () {
						location.href='actualiza-tus-datos/'+jotas.id_suscrito;
					}, 2000); //msj desparece en 5seg.

					
				}else if(jotas.rpta=="existe_email"){   /* si el dni ya esta registradao y el usuaior habilitado */
					$('#rptapago_portada').text('Como su Email ya se encuentra registrado si no recuerdas tu usuario y contraseña actualiza tus datos');
					document.getElementById("finalizar_portada").disabled=false;
					// si existe algun error
					$('#rptapago_portada').removeClass('hide');
					$('#rptapago_portada').removeClass('pagoespera');$('#rptapago_portada').removeClass('ingresa_gmail');
					$('#rptapago_portada').removeClass('pagoexito');
					$('#rptapago_portada').addClass('pagoerror');
					setTimeout(function () {
						location.href='actualiza-tus-datos/'+jotas.id_suscrito;
					}, 2000); //msj desparece en 5seg.
					
				}else if(jotas.rpta=="ingresa_email_gmail"){   /* si un correo gmail para registrarte */
					document.getElementById("finalizar_portada").disabled=false;
					// si existe algun error
					$('#rptapago_portada').removeClass('hide');
					$('#rptapago_portada').removeClass('pagoespera');
					$('#rptapago_portada').removeClass('pagoexito');
					$('#rptapago_portada').removeClass('pagoerror');
					$('#rptapago_portada').addClass('ingresa_gmail');
					$('#rptapago_portada').text('Ingresa un correo gmail para registrarse!');
				
				}else if(jotas.rpta=="email_no_valido"){   /* ingresa un correo valido */
					document.getElementById("finalizar_portada").disabled=false;
					// si existe algun error
					$('#rptapago_portada').removeClass('hide');
					$('#rptapago_portada').removeClass('pagoespera');$('#rptapago_portada').removeClass('ingresa_gmail');
					$('#rptapago_portada').removeClass('pagoexito');
					$('#rptapago_portada').addClass('pagoerror');
					$('#rptapago_portada').text('Ingresa un correo válido!');
					
				}else if(jotas.rpta=="soy_robot"){   /* si el dni ya esta registradao y el usuaior habilitado */
					document.getElementById("finalizar_portada").disabled=false;
					// si existe algun error
					$('#rptapago_portada').removeClass('hide');
					$('#rptapago_portada').removeClass('pagoespera');$('#rptapago_portada').removeClass('ingresa_gmail');
					$('#rptapago_portada').removeClass('pagoexito');
					$('#rptapago_portada').addClass('pagoerror');
					$('#rptapago_portada').text('Selecciona "No soy un Robot"');
					
					
				}else{
					document.getElementById("finalizar_portada").disabled=false;
					// si existe algun error
					$('#rptapago_portada').removeClass('hide');
					$('#rptapago_portada').removeClass('pagoespera');$('#rptapago_portada').removeClass('ingresa_gmail');
					$('#rptapago_portada').removeClass('pagoexito');
					$('#rptapago_portada').addClass('pagoerror');
					$('#rptapago_portada').text('Lo sentimos se perdio la conexion con el servidor error#22 ');

				}

			}});


		}else{
					document.getElementById("finalizar_portada").disabled=false;
					// si existe algun error
					$('#rptapago_portada').removeClass('hide');
					$('#rptapago_portada').removeClass('pagoespera');$('#rptapago_portada').removeClass('ingresa_gmail');
					$('#rptapago_portada').removeClass('pagoexito');
					$('#rptapago_portada').addClass('pagoerror');
					$('#rptapago_portada').text('*Completa todos los datos ');
				console.log("completa todos los datos");
		}
		
	}else{
			document.getElementById("finalizar_portada").disabled=false;
			// si existe algun error
					$('#rptapago_portada').removeClass('hide');
			$('#rptapago_portada').removeClass('pagoespera');$('#rptapago_portada').removeClass('ingresa_gmail');
			$('#rptapago_portada').removeClass('pagoexito');
			$('#rptapago_portada').addClass('pagoerror');
			$('#rptapago_portada').text('* Acepta recibir mensajes promocionales ');
			console.log("marca aceptar ");
		
	} /* end if checked */
	
	});
});


