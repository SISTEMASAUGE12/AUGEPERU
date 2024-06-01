$(document).ready(function(){

	// Registro basico de cliente
	// Registro basico de cliente
		$(".btn_registrar_alumno").click(function(){
				console.log("enviando data ala registro cliente ...  ");
				document.getElementsByClassName("btn_registrar_alumno").disabled=true;
				$('.btn_registrar_alumno').addClass('btn-pedidoencurso');

				var email=$('input[name="email_reg"]').val();
				var clave=$('input[name="clave_reg"]').val();
				var clave_2=$('input[name="clave_reg_2"]').val();


				if( email.length > 5 && clave.length >7 && clave_2.length >7 ){
					if( clave_2 == clave ){
					
						$('#rptapago').removeClass('hide');
						str= '&action=registro&email='+email+"&clave="+clave;
						$.ajax({url:'process_cart/registro_cliente_etapa_1.php',data:str,type:'post',success:function(res){
								var resultado = JSON.parse(res);

										if(resultado.res === 'completar_datos'){
											// si es usuario nuevo a completar registro
											setTimeout(function () {

												document.getElementsByClassName("btn_registrar_alumno").disabled=true;
												$('#rptapago').removeClass('pagoespera');
												$('#rptapago').addClass('pagoexito');
												$('#rptapago').text('Hola! Bienvenido, completa el registro ..');
												setTimeout(function () {
													$("#rptapago").addClass("hide");
													console.log("completa datos importantes ");
													location.href='registrate';
												}, 1000); //msj desparece en 5seg.
											}, 2000); //msj desparece en 5seg.


										}else if(resultado.res === 'ya_existe'){
											console.log("usuario ya_existe, todo Ok");
											console.log("redirec-->"+resultado.link_go);
											// alert(resultado.link_go);
											
											// location.href='perfil_inicio';
											if(resultado.link_go !=''){
												location.href=resultado.link_go;
											}else{
												location.href='perfil_inicio';
												
											}

										}else if(resultado.res === 'robot'){
											console.log(" marca la casilla: No soy un robot ");
											$('#rptapago').removeClass('pagoespera');
											$('#rptapago').removeClass('pagoexitos');
												$('#rptapago').addClass('pagoerror');
												$('#rptapago').text('Marca la casilla: No soy un robot ');
											
											
										}else if(resultado.res === 'no'){
											console.log('RPTA login no Fb');
											// location.reload();

										}else { // alert('Registro Incorrecto');
											console.log('supuesto error login fb');
											// location.reload();
										}
						}});
						
					}else{
							// ... validarcion misma clave --

								$('input[name="clave_reg_2"]').addClass('error');
								$('.label_reg_clave_2').html('Las contraseñas no coinciden ..');
								$('.label_reg_clave_2').removeClass('hide');
						
							// $('input[name="clave_reg_2"]').removeClass('error');
							// $('.label_reg_clave_2').addClass('hide');
					
					}
					
					
				}else{
						if(email.length < 6){
							$('input[name="email_reg"]').addClass('error');
							$('.label_reg_email').removeClass('hide');

						}else{
							$('input[name="email_reg"]').removeClass('error');
							$('.label_reg_email').addClass('hide');
						}

						if(clave.length < 8){
								$('input[name="clave_reg"]').addClass('error');
								$('.label_reg_clave').removeClass('hide');
						}else{
							$('input[name="clave_reg"]').removeClass('error');
							$('.label_reg_clave').addClass('hide');
						}
						
						if(clave_2.length < 8){
								$('input[name="clave_reg_2"]').addClass('error');
								$('.label_reg_clave_2').removeClass('hide');
						}else{
							$('input[name="clave_reg_2"]').removeClass('error');
							$('.label_reg_clave_2').addClass('hide');
						}
					// alert("Ingresa una clave de mínimo 8 caracteres.");
				}
		});


		$('.modal_registro_cliente').find('input[name="email_reg"]').on('keyup',function(){ //para buscar destinos *sin btn
				var email_reg=$('input[name="email_reg"]').val();
				$('input[name="email_reg"]').removeClass('error');
				$('.label_reg_email').addClass('hide');
				// $('.error_name').html('');
				console.log("xxx->"+email_reg);

		});

		$('.modal_registro_cliente').find('input[name="clave_reg"]').on('keyup',function(){ //para buscar destinos *sin btn
				var email_reg=$('input[name="clave_reg"]').val();
				$('input[name="clave_reg"]').removeClass('error');
				$('.label_reg_clave').addClass('hide');
				// $('.error_name').html('');
				console.log("xxx->"+email_reg);
				//quito sisabled a boton
				$('.btn_registrar_alumno').removeClass('disabled');

		});
		
		$('.modal_registro_cliente').find('input[name="clave_reg_2"]').on('keyup',function(){ //para buscar destinos *sin btn
				var email_reg=$('input[name="clave_reg"]').val();
				var email_reg_2=$('input[name="clave_reg_2"]').val();
				$('input[name="clave_reg_2"]').removeClass('error');
				
				if(email_reg_2==email_reg){
					$('.label_reg_clave_2').addClass('hide');
					// document.getElementById("btn_registro").disabled=false;

					
				}else{
					$('.label_reg_clave_2').html('Las contraseñas no coinciden ..');
					
				}
				
				// $('.error_name').html('');
				console.log("xxx->"+email_reg_2);
				$('.btn_registrar_alumno').removeClass('disabled');
		});
		
		
		// Registro basico de cliente  end
		// Registro basico de cliente  end





	// Iniciando sesion  de cliente
	// Iniciando sesion  de cliente
		$(".btn_login_alumno").click(function(){
				console.log("enviando data ala login cliente ...  ");
				document.getElementsByClassName("btn_login_alumno").disabled=true;
				$('.btn_login_alumno').addClass('btn-pedidoencurso');

				var email=$('input[name="email_login"]').val();
				var clave=$('input[name="clave_login"]').val();

				if( email.length > 5 && clave.length >7 ){
						$('#rptapago').removeClass('hide');
						str= '&action=registro&email='+email+"&clave="+clave;
						$.ajax({url:'process_cart/login_cliente.php',data:str,type:'post',success:function(res){
								var respuesta = JSON.parse(res);

										if(respuesta.res === 'completar_datos'){
											// si es usuario nuevo a completar registro
											setTimeout(function () {

												document.getElementsByClassName("btn_login_alumno").disabled=true;
												$('#rptapago').removeClass('pagoespera');
												$('#rptapago').addClass('pagoexito');
												$('#rptapago').text('Hola! Bienvenido, completa el registro ..');
												setTimeout(function () {
													$("#rptapago").addClass("hide");
													console.log("completa datos importantes ");
													location.href='registrate';
												}, 1000); //msj desparece en 5seg.
											}, 2000); //msj desparece en 5seg.


										}else if(respuesta.res === 'ya_existe'){
											// location.href='https://www.mapa19.pe/mapa';

											setTimeout(function () {
												document.getElementsByClassName("btn_login_alumno").disabled=true;
												$('#rptapago').removeClass('pagoespera');
												$('#rptapago').addClass('pagoexito');
												$('#rptapago').text('Hola! bienvenido a AUGE');
												setTimeout(function () {
													$("#rptapago").addClass("hide");
													console.log("usuario ya_existe, todo Ok");
													
													// location.href='perfil_inicio';
													console.log("redirec-->"+respuesta.link_go);
													// alert(respuesta.link_go);
													
													// location.href='perfil_inicio';
													if(respuesta.link_go !=''){
														location.href=respuesta.link_go;
													}else{
														location.href='perfil_inicio';
														
													}
													
													
												}, 1000); //msj desparece en 5seg.
											}, 2000); //msj desparece en 5seg.


										}else if(respuesta.res === 'cliente_deshabilitado'){
											console.log('cliente deshabilitado ..');
											setTimeout(function () {
												document.getElementsByClassName("btn_login_alumno").disabled=true;
												$('#rptapago').removeClass('pagoespera');
												$('#rptapago').addClass('pagoerror');
												$('#rptapago').text('Lo sentimos: esta cuenta se encuentra deshabilitada ..');
												setTimeout(function () {
													$('#rptapago').text('cargando ..');
													$("#rptapago").removeClass("pagoerror");
													$("#rptapago").addClass("pagoespera");
													$("#rptapago").addClass("hide");
													document.getElementsByClassName("btn_login_alumno").disabled=false;
												}, 1000); //msj desparece en 5seg.
											}, 2000); //msj desparece en 5seg.

										}else if(respuesta.res === 'cliente_no_registrado'){
											console.log('cliente no registrado ..');
											setTimeout(function () {
												document.getElementsByClassName("btn_login_alumno").disabled=true;
												$('#rptapago').removeClass('pagoespera');
												$('#rptapago').addClass('pagoerror');
												$('#rptapago').text('Cliente no registrado ..');
												setTimeout(function () {
													$('#rptapago').text('cargando ..');
													$("#rptapago").removeClass("pagoerror");
													$("#rptapago").addClass("pagoespera");
													$("#rptapago").addClass("hide");
													document.getElementsByClassName("btn_login_alumno").disabled=false;
												}, 1000); //msj desparece en 5seg.
											}, 2000); //msj desparece en 5seg.

										}else if(respuesta.res === 'error_clave'){
											console.log('cliente no registrado ..');
											setTimeout(function () {
												document.getElementsByClassName("btn_login_alumno").disabled=true;
												$('#rptapago').removeClass('pagoespera');
												$('#rptapago').addClass('pagoerror');
												$('#rptapago').text('Clave incorrecta ..');
												setTimeout(function () {
													$('#rptapago').text('cargando ..');
													$("#rptapago").removeClass("pagoerror");
													$("#rptapago").addClass("pagoespera");
													$("#rptapago").addClass("hide");
													document.getElementsByClassName("btn_login_alumno").disabled=false;
												}, 1000); //msj desparece en 5seg.
											}, 2000); //msj desparece en 5seg.

										}else if(respuesta.res === 'no'){
											console.log('supuesto error consulta, revisar #22 ');
											// location.reload();
											setTimeout(function () {
												document.getElementsByClassName("btn_login_alumno").disabled=true;
												$('#rptapago').removeClass('pagoespera');
												$('#rptapago').addClass('pagoexito');
												$('#rptapago').text('Error #22, comunícate por interno .. ');
												setTimeout(function () {
													$('#rptapago').text('cargando ..');
													$("#rptapago").removeClass("pagoerror");
													$("#rptapago").addClass("pagoespera");
													$("#rptapago").addClass("hide");
													console.log("supuesto error en consulta .. ");
													document.getElementsByClassName("btn_login_alumno").disabled=false;
												}, 1000); //msj desparece en 5seg.
											}, 2000); //msj desparece en 5seg.


										}else { // alert('Registro Incorrecto');
											console.log('supuesto error login fb');
											// location.reload();
										}
						}});

				}else{
						if(email.length < 6){
							$('input[name="email_login"]').addClass('error');
							$('.label_log_email').removeClass('hide');

						}else{
							$('input[name="email_login"]').removeClass('error');
							$('.label_log_email').addClass('hide');
						}

						if(clave.length < 8){
								$('input[name="clave_login"]').addClass('error');
								$('.label_log_clave').removeClass('hide');
						}else{
							$('input[name="clave_login"]').removeClass('error');
							$('.label_log_clave').addClass('hide');
						}
					// alert("Ingresa una clave de mínimo 8 caracteres.");
				}
		});


		$('.modal_login_cliente').find('input[name="email_login"]').on('keyup',function(){ //para buscar destinos *sin btn
				var email_login=$('input[name="email_login"]').val();
				$('input[name="email_login"]').removeClass('error');
				$('.label_log_email').addClass('hide');
				// $('.error_name').html('');
				console.log("xxx->"+email_login);

		});

		$('.modal_login_cliente').find('input[name="clave_login"]').on('keyup',function(){ //para buscar destinos *sin btn
				var email_login=$('input[name="clave_login"]').val();
				$('input[name="clave_login"]').removeClass('error');
				$('.label_log_clave').addClass('hide');
				// $('.error_name').html('');
				console.log("xxx->"+email_login);
				//quito sisabled a boton
				$('.btn_login_alumno').removeClass('disabled');

		});

	// Iniciando sesion  de cliente
	// Iniciando sesion  de cliente



}); // en wins load



