
function precio_total(){
	$.get("process_cart/content_cart.php", function(data){
		var json = JSON.parse(data);
		var html = "";
		if(json.res == "ok"){
      //var totalfinal = parseFloat(json.precio_total) + parseFloat(json.content[datos].envio) ;
			$(".monto_total").html("(s/ "+json.precio_total+")");
			$(".costodeenvio").html("(s/ "+json.precio_envio+")");
			$(".articulos_total").html(json.articulos_total);
		}else{
			$(".monto_total").html("(s/ 0.00)");
			$(".costodeenvio").html("(s/ 0.00)");
			$(".articulos_total").html("0");
		}
	});
}




//función para eliminar una fila
function eliminar(unique_id)
{
	$.post("process_cart/remove_product.php",{unique_id : unique_id}, function(data){
		var json = JSON.parse(data);
		if(json.res == "ok")
		{
			//llamamos a la función content_cart() para actualizar el carrito
      carrito_boton(unique_id);//envio id para quitar le clase del texto.
			content_cart();
			content_data_pedido_compra();
		}else{
			alert("error");
		}
	});
}


// para añadir al carrito ..
function carrito_boton(envioid) {
		let imagen_add_car, texto_quitar_carrito,  entro,texto,ides=[],i,nro ;
		// let imagen_add_car="<a class='btn-carro'><img src='img/iconos/carrito3.png'></a> ";
		
		imagen_add_car="<a class='btn-carro'><img src='img/iconos/carrito3.png'></a> ";
		texto_quitar_carrito="<a class='btn-carro'><img src='img/iconos/cerrar.png'></a>";
		let imagen_add_car_texto_comprar=' <a class="  roboto"><img src="img/iconos/carrito2.png">Comprar</a>';
		let texto_quitar_carrito_texto_quitar="Quitar de carrito";
		let texto_quitar; 
		
    $.get("process_cart/content_cart.php", function(data){
      var json = JSON.parse(data);

      if(json.res == "ok"){
        $(".hola").html(imagen_add_car);//a todos para cuando aya F5 , no pierdan el texto
        $('.mostrar_texto_comprar').find(".hola").html(imagen_add_car_texto_comprar);//a todos para cuando aya F5 , no pierdan el texto
        // si ya esta carro irecto quito la opcion para redireccionar a cesta
					
				for(datos in json.content){
          if(json.content[datos].id == envioid){
						/*captura las id del car en un [] */
						entro=1;
						ides.push(envioid);
					}else{
						/* sino esta en car , anulamos la clase */
						$("#ruta-"+envioid).find('button').removeClass('curso_en_carrito');
						// agrago la clase para boton carrito directo --> detalle curso 
						$("#ruta-"+envioid).find('button.estoy_detalle_curso').addClass('compra_directa');//lo q estan en el carro se cambiana a eloiminar
					}
				}

				// texto = (entro == 1) ? texto_quitar_carrito : "no esta dentro del carro";
				// capturo contenido para mostrar: quitar carrito o imagen de delete
				if(entro == 1){
					texto = 	texto_quitar_carrito ;
					texto_quitar = 	texto_quitar_carrito_texto_quitar ;
				}else{ 
					texto =  "no esta dentro del carro";
				}
				
      }else{
					// Quitamos de carrito, si ya existe este product agregado
					//si esta vacio:empty
					//si car esta vacio, eliminar las clases

					$(".hola").removeClass('curso_en_carrito');
					// $(".hola").text("Añadir a pedido ");
					$(".hola").html(imagen_add_car);
					$('.mostrar_texto_comprar').find(".hola").html(imagen_add_car_texto_comprar);//a todos para cuando aya F5 , no pierdan el texto

      }

      nro = ides.length;
			//lo q estan en el carro se cambiana a eloiminar
			// Los que ya estan dentro del carrito 
      if(nro => 0 ){
        for (i = 0; i <= nro; i++) {
          $(".curso_en_carrito").html(texto);
					$('.mostrar_texto_comprar').find(".curso_en_carrito").html(texto_quitar);//a todos para cuando aya F5 , no pierdan el texto
          $("#ruta-"+ides[i]).find('button').addClass('curso_en_carrito');//lo q estan en el carro se cambiana a eloiminar
					
					// si ya esta carro irecto quito la opcion para redireccionar a cesta
					$("#ruta-"+ides[i]).find('button.estoy_detalle_curso').removeClass('compra_directa');//lo q estan en el carro se cambiana a eloiminar
        }
      }

    });//get

}




