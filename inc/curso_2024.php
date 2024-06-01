<?php  
$link_destino='cesta-pago-tarjeta-directo/'.$detalles["id_curso"]; //si lleva a link de compra directa 
$imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen'];  /* mostramos la img pequeña */
$alumn = executesql("SELECT * FROM suscritos_x_cursos WHERE estado_idestado = 1 AND id_curso = '".$detalles['id_curso']."'");
$tipo = executesql("SELECT titulo FROM tipo_cursos WHERE id_tipo = '".$detalles['id_tipo']."'" );
?>
<div class="curso-list">
	<a href="<?php echo $link; ?>" >
   		 <figure class="rel ">				
			<img src="<?php echo !empty( $detalles['imagen2'])?$imgproduct:'img/no_imagen.jpg'; ?>" class="principal " alt="<?php echo $detalles['titulo'];?>">
			<!-- 
			<a class="abs mpopup-03 " title="ver más" href="detalle/<?php echo $detalles['tiprewri'].'/'.$detalles['titulo_rewrite'] ; ?>"><img src="img/iconos/ico-play-small.png" alt="ver video" class="verticalalignmiddle"></a>
			-->
		</figure>
	</a>

<?php 

// si tiene dependientes .. capturamos y agrupamos en HTML para el carrito ..
// si tiene dependientes .. capturamos y agrupamos en HTML para el carrito ..
$_data_cursos_dependientes="";
if( !empty($detalles['cursos_dependientes']) ){
	// $sql_dependientes="select c.*, p.titulo as profe from cursos c INNER JOIN profesores p ON c.id_pro=p.id_profesor where c.estado_idestado=1 and c.id_curso IN (".$detalles['cursos_dependientes'].") order by c.titulo asc ";
	$sql_dependientes="select c.* from cursos c  where c.estado_idestado=1 and c.id_curso IN (".$detalles['cursos_dependientes'].") order by c.titulo asc ";

	$dependientes=executesql($sql_dependientes);
	if( !empty($dependientes) ){
		foreach( $dependientes as $anexo ){
			$_data_cursos_dependientes.="<div class='detalle'><figure class='img-cesta rel'><img src='tw7control/files/images/capa/".$anexo["imagen"]."'><div class='capa abs'></div></figure><div class='delete_curso text-center '></div><div class='titulo'><p class='poppi-b color1'>".$anexo["titulo"]."</p></div></div>";
			
		}
	}
}



// si tiene especiales .. capturamos y agrupamos en HTML para el carrito ..
$_data_ides_especialidades="";
$_data_cursos_especiales="";
if( !empty($detalles['cursos_especialidades']) ){
	
	$sql_especiales="select c.* from cursos c 
										INNER JOIN especialidades esp ON c.id_especialidad=esp.id_especialidad 
										WHERE c.estado_idestado=1 and c.id_curso IN (".$detalles['cursos_especialidades'].") and esp.id_especialidad='".$especialidad_del_cliente."' 
										ORDER by c.titulo asc ";
									
	$especiales=executesql($sql_especiales);
	if( !empty($especiales) ){
		$n_esp=0;
		foreach( $especiales as $anexo_especiales ){
			if($n_esp==0){
				$_data_ides_especialidades=$anexo_especiales['id_curso'];
			}else{
				$_data_ides_especialidades=$_data_ides_especialidades.','.$anexo_especiales['id_curso'];
				
			}
			
			$_data_cursos_especiales.="<div class='detalle'><figure class='img-cesta rel'><img src='tw7control/files/images/capa/".$anexo_especiales["imagen"]."'><div class='capa abs'></div></figure><div class='delete_curso text-center '></div><div class='titulo'><p class='poppi-b color1'>".$anexo_especiales["titulo"]."</p></div></div>";	
			$n_esp++;
			
		}
	}
}

?>
    <div class="deta">
		<a href="<?php echo $link; ?>" >
			<figcaption style="background:#A83628; padding: 5px 10px;display: inline-block;margin-bottom: 10px;height:34px;">
				<span class=" poppi  blanco "><?php echo !empty($detalles['etiqueta'])?$detalles['etiqueta'] : ''; ?></span>
			</figcaption>	
			<h2 class="color1 poppi-sb  ">					
					<?php echo short_name($titulo,70); ?>
			</h2>							
		</a>
