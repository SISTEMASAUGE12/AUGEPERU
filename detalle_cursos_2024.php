<?php 
 $sql_detalle= " SELECT c.*, ca.titulo as categoria, ca.titulo_rewrite AS catrewri, sc.titulo as subcategoria, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso INNER JOIN categorias ca ON csc.id_cat = ca.id_cat INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo WHERE c.estado_idestado = 1  and c.titulo_rewrite = '".$_GET['rewrite4']."' ORDER BY c.orden DESC ";
$curso = executesql($sql_detalle);

if( !empty($curso[0]['id_pro']) ){
$profe = executesql("SELECT * FROM profesores WHERE id_profesor IN (".$curso[0]['id_pro'].") ");
}

$fecha= date('m\/Y ',strtotime($curso[0]['fecha_actualizacion']));
$mes= date('m',strtotime($curso[0]['fecha_actualizacion']));
$mes_actual = date("m");

$imgproduct= 'tw7control/files/images/capa/'.$curso[0]['imagen2'];  /* mostramos la img pequeña */


$titulo_del_boton=  !empty($curso[0]["titulo_boton"])?$curso[0]["titulo_boton"]:'COMPRAR AHORA'; 
$link_destino='cesta-pago-tarjeta-directo/'.$curso[0]["id_curso"]; //si lleva a link de compra directa 


$fecha_actual = strtotime(date("d-m-Y"));
$fecha_entrada = strtotime($curso[0]["fecha_fin_promo"]);

if($fecha_actual < $fecha_entrada  ){
	// si esta vigente la fecha promo, validaos si existe un precio promo
	$precio= ($curso[0]['costo_promo']>0) ? $curso[0]['costo_promo']: $curso[0]['precio'];
}else{
	$precio= $curso[0]['precio'];
}
?>
	<div class="callout banners  _mostrar_solo_pc  " > 
		<ul class="no-bullet hide  " id="carousel-1">
			<div class="esperando-slider fondo banner-1"></div>
			<!-- <li class=" fondo   "  style=" background: url(tw7control/files/images/banners/<?php echo $curso[0]["imagen"]; ?> "> -->
			<li class=" fondo   "  style=" background-image: url(img/banners/banner_detalle_cursos.jpg">
				<div class="row">
					<div class="  medium-12  text-center columns">
						<h3 class=" poppi-b color1 "> <?php echo $curso[0]["titulo_banner_detalle"]; ?></h3>
					</div>
					<div class="  medium-6  columns">
						<figure class="rel">
							<img src="<?php echo !empty( $curso[0]['imagen2'])?$imgproduct:'img/no_imagen.jpg'; ?>" class="principal " alt="<?php echo $curso[0]['titulo'];?>">
							<?php if( !empty($curso[0]["link_video"])){ ?>
							<a class="mascara abs mpopup-02 " href="<?php echo $curso[0]["link_video"]; ?>"></a>
							<?php } ?>
						</figure>
					</div>								
					<div class=" medium-6  columns"><div class="_data_banners text-center ">									
						<h1 class="poppi-b color1  "><?php echo  $curso[0]['titulo']; ?></h1>
						<a class="boton poppi-sb    " href="<?php echo  $link_destino; ?>"> <?php echo  $titulo_del_boton; ?> </a>
						<!--
						-->
						<?php //include("formulario_de_compra_detalle_2024.php"); ?>
					</div></div>
				</div>
			</li>			
		</ul>
	</div>  <!-- end banner  PC -->


	<div class="callout banners  _mostrar_solo_movil  " > 
		<ul class="no-bullet hide  " id="carousel-1-movil">
			<div class="esperando-slider fondo banner-1"></div>
			<!-- <li class=" fondo   "  style=" background-image: url(tw7control/files/images/banners/<?php echo $curso[0]["imagen2"]; ?> "> -->
			<li class=" fondo"  style=" background-image: url(img/banners/banner_detalle_cursos.jpg">
				<div class="row">
					<div class="  medium-12  text-center columns">
						<h3 class=" poppi-b color1 "> <?php echo $curso[0]["titulo_banner_detalle"]; ?> </h3>
					</div>
					<div class="  medium-6  columns">
						<figure class="rel">
							<img src="<?php echo !empty( $curso[0]['imagen'])?$imgproduct:'img/no_imagen.jpg'; ?>" class="principal " alt="<?php echo $curso[0]['titulo'];?>">
							<a class="mascara abs mpopup-02 " href="<?php echo $curso[0]["link_video"]; ?> "></a>
						</figure>
					</div>								
					<div class=" medium-6  columns"><div class="_data_banners text-center ">									
						<h1 class="poppi-b color1  "><?php echo  $curso[0]['titulo']; ?></h1>
						<a class="boton poppi-sb " href="<?php echo  $link_destino; ?>"> <?php echo  $titulo_del_boton; ?> </a>
						<!--
						-->
						<?php // include("formulario_de_compra_detalle_2024.php"); ?>
					</div></div>
				</div>
			</li>
		</ul>
	</div>  <!-- end banner   MOVIL -->
	

