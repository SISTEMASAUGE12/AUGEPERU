<?php 
/* Datos de los profesores del curso */
if( !empty($profe)){    // multiples profes .. 
	$profes_data_cart='';$i_pro=0;
	foreach($profe as $dataprofes){ 

			if($i_pro==0){
			$profes_data_cart=$dataprofes['titulo'];
				
			}else{
			$profes_data_cart=$profes_data_cart.', '.$dataprofes['titulo'];

			}

			$i_pro++;
	}
}
?>

<?php
/* Datos puntuales del curso .. */
    $n_hora_total = 0;
    $ab1 = executesql("SELECT * FROM sesiones WHERE estado_idestado = 1 AND id_curso = ".$curso[0]['id_curso']." ORDER BY ORDEN ASC");
    $n_recursos=0;
    $n_recursos_archivos=0;
    $j=0;
    if(!empty($ab1)){ foreach($ab1 as $ab01){
		$ab2 = executesql("SELECT * FROM detalle_sesiones WHERE estado_idestado = 1 AND id_sesion = ".$ab01['id_sesion']." ORDER BY orden DESC");
		if(!empty($ab2)){ foreach($ab2 as $ab02){
			$j = $j+1;
            if(!empty($ab02['duracion'])){
                $n_hora_total = $n_hora_total + $ab02['duracion'];
            }

			$ab3 = executesql("SELECT * FROM archivos_detalle_sesion_virtuals WHERE estado_idestado = 1 AND id_detalle = ".$ab02['id_detalle']." ORDER BY orden DESC");
				if(!empty($ab3)){ foreach($ab3 as $n_archivos_recursos){
						$n_recursos = $n_recursos+1;
						if( !empty($n_archivos_recursos["archivo"]) || !empty($n_archivos_recursos["enlace"]) ){
							$n_recursos_archivos=$n_recursos_archivos+1;
						}
				} }
			} }
    } }
?>
				
				
        <div class="detacurso" style="padding-top:0;">
<?php 
$fecha_actual = strtotime(date("d-m-Y"));
$fecha_entrada = strtotime($curso[0]["fecha_fin_promo"]);

if($curso[0]['costo_promo']>0){
    $resul = number_format($curso[0]['costo_promo']*100/$curso[0]['precio'],0);
    $resultado = 100-$resul;
}
// $precio= ($curso[0]['costo_promo']>0) ? $curso[0]['costo_promo']: $curso[0]['precio'];

if($fecha_actual < $fecha_entrada){
	// si esta vigente la fecha promo, validaos si existe un precio promo
	$precio= ($curso[0]['costo_promo']>0) ? $curso[0]['costo_promo']: $curso[0]['precio'];
}else{
	$precio= $curso[0]['precio'];
}

$precio_online= ($curso[0]['precio_online']>0) ? $curso[0]['precio_online']: $precio;

// $imgproduct= 'tw7control/files/images/capa/'.$curso[0]['imagen'];
$imgproduct= 'tw7control/files/images/capa/'.$curso[0]['imagen2'];



