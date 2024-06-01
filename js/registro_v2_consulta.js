$(document).ready(function(){
	// registramos total
	$("#consultar_datos_registro").click(function(){
		//enviamos data completar registro de alumno
		var data=$('input[name="data"]').val();
		console.log('data_update reg->'+data);
		let cadena= "action=actualiza_tus_datos"+"&data="+data;
			
		$('#rptapago_1').removeClass('hide');
		$('#rptapago_1').removeClass('pagoerror');
		$('#rptapago_1').removeClass('pagoexito');
		$('#rptapago_1').addClass('pagoespera');
		
		// alert(data);
		if( data !=''){ 
			
			$.ajax({url:'process_cart/registro_v2_a_consulta_actualiza_tus_datos.php',data:cadena,type:'post',success:function(datos){
				var jotas = JSON.parse(datos);

				$('#rptapago_1').removeClass('hide');
				console.log('reg update datos --> '+jotas.rpta);

				if(jotas.rpta=="ok"){
					// redireccionamos a inicio. o al perfil suscrito
					setTimeout(function () {
						$('#rptapago_1').removeClass('pagoespera');
						$('#rptapago_1').addClass('pagoexito');
						$('#rptapago_1').text('Registrado correctamente ..');
						setTimeout(function () {
							$("#rptapago_1").addClass("hide");
							// location.href='perfil_inicio';							
							if(jotas.link_go !=''){
									location.href=jotas.link_go;
							}else{
								location.href='mis-cursos';
							}
							
						}, 2000); //msj desparece en 5seg.
					}, 3000); //msj desparece en 5seg.

				}else if(jotas.rpta=="4"){   /* enviamos al registro */
					// si existe algun error
					$('#rptapago_1').removeClass('pagoespera');
					$('#rptapago_1').removeClass('pagoexito');
					$('#rptapago_1').addClass('pagoerror');
					$('#rptapago_1').text('Ops! Número de DNI/cédula o correo no existe. Te redireccionamos al formulario de registro');
					
					console.log(" envio a registrarse ");
					setTimeout(function () {
						$("#rptapago_1").addClass("hide");					
						location.href='registrate_v2/'+jotas.data;
					}, 2000); //msj desparece en 5seg.
					
					
				}else if(jotas.rpta=="existe_data"){   /* si el dni ya esta registradao y el usuaior habilitado */
					// si existe algun error
					$('#rptapago_1').removeClass('pagoespera');
					$('#rptapago_1').removeClass('pagoerror');
					$('#rptapago_1').addClass('pagoexito');
					$('#rptapago_1').text('Actualiza tus datos para finalizar el registro..');
					console.log(" envio a actualizar datos .. ");
					setTimeout(function () {
						$("#rptapago_1").addClass("hide");					
						location.href='actualiza-tus-datos/'+jotas.id_suscrito;
					}, 2000); //msj desparece en 5seg.					
					
				}else{
					// si existe algun error
					$('#rptapago_1').removeClass('pagoespera');
					$('#rptapago_1').removeClass('pagoexito');
					$('#rptapago_1').addClass('pagoerror');
					$('#rptapago_1').text('Lo sentimos se perdio la conexion con el servidor error#22 ');
				}

			}});


		}else{
				/* ingresa un dato para continuar */
				$('#rptapago_1').removeClass('pagoespera');
				$('#rptapago_1').removeClass('pagoexito');
				$('#rptapago_1').addClass('pagoerror');
				$('#rptapago_1').text('Ingresa un dato para continuar ');
		}
		
	});
});



