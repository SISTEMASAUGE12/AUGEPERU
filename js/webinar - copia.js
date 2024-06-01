$(document).ready(function(){
		
		
		/* registro del webinar */
		$("#registro_al_webinar_2").click(function(){
			// alert("hola");
			//enviamos data completar registro de alumno
			var id_webinar=$('input[name="id_webinar"]').val();
			var webinar=$('input[name="webinar"]').val();
			var rewrite=$('input[name="rewrite"]').val();
			var nombre=$('input[name="nombre_completo"]').val();
			var email=$('input[name="email"]').val();
			var telefono=$('input[name="telefono"]').val();
			// var tipo=$('select[name="tipo"]').val();
			
			// if( nombre !='' && telefono !='' && email !='' && tipo !='' ){
			if( nombre !='' && email !=''  ){
					// 
					$('#rptapago_w2').removeClass('hide');
					$('#rptapago_w2').removeClass('pagoerror');
					$('#rptapago_w2').removeClass('pagoexito');
					$('#rptapago_w2').addClass('pagoespera');
					$('#rptapago_w2').text('Procesando..');

					// let cadena= "action=registro"+"&id_webinar="+id_webinar+"&nombre_completo="+nombre+"&webinar="+webinar+"&rewrite="+rewrite+"&telefono="+telefono+"&tipo="+tipo+"&email="+email;
					
					let cadena= "&xx=registro"+"&action=registro"+"&id_webinar="+id_webinar+"&nombre_completo="+nombre+"&webinar="+webinar+"&rewrite="+rewrite+"&email="+email+"&telefono="+telefono;

					$.ajax({url:'btn_registro_de_webinars.php',data:cadena,type:'post',success:function(datos){
						var jotas = JSON.parse(datos);

						console.log('reg completo --> '+jotas.rpta);
						if(jotas.rpta==1){
							// redireccionamos a inicio. o al perfil suscrito
							setTimeout(function () {
								$('#rptapago_w2').removeClass('pagoespera');
								$('#rptapago_w2').addClass('pagoexito');
								$('#rptapago_w2').text('Registrado correctamente');
								setTimeout(function () {
									$("#rptapago_w2").addClass("hide");
									// alert("rloadd");
									location.reload();
									
								}, 3000); //msj desparece en 5seg.
							}, 4000); //msj desparece en 5seg.

						}else{
							// si existe algun error
							$('#rptapago_w2').removeClass('pagoespera');
							$('#rptapago_w2').removeClass('pagoexito');
							$('#rptapago_w2').addClass('pagoerror');
							$('#rptapago_w2').text('Lo sentimos se perdio la conexion con el servidor error#22 ');

						}
					}});
			}else{
				$('#rptapago_w2').removeClass('hide');
				$('#rptapago_w2').removeClass('pagoespera');
				$('#rptapago_w2').removeClass('pagoexito');
				$('#rptapago_w2').addClass('pagoerror');
				$('#rptapago_w2').text('Completa todos los datos');
			}
	});
	
	
	/* registro del webinar v_3 */
	$("#registro_al_webinar_3").click(function(){
		// alert("hola");
		//enviamos data completar registro de alumno
		var id_webinar=$('input[name="id_webinar"]').val();
		var webinar=$('input[name="webinar"]').val();
		var rewrite=$('input[name="rewrite"]').val();
		var nombre=$('input[name="nombre_completo"]').val();
		var email=$('input[name="email"]').val();
		var telefono=$('input[name="telefono"]').val();
		// var tipo=$('select[name="tipo"]').val();
		
		// if( nombre !='' && telefono !='' && email !='' && tipo !='' ){
		if( nombre !='' && email !=''  ){
				// 
				$('#rptapago_w3').removeClass('hide');
				$('#rptapago_w3').removeClass('pagoerror');
				$('#rptapago_w3').removeClass('pagoexito');
				$('#rptapago_w3').addClass('pagoespera');
				$('#rptapago_w3').text('Procesando..');

				// let cadena= "action=registro"+"&id_webinar="+id_webinar+"&nombre_completo="+nombre+"&webinar="+webinar+"&rewrite="+rewrite+"&telefono="+telefono+"&tipo="+tipo+"&email="+email;
				
				let cadena= "&xx=registro"+"&action=registro"+"&id_webinar="+id_webinar+"&nombre_completo="+nombre+"&webinar="+webinar+"&rewrite="+rewrite+"&email="+email+"&telefono="+telefono;

				$.ajax({url:'btn_registro_de_webinars.php',data:cadena,type:'post',success:function(datos){
					var jotas = JSON.parse(datos);

					console.log('reg completo --> '+jotas.rpta);
					if(jotas.rpta==1){
						// redireccionamos a inicio. o al perfil suscrito
						setTimeout(function () {
							$('#rptapago_w3').removeClass('pagoespera');
							$('#rptapago_w3').addClass('pagoexito');
							$('#rptapago_w3').text('Registrado correctamente');
							setTimeout(function () {
								$("#rptapago_w3").addClass("hide");
								// alert("rloadd");
								location.reload();
								
							}, 3000); //msj desparece en 5seg.
						}, 4000); //msj desparece en 5seg.

					}else{
						// si existe algun error
						$('#rptapago_w3').removeClass('pagoespera');
						$('#rptapago_w3').removeClass('pagoexito');
						$('#rptapago_w3').addClass('pagoerror');
						$('#rptapago_w3').text('Lo sentimos se perdio la conexion con el servidor error#22 ');

					}
				}});
		}else{
			$('#rptapago_w3').removeClass('hide');
			$('#rptapago_w3').removeClass('pagoespera');
			$('#rptapago_w3').removeClass('pagoexito');
			$('#rptapago_w3').addClass('pagoerror');
			$('#rptapago_w3').text('Completa todos los datos');
		}
	});
	/* end webinar v.3 */


}); // en wins load