<!-- * temarios -->
<?php  
 $sql_tema=" select * from silabos where id_curso='".$curso[0]['id_curso']."'  and estado_idestado=1 ";
$temarios= executesql( $sql_tema);
if( !empty($temarios) ){ 
?>

<div class="  callout callout-temarios ">
	<div class=" row text-center  ">
		<h3 class=" poppi-b color2 " > NUESTRO TEMARIO </h3>
		<p class=" poppi color1 " style="padding-bottom:40px;"> Para conocerlo selecciona tu especialidad </p>
		<div class=" _menu_temario ">
	<?php  
		 $especialidades_tem= executesql(" select * from especialidades where estado_idestado=1 and id_especialidad != 13 order by titulo asc ");
		 foreach( $especialidades_tem as $row ){ ?>
			<a  id="id-<?php echo $row["id_especialidad"]; ?>" class="poppi btn  mostrar_temario " > <?php echo $row["titulo"]; ?></a>
			<?php 
		 }
	?>
		</div>

		<?php 
			foreach( $temarios as $tema){
		?>
		<div class=" listado_temario   temario_<?php echo $tema["id_especialidad"]; ?>  hide " >
			<div class=" large-12 columns text-center " >
				<h3 class=" poppi-b color2 " > <?php echo $tema["titulo"]; ?> </h3>
			</div>
			<div class=" large-8 medium-7 columns text-justify " >
				<div class=" _contiene_des_temario  ">
					<?php echo $tema["descripcion"]; ?>
				</div>
			</div>
			<div class=" large-4 medium-5 columns text-center " >
				<?php if( !empty($tema["imagen"]) ){ ?>
					<figure><img src="tw7control/files/images/silabos/<?php echo $tema["imagen"]; ?>"></figure>
				<?php } ?>
			</div>
		</div>
		<?php } // end for ?> 
		
	</div>
</div>
<?php } // end IF ?> 
<!-- * END temarios -->