<?php
$fecha_actual = strtotime(date("d-m-Y"));
$fecha_entrada = strtotime($detalles["fecha_fin_promo"]);


if($fecha_actual < $fecha_entrada  &&  (!empty($detalles["costo_promo"]) && $detalles["costo_promo"]!="0.00") ){
	$precio=$detalles["costo_promo"];
}else{
	$precio=$detalles["precio"];
}
$precio_online=  $precio; // pago tarjeta y pago deposito van a enjar e mismo precio. 
		
		
			if($detalles["tipocurso"]== $_variable_tipo_categoria_gratuita ){ //id de tipo gratuitos
				 echo '<blockquote class="poppi-b  ">Gratuito</blockquote>'; 
				 
			}else{ // si no es gratuito mostramos precio
?>
		<div class="listado_de_precios ">
			<div>
        <blockquote class="poppi-s color2 ">	
			<?php if( !empty($detalles['n_sesiones']) ){ ?>
					<span class="textillo lleva_precio_span   " style="top:3px;">
             			<img src="img/iconos/ico_sesiones_2024.png"> <?php echo $detalles['n_sesiones'];?> Sesiones
					</span>
			<?php }	?>
				</blockquote>
			</div>
			

		<?php if($fecha_actual < $fecha_entrada  && $detalles['costo_promo']>0 ){ ?>
        	<blockquote class="poppi-s   ">
				<span class="lleva_precio_span ">
            		<?php  echo ($detalles['costo_promo']>0) ? '<small class="poppi rojo"> s/ '.$detalles['precio'].'</small>' : 's/ '.$detalles['precio']; ?>
				</span>
			</blockquote>		
		<?php }	/* else precio oferta */ ?>
				
		
				
			</div>
			<!-- end lleva precio s -->
			
<?php } ?>
				
        <div class="lleva_botones_curso">
