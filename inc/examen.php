<?php  
//$link_destino='cesta-pago-tarjeta-directo/'.$detalles["id_curso"]; //si lleva a link de compra directa 
$imgproduct= 'tw7control/files/images/examenes/'.$detalles['imagen'];  /* mostramos la img pequeña */
?>
<div class="curso-list">
	<figure class="rel ">				
		<img src="<?php echo !empty( $detalles['imagen'])?$imgproduct:'img/no_imagen.jpg'; ?>" class="principal " alt="<?php echo $detalles['titulo'];?>">
		<!-- <img src="img/examen-generico.jpg" class="principal " >		 -->

	</figure>
    <div class="deta">
		<figcaption style="background:#A83628; padding: 5px 10px;display: inline-block;margin-bottom: 10px;height:34px;">
			<span class=" poppi  blanco "><?php echo !empty($detalles['etiqueta'])?$detalles['etiqueta'] : ''; ?></span>
		</figcaption>	
		<h2 class="color1 poppi-sb  "><?php echo  short_name($titulo,70); ?></h2>	
		<p class="color1 poppi  "><?php echo short_name($detalles['breve_detalle'],120); ?></p>						
<?php
//$fecha_actual = strtotime(date("d-m-Y"));
//$fecha_entrada = strtotime($detalles["fecha_fin_promo"]);

if( (!empty($detalles["costo_promo"]) && $detalles["costo_promo"]!="0.00") ){
	$precio=$detalles["costo_promo"];
}else{
	$precio=$detalles["precio"];
}
$precio_online=  $precio; // pago tarjeta y pago deposito van a enjar e mismo precio. 
				
?>
		<div class="listado_de_precios ">					
		<?php if( $detalles['costo_promo']>0 ){ ?>
        	<blockquote class="poppi-s   ">
				<span class="lleva_precio_span ">
            		<?php  echo ($detalles['costo_promo']>0) ? '<small class="poppi rojo"> s/ '.$detalles['precio'].'</small>' : 's/ '.$detalles['precio']; ?>
				</span>
			</blockquote>		
		<?php }	/* else precio oferta */ ?>
				
		
				
			</div>
			<!-- end lleva precio s -->
			
<?php  // } ?>
				
        <div class="lleva_botones_curso">
<?php 

/*
// validamos si ya tiene comprado este curso. 	
if(isset($_SESSION["suscritos"]["id_suscrito"]) and !empty($_SESSION["suscritos"]["id_suscrito"]) ){ 
$ya_tiene_curso=executesql("select * from suscritos_x_examenes where  estado_idestado=1 and id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."' and id_examen='".$detalles["id_examen"]."'  ");
				if(!empty($ya_tiene_curso)){

					
						//siya tien el curso comprado... 
					 ?>	
					<div class="text-center"><a href="<?php echo $link ?>" class="boton poppi-sb" title="ir al curso ahora">IR A RESOLVER</a></div>
					  
		<?php	
		}else{ // disponible para la compra ..    
			*/
											
		?>
					<form id ="ruta-<?php echo $detalles["id_examen"]; ?>" class="add mostrar_texto_comprar " method="POST" action="process_cart/insert.php" accept-charset="UTF-8">
						<input type="hidden" name="id"  value="<?php echo $detalles["id_examen"] ?>">
						<input type="hidden" name="id_tipo"  value="7777">  <!-- *7777:: examenes -->
						<input type="hidden" name="validez_meses"  value="<?php echo $detalles["id_examen"] ?>">  <!-- *usare esta variable para enviar id_curso, para venta de examen-->
						<!-- 
						<input type="hidden" name="tag"  value="<?php echo $detalles["tag"]; ?>" id="tag">
						-->
						<input type="hidden" name="tag"  value="2100" id="tag">  <!-- tag que indica que compro un certificado -->
						<input type="hidden" name="cursos_dependientes"  value="">
						<input type="hidden" name="cursos_dependientes_data"  value="">
						<input type="hidden" name="cursos_especialidades"  value="">
						<input type="hidden" name="cursos_especiales_data"  value="">
						<input type="hidden" name="rewrite"  value="examenes_disponibles">
						<input type="hidden" name="imagen"  value="<?php echo $imgproduct ; ?>">
						<input type="hidden" name="cantidad"  value="1">
						<input type="hidden" name="profe"  value="" >
						<input type="hidden" name="nombre"  value="<?php echo $detalles["titulo"]; ?>" id="nombre">
						<input type="hidden" name="precio"  value="<?php echo $precio; ?>" id="precio">
						<input type="hidden" name="precio_online"  value="<?php echo $precio; ?>" id="precio_online">
						<div style="">
							<button class="  boton  hola  poppi-sb estoy_detalle_curso compra_directa"><img src="img/iconos/carrito.png" title="cesta carrito"> s/ <?php echo $precio; ?> </button>							
						</div><!-- l **12 prod-->
					</form>
					
<?php 		
/*	
					}
	

 }
 */ 
 ?>
					
					
        </div>
    </div>
</div>