// Lamando formuakrios flotantes
//Abrir Login Emergente
$("#busquita").click(function(){
    $("#busq").toggle();
});
$("#mita1").click(function(){
	if($('#laca').is(":visible")){
    	$('#laca').css('display', 'none');
  	}
    if($('#memi').hasClass('auto')){
        $("#memi").removeClass('auto');
    }else{
        $("#memi").addClass('auto');
    }
});
$("#mita2").click(function(){
    $("#laca").toggle();
    if($('#memi').hasClass('auto')){
        $("#memi").removeClass('auto');
    }
    if($('#mita2 i').hasClass('ica2')){
        $("#mita2 i").removeClass('ica2');
    }else{
        $("#mita2 i").addClass('ica2');
    }
});



// let google_registro = '<a id="googleSignIn" class="  btn-google poppi-sb " href="javascript:;" ><img src="img/iconos/google.png">Regístrate con google</a> ';
// let google_ingresar = '<a id="googleSignIn" class="  btn-google poppi-sb " href="javascript:;" ><img src="img/iconos/google.png">Ingresar con google</a>';

/* Abrir Login Emergente */
$(".llama_al_login").click(function(){
    $("#login-modal").toggle();
    $("#top").addClass("bodmodal");
	// $(".google_ingresar").html(google_ingresar);
    // $(".google_registro").html("hola");
		onLoadGoogleCallback();
});

