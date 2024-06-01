
	// function culqi() {
			// if (Culqi.order) { 
				 // console.log("Order confirmada");
				 // console.log(Culqi.order); 
				 
				 // alert('Se ha elegido el metodo de pago en efectivo:' + Culqi.order.id); 
				 // alert(' Codigo de pago en efectivo:' + Culqi.order.payment_code); 
				 // alert(' Codigo de pago en expeira:' + Culqi.order.expiration_date); 
				 
				 // $('#btn_pedido').removeClass('btn-pedidoencurso');
					// document.getElementById("btn_pedido").disabled=false;
					// procesando_pago_efectivo(Culqi.order.payment_code); ////llamo funcion
					
					// $('#rptapago').removeClass('hide');
					// $('#rptapago').removeClass('pagoerror');
					// $('#rptapago').removeClass('pagoexito');
					// $('#rptapago').addClass('pagoespera');
					// document.getElementById("btn_pedido").disabled=true;
					// $('#rptapago').addClass('btn-pedidoencurso');
				 
				 

			// }else if (Culqi.closeEvent){
				// console.log(Culqi.closeEvent); 
			// }else {
				// console.log(Culqi.error.merchant_message);
			// }
// };




function procesando_pago_efectivo(cod_orden,cod_pago,expira){
	// console.log('corriendo fn proceso pedidos');
	var resultado_pago;
	var msj_exito;
	var msj_error;

	$('#rptapago').addClass('pagoespera');
	$('#rptapago').html("Procesando pedido, espere unos segundos..");
	$('#rptapago').removeClass('pagoexito');
	$('#rptapago').removeClass('pagoerror');


	var direccion=$('input[name="name_direc"]').val();
	// var direccion='Chiclayo, Lambayeque Peru';
	// var banco_pago=$('select[name="banco_pago"]').val();
	// var fecha_pago_off=$('input[name="fecha_pago_off"]').val();
	// var codigo_ope_off=$('input[name="codigo_ope_off"]').val();
	// var imagen=$('#imagen').val();
	// var files = $('#imagen')[0].files[0];
	
	var codreferencia=cod_pago; /* numero de orden generado por pago efectivo */
	var codigo_ope_off=cod_orden; /* numero de orden para los webhooks */
	var total= $('input[name="total_pago_efectivo"]').val();  /* aca procesa el pago normal; sin beneficio del pago online */
	var formData = new FormData();

	formData.append('action',"registro");
	formData.append('direccion',direccion);
	// formData.append('banco_pago',banco_pago);
	// formData.append('fecha_pago_off',fecha_pago_off);
	
	formData.append('tipo_pago',3); /* 3: tipo pago efectivo */
	formData.append('codreferencia',codreferencia);
	formData.append('codigo_ope_off',codigo_ope_off);
	formData.append('total',total);
	// formData.append('file',files);

	var str=formData;

	$.ajax({url:'process_cart/insert_bd.php',data:str,type:'post',contentType: false,processData: false, success:function(datos){
		// console.log(datos);
		var resultados = JSON.parse(datos);
		if(resultados.res == "ok"){
			$('#rptapago').removeClass('pagoerror');
			$('#rptapago').removeClass('pagoespera');
			$('#rptapago').addClass('pagoexito');
			$('#rptapago').html('<meta http-equiv="Refresh" content="3;url=codigo_pago_efectivo?task='+cod_pago+'&amount='+total+'&expi='+expira+'">');
			resultdiv("Genial! Coódigo de pago generado con éxito. ");
			
			// $('.cargando_pago').addClass('hide'); /* capa de cargando */

		
		}else{
			$('.cargando_pago').addClass('hide'); /* capa de cargando */
			
			$('#rptapago').removeClass('pagoespera');
			$('#rptapago').removeClass('pagoexito');
			$('#rptapago').addClass('pagoerror');
			resultdiv("Upps #22 error registrando.. ",'error');
			document.getElementById("btn_pedido").disabled=false;
			console.log("re habilito boton principal ");
			
			setTimeout(function () {
				$('#rptapago').addClass('hide');
			}, 9000); //msj desparece en 5seg.
			
		}

	}});

};


