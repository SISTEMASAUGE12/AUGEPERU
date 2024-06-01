function buscar_dni_reniec(){
	$("#name_reniec_origen").val('Espere, consultando en RENIEC ..');
	var dni=$('input[name="dni"]').val();
	// let dni="48431448";
	let str="dni="+dni;
	$.ajax({url:'z_consultar_reniec',data:str,type:'post',success:function(datos){
		if(datos){
				console.log(datos);
				var resultados = JSON.parse(datos);
				
				if(resultados.success == false ){
					//si ya existe bloquear registro
					$("#nombre_completo_origen").val("no se encontro dato en reniec");
					$("#name_reniec_origen").val("no se encontro dato en reniec");
					$("#btnguardar").removeClass('hide');
					
				}else if(resultados.dni != "" && typeof resultados.dni !== 'undefined'){
						// si todo okey encontro dato en reniec 
						let nombre= resultados.nombres;
						let ape= resultados.apellidoPaterno+' '+resultados.apellidoMaterno;
						
						$("#nombre_completo_origen").val(nombre+' '+ape);
						$("#name_reniec_origen").val(nombre+' '+ape);
						
				}else if(resultados.error == "error"){
					console.log('_error busqueda ');
					$("#nombre").val("No se encontro dato en reniec");
					$("#apellidos").val("No se encontro dato en reniec");
					$("#name_reniec_origen").val("No se encontro dato en reniec");

				}

		}else{
			console.log('	error reniec .. no devuelve datos');
			$("#name_reniec_origen").val("error reniec ..");
		}
	}});
}
