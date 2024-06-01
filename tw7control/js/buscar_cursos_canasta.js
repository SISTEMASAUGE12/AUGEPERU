function autocompletar_canasta() {
	var min_length = 0; // variable length
	var nombre = $('#titulo_curso_canasta').val();//obtener el nombre y/o termino de busqeuda
	if (nombre.length > min_length) {
		$.ajax({
			url: 'proceso_busqueda_curso_canastas.php',
			type: 'POST',
			data: {nombrebusqueda:nombre},
			success:function(data){
				$('#listadobusqueda_curso_canastas').show();//mistrar la lista
				$('#listadobusqueda_curso_canastas').html(data);//mostrar resultado de consulta en la lista
			}
		});
	} else {
		$('#listadobusqueda_curso_canastas').hide();
	}
}


let ides_canasta=[];
let fila_curso_canasta='';


// funcion que setea valores a los input despues de busqueda
function set_item_search_datos_cli_canasta(id,nombre,tipo,codigo){
	let nro;
	let ides_canasta_que_ya_tiene= $('input[name="cursos_canasta"]').val();
	// alert(ides_canasta_que_ya_tiene);
	
	let fila_curso_canasta= document.getElementById("cakes_canasta").innerHTML;


	
	if (ides_canasta.length >0 ) { //si ya tiene cursos ..
			nro = ides_canasta.length;
		
			// VALIDAMOS evitar que se repitan ..
			// validamos que no este repetido el curso ..
			nro = ides_canasta.length;
			// alert(nro);
			sino_suplicado=0; 
			if(nro => 0 ){
				for (i = 0; i < nro; i++) {
					// alert(i+'->'+ides_canasta[i]);
					if(ides_canasta[i] == id){
							// no agregamos duplicado 
							alert("Este curso ya esta asignado como dependiente. ");
					}else{
						sino_suplicado++;
					}
					
				}
			}
			
			// alert(sino_suplicado);
			if(nro == sino_suplicado ){ // sino tiene duplicados .. agregamos el id_curso al aarray[]
				ides_canasta.push(id);
				// alert(ides_canasta);
				$('#cursos_canasta').val(ides_canasta);	// asignamos el nuevo valor del array al input ..
				// fila_curso_canasta=fila_curso_canasta;
				
			fila_curso_canasta+=' <div id="canasta'+id+'" class="col-sm-12" style="margin-bottom:5px;background:#e1e1e1;"><div class="col-sm-3"><input type="text" id=""  name="" disabled class="form-control" value="'+tipo+' "></div><div class="col-sm-7"><input type="text" id="nombre_curso_x"  name="nombre_curso_x" disabled class="form-control" value="'+codigo+' - '+nombre+' "></div> <div class="col-sm-2"><a class="quitar_canasta" href="javascript:quitar_canasta('+id+')">quitar</a></div>  </div>';	
				
				// preguntamos si es que ya existe 
				if( $('#canasta'+id).length ){	
					// si ya existe le quitamos el hide por si lo tuviera.
					$('#canasta'+id).removeClass('hide');
					
				}else{
					$('.resultados_canasta').html(fila_curso_canasta);	// asignamos el nuevo valor del array al input ..
					
				}
				
			}
			
		
	}else{ // cuando esta en editar primera instancia .. aun no tiene array agregados moemntaneaos 
		// si esta vacio asigno los cursos que ya tien el curso
		if(ides_canasta_que_ya_tiene !=''){
			ides_canasta.push(ides_canasta_que_ya_tiene);		
			ides_canasta=ides_canasta_que_ya_tiene.split(',');	// cadena de texto la convertimos a array[]
			
		}
		
		// validamos que no este repetido el curso ..
		nro = ides_canasta.length;
		// alert(nro);
		sino_suplicado=0; 
		if(nro => 0 ){
			for (i = 0; i < nro; i++) {
				// alert(i+'->'+ides_canasta[i]);
				if(ides_canasta[i] == id){
						// no agregamos duplicado 
						alert("Este curso ya esta asignado en esta canasta. ");
				}else{
					sino_suplicado++;
				}
				
			}
		}
		
		// alert(sino_suplicado);
		if(nro == sino_suplicado ){ // sino tiene duplicados .. agregamos el id_curso al aarray[]
			ides_canasta.push(id);
			// alert(ides_canasta);
			$('#cursos_canasta').val(ides_canasta);	// asignamos el nuevo valor del array al input ..
			// fila_curso_canasta= fila_curso_canasta;
			fila_curso_canasta+=' <div id="canasta'+id+'" class="col-sm-12" style="margin-bottom:5px;background:#e1e1e1;"><div class="col-sm-3"><input type="text" id="nombre_curso"  name="nombre_curso" disabled class="form-control" value="'+tipo+' "></div><div class="col-sm-7"><input type="text" id="nombre_curso_x"  name="nombre_curso_x" disabled class="form-control" value="'+codigo+'-'+nombre+' "></div> <div class="col-sm-2"><a class="quitar_canasta" href="javascript:quitar_canasta('+id+')">quitar</a></div>  </div>';	
			// preguntamos si es que ya existe 
			if( $('#canasta'+id).length ){	
				// si ya existe le quitamos el hide por si lo tuviera.
				$('#canasta'+id).removeClass('hide');
				
			}else{
				$('.resultados_canasta').html(fila_curso_canasta);	// asignamos el nuevo valor del array al input ..
				
			}
				
		}
		
	}
	

	// ocultar la lista
	$('#listadobusqueda_curso_canastas').hide();
	
}



