
function guardar_atencion_cliente_vendedor() { 
	// alert("fiuuuuu");
	
	var nompage = $('input[name="nompage"]').val();
  var nommodule = $('input[name="nommodule"]').val();
  var nomparenttab = $('input[name="nomparenttab"]').val();
	
  var id_suscrito = $('input[name="id_cliente"]').val();
  var motivo = $('input[name="motivo"]').val();
  var id_tipo_atencion = $('select[name="id_tipo_atencion"]').val();
  var id_tipo_intera = $('select[name="id_tipo_intera"]').val();
  var descripcion = $('textarea[name="descripcion"]').val();
  var curso = $('input[name="curso"]').val();
  var precio = $('input[name="precio"]').val();
  var id_nivel = $('select[name="id_nivel"]').val();
  var id_tipo_recordatorio = $('select[name="id_tipo_recordatorio"]').val();
  var fecha_recordatorio = $('input[name="fecha_recordatorio"]').val();
  var hora_recordatorio = $('input[name="hora_recordatorio"]').val();
	

  // var imagen=$('#imagen').val();
  // var files = $('#imagen')[0].files[0];
	
	
    if(id_suscrito > 0){
			$('#texto_procesando').removeClass('hide');
			$('#texto_procesando').html('Procesando atención ..');
			
      // $('#pagocuo').attr('disabled','disabled');
      var formData = new FormData();
			
		
			formData.append('task','atender_cliente_insertar_kardex');
      formData.append('nompage',nompage);
      formData.append('nommodule',nommodule);
      formData.append('nomparenttab',nomparenttab);
      formData.append('id_suscrito',id_suscrito);
      formData.append('motivo',motivo);
      formData.append('id_tipo_atencion',id_tipo_atencion);
      formData.append('id_tipo_intera',id_tipo_intera);
      formData.append('descripcion',descripcion);
      formData.append('curso',curso);
      formData.append('precio',precio);
      formData.append('id_nivel',id_nivel);
      formData.append('id_tipo_recordatorio',id_tipo_recordatorio);
      formData.append('fecha_recordatorio',fecha_recordatorio);
      formData.append('hora_recordatorio',hora_recordatorio);
   
      // formData.append('file',files);
			
				// if(accion_tomada == "vamos_liquidar"){

					$.ajax({
						type: 'POST',
						url: nompage+'.php',
						data: formData,
						contentType: false,
						processData: false,
						success: function(datos){
							var resultados = JSON.parse(datos);
							
							if(resultados.res == 1){
								$('#texto_procesando').removeClass('hide');
								$('#texto_procesando').html('Ok. registro guardado ..');
								
								setTimeout(function(){
									$('#exampleModal').modal('hide');
									$('#modi').html(resultados.texto);
									$('#exampleModalCenter2').modal('show');
								},500);
								
							}else{
								$('#texto_procesando').removeClass('hide');
								$('#texto_procesando').html('Ups. algo salio mal ..');
								
								setTimeout(function(){
									$('#btnguardar').removeAttr('disabled');
									swal({
										title: "Error.",
										type: "error",
										showCancelButton: false,
										confirmButtonClass: "btn-error",
										confirmButtonText: "Ok",
										closeOnConfirm: false
									});
								},500);
							}
						}
					});
				
		}else{  // if 
			alert("No existe un id_suscrito asociado; Error linea 93. tomar_cliente...js: => "+id_suscrito);
		}

}


function cerrar_flotante(){
  location.reload();
}
