$(document).ready(function(){
	$(".gracias_close").click(function(){
		location.reload();
		// alert("hola");
	});
	
	if($('#ajax-perfil-form').length){
			var frm2 = $('#ajax-perfil-form');
			frm2.customPlugin({
					rules : {
							nombre    : { required:true,minlength:3 },
							ap_pa     : { required:true,minlength:3 },
							ap_ma     : { required:true,minlength:3 },
							email     : { required:true,email:true },
							telefono  : { required:true,maxlength:9,minlength:9 },
							dni       : { required:true,maxlength:8,minlength:8 },
							ciudad    : { required:true,minlength:3 },
							direccion : { required:true,minlength:3 }
					},
					messages    : {
							nombre    : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa al menos 3 caracteres' },
							ap_pa     : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa al menos 3 caracteres' },
							ap_ma     : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa al menos 3 caracteres' },
							email     : { required:'(*) este campo es obligatorio',email:'(*) Ingresa un correo válido' },
							telefono  : { required:'(*) este campo es obligatorio',maxlength:'(*) Ingresa 9 caracteres',minlength:'(*) Ingresa 9 caracteres' },
							dni       : { required:'(*) este campo es obligatorio',maxlength:'(*) Ingresa un DNI válido',minlength:'(*) Ingresa un DNI válido' },
							ciudad    : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa una ciudad válida' },
							direccion : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa una ciudad válida' }
					},
					url         : 'btn_update_data_perfil.php',
					gotourl     : 'perfil/mis-datos',
					val_action  : 'actualizar',
					prex_msg    : 'report'
			}).data('customPlugin').validate();
	}

	/* certificado unitario */
	if($('#btn_solicitar_certificado_unitario').length){
			var frm4 = $('#btn_solicitar_certificado_unitario');
			frm4.customPlugin({
					rules : {
							nombre    : { required:true,minlength:3 },
							ap_pa     : { required:true,minlength:3 },
							ap_ma     : { required:true,minlength:3 },
							email     : { required:true,email:true },
							telefono  : { required:true,maxlength:9,minlength:9 },
							dni       : { required:true,maxlength:8,minlength:8 },
							// ciudad    : { required:true,minlength:3 },
							// direccion : { required:true,minlength:3 },
							// agencia : { required:true,minlength:3 }

							// dpto : { required:true,minlength:3 },
							// prov : { required:true,minlength:3 },
							// dist : { required:true,minlength:3 }
					},
					messages    : {
							nombre    : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa al menos 3 caracteres' },
							ap_pa     : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa al menos 3 caracteres' },
							ap_ma     : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa al menos 3 caracteres' },
							email     : { required:'(*) este campo es obligatorio',email:'(*) Ingresa un correo válido' },
							telefono  : { required:'(*) este campo es obligatorio',maxlength:'(*) Ingresa 9 caracteres',minlength:'(*) Ingresa 9 caracteres' },
							dni       : { required:'(*) este campo es obligatorio',maxlength:'(*) Ingresa un DNI válido',minlength:'(*) Ingresa un DNI válido' },
							// ciudad    : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa una ciudad válida' },
							// direccion : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa una ciudad válida' },
							// agencia : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa una agencia válida' }
							
							// dpto : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa un departamento válido' },
							// prov : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa una provincia válida' },
							// dist : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa un distrito válido' }
					},
					url         : 'btn_solicitar_certificado_unitario.php',
					// gotourl     : 'perfil/certificados',
					gotourl     : 'certificados',
					val_action  : 'registro',
					prex_msg    : 'report',
            		type_save   : 2
			}).data('customPlugin').validate();
	}
/* certificado unitario */
	if($('#btn_solicitar_libro_unitario').length){
			var frm4 = $('#btn_solicitar_libro_unitario');
			frm4.customPlugin({
					rules : {
							nombre    : { required:true,minlength:3 },
							ap_pa     : { required:true,minlength:3 },
							ap_ma     : { required:true,minlength:3 },
							email     : { required:true,email:true },
							telefono  : { required:true,maxlength:9,minlength:9 },
							dni       : { required:true,maxlength:8,minlength:8 },
							ciudad    : { required:true,minlength:3 },
							direccion : { required:true,minlength:3 },
							agencia : { required:true,minlength:3 }
							// dpto : { required:true,minlength:3 },
							// prov : { required:true,minlength:3 },
							// dist : { required:true,minlength:3 }
					},
					messages    : {
							nombre    : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa al menos 3 caracteres' },
							ap_pa     : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa al menos 3 caracteres' },
							ap_ma     : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa al menos 3 caracteres' },
							email     : { required:'(*) este campo es obligatorio',email:'(*) Ingresa un correo válido' },
							telefono  : { required:'(*) este campo es obligatorio',maxlength:'(*) Ingresa 9 caracteres',minlength:'(*) Ingresa 9 caracteres' },
							dni       : { required:'(*) este campo es obligatorio',maxlength:'(*) Ingresa un DNI válido',minlength:'(*) Ingresa un DNI válido' },
							ciudad    : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa una ciudad válida' },
							direccion : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa una ciudad válida' },
							agencia : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa una agencia válida' }
							// dpto : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa un departamento válido' },
							// prov : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa una provincia válida' },
							// dist : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa un distrito válido' }
					},
					url         : 'btn_solicitar_libro_unitario.php',
					// gotourl     : 'perfil/certificados',
					gotourl     : 'mis-libros',
					val_action  : 'registro',
					prex_msg    : 'report',
            		type_save   : 2
			}).data('customPlugin').validate();
	}


/* Solictamos certificados multiples */
	if($('#solicitar_certificado').length){
			var frm41 = $('#solicitar_certificado');
			frm41.customPlugin({
					rules : {
							nombre    : { required:true,minlength:3 },
							ap_pa     : { required:true,minlength:3 },
							ap_ma     : { required:true,minlength:3 },
							email     : { required:true,email:true },
							telefono  : { required:true,maxlength:9,minlength:9 },
							dni       : { required:true,maxlength:8,minlength:8 },
							ciudad    : { required:true,minlength:3 },
							direccion : { required:true,minlength:3 },
							agencia : { required:true,minlength:3 }
							// dpto : { required:true,minlength:3 },
							// prov : { required:true,minlength:3 },
							// dist : { required:true,minlength:3 }
					},
					messages    : {
							nombre    : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa al menos 3 caracteres' },
							ap_pa     : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa al menos 3 caracteres' },
							ap_ma     : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa al menos 3 caracteres' },
							email     : { required:'(*) este campo es obligatorio',email:'(*) Ingresa un correo válido' },
							telefono  : { required:'(*) este campo es obligatorio',maxlength:'(*) Ingresa 9 caracteres',minlength:'(*) Ingresa 9 caracteres' },
							dni       : { required:'(*) este campo es obligatorio',maxlength:'(*) Ingresa un DNI válido',minlength:'(*) Ingresa un DNI válido' },
							ciudad    : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa una ciudad válida' },
							direccion : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa una ciudad válida' },
							agencia : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa una agencia válida' }
							// dpto : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa un departamento válido' },
							// prov : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa una provincia válida' },
							// dist : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa un distrito válido' }
					},
					url         : 'btn_solicitar_certificado.php',
					gotourl     : 'perfil/certificados',
					val_action  : 'registro',
					prex_msg    : 'report',
            		type_save   : 2
			}).data('customPlugin').validate();
	}


	if($('#ajax-actualizaclave-form').length){
			var frm3 = $('#ajax-actualizaclave-form');
			frm3.customPlugin({
					rules : {
							clave    : { required:true,minlength:8 },

					},
					messages    : {
							clave    : { required:'(*) este campo es obligatorio',minlength:'(*) Ingresa mínimo 8 caracteres ..' },

					},
					url         : 'btn_update_data_clave.php',
					gotourl     : 'perfil',
					val_action  : 'actualizarclave',
					prex_msg    : 'report'
			}).data('customPlugin').validate();
	}

}); // en wins load


	/* MARCAR CERTIFICADO COMO ENTREGADO/RECIBIDO */
