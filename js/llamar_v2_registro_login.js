$(document).ready(function(){
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
													// location.href='registrate';
													location.href='actualiza-tus-datos/'+respuesta.email;
												}, 1000); //msj desparece en 5seg.
											}, 2000); //msj desparece en 5seg.


										}else if(respuesta.res === 'ya_existe'){

											setTimeout(function () {
												document.getElementsByClassName("btn_login_alumno").disabled=true;
												$('#rptapago').removeClass('pagoespera');
												$('#rptapago').addClass('pagoexito');
												$('#rptapago').text('Hola! bienvenido a Educa auge');
												setTimeout(function () {
													$("#rptapago").addClass("hide");
													console.log("usuario ya_existe, todo Ok");
													
													// location.href='mis-cursos';
													console.log("redirec-->"+respuesta.link_go);
													// alert(respuesta.link_go);
													
													// location.href='mis-cursos';
													if(respuesta.link_go !=''){
														//location.href=respuesta.link_go;
														location.href='mis-cursos';
													}else{
														location.href='mis-cursos';
														
													}
													
													
												}, 1000); //msj desparece en 5seg.
											}, 2000); //msj desparece en 5seg.


										}else if(respuesta.res === '_ya_esta_logeado'){
											console.log('cliente _ya_esta_logeado ..');
											setTimeout(function () {
												document.getElementsByClassName("btn_login_alumno").disabled=true;
												$('#rptapago').removeClass('pagoespera');
												$('#rptapago').addClass('pagoerror');
												$('#rptapago').text(' Ya tienes una sesión iniciada, cierra sesión en el dispositivo para poder acceder nuevamente aquí. ');
												setTimeout(function () {
													$('#rptapago').text('cargando ..');
													$("#rptapago").removeClass("pagoerror");
													$("#rptapago").addClass("pagoespera");
													$("#rptapago").addClass("hide");
													document.getElementsByClassName("btn_login_alumno").disabled=false;
												}, 10000); //msj desparece en 5seg.
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
										
										
											// ASISTENCIA YA EXISTE, TIENE SESSION ACTIVA EN DISPISITIVO 
										}else if(respuesta.res === 'sesion_ya_activa'){
											console.log('cliente tiene una sesion_activa registrada, debe cerrar sesion en otro dispositivo  ..');
											setTimeout(function () {
												document.getElementsByClassName("btn_login_alumno").disabled=true;
												$('#rptapago').removeClass('pagoespera');
												$('#rptapago').addClass('pagoerror');
												$('#rptapago').text(' Tu cuenta de Educaauge ya está en uso en otro dispositivo, cierra sesión para acceder aquí..');
												setTimeout(function () {
													$('#rptapago').text('cargando ..');
													$("#rptapago").removeClass("pagoerror");
													$("#rptapago").addClass("pagoespera");
													$("#rptapago").addClass("hide");
													document.getElementsByClassName("btn_login_alumno").disabled=false;
												}, 10000); //msj desparece en 5seg.
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

