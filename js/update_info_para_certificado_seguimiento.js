$(document).ready(function(){
	
  if($('#update_info_seguimiento').length){
        var frm2_certi = $('#update_info_seguimiento');
        frm2_certi.customPlugin({
            rules : {              
                dni   : { required:true},
                api_nombre_editado   : { required:true},
                api_paterno_editado   : { required:true},
                api_materno_editado   : { required:true},
                iddpto   : { required:true},
                idprvc   : { required:true},
                iddist   : { required:true},
                direccion   : { required:true}, 
                agencia   : { required:true}
            },
            prex_msg    : 'registro',
            val_action  : 'actualizar',
						gotourl   : 'https://www.educaauge.com/',
						url: 'process_cart/update_info_seguimiento.php'
        }).data('customPlugin').validate();
    }
	
}); // en wins load		