<?php  
	$pestañas=executesql("select * from pestanhas where estado_idestado=1 and id_curso='".$curso[0]['id_curso']."' order by orden asc ");
	if( !empty($pestañas) ){  $contador_linea=1;
		foreach($pestañas as $detalle_pestana){
			$imagen_pes= !empty($detalle_pestana["descripcion"])?'tw7control/files/images/pestanas/'.$detalle_pestana["imagen"]:'img/_curso_1.png';
			if( $contador_linea == 1 ){
				$contador_linea++;
?>	
	<div class="callout callout-20 fondo_1 "><div class="row">
		<div class="large-12  text-center  columns">
			<H3 class=" poppi-b color1 "> <?php echo $detalle_pestana["titulo"]; ?></H3>
		</div>
		<div class="large-6  medium-7  columns">
			<div class=" _contiene_detalle ">
				<?php echo $detalle_pestana["descripcion"]; ?>
			</div>
		</div>					
		<div class="large-6 medium-5  columns">
			<figure><img src="<?php echo $imagen_pes; ?>"></figure>	
			<a class="boton poppi-sb " href="<?php echo  $link_destino; ?>"> <?php echo  $titulo_del_boton; ?> </a>
			<?php // include("formulario_de_compra_detalle_2024.php"); ?>
		</div>
    </div></div>

	<?php 
			}else{  
	?>				
	<div class="callout callout-20  "><div class="row">
		<div class="large-12  text-center  columns">
			<H3 class=" poppi-b color1 "> <?php echo $detalle_pestana["titulo"]; ?></H3>
		</div>
		<div class="large-6 medium-5  columns">
			<figure><img src="<?php echo $imagen_pes; ?>"></figure>	
			<!-- -->
		</div>
		<div class="large-6  medium-7  columns">
			<div class=" _contiene_detalle ">
				<?php echo $detalle_pestana["descripcion"]; ?>
			</div>
			<?php //include("formulario_de_compra_detalle_2024.php"); ?>
			<a class="boton poppi-sb  " href="<?php echo  $link_destino; ?>"> <?php echo  $titulo_del_boton; ?> </a> 
		</div>							
    </div></div>
	
<?php	
				$contador_linea=1;	
			}			
		}// end for 
	}// end if pestanas 
