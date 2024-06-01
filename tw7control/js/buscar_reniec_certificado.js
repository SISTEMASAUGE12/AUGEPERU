function buscar_dni_reniec_certificado(dni){
	console.log(dni.length);
	if( dni != '' && dni.length == 8){
			// let dni="48431448";
			let str="dni="+dni;
			$.ajax({url:'z_consultar_reniec',data:str,type:'post',success:function(datos){
				if(datos){
						console.log(datos);
						var resultados = JSON.parse(datos);
						
						if(resultados.success == false ){
							//si ya existe bloquear registro
							$("#api_nombre").val("no se encontro dato en reniec");
							$("#api_paterno").val("no se encontro dato en reniec");
							$("#api_materno").val("no se encontro dato en reniec");
							
							$("#api_nombre_text").val("no se encontro dato en reniec");
							$("#api_paterno_text").val("no se encontro dato en reniec");
							$("#api_materno_text").val("no se encontro dato en reniec");
							
						}else if(resultados.dni != "" && typeof resultados.dni !== 'undefined'){
								// si todo okey encontro dato en reniec 
								let nombre= resultados.nombres;
								
								$("#api_nombre").val(nombre);
								$("#api_paterno").val(resultados.apellidoPaterno);
								$("#api_materno").val(resultados.apellidoMaterno);
								
								$("#api_nombre_text").val(nombre);
								$("#api_paterno_text").val(resultados.apellidoPaterno);
								$("#api_materno_text").val(resultados.apellidoMaterno);
								
						}else if(resultados.error == "error"){
							console.log('_error busqueda ');
							$("#api_nombre").val("no se encontro dato en reniec -- ");
							$("#api_paterno").val("no se encontro dato en reniec --");
							$("#api_materno").val("no se encontro dato en reniec -- ");

									
							$("#api_nombre_text").val("no se encontro dato en reniec --");
							$("#api_paterno_text").val("no se encontro dato en reniec --");
							$("#api_materno_text").val("no se encontro dato en reniec --");

						}

				}else{
					console.log('	error reniec .. no devuelve datos');
					$("#api_nombre").val("error reniec ..");
					$("#api_nombre_text").val("error reniec ..");
				}
			}});
	
	}else{
		alert("Ingresa un DNI valido! "+dni);
	}
}