if($curso[0]["tipocurso"]== $_variable_tipo_categoria_gratuita){ //id de tipo gratuitos
		echo '<blockquote class="roboto-b color1">Gratuito</blockquote>';
}else{
	// sino es greuito muestro precios 
?>
			<?php if($fecha_actual < $fecha_entrada  && $curso[0]['costo_promo']>0 ){ ?>
                <blockquote class="poppi  color1  ">
									<span class="textillo ">Antes</span>  
									<span class=" lleva_precio_span ">
										<small>
                <?php  
										
                    echo ($curso[0]['costo_promo']>0) ? 'S/ '.$curso[0]['precio']: '--';
								?>
										</small>
									</span>
								</blockquote>
               <?php   } ?>
								
								<blockquote class="poppi-b  azul ">
									<span class="textillo ">Ahora</span>  
									<span class=" lleva_precio_span ">
					<?php if($fecha_actual < $fecha_entrada  && $curso[0]['costo_promo']>0 ){
                  
										
                    echo ($curso[0]['costo_promo']>0) ? 'S/ '.$curso[0]['costo_promo']: '---';
                }else{
                    echo 'S/ '.$curso[0]['precio'];
                }
						?>
									</span>
								</blockquote>
								
								<!-- 
						<?php if($curso[0]['precio_online']>0 ){ ?>
								<blockquote class="poppi-b color2 lleva_online ">
									<span class="textillo _online">Tarjeta</span> 
									<span class="lleva_precio_span ">
										s/ <?php echo $curso[0]['precio_online']; ?>
									</span>
								</blockquote>
							<?php } 	?>
								-->
								
<?php } // si no es gretuito ?>
								
							 <?php
								/* fecha limite de la oferta */
                    if($fecha_actual < $fecha_entrada){
                ?>
                    <li style="list-style:none;" class="color2 cronometro"><div class="img"><img class="" src="img/iconos/reloj.png"></div>La oferta termina en <?php echo $curso[0]["fecha_fin_promo"]; ?> <div id="countdown" style="display:inline-block;padding-left:10px;"></div></li>
                    <script>
                    var end = new Date('<?php echo $curso[0]["fecha_fin_promo"] ?> 11:59 PM');

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
                            document.getElementById('countdown').innerHTML = 'Promocíón a expirado!';
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
                        document.getElementById('countdown').innerHTML = hours + 'h :';
                        document.getElementById('countdown').innerHTML += minutes + 'm :';
                        document.getElementById('countdown').innerHTML += seconds + '';
                    }

                    timer = setInterval(showRemaining, 1000);
                    </script>
                <?php
                    }
                ?>
							
								
							
								<form id ="ruta-<?php echo $curso[0]["id_curso"]; ?>" class="add mostrar_texto_comprar " method="POST" action="process_cart/insert.php" accept-charset="UTF-8">
									<input type="hidden" name="id"  value="<?php echo $curso[0]["id_curso"] ?>">
									<input type="hidden" name="id_tipo"  value="<?php echo $curso[0]["id_tipo"] ?>">
									<input type="hidden" name="validez_meses"  value="<?php echo $curso[0]["validez_meses"] ?>">
									<input type="hidden" name="cursos_dependientes"  value="<?php echo $curso[0]["cursos_dependientes"]; ?>">
									<input type="hidden" name="cursos_dependientes_data"  value="<?php echo $_data_cursos_dependientes; ?>">
									<input type="hidden" name="cursos_especialidades"  value="<?php echo $_data_ides_especialidades; ?>">
									<input type="hidden" name="cursos_especiales_data"  value="<?php echo $_data_cursos_especiales; ?>">
									<input type="hidden" name="rewrite"  value="<?php echo "curso/".$_GET["rewrite"]."/".$curso[0]["catrewri"]."/".$curso[0]["subrewri"]."/".$curso[0]["titulo_rewrite"]; ; ?>">
									<input type="hidden" name="imagen"  value="<?php echo $imgproduct ; ?>">
									<input type="hidden" name="cantidad"  value="1">
									<input type="hidden" name="profe"  value="<?php echo $profes_data_cart; ?>" >
									<input type="hidden" name="tag"  value="<?php echo $curso[0]["tag"]; ?>" id="tag">
									<input type="hidden" name="nombre"  value="<?php echo $curso[0]["codigo"].' - '.$curso[0]["titulo"]; ?>" id="nombre">
									<input type="hidden" name="precio"  value="<?php echo $precio; ?>" id="precio">
									<input type="hidden" name="precio_online"  value="<?php echo $precio_online; ?>" id="precio_online">

									<div class="text-center ">
										
<?php 
				//id de tipo gratuitos y caso de especialidades que demandan la id_espec del cli
				if( ($curso[0]["tipocurso"]== $_variable_tipo_categoria_gratuita) || !empty($curso[0]['cursos_especialidades']) || !empty($_data_ides_especialidades)  ){
							
							/* $_data_ides_especialidades ::> tambien implica a los cursos de especilidad de los cursos dependientess :: los packs  */
							// el cleinte es requesitio que este logeado para estos procedmientos ..
							/* lo de especialidades es par aque se le peuda asignar su curso de especialidad, debe logearse antes de comrpar .. */
							if( isset( $_SESSION["suscritos"]["id_suscrito"] )){
							// el cleinte es requesitio que este logeado para estos procedmientos ..
										if( ($curso[0]["tipocurso"]== $_variable_tipo_categoria_gratuita) ){ // si es gratuito ...
										
											echo '<a class="roboto boton  estoy_detalle_curso suscribirse_al_curso_free  pulse comprar_ahora_webinar "> Suscríbete </a>';
											echo '<div id="rptapago" class="hide">... </div>';
											
										}elseif(!empty($curso[0]['cursos_especialidades']) || !empty($_data_ides_especialidades)  ){   // si tiene espealidades --> bton compra directa - sino esta logeado que inicie sesion
												echo '<button class="roboto boton  hola  estoy_detalle_curso compra_directa  pulse comprar_ahora_webinar  "> COMPRAR AQUÍ	</button>';
										}
										
							}else{  // lo mandamos a que inicia sesión para poder asignarle sus especialidades gratuitas .. 
									if( ($curso[0]["tipocurso"]== $_variable_tipo_categoria_gratuita) ){ // si es gratuito ...
										echo '<a href="iniciar-sesion" class="roboto boton  estoy_detalle_curso comprar_ahora_webinar sin_login_usuario" > Suscríbete </a>';	
																					
									}elseif( !empty($curso[0]['cursos_especialidades'])  || !empty($_data_ides_especialidades)  ){   // si tiene espealidades --> bton compra directa - sino esta logeado que inicie sesion
										echo '<a href="iniciar-sesion" class="roboto boton  estoy_detalle_curso comprar_ahora_webinar pulse sin_login_usuario"> COMPRAR AQUÍ	 </a>';	
									}
									
							}
								
			}else{
							// sino es greuito boton carrito   
?>
										<button class="roboto boton  hola  estoy_detalle_curso compra_directa  pulse comprar_ahora_webinar pulse">COMPRAR s/ <?php echo $precio; ?></button>
<?php	} // si no es gretuito ?>


									</div><!-- l **12 prod-->
								</form>

            </div>