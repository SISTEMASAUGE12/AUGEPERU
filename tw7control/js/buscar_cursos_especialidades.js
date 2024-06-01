function autocompletar() {
	var min_length = 0; // variable length
	var nombre = $('#titulo_curso').val();//obtener el nombre y/o termino de busqeuda
	if (nombre.length > min_length) {
		$.ajax({
			url: 'proceso_busqueda_curso_especialidades.php',
			type: 'POST',
			data: {nombrebusqueda:nombre},
			success:function(data){
				$('#listadobusqueda_curso_especialidades').show();//mistrar la lista
				$('#listadobusqueda_curso_especialidades').html(data);//mostrar resultado de consulta en la lista
			}
		});
	} else {
		$('#listadobusqueda_curso_especialidades').hide();
	}
}


let ides_dependientes=[];
let fila_curso='';


// funcion que setea valores a los input despues de busqueda
function set_item_search_datos_cli(id,nombre,tipo){
	let nro;
	let ides_dependientes_que_ya_tiene= $('input[name="cursos_dependientes"]').val();
	// alert(ides_dependientes_que_ya_tiene);
	

	
	if (ides_dependientes.length >0 ) { //si ya tiene cursos ..
			nro = ides_dependientes.length;
		
			// VALIDAMOS evitar que se repitan ..
			// validamos que no este repetido el curso ..
			nro = ides_dependientes.length;
			// alert(nro);
			sino_suplicado=0; 
			if(nro => 0 ){
				for (i = 0; i < nro; i++) {
					// alert(i+'->'+ides_dependientes[i]);
					if(ides_dependientes[i] == id){
							// no agregamos duplicado 
							alert("Este curso ya esta asignado como dependiente. ");
					}else{
						sino_suplicado++;
					}
					
				}
			}
			
			// alert(sino_suplicado);
			if(nro == sino_suplicado ){ // sino tiene duplicados .. agregamos el id_curso al aarray[]
				ides_dependientes.push(id);
				// alert(ides_dependientes);
				$('#cursos_dependientes').val(ides_dependientes);	// asignamos el nuevo valor del array al input ..
				fila_curso=fila_curso;
				fila_curso+=' <div id="depen'+id+'" class="col-sm-12" style="margin-bottom:5px;background:#e1e1e1;"><div class="col-sm-3"><input type="text" id="nombre_curso"  name="nombre_curso" disabled class="form-control" value="'+tipo+' "></div><div class="col-sm-7"><input type="text" id="nombre_curso"  name="nombre_curso" disabled class="form-control" value="'+nombre+' "></div> <div class="col-sm-2"><a class="quitar_depen" href="javascript:quitar_dependiente('+id+')">quitar</a></div>  </div>';	
				
				// preguntamos si es que ya existe 
				if( $('#depen'+id).length ){	
					// si ya existe le quitamos el hide por si lo tuviera.
					$('#depen'+id).removeClass('hide');
					
				}else{
					$('.resultados').html(fila_curso);	// asignamos el nuevo valor del array al input ..
					
				}
				
			}
			
		
	}else{ // cuando esta en editar primera instancia .. aun no tiene array agregados moemntaneaos 
		// si esta vacio asigno los cursos que ya tien el curso
		if(ides_dependientes_que_ya_tiene !=''){
			ides_dependientes.push(ides_dependientes_que_ya_tiene);		
			ides_dependientes=ides_dependientes_que_ya_tiene.split(',');	// cadena de texto la convertimos a array[]
			
		}
		
		// validamos que no este repetido el curso ..
		nro = ides_dependientes.length;
		// alert(nro);
		sino_suplicado=0; 
		if(nro => 0 ){
			for (i = 0; i < nro; i++) {
				// alert(i+'->'+ides_dependientes[i]);
				if(ides_dependientes[i] == id){
						// no agregamos duplicado 
						alert("Este curso ya esta asignado como dependiente. ");
				}else{
					sino_suplicado++;
				}
				
			}
		}
		
		// alert(sino_suplicado);
		if(nro == sino_suplicado ){ // sino tiene duplicados .. agregamos el id_curso al aarray[]
			ides_dependientes.push(id);
			// alert(ides_dependientes);
			$('#cursos_dependientes').val(ides_dependientes);	// asignamos el nuevo valor del array al input ..
			fila_curso=fila_curso;
			fila_curso+=' <div id="depen'+id+'" class="col-sm-12" style="margin-bottom:5px;background:#e1e1e1;"><div class="col-sm-3"><input type="text" id="nombre_curso"  name="nombre_curso" disabled class="form-control" value="'+tipo+' "></div><div class="col-sm-7"><input type="text" id="nombre_curso"  name="nombre_curso" disabled class="form-control" value="'+nombre+' "></div> <div class="col-sm-2"><a class="quitar_depen" href="javascript:quitar_dependiente('+id+')">quitar</a></div>  </div>';	
			// preguntamos si es que ya existe 
			if( $('#depen'+id).length ){	
				// si ya existe le quitamos el hide por si lo tuviera.
				$('#depen'+id).removeClass('hide');
				
			}else{
				$('.resultados').html(fila_curso);	// asignamos el nuevo valor del array al input ..
				
			}
				
		}
		
	}
	

	// ocultar la lista
	$('#listadobusqueda_curso_especialidades').hide();
	
}



function quitar_dependiente(id_quitar){
	// setear valor al imput id y nombre	
		let ides_dependientes_que_ya_tiene= $('input[name="cursos_dependientes"]').val();
	// alert(ides_dependientes_que_ya_tiene);
	
	if (ides_dependientes.length >0 ) { 
		// alert(ides_dependientes.length);
		// eliminamos del array el id del curso a quitar 
			nro = ides_dependientes.length;
      if(nro => 0 ){
        for (i = 0; i < nro; i++) {
					// alert(i+'->'+ides_dependientes[i]);
					if(ides_dependientes[i] == id_quitar){
							// quitamos 
							// alert('encontre'+ides_dependientes[i]+'-->'+i);				
							//eliminamos segun posicion ..
							ides_dependientes.splice(i, 1)
							$("#depen"+id_quitar).addClass('hide');//lo q estan en el carro se cambiana a eloiminar
					}
					
        }
      }

		
	}else{ //editando un curso .. *pisiblemente ya tenga curso asignados ..
		// si esta vacio asigno los cursos que ya tien el curso
		if(ides_dependientes_que_ya_tiene !=''){
			// asignamos los ides  que vienens desde bd
			ides_dependientes=ides_dependientes_que_ya_tiene.split(',');	// cadena de texto la convertimos a array[]
			
			// eliminamos del array el id del curso a quitar 
			nro = ides_dependientes.length;
      if(nro => 0 ){
        for (i = 0; i < nro; i++) {
					// alert(i+'->'+ides_dependientes[i]);
					if(ides_dependientes[i] == id_quitar){
							// quitamos 
							// alert('encontre'+ides_dependientes[i]+'-->'+i);
							
							//eliminamos segun posicion ..
							ides_dependientes.splice(i, 1)
							$("#depen"+id_quitar).addClass('hide');//lo q estan en el carro se cambiana a eloiminar
					}
					
        }
      }
			
		}else{
			alert("este curso no tiene dependientes..")
		}
	}
		
	// alert(ides_dependientes);
	$('#cursos_dependientes').val(ides_dependientes);		
}