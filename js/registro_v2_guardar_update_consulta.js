$(document).ready(function(){
	
  if($('#ingresa_tus_datos').length){
        var frm2 = $('#ingresa_tus_datos');
        frm2.customPlugin({
            rules : {
                dni    		: { 	required:true,
																minlength:8, 
																remote:{ url:'index.php?task=valida_dni_suscrito', type:'post', data:{envio_dni_usuario:function(){ return $('#dni').val();}} }
														},
                // email    	: { required:true,
														//	email:true,
													//		remote:{ url:'index.php?task=valida_email_suscrito', type:'post', data:{envio_usuario:function(){ return $('#email').val();}} }
													//	},
                nombre    : { required:true,minlength:2 },
                ap_pa    : { required:true,minlength:2 },
                ap_ma    : { required:true,minlength:2 },
                telefono      : { required:true,maxlength:15,minlength:9 },
                id_especialidad   : { required:true},
                clave   : { required:true,minlength:8 },
                clave2   : { required:true,minlength:8,equalTo:'#clave' }
            },
            messages    : {
                dni       : {minlength:'Ingresa al menos 8 dígitos',remote:'Ya existe un registro con este Dni'},
              //  email    : {remote:'Este correo, ya se encuentra registrado en nuestra Base de datos.'},
                clave2    : {equalTo:'las contrase&ntilde;as no coinciden'}
            },
            prex_msg    : 'registro',
            val_action  : 'actualizar',
						gotourl   : 'mis-cursos',
						url: 'process_cart/registro_v2_a_consultar_datos.php'
        }).data('customPlugin').validate();
    }
	
}); // en wins load		