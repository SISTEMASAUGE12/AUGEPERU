<?php 
/* imagen a mostrar :: ahora mini: imagen */
$imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen'];  /* mostramos la img pequeña */
// $imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen2'];  /* mostramos la img grande */


$alumn = executesql("SELECT * FROM suscritos_x_cursos WHERE estado_idestado = 1 AND id_curso = '".$detalles['id_curso']."'");
$tipo = executesql("SELECT titulo FROM tipo_cursos WHERE id_tipo = '".$detalles['id_tipo']."'" );
$profe = executesql("SELECT titulo,titulo_rewrite,imagen FROM profesores WHERE id_profesor = '".$detalles['id_pro']."'"); 
?>
<div class="curso-list">

    <figure class="rel ">
			<figcaption style="background:#000; <?php /* echo !empty($detalles['etiqueta_fondo'])?'background:'.$detalles['etiqueta_fondo'] : ''; */ ?>">
				<span class=" poppi-sb ">
					<?php echo !empty($detalles['etiqueta'])?$detalles['etiqueta'] : ''; ?>
				</span>
			</figcaption>
			<!-- 
			<img src="<?php echo !empty( $detalles['imagen'])?$imgproduct:'img/no_imagen.jpg'; ?>" class="principal ">
			-->
			<img src="<?php echo !empty( $detalles['imagen2'])?$imgproduct:'img/no_imagen.jpg'; ?>" class="principal " alt="<?php echo $detalles['titulo'];?>">
			<a class="abs mpopup-03 " title="ver más" href="detalle/<?php echo $detalles['tiprewri'].'/'.$detalles['titulo_rewrite'] ; ?>"><img src="img/iconos/ico-play-small.png" alt="ver video" class="verticalalignmiddle"></a>
	<?php if(!empty( $detalles['link_video'])){  /* video trailer */ ?>
	<?php }  ?>
		</figure>
<!-- 
<div class="rel lleva_vimeo_listado">
		<iframe src="<?php echo $detalles['link_video']; ?>"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
</div>
		-->


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
		<!-- 
        <span class="color4 bold  poppi-sb"><?php /* echo strtoupper(short_name($tipo[0]['titulo'],92)) */ ?></span>
				-->
        <h2 class="color1 poppi">
					<small><?php echo $detalles['codigo']; ?></small>
				<?php if($detalles["tipocurso"]==1 ){ /* solo paar tipo: crsos mostrar este campo */?>
					<small class="modalidad  <?php echo ($detalles['modalidad']==1)?' ':' pulse '; ?>"><?php echo ($detalles['modalidad']==1)?'GRABADO':' EN VIVO'; ?></small>
				<?php } ?> 
					</br> 
					<a href="<?php echo $link; ?>" >
						<?php echo short_name($titulo,110); ?>
					</a>
				</h2>
				
				<!-- 
        <p class="texto poppi-l breve_detalle "><?php echo short_name($detalles['breve_detalle'],90) ?></p> 
				-->
				
				<?php if( !empty($profe)){  ?>
				<ol class="no-bullet poppi-l">
            <li class="texto"><img alt="# clientes" src="img/iconos/users.png"> <?php echo count($alumn) ?></li>
            <li class="texto   li_docente_dicta ">
							<a  title="conoce al docente" class="color1 " href="docente/<?php echo $profe[0]['titulo_rewrite']; ?>">
								<img class="rb50" alt="docente" src="img/iconos/ico-profe.png"> <?php echo short_name($profe[0]['titulo'],20) ?>
							</a>
						</li>
        </ol>
				<?php } ?>
        <!--
				-->
<?php
$fecha_actual = strtotime(date("d-m-Y"));
$fecha_entrada = strtotime($detalles["fecha_fin_promo"]);


if($fecha_actual < $fecha_entrada  &&  (!empty($detalles["costo_promo"]) && $detalles["costo_promo"]!="0.00") ){
	$precio=$detalles["costo_promo"];
}else{
	$precio=$detalles["precio"];
}

