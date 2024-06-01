

$(document).on('click','.suscribirse_al_curso_free',function(){
	// console.log('corriendo fn proceso pedidos');
	var msj_exito;
	var msj_error;
	// alert("hola"); 
	
	$('#rptapago').removeClass('hide');
	$('#rptapago').addClass('pagoespera');
	$('#rptapago').html("Procesando suscripción, espere unos segundos..");
	$('#rptapago').removeClass('pagoexito');
	$('#rptapago').removeClass('pagoerror');



	var id_curso= $('input[name="id"]').val();
	var validez_meses= $('input[name="validez_meses"]').val();
	// var imagen=$('#imagen').val();
	// var files = $('#imagen')[0].files[0];
	var formData = new FormData();

	formData.append('action',"suscripcion_gratuita");
	formData.append('id_curso',id_curso);
	formData.append('validez_meses',validez_meses);
	// formData.append('file',files);

	var str=formData;

	$.ajax({url:'process_cart/insert_bd_gratis.php',data:str,type:'post',contentType: false,processData: false, success:function(datos){
		// console.log(datos);
		var resultados = JSON.parse(datos);
		if(resultados.res == "ok"){
			$('#rptapago').removeClass('pagoerror');
			$('#rptapago').removeClass('pagoespera');
			$('#rptapago').addClass('pagoexito');
			$('#rptapago').html('<meta http-equiv="Refresh" content="3;url=mis-cursos">');
			resultdiv("Genial! Suscrito con éxito. ");

		}else{
			$('#rptapago').removeClass('pagoespera');
			$('#rptapago').removeClass('pagoexito');
			$('#rptapago').addClass('pagoerror');
			resultdiv("Upps #22 error registrando.. ");
			alert('error');
		}

	}});
	
});




function resultdiv(message){
	$('#rptapago').removeClass('hide');
	$('#rptapago').html(message);
}