$(document).on('click','.certificado_marcar_como_recibido',function(){
	var certificado=$('input[name="name_certificado"]').val();
	var ide_sxc=$('input[name="ide_suscrito_x_certificados"]').val();
	var id_solicitud=$('input[name="id_solicitud"]').val();
	
  $.ajax({
    url: 'btn_certificado_entregado.php',
		data: '&action=marcar_entregado&ide_solicitud='+id_solicitud+'&ide_sxc='+ide_sxc+'&certificado='+certificado,
    type: 'POST',
    success: function(datos){
      var jotas = JSON.parse(datos);
			
			console.log(datos);
			console.log(jotas);
			
      if(jotas.res == 1 || jotas.res == '1' ){
        // swal('Bien! Clase completada! ','','success');
				console.log("bien marcada okey  ");
				location.reload();
				
      }else{
				console.log("error marcando como recibido certificado .. perfil.js ");
			}			

    }
  });
}); 
	/* MARCAR CERTIFICADO COMO ENTREGADO/RECIBIDO */
$(document).on('click','.libro_marcar_como_recibido',function(){
	var libro=$('input[name="name_libro"]').val();
	var ide_sxc=$('input[name="ide_suscrito_x_cursos"]').val();
	var id_solicitud=$('input[name="id_solicitud"]').val();
	
  $.ajax({
    url: 'btn_libro_entregado.php',
		data: '&action=marcar_entregado&ide_solicitud='+id_solicitud+'&ide_sxc='+ide_sxc+'&libro='+libro,
    type: 'POST',
    success: function(datos){
      var jotas = JSON.parse(datos);
			
			console.log(datos);
			console.log(jotas);
			
      if(jotas.res == 1 || jotas.res == '1' ){
        // swal('Bien! Clase completada! ','','success');
				console.log("bien marcada okey  ");
				location.reload();
				
      }else{
				console.log("error marcando como recibido certificado .. perfil.js ");
			}			

    }
  });
}); 
function fn_estado_clase(ide_tes){
  $.ajax({
    url: 'perfil.php',
    data: '&task=uestado_clase&id_detalle=' + ide_tes,
    type: 'GET',
    success: function(state){
      state = parseInt(state);
      if(state==1){
        swal('Bien! Clase completada! ','','success')
      }
			setTimeout(function () {
				location.reload();
			}, 1300); //msj desparece en 5seg.

    }
  });
}