// $precio_online= ($detalles['precio_online']>0) ? $detalles['precio_online']: $precio; // precio exclusico por pago online 
$precio_online=  $precio; // pago tarjeta y pago deposito van a enjar e mismo precio. 
		
		
			if($detalles["tipocurso"]== $_variable_tipo_categoria_gratuita ){ //id de tipo gratuitos
				 echo '<blockquote class="poppi-b color2">Gratuito</blockquote>'; 
				 
			}else{ // si no es gratuito mostramos precio
?>
		<div class="listado_de_precios ">
			<div>
        <blockquote class="poppi-s color2 ">
			<?php if( !empty($detalles['fecha_de_inicio_texto']) ){ ?>
					<span class="textillo color2 " style=" font-size: 14px;line-height: 20px; ">Inicio: <?php echo $detalles['fecha_de_inicio_texto']; ?></span>
			<?php }	?>
			<?php if( !empty($detalles['n_sesiones']) ){ ?>
					<span class="textillo lleva_precio_span color2 " style="top:3px;     font-size: 14px;line-height: 20px; ">
            Sesiones: <?php echo $detalles['n_sesiones'];?>
					</span>
			<?php }	?>
				</blockquote>
			</div>
			
			<?php if($fecha_actual < $fecha_entrada  && $detalles['costo_promo']>0 ){ ?>
        <blockquote class="poppi-s color1 ">
					<span class="textillo ">Antes</span>
					<span class="lleva_precio_span ">
            <?php  echo ($detalles['costo_promo']>0) ? '<small class="poppi rojo"> s/ '.$detalles['precio'].'</small>' : 's/ '.$detalles['precio']; ?>
					</span>
				</blockquote>
			 <?php	/* fecha limite de la oferta */  ?>
						<span style="list-style:none;" class="color2 cronometro " style="font-size: 12px;"><div class="img"><img class="" src="img/iconos/reloj.png" alt="oferta vence en"></div>Oferta hasta <?php echo $detalles["fecha_fin_promo"]; ?> <div id="countdown_<?php echo $detalles["id_curso"] ?>" style="display:inline-block;padding-left:10px;"></div></span>
						<script>
						var end = new Date('<?php echo $detalles["fecha_fin_promo"] ?> 11:59 PM');

						var _second = 1000;
						var _minute = _second * 60;
						var _hour = _minute * 60;
						var _day = _hour * 24;
						var timer;

						function showRemaining() {
								var now = new Date();
								var distance = end - now;
								if(distance < 0){
										clearInterval(timer);
										document.getElementById('countdown_<?php echo $detalles["id_curso"] ?>').innerHTML = 'Promocíón a expirado!';
										return;
								}
								var days = Math.floor(distance / _day);
								var hours = Math.floor((distance % _day) / _hour);
								var minutes = Math.floor((distance % _hour) / _minute);
								var seconds = Math.floor((distance % _minute) / _second);

								let namedias=" xxx ";
								if(days === 1){ // si termina en 1 día basta con mostrar solo las horas pendientes.
									 namedias="  ";
								}else{ // si es mayor a 1 día
									 namedias= days+" días ";
								}
								// document.getElementById('countdown').innerHTML = namedias;
								document.getElementById('countdown_<?php echo $detalles["id_curso"] ?>').innerHTML = hours + 'h :';
								document.getElementById('countdown_<?php echo $detalles["id_curso"] ?>').innerHTML += minutes + 'm :';
								document.getElementById('countdown_<?php echo $detalles["id_curso"] ?>').innerHTML += seconds + '';
						}

						timer = setInterval(showRemaining, 1000);
						</script>								
				
			<?php }	/* else precio oferta */ ?>
				
				<!--  *Precio Pasa ahora a mostrase en el boton comprar :
				<blockquote class="poppi-sb color1 ">
					<span class="textillo ">Ahora</span>
					<span class="lleva_precio_span ">
						<?php 
                    // echo 'S/ '.$precio;
                
						?>
					</span>
				</blockquote>
        --> 
				
				
				<!-- * precio exclusivo Online: no usar por ahora -->
				<?php if($detalles['precio_online']>0 ){ ?>
				<!--
				<blockquote class="poppi-b color2 lleva_online ">
					<span class="textillo _online">Tarjeta</span> 
					<span class="lleva_precio_span ">
						s/ <?php echo $detalles['precio_online']; ?>
					</span>
				</blockquote>
				-->
				<?php } 	?>
				
			</div>
			<!-- end lleva precio s -->
			
<?php } ?>
				
        <div class="lleva_botones_curso "  style="     margin-top: 30px;">
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
								echo '<a href="'.$link.'" class="boton poppi-sb btn_grauito " title="suscibete"><img src="img/iconos/carrito.png" alt="agregar al carrito"> s/ '.$precio.'</a>';
						 
						}else{ 
					?>
					<a href="<?php echo $link ?>" title="agregar al carrito" class="boton poppi-sb"><img src="img/iconos/carrito.png" title="cesta carrito"> s/ <?php echo $precio; ?> </a>
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
					echo '<a href="'.$link.'" class="boton poppi-sb  " title="agregar al carrito"> <img src="img/iconos/carrito.png" alt="agregar al carrito"> s/ '.$precio.'</a>';
					
				}			 
			}else{ 
 ?>
					<a href="<?php echo $link ?>" title="ver mas detalles" class="boton poppi-sb"><img src="img/iconos/carrito.png" alt="carrito"> s/ <?php echo $precio; ?></a>
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