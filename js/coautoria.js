$(document).ready(function(){


	if($('#solicitar_coautoria').length){
			var frm4 = $('#solicitar_coautoria');
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
					url         : 'btn_solicitar_coautoria.php',
					gotourl     : 'coautoria/todos-los-libros-coautoria',
					val_action  : 'registro',
					prex_msg    : 'report',
            		type_save   : 2
			}).data('customPlugin').validate();
	}


}); // en wins load

