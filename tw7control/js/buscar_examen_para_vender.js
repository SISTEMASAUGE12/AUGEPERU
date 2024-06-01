function autocompletar_certificado_venta(tipo_curso) {
	console.log("buscando curso para venta manual .. ");

	var min_length = 0; // variable length
	var nombre = $('#certificado_a_buscar').val();//obtener el nombre y/o termino de busqeuda
	if (nombre.length > min_length) {
		let _url='proceso_busqueda_examen_para_vender.php';
	
		$.ajax({
			url: _url,
			type: 'POST',
			data: {nombrebusqueda:nombre},
			success:function(data){
				$('#listadobusqueda_examenes_a_vender').show();//mistrar la lista
				$('#listadobusqueda_examenes_a_vender').html(data);//mostrar resultado de consulta en la lista
			}
		});
	} else {
		$('#listadobusqueda_examenes_a_vender').hide();
	}
}


let ides_dependientes=[];
let fila_curso='';


// funcion que setea valores a los input despues de busqueda
function seleccionar_add_certificado_venta_manual(id,nombre,tipo){    
	let nro;
	let fila_curso= document.getElementById("cakes").innerHTML;	
	let ides_dependientes_string= $('input[name="array_examenes_a_vender[]"]').val();
	let ides_dependientes = ides_dependientes_string.split(','); 


	// alert(ides_dependientes);
	//alert('-->'+fila_curso);
	
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
							alert("ALERTA. Este examen ya esta asignado al carrito. ");
					}else{
						sino_suplicado++;
						console.log("add, agrego examen  no uplciado.. ");
					}
					
				}
			}
			
			// alert(sino_suplicado);
			if(nro == sino_suplicado ){ // sino tiene duplicados .. agregamos el id_curso al aarray[]
				ides_dependientes.push(id);  // agrego el new ID al grupo array
				// alert(ides_dependientes);
				console.log('#cursos:: '+nro);
				console.log(sino_suplicado);
				console.log(ides_dependientes);

				// $('#array_examenes_a_vender').val(ides_dependientes);	// asignamos el nuevo valor del array al input ..
				$('input[name="array_examenes_a_vender[]"]').val(ides_dependientes);

				// fila_curso=fila_curso;
				fila_curso+=' <div id="depen'+id+'" class="col-sm-12" style="margin-bottom:5px;background:#e1e1e1;"><div class="col-sm-3"><input type="text" id="nombre_curso"  name="nombre_curso" disabled class="form-control" value="'+tipo+' "></div><div class="col-sm-7"><input type="text" id="nombre_curso"  name="nombre_curso" disabled class="form-control" value="'+nombre+' "></div> <div class="col-sm-2"><a class="quitar_depen" href="javascript:quitar_dependiente('+id+')">quitar</a></div>  </div>';	
				
				// preguntamos si es que ya existe 
				if( $('#depen'+id).length ){	
					// si ya existe le quitamos el hide por si lo tuviera.
					$('#depen'+id).removeClass('hide');
					
				}else{
					$('.resultados').html(fila_curso);	// asignamos el nuevo valor del array al input ..
					
				}
				
			}

	// ocultar la lista
	$('#listadobusqueda_examenes_a_vender').hide();
	
}




function quitar_dependiente(id_quitar){
	// setear valor al imput id y nombre	
		let ides_dependientes_que_ya_tiene= $('input[name="array_examenes_a_vender[]"]').val();
	// alert(ides_dependientes_que_ya_tiene);
	// alert(ides_dependientes);
	
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
							// alert(ides_dependientes);
							
							// $("#depen"+id_quitar).addClass('hide');//lo q estan en el carro se cambiana a eloiminar
							// document.getElementById("#depen"+id_quitar).innerHTML='';
							$( "div" ).remove("#depen"+id_quitar);


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
							$( "div" ).remove("#depen"+id_quitar); /* lo quito del DOM */

							alert(ides_dependientes);
							
					}
					
        }
      }
			
		}else{
			alert("este curso no tiene dependientes..")
		}
	}
		
	// alert(ides_dependientes);
	$('#array_examenes_a_vender').val(ides_dependientes);		
}