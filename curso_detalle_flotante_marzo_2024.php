<?php include 'auten.php';
$unix_date = strtotime(date('Y-m-d H:i:s'));
$no_galeria="";
?>

<main id="curso" class=" ">
<?php 
if(!empty($_GET["rewrite4"])){  

	$curso = executesql(" SELECT c.*, ca.titulo as categoria, ca.titulo_rewrite AS catrewri, sc.titulo as subcategoria, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso INNER JOIN categorias ca ON csc.id_cat = ca.id_cat INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo WHERE c.estado_idestado = 1  and c.titulo_rewrite = '".$_GET['rewrite4']."' ORDER BY c.orden DESC ");
	
		$link='curso/'.$curso[0]['tiprewri'].'/'.$curso[0]['catrewri'].'/'.$curso[0]['subrewri'].'/'.$curso[0]['titulo_rewrite'];


// data puntual
$alumn = executesql("SELECT * FROM suscritos_x_cursos WHERE estado_idestado = 1 AND id_curso = '".$curso[0]['id_curso']."'");
$profe = executesql("SELECT * FROM profesores WHERE id_profesor IN (".$curso[0]['id_pro'].") ");
$fecha= date('m\/Y ',strtotime($curso[0]['fecha_actualizacion']));
$mes= date('m',strtotime($curso[0]['fecha_actualizacion']));
$mes_actual = date("m");

?>
    <div class="callout callout-10 flotante "><div class="row">
			<div class="large-12  text-center  columns">						
					<?php if(!empty( $curso[0]['link_video'])){  /* video trailer */ ?>
							<div class="rel lleva_vimeo_listado">
									<iframe src="<?php echo $curso[0]['link_video']; ?>"  frameborder="0" allow="autoplay=1; fullscreen" allowfullscreen></iframe>
							</div>
					<?php }else{ 
									$imgproduct= !empty($curso[0]['imagen2'])?'tw7control/files/images/capa/'.$curso[0]['imagen2']:'img/no_imagen.jpg';
					?>
							<figure class="rel ">
								<img src="<?php echo $imgproduct ?>" class="principal _flotante ">
							</figure>
					<?php }  ?>
			</div>
			<div class="large-7 medium-6  columns">
			<?php  
			/* detecto que tipo de cirso es, segun eso mofifico la ruta del link:  */
			if($curso[0]['tipocurso']==1){
					$ruta='curso/todos/';
			}else if($curso[0]['tipocurso']==2){
					$ruta='libro/todos-los-libros/';
			}else if($curso[0]['tipocurso']==3){
					$ruta='coautoria/todos-los-libros-coautoria/';
			}else{
					$ruta='error_tipo_curso';
			}
			?>
				<blockquote class="cabezera_menu">
					<?php  echo '<a href="'.$ruta.$curso[0]['catrewri'].'">'.$curso[0]['categoria'].' </a> / <a href="'.$ruta.$curso[0]['catrewri'].'/'.$curso[0]['subrewri'].'">'.$curso[0]['subcategoria'].'</a>'?>
				</blockquote>
				<h1 class="poppi  "><?php echo $curso[0]['titulo'] ?></h1>
				
				<?php echo !empty($curso[0]['breve_detalle']) ? '<div class="poppi texto rel">'.$curso[0]['breve_detalle'].'</div>' : '' ?>
				<p class="poppi-b mos texto"></p>
				<div class=" datos_anexos_en_vivo blanco text-center ">
						<?php /* frecuencia y clases  */
						/*
						if( $curso[0]["modalidad"]==2 && !empty($curso[0]["frecuencia_clase"]) ){  
									$meses=array('Jan'=>'ENERO','Feb'=>'FEBRERO','Mar'=>'MARZO','Apr'=>'ABRIL','May'=>'MAYO','Jun'=>'JUNIO','Jul'=>'JULIO','Aug'=>'AGOSTO','Sep'=>'SEPTIEMBRE','Oct'=>'OCTUBRE','Nov'=>'NOVIEMBRE','Dec'=>'DICIEMBRE');
									$fecha_inicio_curso= strtr(date('d\ \d\e\ M',strtotime($curso[0]['frecuencia_clase'])),$meses);
						?>							
							<div class="fecha_en_vivo blanco text-center ">
								<p class="poppi ">
									<small>Frecuencia de clases</small> 
									<?php echo $fecha_inicio_curso; ?> 
								</p>
							</div>
						<?php } 
						
						*/?>
						
						<?php /* frecuencia y clases  */
						if( $curso[0]["modalidad"]==2 && !empty($curso[0]["horario_clase"]) ){  
									$meses=array('Jan'=>'ENERO','Feb'=>'FEBRERO','Mar'=>'MARZO','Apr'=>'ABRIL','May'=>'MAYO','Jun'=>'JUNIO','Jul'=>'JULIO','Aug'=>'AGOSTO','Sep'=>'SEPTIEMBRE','Oct'=>'OCTUBRE','Nov'=>'NOVIEMBRE','Dec'=>'DICIEMBRE');
									$fecha_inicio_curso= strtr(date('d\ \d\e\ M',strtotime($curso[0]['horario_clase'])),$meses);
						?>							
							<div class="fecha_en_vivo blanco text-center ">
								<p class="poppi ">
									<small>Horario de Clases</small> 
									<?php echo $curso[0]['horario_clase']; ?>
								</p>
							</div>
						<?php } ?>
				</div>

				
						
				
				<?php if(!empty($curso[0]['link_grupo_wasap']) ){ ?>													
								<div class="parte-medio text-center " style="margin-top:10px;">
									<a href="<?php echo $curso[0]['link_grupo_wasap']; ?>" title="  canal_wsp_flota" target="_blank" class=" canal_wsp_flota  poppi  "  >
										<img src="img/iconos/ws.png" alt="Únete a nuestro  canal de whatsApp "> Únete a nuestro grupo de whatsApp <span> Grupo Auge  </span>
									</a>
							</div>
				<?php }else{  ?>
					<div class="parte-medio text-center " style="margin-top:10px;">
					<a href="<?php echo $link_grupo_wasap; ?>" title="  canal_wsp_flota" target="_blank" class=" canal_wsp_flota  poppi  "  >
						<img src="img/iconos/ws.png" alt="Únete a nuestro  canal de whatsApp "> Únete al canal de whatsApp <span>de Grupo Auge  </span>
					</a>
				</div>
				
				<?php } ?>


				<hr>
				<div id="compi" >
					<ul class="no-bullet poppi float-left color1">
							<li class="poppi"><em style="display:inline-block;padding-right:10px;">Compartir: </em> 
							<a title="Twitter" href="javascript: void(0);" onclick="window.open('https://twitter.com/intent/tweet?text=&url='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/twitter-b.png"></a> <a title="Facebook" href="javascript: void(0);" onclick="window.open('http://www.facebook.com/sharer.php?u='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/face-b.png"></a> <a title="Telegram" href="javascript: void(0);" onclick="window.open('https://telegram.me/share/url?url='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/telegram-b.png"></a> <a href="https://api.whatsapp.com/send/?phone&text=<?php echo 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" target="_blank"><img src="img/iconos/wsp-b.png" style="margin-top:;"></a></li>
					</ul>
				</div>

			

			</div>
			
			<div class="large-5 medium-6  columns"><div class="contiene_datos_compra ">
					<!--  datos puntuales -->
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
				
				
        <div class="detacurso">
<?php
if($curso[0]['costo_promo']>0){
    $resul = number_format($curso[0]['costo_promo']*100/$curso[0]['precio'],0);
    $resultado = 100-$resul;
}
$precio= ($curso[0]['costo_promo']>0) ? $curso[0]['costo_promo']: $curso[0]['precio'];
$imgproduct= 'tw7control/files/images/capa/'.$curso[0]['imagen'];

$fecha_actual = strtotime(date("d-m-Y"));
$fecha_entrada = strtotime($curso[0]["fecha_fin_promo"]);

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
								
								<?php 
								/* si es curso es en vivo */
								if( $curso[0]["modalidad"]==2 && !empty($curso[0]["fecha_inicio"]) ){  
												$meses=array('Jan'=>'ENERO','Feb'=>'FEBRERO','Mar'=>'MARZO','Apr'=>'ABRIL','May'=>'MAYO','Jun'=>'JUNIO','Jul'=>'JULIO','Aug'=>'AGOSTO','Sep'=>'SEPTIEMBRE','Oct'=>'OCTUBRE','Nov'=>'NOVIEMBRE','Dec'=>'DICIEMBRE');
												$fecha_inicio_curso= strtr(date('d\ \d\e\ M',strtotime($curso[0]['fecha_inicio'])),$meses);
								?>
									
									<div class="fecha_en_vivo blanco text-center ">
										<p class="poppi ">
											<small>Inicio de CURSO VIRTUAL</small> 
											<?php echo $fecha_inicio_curso; ?> 
											<small><?php echo $curso[0]['hora_inicio']; ?></small>
										</p>
									</div>
								<?php } ?>

                <ul class="no-bullet roboto">
					<?php if($_GET['rewrite']!='todos-los-libros' && $_GET['rewrite']!='libros' && $_GET['rewrite']!='todos-los-libros-coautoria' && $_GET['rewrite']!='libros-coautores'){ ?> 
									<!-- // total de alumnos en el curso 
                    <li class="texto"><div class="img"><img class="verticalalignmiddle" src="img/iconos/alum.png"></div><?php echo count($alumn) ?> alumnos</li>
										-->
                    <li class="texto bold "><div class="img"><img class="verticalalignmiddle" src="img/iconos/lecc.png"></div><?php echo count($ab1) ?> Lecciones <?php
                    if($n_hora_total>0){
                        $hours = floor($n_hora_total / 60);
                        $minutes = $n_hora_total % 60;
                        echo '('.$hours.'H '.$minutes.'min)';
                    }
                    ?> </li>
                    <!--
										<li class="texto"><div class="img"><img class="verticalalignmiddle" src="img/iconos/recu.png"></div><?php echo $n_recursos; ?> Recursos adicionales (<?php echo $n_recursos_archivos; ?> archivos)</li>
										-->
                    <li class="texto"><div class="img"><img class="verticalalignmiddle" src="img/iconos/ico-online.png"></div><?php echo ($curso[0]["modalidad"]==1)?'100% Online y a tu ritmo':'En vivo'; ?> </li>
                    <li class="texto"><div class="img"><img class="verticalalignmiddle" src="img/iconos/ico-certificacion.png"></div>Curso con certificación </li>
                    <li class="texto"><div class="img"><img class="verticalalignmiddle" src="img/iconos/ico-docentes.png"></div>Profesor(es) Profesional(es)  </li>
                    <li class="texto"><div class="img"><img class="verticalalignmiddle" src="img/iconos/ico-comunicacion.png"></div>Comunicación directa con el docente</li>
                    <li class="texto"><div class="img"><img class="verticalalignmiddle" src="img/iconos/ico-chat.png"></div>Chat en vivo</li>
							
					<?php } ?>
                </ul>
					
								<a class="roboto boton " href="<?php echo $link ?>"> ver detalles</a>
            </div>
					<!--  datos puntuales -->
			</div></div>
    </div></div>
		
	
<?php 
}else{ //si exist rew?>
<p class="osans em texto" style="padding:80px 0;">No existe parametro...</p>
<?php } ?>
</main>


<script src="js/foundation.min.js"></script>
<script>
$(document).foundation();
</script>

<script src="js/main.js?ud=<?php echo $unix_date; ?>"></script>  