<?php 
// validamos si ya tiene comprado este curso. 	
if(isset($_SESSION["suscritos"]["id_suscrito"]) and !empty($_SESSION["suscritos"]["id_suscrito"]) ){ 
					$ya_tiene_curso=executesql("select * from suscritos_x_cursos where id_tipo=1 and estado_idestado=1 and id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."' and id_curso='".$detalles["id_curso"]."' and estado!=3 ");
					if(!empty($ya_tiene_curso)){
						//siya tien el curso comprado... 
					 ?>	
					<div class="text-center"><a href="<?php echo $link ?>" class="boton poppi-sb" title="ir al curso ahora">Ir al curso</a></div>
					  
		<?php	}else{ // disponible para la compra .. 
						
						if($detalles["tipocurso"]== $_variable_tipo_categoria_gratuita){ //id de tipo gratuitos 
							 // curso es gratuito 
								echo '<a href="'.$link.'" class="boton poppi-sb btn_grauito" title="suscribete">Suscríbete</a>';
						
						}elseif(  !empty($detalles['cursos_especialidades']) ){
								echo '<a href="'.$link_destino.'" class="boton poppi-sb btn_grauito " title=" pagar ahora "><img src="img/iconos/carrito.png" alt="agregar al carrito"> s/ '.$precio.'</a>';
						 
						}else{ 
					?>
					<a href="<?php echo $link_destino ?>" title="agregar al carrito" class="boton poppi-sb"><img src="img/iconos/carrito.png" title="cesta carrito"> s/ <?php echo $precio; ?> </a>
<!-- 				
				<form id ="ruta-<?php echo $detalles["id_curso"]; ?>" class="add" method="POST" action="process_cart/insert.php" accept-charset="UTF-8">
						<input type="hidden" name="id"  value="<?php echo $detalles["id_curso"]; ?>">
						<input type="hidden" name="id_tipo"  value="<?php echo $detalles["id_tipo"]; ?>">
						<input type="hidden" name="validez_meses"  value="<?php echo $detalles["validez_meses"]; ?>">
						<input type="hidden" name="cursos_dependientes"  value="<?php echo $detalles["cursos_dependientes"]; ?>">
						<input type="hidden" name="cursos_dependientes_data" value="<?php echo $_data_cursos_dependientes; ?>">
						<input type="hidden" name="cursos_especialidades"    value="<?php echo $_data_ides_especialidades; ?>">
						<input type="hidden" name="cursos_especiales_data"  value="<?php echo $_data_cursos_especiales; ?>">
									
						<input type="hidden" name="rewrite"  value="<?php echo $link; ?>">
						<input type="hidden" name="imagen"   value="<?php echo $imgproduct ; ?>">
						<input type="hidden" name="cantidad" value="1">
						<input type="hidden" name="profe"  value="<?php echo $profe[0]['titulo']; ?>" >
						<input type="hidden" name="nombre" value="<?php echo $detalles["titulo"]; ?>" id="nombre">
						<input type="hidden" name="precio" value="<?php echo $precio; ?>" id="precio">
						<input type="hidden" name="precio_online" value="<?php echo $precio_online; ?>" id="precio_online">
						<div class="">
							<button class="osans bold btn botones lleva_ico_cesta  hola"></button>
						</div>
					</form>
					-->
					
<?php 			} // si no es gratuito 
					}
	
 }else{ // publico general  sin login
				
			if($detalles["tipocurso"]== $_variable_tipo_categoria_gratuita  ||  !empty($detalles['cursos_especialidades']) ){ //id de tipo gratuitos 
				if($detalles["tipocurso"]== $_variable_tipo_categoria_gratuita){  //id de tipo gratuitos 
					// curso es gratuito 
					echo '<a href="'.$link.'" class="boton poppi-sb btn_grauito ">Suscríbete</a>';
					
				}elseif(  !empty($detalles['cursos_especialidades']) ){  /* lleva especialidades ..  */
					echo '<a href="'.$link_destino.'" class="boton poppi-sb  " title="agregar al carrito"> <img src="img/iconos/carrito.png" alt="agregar al carrito"> s/ '.$precio.'</a>';
					
				}			 
			}else{ 
					
			?>
					<!-- 
					<a href="<?php echo $link ?>" title="ver mas detalles" class="boton poppi-sb"><img src="img/iconos/carrito.png" alt="carrito"> s/ <?php echo $precio; ?></a>
					-->
					<a href="<?php echo $link_destino ?>" title="ver mas detalles" class="boton poppi-sb"><img src="img/iconos/carrito.png" alt="carrito"> s/ <?php echo $precio; ?></a>
				
					<!-- 
					<form id ="ruta-<?php echo $detalles["id_curso"]; ?>" class="add" method="POST" action="process_cart/insert.php" accept-charset="UTF-8">
						<input type="hidden" name="id"  value="<?php echo $detalles["id_curso"] ?>">
						<input type="hidden" name="id_tipo"  value="<?php echo $detalles["id_tipo"]; ?>">
						<input type="hidden" name="validez_meses"  value="<?php echo $detalles["validez_meses"] ?>">
						<input type="hidden" name="cursos_dependientes"  value="<?php echo $detalles["cursos_dependientes"] ?>">
						<input type="hidden" name="cursos_dependientes_data"  value="<?php echo $_data_cursos_dependientes; ?>">
						<input type="hidden" name="cursos_especialidades"  value="<?php echo $_data_ides_especialidades; ?>">
						<input type="hidden" name="cursos_especiales_data"  value="<?php echo $_data_cursos_especiales; ?>">
						<input type="hidden" name="rewrite"  value="<?php echo $link; ?>">
						<input type="hidden" name="imagen"  value="<?php echo $imgproduct ; ?>">
						<input type="hidden" name="cantidad"  value="1">
						<input type="hidden" name="nombre"  value="<?php echo $detalles["titulo"]; ?>" id="nombre">
						<input type="hidden" name="profe"  value="<?php echo !empty($profe[0]['titulo'])?$profe[0]['titulo']:'Por definir'; ?>" >
						<input type="hidden" name="precio"  value="<?php echo $precio; ?>" id="precio">
						<input type="hidden" name="precio_online" value="<?php echo $precio_online; ?>" id="precio_online">
						<div class="botones_de_accion ">
							<button class="osans bold btn botones   hola"></button>
						</div>
					</form>
					-->
<?php } // end si es gratuito 
 }
 ?>
					
					
        </div>
    </div>
</div>