function content_cart(){
	$.get("process_cart/content_cart.php", function(data){
		var json = JSON.parse(data);
		var html = "";
		var xy = 0,i = 0,colori="";
		if(json.res == "ok")
		{

			for(datos in json.content){ xy++; //recorro pedidos

				if(i==1){colori="";i=0;}else{colori="style='background:#efefef;'";i++}
				carrito_boton(json.content[datos].id);//envia las id delos q estan dentro del carro
				
				html += "<div class='detalle'><figure class='img-cesta rel'><img src='"+ json.content[datos].imagen +"'><div class='capa abs'></div></figure><div class='delete_curso text-center '><a href='javascript:void(0)' onclick=\"eliminar('" + json.content[datos].unique_id + "')\"><img src='img/iconos/delete_curso.png'></a></div><div class='titulo'><p class='poppi-b color1'>"+ json.content[datos].nombre +"</p><span class='color1 poppi'>"+ json.content[datos].profe +"</span></div></div>";

			}//End for

			var precio_envio = json.precio_envio;
			var precio_subtotal = json.precio_subtotal;
			var totalfinal = json.precio_total.toFixed(2);
			//var totalfinal = parseFloat(json.precio_total) + parseFloat(json.content[datos].envio) ;
			html +='<div class="detalle"><div class="clearfix"></div><div class="pagar"><p class="poppi-sb color4">Total a pagar</p><p class="poppi-b color1 total_a_pagar_texto">s/ '+totalfinal+'</p></div><ol class="no-bullet roboto uni"><li><img src="img/iconos/pago1.png"></li><li><img src="img/iconos/pago2.png"></li><li><img src="img/iconos/pago3.png"></li></ol><blockquote class="poppi texto uni"><img src="img/iconos/candado3.png"> Pago 100% Seguro</blockquote><span class="texto poppi uni">Este sitio cumple con los estándares de seguridad de la industria de medio de pago PCI-DSS para proteger su información personal y la de su tarjeta.</span></div> ';
			html += " </div>"; //2º lg-6

		}else{ //si carrito esta vacio
				$(".titulo_cesta").html("");
				html += "<tbody class='monset'>";
				html += "<tr>";
				html += "<td>El carrito está vacío. </br> <a  href='curso/todos' class=' poppi-b boton boton2' oncontextmenu='return false' onkeydown='return false' style='font-size:18px;margin-top:50px;'>Ver cursos</a> </td>";
				html += "</tr>";
				html += "</tbody>";
		}

		$(".content_cart").html("").append(html);
		precio_total();//Carrito precio total
	});
}







$(document).ready(function(){

			

			// para añadir al carrito ..
			$(".add").on("submit", function(e){
			e.preventDefault();
			console.log("agregado a carrito");

			var el = $(this) , div = el.attr('id').split('-') , envioid =div[1];//split divide separa por (-)
				$.ajax({
					type: $(this).attr("method"),
							url: $(this).attr("action"),
							data: $(this).serialize(),
							beforeSend: function(){ },
							success: function(data){
								var json = JSON.parse(data);
								if(json.res == "ok"){
									
									content_cart();
									carrito_boton(envioid);
									if( $(el).find('.compra_directa').length ){
										// alert("addd");
										console.log("compra - directa detalle curso, rumbo carrito");
										location.href="cesta";
										
									}
									
									// precio_total();//Carrito precio total
								}else{
									alert(json.message);
								}
							},

							error: function(){alert("Error"); }
				})
			});


		
			//función para vaciar el contenido del carrito
			$(document).on("click", ".destroy", function(e){
				e.preventDefault();
				$.post("process_cart/destroy.php", function(){
					//llamamos a la función content_cart() para actualizar el carrito
					content_cart();
					carrito_boton();
					// precio_total();//Carrito precio total
				});
			})
			

			//función para vaciar el contenido del carrito
			$(document).on("click", ".destroy", function(e){
				e.preventDefault();
				$.post("process_cart/destroy.php", function(){
					//llamamos a la función content_cart() para actualizar el carrito
					content_cart();
					carrito_boton();
					// precio_total();//Carrito precio total
				});
			})


			content_cart(); //el abrir la página ya mostramos el contenido del carrito
			carrito_boton(); //Carrito botones
			// precio_total();//Carrito precio total



});
