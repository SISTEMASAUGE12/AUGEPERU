$(document).on('click','#siguiente1',function(){
    var nombre  =   $('input[name="nombre"]').val();
    var ape1    =   $('input[name="ap_pa"]').val();
    var ape2    =   $('input[name="ap_ma"]').val();
    var dni     =   $('input[name="dni"]').val();

    if((nombre.length >= 3) && (ape1.length >= 3) && (ape2.length >= 3) && (dni.length == 8)){
        $("#cuerpo1").css("display", "none");
        $("#cuerpo2").css("display", "block");
    }else{
        if(nombre.length < 3) $('input[name="nombre"]').addClass('error');
        else $('input[name="nombre"]').removeClass('error');
        if(ape1.length < 3) $('input[name="ap_pa"]').addClass('error');
        else $('input[name="ap_pa"]').removeClass('error');
        if(ape2.length < 3) $('input[name="ap_ma"]').addClass('error');
        else $('input[name="ap_ma"]').removeClass('error');
        if(dni.length != 8) $('input[name="dni"]').addClass('error');
        else $('input[name="dni"]').removeClass('error');
    }
});
$(document).on('click','#siguiente2',function(){
    var celu    =   $('input[name="telefono"]').val();
    var email   =   $('input[name="email"]').val();

    if((celu.length == 9) && (email.indexOf('@', 0) != -1 || email.indexOf('.', 0) != -1)){
        $("#cuerpo2").css("display", "none");
        $("#cuerpo3").css("display", "block");
    }else{
        if(celu.length != 9) $('input[name="telefono"]').addClass('error');
        else $('input[name="telefono"]').removeClass('error');
        if(email.indexOf('@', 0) == -1 || email.indexOf('.', 0) == -1) $('input[name="email"]').addClass('error');
        else $('input[name="email"]').removeClass('error');
    }
});
$(document).on('click','#siguiente3',function(){
    var espe    =   $('select[name="id_especialidad"]').val();
    var esca    =   $('select[name="id_escala_mag"]').val();

    if((espe.length != '') && (esca.length != '')){
        $("#cuerpo3").css("display", "none");
        $("#cuerpo4").css("display", "block");
    }else{
        if(espe.length == '') $('select[name="id_especialidad"]').addClass('error');
        else $('select[name="id_especialidad"]').removeClass('error');
        if(esca.length == '') $('select[name="id_escala_mag"]').addClass('error');
        else $('select[name="id_escala_mag"]').removeClass('error');
    }
});



$(document).ready(function(){
	// registramos total
	$("#finalizar").click(function(){
		var id_pais    =   $('select[name="id_pais"]').val();

		if((id_pais.length != '')){
			$('select[name="id_pais"]').removeClass('error');

			//enviamos data completar registro de alumno
			var nombre=$('input[name="nombre"]').val();
			var ap_pa=$('input[name="ap_pa"]').val();
			var ap_ma=$('input[name="ap_ma"]').val();
			var telefono=$('input[name="telefono"]').val();
			var dni=$('input[name="dni"]').val();

			var email=$('input[name="email"]').val();
			var id_especialidad=$('select[name="id_especialidad"]').val();
			var id_escala_mag=$('select[name="id_escala_mag"]').val();
			var ciudad=$('input[name="ciudad"]').val();
			var direccion=$('input[name="direccion"]').val();
			// var nam7="";

			let cadena= "action=registro"+"&id_pais="+id_pais+"&nombre="+nombre+"&ap_pa="+ap_pa+"&ap_ma="+ap_ma+"&telefono="+telefono+"&dni="+dni+"&email="+email+"&id_especialidad="+id_especialidad+"&id_escala_mag="+id_escala_mag+"&ciudad="+ciudad+"&direccion="+direccion;

			$.ajax({url:'process_cart/registro_completo_suscrito.php',data:cadena,type:'post',success:function(datos){
				var jotas = JSON.parse(datos);

				$('#rptapago').removeClass('hide');
				console.log('reg completo --> '+jotas.rpta);

				if(jotas.rpta=="ok"){
					// redireccionamos a inicio. o al perfil suscrito
					setTimeout(function () {

						document.getElementById("finalizar").disabled=true;
						$('#rptapago').removeClass('pagoespera');
						$('#rptapago').addClass('pagoexito');
						$('#rptapago').text('Registrado correctamente ..');
						setTimeout(function () {
							$("#rptapago").addClass("hide");
							location.href='perfil';
						}, 3000); //msj desparece en 5seg.
					}, 4000); //msj desparece en 5seg.

				}else{
					document.getElementById("finalizar").disabled=false;
					// si existe algun error
					$('#rptapago').removeClass('pagoespera');
					$('#rptapago').removeClass('pagoexito');
					$('#rptapago').addClass('pagoerror');
					$('#rptapago').text('Lo sentimos se perdio la conexion con el servidor error#22 ');

				}

			}});


		}else{
				$('select[name="id_pais"]').addClass('error');
		}
	});

});