?>
	

	
	<?php  
        $test = executesql("SELECT * FROM testimonios WHERE estado_idestado = 1   ORDER BY orden DESC limit 0,8");
        if(!empty($test)){ ?>
	<div class="callout callout-21  "><div class="row">
		<div class="large-10 large-centered   text-center  columns">
			<H3 class=" poppi-b color1 ">  TESTIMONIOS</H3>
			<p> Los docentes nos recomiendan</p>
			<ul class=" carousel-3 no-bullet poppi ">
			<?php  foreach($test as $testi){ 
					$img_testimonio= !empty($testi["imagen2"])?'tw7control/files/images/testimonios/'.$testi["imagen2"]:'img/_curso_testi.png';	
			?>
				<li class=" _lleva_testimonio ">
					<figure><img src="<?php echo $img_testimonio; ?>"></figure>	
					<h4 class=" poppi-sb "> <?php echo $testi["titulo"];?></h4>
					<div> <?php echo short_name($testi["descripcion"], 128); ?> </div>
				</li>		
				<?php } 	?>			
			</ul>		
		</div>
    </div></div>
	<?php
        } // end testuimonios
	?>			


    <div class="callout callout-11 "  > <div class="row">
        <div class="large-10 large-centered columns">	
			<div class=" propuestas  row text-center " >
				<h3 class="poppi-b color1 text-center "> ESTRUCTURA </h3>
				<div class="large-3 medoum-4 small-6 columns end " >
					<img src="img/icono_detalle_1.png">
					<p class="poppi texto ">Aprende </br>a tu ritmo</p>
				</div>
				<div class="large-3 medoum-4 small-6 columns end " >
					<img src="img/icono_detalle_2.png">
					<p class="poppi texto ">De la mano del </br>profesor</p>
				</div>
				<div class="large-3 medoum-4 small-6 columns end " >
					<img src="img/icono_detalle_3.png">
					<p class="poppi texto ">Profesores </br> expertos</p>
				</div>
				<div class="large-3 medoum-4 small-6 columns end " >
					<img src="img/icono_detalle_4.png">
					<p class="poppi texto ">Certificado </br> por curso</p>
				</div>
				<div class="large-3 medoum-4 small-6 columns end " >
					<img src="img/icono_detalle_5.png">
					<p class="poppi texto ">En primera </br> fila</p>
				</div>
				<div class="large-3 medoum-4 small-6 columns end " >
					<img src="img/icono_detalle_6.png">
					<p class="poppi texto ">Comparte </br> conocimiento </p>
				</div>
				<div class="large-3 medoum-4 small-6 columns end " >
					<img src="img/icono_detalle_7.png">
					<p class="poppi texto ">Comunidad </br> creativa</p>
				</div>
				<div class="large-3 medoum-4 small-6 columns end " >
					<img src="img/icono_detalle_8.png">
					<p class="poppi texto ">Cursos producidos </br> profesionalmente</p>
				</div>
			</div>				
		</div> <!-- L8 detalle -->			
	</div></div> <!-- calloiut -#11 -->

	<div class="callout callout-22  poppi "><div class="row">
		<div class="large-12  text-center  columns">
			<H3 class=" poppi-b color1 ">   CONTENIDO</H3>
			<p > Te brindaremos los cursos de:</p>
		</div>
		<div class="large-6 medium-6  columns">
			<blockquote><b class="p_top "> HABILIDADES GENERALES</b>  Razonamiento Lógico Matemático </br>Comprensión Lectora</blockquote>
		</div>
		<div class="large-6 medium-6  columns">
			<blockquote><b>   CONOCIMIENTOS PEDAGÓGICOS, CURRICULARES,  DISCIPLINARES DE LA ESPECIALIDAD</b>  Conocimientos Pedagógicos Generales </br> Conocimientos Pedagógicos de tu especialidad</blockquote>
		</div>
		<div class="large-12  text-center  columns" style="margin-top:20px;">
			<H3 class=" poppi-b color1 ">    CLASES EN VIVO</H3>
		</div>
		<div class="large-12  columns">
			<blockquote class="_ancho "><b> PREGÚNTALE AL DOCENTE</b> Clases en vivo de Lunes a Sábado, en donde podrás interactuar con el docente</blockquote>
		</div>
		
							
    </div></div>

	<div class="callout callout-23 fondo_1 "><div class="row">
		<div class="large-12  text-center  columns">
			<H3 class=" poppi-b color1 "> HORARIOS </H3>
		</div>		
		<div class="large-4 medium-4 small-6    columns  end ">
			<figure class="  rel  ">
				<img src="img/horario_1.png" class=" _mostrar_solo_pc ">
				<img src="img/horario_movil_1.png" class=" _mostrar_solo_movil ">
				<figcaption class="   ">
					<div class=" text-center ">
						<p> <b>LUNES </b> </BR> <?php echo !empty($curso[0]["horario_lunes"]) ?$curso[0]["horario_lunes"]:' --- ';?> </p>
					</div>
				</figcaption>
			</figure>	
		</div>
		<div class="large-4 medium-4 small-6    columns  end ">
			<figure class="  rel  ">
				<img src="img/horario_2.png" class=" _mostrar_solo_pc ">
				<img src="img/horario_movil_2.png" class=" _mostrar_solo_movil ">
				<figcaption class="   ">
					<div class=" text-center ">
						<p> <b>MARTES </b> </BR>  <?php echo !empty($curso[0]["horario_martes"]) ?$curso[0]["horario_martes"]:' ---';?> </p>
					</div>
				</figcaption>
			</figure>	
		</div>
		<div class="large-4 medium-4 small-6    columns  end ">
			<figure class="  rel  ">
				<img src="img/horario_3.png" class=" _mostrar_solo_pc ">
				<img src="img/horario_movil_3.png" class=" _mostrar_solo_movil ">
				<figcaption class="   ">
					<div class=" text-center ">
						<p> <b>MÍERCOLES </b> </BR>  <?php echo !empty($curso[0]["horario_miercoles"]) ?$curso[0]["horario_miercoles"]:' ---';?> </p>
					</div>
				</figcaption>
			</figure>	
		</div>
		<div class="large-4 medium-4 small-6    columns  end ">
			<figure class="  rel  ">
				<img src="img/horario_4.png" class=" _mostrar_solo_pc ">
				<img src="img/horario_movil_4.png" class=" _mostrar_solo_movil ">
				<figcaption class="   ">
					<div class=" text-center ">
						<p> <b>JUEVES </b> </BR> <?php echo !empty($curso[0]["horario_jueves"]) ?$curso[0]["horario_jueves"]:' ---';?></p>
					</div>
				</figcaption>
			</figure>	
		</div>
		<div class="large-4 medium-4 small-6    columns  end ">
			<figure class="  rel  ">
				<img src="img/horario_5.png" class=" _mostrar_solo_pc ">
				<img src="img/horario_movil_5.png" class=" _mostrar_solo_movil ">
				<figcaption class="   ">
					<div class=" text-center ">
						<p> <b>VIERNES </b> </BR> <?php echo !empty($curso[0]["horario_viernes"]) ?$curso[0]["horario_viernes"]:' ---';?></p>
					</div>
				</figcaption>
			</figure>	
		</div>
		<div class="large-4 medium-4 small-6    columns  end ">
			<figure class="  rel  ">
				<img src="img/horario_6.png" class=" _mostrar_solo_pc ">
				<img src="img/horario_movil_6.png" class=" _mostrar_solo_movil ">
				<figcaption class="   ">
					<div class=" text-center ">
						<p> <b>SÁBADO </b> </BR> <?php echo !empty($curso[0]["horario_sabado"]) ?$curso[0]["horario_sabado"]:' ---';?></p>
					</div>
				</figcaption>
			</figure>	
		</div>
    </divv></div>



	<div class="callout callout-20  "><div class="row">
		<div class="large-12  text-center  columns">
			<H3 class=" poppi-b color1 ">  LO QUE LOGRARÁS </H3>
		</div>
		<div class="large-6 medium-6  columns   ">
			<div class=" _lo_que_lograras ">
				<p class="rel _lleva_numerillo poppi ">
					<span class=" poppi-b _numerillo color2 "> 1</span>
					<b>Dominar Metodologías Pedagógicas Innovadoras: </b>Técnicas comprobadas que mejorarán la enseñanza y el aprendizaje.
				</p>
				<p class="rel _lleva_numerillo poppi ">
					<span class=" poppi-b _numerillo color2 "> 2</span>
					<b>Desarrollar Estrategias de Resolución de Problemas: </b>Enfrentar y superar los desafíos comunes en la educación.
				</p>
				<p class="rel _lleva_numerillo poppi ">
					<span class=" poppi-b _numerillo color2 "> 3</span>
					<b>Preparación para Exámenes de Competencia Docente: </b> Tácticas para sobresalir en evaluaciones oficiales.
				</p>
			</div>			
		</div>

		<div class="large-6  medium-6  columns   ">
			<div class=" _lo_que_lograras ">
				<p class="rel _lleva_numerillo poppi _especial">
					<span class=" poppi-b _numerillo color2 "> 4</span>
					<b> Gestión Efectiva:</b> Mantener un ambiente de aprendizaje positivo y productivo.
				</p>
				<p class="rel _lleva_numerillo poppi ">
					<span class=" poppi-b _numerillo color2 "> 5</span>
					<b> Construir Redes con Docentes Exitosos: </b>Establecer relaciones que fomenten el intercambio de mejores prácticas.
				</p>
				<p class="rel _lleva_numerillo poppi ">
					<span class=" poppi-b _numerillo color2 "> 6</span>
					<b> Desarrollo Profesional Continuo:</b> Recursos para el crecimiento constante en la carrera docente.
				</p>			
			</div>
		</div>
			
		<div class="large-12  columns text-center ">			
			<!-- 
				-->
			<a class="boton poppi-sb  " href="<?php echo  $link_destino; ?>"> <?php echo  $titulo_del_boton; ?> </a>
			<?php // include("formulario_de_compra_detalle_2024.php"); ?>
		</div>						
    </div></div>


	<div class="callout callout-11 _listado_docentes  "><div class="row">
		<h3 class=" poppi-b text-center "> NUESTROS DOCENTES </h3>
		<div class=" large-10 large-centered contiene_slider docentes rel "> 			
			<div class=" contiene_sesiones_listado  "> 