//Cerrar Login
$('.close1').click(function(){
    $("#top").removeClass("bodmodal");
    $("#login-modal").toggle();
});


//Abrir Registrar
// $('.llama_al_registro').click(function(){
    // $("#registrar-modal").toggle();
    // $("#top").addClass("bodmodal");
    // $(".google_ingresar").html("hola");
    // $(".google_registro").html(google_registro);
		// onLoadGoogleCallback();
// });

// $('#registrar2').click(function(){
    // $("#registrar-modal").toggle();
    // $("#top").addClass("bodmodal");
// });

//Cerrar Registrar
// $('.close2').click(function(){
    // $("#top").removeClass("bodmodal");
    // $("#registrar-modal").toggle();
// });

// pasamos de login a registro
// $('#crear').click(function(){
    // $("#registrar-modal").toggle();
    // $("#login-modal").toggle();
		// $(".google_ingresar").html("hola");
    // $(".google_registro").html(google_registro);
		// onLoadGoogleCallback();

// });


//Cambiar de registro  a login
// $('#entrar').click(function(){
    // $("#login-modal").toggle();
    // $("#registrar-modal").toggle();
		// $(".google_ingresar").html(google_ingresar);
    // $(".google_registro").html("hola");
		// onLoadGoogleCallback();
// });

