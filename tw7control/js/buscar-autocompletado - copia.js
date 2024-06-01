function autocompletar() {
	var min_length = 0; // variable length
	var nombre = $('#dni').val();//obtener el nombre y/o termino de busqeuda
	if (nombre.length > min_length) {
		$.ajax({
			url: 'proceso_busqueda_alumno.php',
			type: 'POST',
			data: {nombrebusqueda:nombre},
			success:function(data){
				$('#listadobusqueda_cliente').show();//mistrar la lista
				$('#listadobusqueda_cliente').html(data);//mostrar resultado de consulta en la lista
			}
		});
	} else {
		$('#listadobusqueda_cliente').hide();
	}
}

// funcion que setea valores a los input despues de busqueda
function set_item_search_datos_cli(id,nombre,email,telefono,estado){
	// setear valor al imput id y nombre
	$('#id_suscrito').val(id);
	$('#nombre').val(nombre);
	$('#email').val(email);	
	$('#telefono').val(telefono);
		if(estado===1){estado="Habilitado"}else{estado="Deshabilitado"}
	$('#estado').val(estado);
	

	// ocultar la lista
	$('#listadobusqueda_cliente').hide();
}

