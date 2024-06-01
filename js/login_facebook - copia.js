// Integración login facebook_ 

let token= '192358075687241';


function agregar_usuario_face(id, nombre,apellido,correo,imagen){
  $.ajax({
    type: "POST", url: 'login_facebook.php?opera=face', data: { id:id,  nombre : nombre, apellido : apellido, correo : correo, imagen : imagen },
    success: function(res){
			var respuesta = JSON.parse(res);

      if(respuesta.res==='completar_datos'){
				// si es usuario nuevo a completar registro		
				console.log("completa datos importantes ");
				location.href='registrate';
				
      }else if(respuesta.res==='ya_existe'){
				// location.href='https://www.tuweb7.com';
				console.log("usuario ya_existe, todo Ok");
				// location.href='mis-cursos'; 
				
				console.log("redirec-->"+respuesta.link_go);
				// alert(respuesta.link_go);
				
				// location.href='mis-cursos';
				
				if(respuesta.link_go !=''){
						// alert(' test =>'+respuesta.link_go);
					location.href=respuesta.link_go;
				}else{
					location.href='mis-cursos';
					
				}
				
      }else if(respuesta.res==='no'){ 
				console.log('RPTA login no Fb');
				// location.reload();
			
			}else { // alert('Registro Incorrecto');
				console.log('supuesto error login fb');
				// location.reload();
			}
			
    }
  });
}


function statusChangeCallback(response) {
		console.log('statusChangeCallback');
		console.log(response);
		if (response.status === 'connected') {
				testAPI();
				
		}
}

function checkLoginState() {
		FB.getLoginStatus(function (response) {
				statusChangeCallback(response);
		});
}

window.fbAsyncInit = function () {
		FB.init({appId: token, cookie: true, xfbml: true, version: 'v6.0'});
		// FB.getLoginStatus(function (response) {
				// statusChangeCallback(response);
		// });
};

(function (d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {
				return;
		}
		js = d.createElement(s);
		js.id = id;
		js.src = "https://connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function testAPI() {
		FB.api('/me', {fields: 'id, first_name, last_name, email, picture'},
			function (response) {
				console.log('Successful login for: ' + response.first_name);
				agregar_usuario_face(response.id, response.first_name, response.last_name, response.email, response.picture.data.url);
			}
		);

}
