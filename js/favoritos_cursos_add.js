$(document).ready(function(){
	
		
	function load_likes(){
		var ides_productos=[],i,nro;
		$(".megusta").find("span").addClass('f-1');
		$.get("process_cart/load_likes.php", function(data){
			var json = JSON.parse(data);
			if(json.rpta == "isset"){
			//destino
				ides_productos=json.content_product;/*captura las id */
				nro = ides_productos.length;//nro= nro_destinos_pintados
				if(nro => 0 ){//lo q estan se pintan
					for (i = 0; i <= nro; i++) {//recorro las id´s
						$("#producto_"+ides_productos[i]).find('span').removeClass('f-1');
						$("#producto_"+ides_productos[i]).find('span').addClass('f-2');
					}
				}       
		//nro de favoritos productos y pedidos x suscrito
				$(".carga_favoritos").find(".nro_product").find("span").html(json.nro_product);
				$(".carga_favoritos").find(".nro_pedidos").find("span").html(json.nro_pedidos);      
				//end
			}else{//si no hay sesion
				$(".megusta").find("span").removeClass('f-2');
				$(".megusta").find("span").addClass('f-1');
				$(".carga_favoritos").find("span").html('0');//nro de favor x suscrito
			}
		});//get 
	}


	//Favoritos/Like Producto
	$('.fav-des').addClass('hide');
	$(document).on("click", ".favori-destino", function(e){
		e.preventDefault();
		var el = $(this);
		var str='', div = el.attr('id').split('_');//split divide separa por (-)
		if(div[0]=="producto"){
			str= '&id_producto='+div[1];//envio id al process ..
		}else{
			//añadir el new
		}
		
		if(el.find(".f-2").length){
			str=str+"&pintado=yes";
		}
		//show msj add
		el.find('.fav-des').removeClass('hide');
		setTimeout(function(){ el.find('.fav-des').addClass('hide'); },2000);//msj desparece en 5seg.  
		//++like
		$.ajax({url:'process_cart/insert_like_favoritos.php',data:str,type:'post',success:function(data){
			var json = JSON.parse(data);
			el.find('.megusta').find('p').text(json.rpta);
			el.find('.fav-des').find('p').text(json.msj);
			//cambio icono  
			el.find('.megusta').find('span').removeClass(json.quitar);  
			el.find('.megusta').find('span').addClass(json.add); 
			//nro de favoritos x suscrito
			$(".carga_favoritos").find(".nro_product").find("span").html(json.nro_product);
			$(".carga_favoritos").find(".nro_pedidos").find("span").html(json.nro_pedidos);
		}});     
	});

	load_likes();
 
});