function quitar_canasta(id_quitar){
	// setear valor al imput id y nombre	
		let ides_canasta_que_ya_tiene= $('input[name="cursos_canasta"]').val();
	// alert(ides_canasta_que_ya_tiene);
	
	if (ides_canasta.length >0 ) { 
		// alert(ides_canasta.length);
		// eliminamos del array el id del curso a quitar 
			nro = ides_canasta.length;
      if(nro => 0 ){
        for (i = 0; i < nro; i++) {
					// alert(i+'->'+ides_canasta[i]);
					if(ides_canasta[i] == id_quitar){
							// quitamos 
							// alert('encontre'+ides_canasta[i]+'-->'+i);				
							//eliminamos segun posicion ..
							ides_canasta.splice(i, 1)
							// $("#canasta"+id_quitar).addClass('hide');//lo q estan en el carro se cambiana a eloiminar
							$( "div" ).remove("#canasta"+id_quitar); /* lo quito del DOM */
					}
					
        }
      }

		
	}else{ //editando un curso .. *pisiblemente ya tenga curso asignados ..
		// si esta vacio asigno los cursos que ya tien el curso
		if(ides_canasta_que_ya_tiene !=''){
			// asignamos los ides  que vienens desde bd
			ides_canasta=ides_canasta_que_ya_tiene.split(',');	// cadena de texto la convertimos a array[]
			
			// eliminamos del array el id del curso a quitar 
			nro = ides_canasta.length;
      if(nro => 0 ){
        for (i = 0; i < nro; i++) {
					// alert(i+'->'+ides_canasta[i]);
					if(ides_canasta[i] == id_quitar){
							// quitamos 
							// alert('encontre'+ides_canasta[i]+'-->'+i);
							
							//eliminamos segun posicion ..
							ides_canasta.splice(i, 1)
							// $("#canasta"+id_quitar).addClass('hide');//lo q estan en el carro se cambiana a eloiminar
							$( "div" ).remove("#canasta"+id_quitar); /* lo quito del DOM */

					}
					
        }
      }
			
		}else{
			alert("este curso no tiene dependientes..")
		}
	}
		
	// alert(ides_canasta);
	$('#cursos_canasta').val(ides_canasta);		
}