function onLoadGoogleCallback() {
		var element = document.getElementById('googleSignIn');
		
			// alert("si existe"+element);

		
		gapi.load('auth2', function () {
				auth2 = gapi.auth2.init({
						client_id: '889922707584-vra1hc9mdn321p2m1ieouc6rijqfnr9i',
						// cookiepolicy:'single_host_origin',
						scope: 'profile email'
				});

				auth2.attachClickHandler(element, {},
						function (googleUser) {
								var name = googleUser.getBasicProfile().getName();
								var email = googleUser.getBasicProfile().getEmail();
								var accestoken = googleUser.getBasicProfile().getId();

								console.log(name);
								console.log(email);
								console.log(accestoken);
								var str = "nombre=" + name + "&email=" + email + "&id_fb=" + accestoken;
								
								$.ajax({
										url: 'process_cart/login_google.php', data: str, type: 'post', success: function (res) {
												var respuesta = JSON.parse(res);

												if(respuesta.res === 'completar_datos'){
													// si es usuario nuevo a completar registro		
													console.log("completa datos importantes ");
													location.href='registrate';
													
												}else if(respuesta.res === 'ya_existe'){
													// location.href='https://www.tuweb7.com';
													console.log("usuario ya_existe, todo Ok");
													// location.href='mis-cursos';
													
													console.log("redirec-->"+respuesta.link_go);
													// alert(respuesta.link_go);
													
													// location.href='mis-cursos';
													if(respuesta.link_go !=''){
														location.href=respuesta.link_go;

													}else{
														location.href='mis-cursos';
														
													}
																						
												}else if(respuesta.res === 'no'){ 
													console.log('RPTA login no Fb');
													// location.reload();
												
												}else { // alert('Registro Incorrecto');
													console.log('supuesto error login fb');
													// location.reload();
												}		
												
												
										}
								});
						}, function (error) {
								console.log('goo error', error);
						}
				);
		});

		
} 