<?php 
			if( !empty($profe)){    // multiples profes .. 
				echo '<ul class="carousel-1  no-bullet" >';
				foreach($profe as $dataprofes){ 
?>
				<li>
					<div class="large-5 medium-5  text-center columns ">
						<figure><img src="<?php echo "tw7control/files/images/profesores/".$dataprofes['imagen']; ?>"></figure>
					</div>
					<div class=" large-7 medium-7 columns ">
						<h4 class="poppi-b color1 "><?php echo $dataprofes['titulo'] ?></h4>
						<?php echo !empty($dataprofes['descripcion']) ? '<div class="data_finder" style="padding:15px 0 25px">'.$dataprofes['descripcion'].'</div>' : '' ?>
					</div>
				</li>
<?php
				}
				echo '</ul>';
			} // if temarios
?>
			</div>
		</div>
	</div></div>


	<section class="callout callout-24  poppi "><div class="row">
		<article class=" medium-10 medium-centered  columns  ">
			<h3 CLASS=" poppi-b color1 text-center ">PAGO</h3>
			<div class=" _contiene row  ">
				<article class=" medium-12 columns text-center ">
					<h2 class="poppi-sb blanco "><?php echo $curso[0]['titulo'];?></h2>
				</article>
				<article class=" medium-6 columns _detalle  _mostrar_solo_movil ">
					<p><img src="img/iconos/vi2.png">Lecciones en VIVO</p>
					<p><img src="img/iconos/vi2.png"> Curso con certificación  </p>
					<p><img src="img/iconos/vi2.png">Profesor(es) Profesional(es)</p>
					<p><img src="img/iconos/vi2.png"> Comunicación directa con el docente</p>
					<p><img src="img/iconos/vi2.png">  Chat en vivo </p>
				</article>		
				<article class=" medium-6 columns  text-center ">
					<?PHP if( ($fecha_actual < $fecha_entrada) && $curso[0]['costo_promo']>0 ){ 
							$style_si_promo='';
					?>
					<div class=" _precio_anterior ">
						<blockquote class="rel poppi-sb color1 ">
							s/ <?php echo $curso[0]['precio']; ?>
							<img src="img/iconos/diagonal_precio.png">
						</blockquote>
					</div>
					<?php }else{   $style_si_promo='margin-top:60px;'; }?>

					<div class=" _precio_ahora " style="<?php echo $style_si_promo; ?>">
						<blockquote class="rel  poppi-b  color1 ">
							<span>s/ <?php echo $precio; ?></span>
							<img src="img/iconos/globo_precio.png">
						</blockquote>
					</div>
					<div class=" text-center    _mostrar_solo_movil ">
						<!-- 
							-->
						<a class="boton poppi-sb  " href="<?php echo  $link_destino; ?>"> <?php echo  $titulo_del_boton; ?> </a>
						<?php // include("formulario_de_compra_detalle_2024.php"); ?>
					</div>	
				</article>

				<article class=" medium-6 columns _detalle  _mostrar_solo_pc ">
					<p><img src="img/iconos/vi2.png">Lecciones en VIVO</p>
					<p><img src="img/iconos/vi2.png"> Curso con certificación  </p>
					<p><img src="img/iconos/vi2.png">Profesor(es) Profesional(es)</p>
					<p><img src="img/iconos/vi2.png"> Comunicación directa con el docente</p>
					<p><img src="img/iconos/vi2.png">  Chat en vivo </p>
				</article>	
				
				<?php  include("inc/inc_formas_de_pago.php"); ?>

			</div>
		</article>	
		<div class="large-12 text-center  columns _mostrar_solo_pc ">
			<!-- 
				-->
				<a class="boton poppi-sb  " href="<?php echo  $link_destino; ?>"> <?php echo  $titulo_del_boton; ?> </a>
			<?php  // include("formulario_de_compra_detalle_2024.php"); ?>
		</div>																		
	</div></section>

	<section class="callout callout-25  poppi "><div class="row">
		<article class=" medium-10 medium-centered  columns  ">
			<div class=" _contiene  ">
				<figure class=" text-center "><img src="img/garantia.png"></figure>
				<div class=" _info ">
					<blockquote class=" color1  poppi-b "> Garantía </blockquote>						
					<p class="poppi rel ">  Si después de 7 días desde la compra, sientes que el contenido no cumple tus expectativas y que no te entrega herramientas para estructurar un año nuevo exitoso, te devolveremos tu dinero sin hacer preguntas. </p>			
				</div>
			</div>
		</article>																			
	</div></section>