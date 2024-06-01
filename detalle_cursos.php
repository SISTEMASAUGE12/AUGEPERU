<?php 
$curso = executesql(" SELECT c.*,  ca.id_cat , ca.titulo as categoria, ca.titulo_rewrite AS catrewri, sc.titulo as subcategoria, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso INNER JOIN categorias ca ON csc.id_cat = ca.id_cat INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo WHERE c.estado_idestado = 1  and c.titulo_rewrite = '".$_GET['rewrite4']."' ORDER BY c.orden DESC ");

// data puntual
$alumn = executesql("SELECT * FROM suscritos_x_cursos WHERE estado_idestado = 1 AND id_curso = '".$curso[0]['id_curso']."'");

if( !empty($curso[0]['id_pro']) ){
	$profe = executesql("SELECT * FROM profesores WHERE id_profesor IN (".$curso[0]['id_pro'].") ORDER BY id_profesor DESC");
}
$fecha= date('m\/Y ',strtotime($curso[0]['fecha_actualizacion']));
$mes= date('m',strtotime($curso[0]['fecha_actualizacion']));
$mes_actual = date("m");



// si tiene especiales .. capturamos y agrupamos en HTML para el carrito ..
$_data_ides_especialidades="";
$_data_cursos_especiales="";
if( !empty($curso[0]['cursos_especialidades']) ){ 
	
	$sql_especiales="select c.* from cursos c 
					INNER JOIN especialidades esp ON c.id_especialidad=esp.id_especialidad 
					WHERE c.estado_idestado=1 and c.id_curso IN (".$curso[0]['cursos_especialidades'].") and esp.id_especialidad='".$especialidad_del_cliente."' 
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
			
			$_data_cursos_especiales.="<div class='detalle'><figure class='img-cesta rel'><img src='tw7control/files/images/capa/".$anexo_especiales["imagen2"]."'><div class='capa abs'></div></figure><div class='delete_curso text-center '></div><div class='titulo'><p class='poppi-b color1'>".$anexo_especiales["codigo"].' - '.$anexo_especiales["titulo"]."</p></div></div>";	
			$n_esp++;   
			
		}
	}
}


// si tiene dependientes .. capturamos y agrupamos en HTML para el carrito ..
$_data_cursos_dependientes="";
if( !empty($curso[0]['cursos_dependientes']) ){
	// $sql_dependientes="select c.*, p.titulo as profe from cursos c INNER JOIN profesores p ON c.id_pro=p.id_profesor where c.estado_idestado=1 and c.id_curso IN (".$curso[0]['cursos_dependientes'].") order by c.titulo asc ";
	$sql_dependientes="select c.* from cursos c  where c.estado_idestado=1 and c.id_curso IN (".$curso[0]['cursos_dependientes'].") order by c.titulo asc ";

	$dependientes=executesql($sql_dependientes);
	if( !empty($dependientes) ){
		foreach( $dependientes as $anexo ){
			$_data_cursos_dependientes.="<div class='detalle'><figure class='img-cesta rel'><img src='tw7control/files/images/capa/".$anexo["imagen2"]."'><div class='capa abs'></div></figure><div class='delete_curso text-center '></div><div class='titulo'><p class='poppi-b color1'>".$anexo["codigo"].' - '.$anexo["titulo"]."</p></div></div>";
			
					/* si este dependiente tiene especialidades tbm van de gratis ..  */
					if( !empty($anexo['cursos_especialidades']) ){ 
						
							$sql_especiales_dependientes="select c.* from cursos c 
																INNER JOIN especialidades esp ON c.id_especialidad=esp.id_especialidad 
																WHERE c.estado_idestado=1 and c.id_curso IN (".$anexo['cursos_especialidades'].") and esp.id_especialidad='".$especialidad_del_cliente."' 
																ORDER by c.titulo asc ";
															
							$especiales_dentro_de_packs=executesql($sql_especiales_dependientes);
							if( !empty($especiales_dentro_de_packs) ){
								$n_esp=0;
								foreach( $especiales_dentro_de_packs as $anexo_especiales ){
									if($n_esp==0){
										$_data_ides_especialidades=$anexo_especiales['id_curso'];
									}else{
										$_data_ides_especialidades=$_data_ides_especialidades.','.$anexo_especiales['id_curso'];				
									}
									
									$_data_cursos_especiales.="<div class='detalle'><figure class='img-cesta rel'><img src='tw7control/files/images/capa/".$anexo_especiales["imagen2"]."'><div class='capa abs'></div></figure><div class='delete_curso text-center '></div><div class='titulo'><p class='poppi-b color1'>".$anexo_especiales["codigo"].' - '.$anexo_especiales["titulo"]."</p></div></div>";	
									$n_esp++;   
									
								}
							} /* end si curso pack tuvo especialidades */
					} /* end especialidade de curso dependiente */
		
		}
	}
}
/* end packs :: dependientes */



?>
    <div class="callout callout-10 "><div class="row">
			<div class="large-8  medium-7  columns">
			<?php  
			/* detecto que tipo de cirso es, segun eso mofifico la ruta del link:  */
			if($curso[0]['tipocurso']==1){
					$ruta='curso/todos/';
			}else if($curso[0]['tipocurso']==2){
					$ruta='libro/todos-los-libros/';
			}else if($curso[0]['tipocurso']==3){
					$ruta='libro/todos-los-libros-coautoria/';
			}else{
					$ruta='error_tipo_curso';
			}
			?>
				
				<blockquote class="cabezera_menu poppi "><?php  echo '<a href="'.$ruta.$curso[0]['catrewri'].'">'.$curso[0]['categoria'].' </a> / <a href="'.$ruta.$curso[0]['subrewri'].'">'.$curso[0]['subcategoria'].'</a>'?></blockquote>

					<!-- IMG PARA PACKS -->
					<?php 
					if( !empty($curso[0]['cursos_dependientes']) ){ 
						if( !empty($curso[0]['imagen_4']) ){ // nueva imagen para detalle
							$imgproduct= 'tw7control/files/images/capa/'.$curso[0]['imagen_4'];
						}else if( !empty($curso[0]['imagen2']) ){ 
							$imgproduct= 'tw7control/files/images/capa/'.$curso[0]['imagen2'];
						}else{
							$imgproduct= 'img/not_img_curso.jpg';
						}
					?>
					<figure class="rel lleva_img_principal ">
						<figcaption  class=" hide " >COD: <?php echo $curso[0]['codigo'] ?></figcaption>
						<img src="<?php echo $imgproduct ?>" class="principal ">
					</figure>
					
					<?php 						
					}					
					?>
					
				
				<?php 	
				if( empty($curso[0]['cursos_dependientes']) ){  /* si tiene cusos dependientes es un PACKs: Aqui mostramos packs */ 	// Dependientes  ?>
				
					<?php 
						//if(!empty( $curso[0]['link_video']) && empty($curso[0]['imagen_4']) ){  /* video trailer */ 
						if(!empty( $curso[0]['link_video'])  ){  /* video trailer, si llevva video saldra directo  */ ?>
							<div class="rel lleva_vimeo_listado">
								<iframe src="	<?php echo $curso[0]['link_video']; ?>"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
							</div>
					<?php }else{  // si solo tiene  imagen  
						
							if( !empty($curso[0]['imagen_4']) ){ // nueva imagen para detalle
								$imgproduct= 'tw7control/files/images/capa/'.$curso[0]['imagen_4'];
							}else if( !empty($curso[0]['imagen2']) ){ 
								$imgproduct= 'tw7control/files/images/capa/'.$curso[0]['imagen2'];
							}else{
								$imgproduct= 'img/not_img_curso.jpg';
							}
						
					?>
							<figure class="rel lleva_img_principal ">
								<figcaption class=" hide ">COD: <?php echo $curso[0]['codigo'] ?></figcaption>
								<img src="<?php echo $imgproduct ?>" class="principal ">
						<?php if(!empty( $curso[0]['link_video'])){  /* video trailer */ ?>
								<!--  <a class="abs mpopup-02" href="<?php echo $curso[0]['link_video'] ?>"><img src="img/iconos/ico-play.png" class="verticalalignmiddle"></a> * video poup  -->
								<!--  ** ya no va lo de trailer videos por ahora abril-2024 
								<a class="abs mpopup-03 " href="trailers/<?php echo $curso[0]['id_curso'] ?>"><img src="img/iconos/ico-play.png" class="verticalalignmiddle"></a>
								-->
						<?php }  ?>
							</figure> 				

					<?php }  // end validation imagenes  ?>			
				<?php } /* end si no tiene depemientes */ ?>
			</div>
						
			<div class="large-4 medium-5  columns"><div class="contiene_datos_compra ">
				<?php // if(!isset($_SESSION["suscritos"]["id_suscrito"])){ //  include("inc/formulario_registro_banner.php"); }  ?>				
				<h1 class="poppi azul  titulo_curso_formulario_de_compra hide "><?php echo (( !empty($curso[0]['cursos_dependientes']) )?'<b>Pack:</b> ':'').$curso[0]['titulo'] ?>	</h1>
				<?php  
				$pagina_open="";
				include("formulario_de_compra_2024_abril.php");   
				?>
			</div></div>
    </div></div>
		
<div class="callout callout-11 <?php echo  (!empty($curso[0]['cursos_dependientes'])) ?' css_si_pack ':'';?> "    style=" <?php echo (!isset($_SESSION["suscritos"]["id_suscrito"]))?'/* margin-top: -450px; */ ':''; ?> "  >  <div class="row">
        <div class="large-8 medium-7 columns">
			<h1 class="poppi-b  color1  titulo_curso_formulario_de_compra   "><?php echo (( !empty($curso[0]['cursos_dependientes']) )?'<b>Pack:</b> ':'').$curso[0]['titulo'] ?>	</h1>
		<?php 	if( !empty($curso[0]['cursos_dependientes']) ){  /* si tiene cusos dependientes es un PACKs: Aqui mostramos packs */ 
				// Dependientes  ?
					$sql_relacionados="SELECT c.*, ca.titulo_rewrite AS catrewri, sc.titulo_rewrite AS subrewri,  tc.titulo_rewrite AS tiprewri,   c.id_tipo AS tipocurso FROM cursos c INNER JOIN categoria_subcate_cursos csc ON 	c.id_curso = csc.id_curso 
					INNER JOIN categorias ca ON csc.id_cat = ca.id_cat  
					INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub 
					INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo 
					WHERE c.estado_idestado = 1   and c.id_curso IN (".$curso[0]["cursos_dependientes"].")  
					ORDER BY c.orden desc  ";				
					// echo $sql_relacionados;
		
					$cur = executesql($sql_relacionados);
				if(!empty($cur)){ ?>
				<h4 class="poppi color1 " style="padding-bottom:40px; 	<?php echo (!isset($_SESSION["suscritos"]["id_suscrito"]))?' /*margin-top: -380px; */ ':''; ?>  "> <small class="azul ">Este pack incluye los siguientes cursos: </small></h4>
					<?php foreach($cur as $detalles){
					$titulo=$detalles['titulo'];
					$link='curso/'.$detalles['catrewri'].'/'.$detalles['catrewri'].'/'.$detalles['subrewri'].'/'.$detalles['titulo_rewrite'];
					$imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen2'];
			?>
				<div class="large-6  medium-12  columns end cursio listado_cursos_del_pack " style="padding:5px;">
					<?php include("inc/curso.php") ?>
				</div>
		<?php
				} }
			/* end  if si tiene dependietnes */
		?>
			
		<?php 	}else{  /*Muestro el detalle del curso, de los cursos que NORMALES, que no tienen cursos Dependientes */  ?>
											
				<?php if( !empty($curso[0]['breve_detalle']) ){  // Presentación ?> 
					<div class="poppi texto breve_detalle  rel"><?php echo $curso[0]['breve_detalle']; ?></div>
					<p class="poppi-b mos texto"></p>
				<?php  } ?>																					

			<?php  if(!empty($curso[0]['link_grupo_wasap'])  && $_GET["rewrite"] != "libros" ){ ?>													
				<div class="parte-medio text-center " style="margin-top:10px;">
					<a href="<?php echo $curso[0]['link_grupo_wasap']; ?>" title="  canal_wsp_flota" target="_blank" class=" canal_wsp_flota  poppi  "  >
						<img src="img/iconos/ws.png" alt="Únete a nuestro  canal de whatsApp "> Descubre nuestras promociones<span> Chat en vivo</span>
					</a>
				</div>
			<?php   /* 
			}else{  ?>
				<div class="parte-medio text-center " style="margin-top:10px;">
					<a href="<?php echo $link_grupo_wasap; ?>" title="  canal_wsp_flota" target="_blank" class=" canal_wsp_flota  poppi  "  >
						<img src="img/iconos/ws.png" alt="Únete a nuestro  canal de whatsApp "> Únete al canal de whatsApp <span>de Grupo Auge  </span>
					</a>
				</div>				
			<?php 
		 */ 
					}  
		?>

		<?php 
			/*   valido sino es libro sale esta info */  
			if( $_GET["rewrite"] == "libros"){ 		?>

<div class="parte-medio text-center " style="margin-top:10px;">
					<a href="https://bit.ly/3Uw3Nrb" title="  canal_wsp_flota" target="_blank" class=" canal_wsp_flota  poppi  "  >
						<img src="img/iconos/ws.png" alt="Únete a nuestro  canal de whatsApp "> Contáctate con una ejecutiva de ventas <b>Click aquí</b> 
					</a>
				</div>
				
	<?php 	
			}


			if( $_GET["rewrite"] != "libros"){ 			
		?> 


			<div class=" lleva_cuadro_frecuencia text-center ">
				<div class=" _contiene_datos_frecuencia " >
					<div class=" cuadro_frecuencia  _fondo_rojo   " >
						<img src="img/iconos/frecuencia_vineta_2.png" class=" _vineta ">
						<div class="text-justify poppi ">
							<h4 class="poppi-b ">DIRIGIDO A:</h4>							
							<p>  <?php echo !empty($curso[0]['inicio'])? $curso[0]['inicio'] : 'Profesionales en educación y áreas relacionadas interesados en el proceso de nombramiento docente.'; ?>   </p>
						</div>						
					</div>
					<div class=" cuadro_frecuencia  poppi    " >
						<img src="img/iconos/frecuencia_vineta_1.png" class=" _vineta ">
						<div class="text-justify ">
							<h4 class="poppi-b ">FRECUENCIA:</h4>
							<p>  <?php echo $curso[0]['frecuencia']; ?>   <Br> <span class=" poppi-b "> <?php echo $curso[0]['horario']; ?></span></p>
						</div>						
					</div>
					<div class=" cuadro_frecuencia     " >
						<img src="img/iconos/frecuencia_vineta_1.png" class=" _vineta ">
						<div class="text-justify poppi ">
							<h4 class="poppi-b ">DURACIÓN:</h4>
							<p> Este módulo tiene una duración de <Br> <span class=" poppi-b ">  <?php echo $curso[0]['duracion']; ?></span></p>
						</div>						
					</div>
					<div class=" cuadro_frecuencia  poppi  _fondo_rojo  " >
						<img src="img/iconos/frecuencia_vineta_2.png" class=" _vineta ">
						<div class="text-justify ">
							<h4 class="poppi-b ">MODALIDAD:</h4>
							<p class=" text-left "><?php echo $curso[0]['modalidad_texto']; ?> <img src="img/iconos/zoom_detalle_clase.png"></p>
						</div>						
					</div>
				</div>				
			</div>
			
			<div class=" lleva_cuadro_requisitos text-center ">
				<div class=" _contiene_datos_frecuencia " >
					<div class=" cuadro_requisito  _fondo_oscuro   " >
						<div class="text-justify poppi ">
							<h4 class="poppi-b text-center "> <img src="img/iconos/frecuencia_vineta_2.png" style=" padding-right:8px; ">REQUISITOS:</h4>
							<p> Para el desarrollo óptimo de las sesiones de nuestro curso de nombramiento es indispensable que el docente cuente con:</p>
						</div>						
					</div>
					<div class=" cuadro_requisito  poppi-sb   _fondo_gris " >
						<div class="text-center ">	<p>  Acceso a internet </p> </div>						
					</div>
					<div class=" cuadro_requisito " >
						<div class="text-center poppi-sb "> <p>  Laptop / PC / Tablet / Otros </p> </div>						
					</div>					
				</div>				
			</div>
				
			<?php /* 
				<?php if( !empty($curso[0]['inicio']) ){ ?>
				<hr>
				<h4 class="poppi-b azul ">Inicio:</h4>
				<div class="poppi texto rel"><?php echo $curso[0]['inicio']; ?></div>
				<p class="poppi-b mos texto"></p>
				<?php  } ?>				

	
				<?php if( !empty($curso[0]['beneficios']) ){ ?>
				<hr>
				<h4 class="poppi-b azul ">Beneficios:</h4>
				<div class="poppi texto rel"><?php echo $curso[0]['beneficios']; ?></div>
				<p class="poppi-b mos texto"></p>
				<?php  } ?>				
				
				<?php if( !empty($curso[0]['inversion']) ){ ?>
					<hr>
				<h4 class="poppi-b azul ">Inversión:</h4>
				<div class="poppi texto rel"><?php echo $curso[0]['inversion'];?> </div>
				<p class="poppi-b mos texto"></p>
				<?php  } ?>				
				
				
				<?php if( !empty($curso[0]['matricula']) ){ ?>
				<hr>
				<h4 class="poppi-b azul ">Matrícula:</h4>
				<div class="poppi texto rel"><?php echo $curso[0]['matricula'];?> </div>
				<p class="poppi-b mos texto"></p>
				<?php  } ?>				
				
				<?php if( !empty($curso[0]['certificacion']) ){ ?>
				<hr>
				<h4 class="poppi-b azul ">Certificación:</h4>
				<div class="poppi texto rel"><?php echo $curso[0]['certificacion'];?> </div>
				<p class="poppi-b mos texto"></p>
				<?php  } ?>				
				
				<?php if( !empty($curso[0]['modulos']) ){  ?>
				<hr>
				<h4 class="poppi-b azul ">Contenido:</h4>
				<div class="poppi texto rel _contenido "><?php echo $curso[0]['modulos'];?></div>
				<p class="poppi-b mos texto"></p>
				<?php  } ?>		
				
				*/ ?>
			<?php 

				}/** ebnd valido sino es libro  */

			} // end detallle de curso normales ?>
		</div> <!-- end L8 -->
		<div class="large-4 meium-5 columns lleva_relacionados "> <!-- L4 dependientes  -->	
			<!-- se mostraban relacionados ; pero se separaron en seccion packs  -->
		</div> <!-- L4 detalle Dependientes -->	

</div></div> <!-- calloiut -#11 -->
			
<?php 		if( $_GET["rewrite"] != "libros"){ 	/*   valido sino es libro sale esta info */  	?> 
<div class="callout callout-12 poppi-sb "><div class="row">		
	<div class=" large-8   columns">
		<div class=" large-12   columns">
			<div class="_encabezadas text-left "> <h3 class="poppi-b "> Razones para <span>ELEGIRNOS</span> </h3></div>
		</div>																				
		<div class=" large-3 medium-4 small-6 columns text-center  end ">
			<figure><img src="img/iconos/razones_1.png"></figure>
			<p> Aprende a tu ritmo</p>
		</div>																				
		<div class=" large-3 medium-4 small-6 columns text-center end  ">
			<figure><img src="img/iconos/razones_2.png"></figure>
			<p>  De la mano del docente</p>
		</div>																				
		<div class=" large-3 medium-4 small-6 columns text-center  end ">
			<figure><img src="img/iconos/razones_3.png"></figure>
			<p> Profesores expertos</p>
		</div>																				
		<div class=" large-3 medium-4 small-6 columns text-center end  ">
			<figure><img src="img/iconos/razones_4.png"></figure>
			<p>  Certificado por curso</p>
		</div>																				
		<div class=" large-3 medium-4 small-6 columns text-center end  ">
			<figure><img src="img/iconos/razones_5.png"></figure>
			<p>  En  primera fila</p>
		</div>																				
		<div class=" large-3 medium-4 small-6 columns text-center end  ">
			<figure><img src="img/iconos/razones_6.png"></figure>
			<p>  Comparte conocimiento</p>
		</div>																				
		<div class=" large-3 medium-4 small-6 columns text-center end  ">
			<figure><img src="img/iconos/razones_7.png"></figure>
			<p>  Red de contactos</p>
		</div>																				
		<div class=" large-3 medium-4 small-6 columns text-center end  ">
			<figure><img src="img/iconos/razones_8.png"></figure>
			<p>  Cursos producidos profesionalmente</p>
		</div>																				
	</div>																				
</div></div>
<?php } ?> 


<?php 	if( empty($curso[0]['cursos_dependientes']) && $_GET["rewrite"] != "libros"  ){  // sino es pack mostramos esto info   ?>

<div class="callout callout-13 poppi "><div class="row">		
	<div class=" large-8  text-center  columns">
	<?php if( $curso[0]['id_cat'] != 16 ){   // id_cat=116 razonamiento mate. no aparece esta seccion  ?>
		<h3 class="poppi-b text-left ">  Cursos Generales </h3>
		<div class=" row "> 
			<div class=" large-3 medium-6 small-6  text-center  columns   _lleva_circulos_generales end ">
				<figure class=" text-center "><img src="img/circulo_detalle_item_1.png"></figure>
				<p class=" poppi-sb ">Conocimientos pedagógicos  </br> y curriculares</p>
			</div>
			<div class=" large-3 medium-6 small-6  text-center  columns _lleva_circulos_generales end ">
				<figure class=" text-center "><img src="img/circulo_detalle_item_2.png"></figure>
				<p class=" poppi-sb "> Compresión  </br> lectora</p>
			</div>
		
		<?php if( $curso[0]['id_cat'] != 2 ){   // id_cat=116 para ascenso no aparece  esta seccion  ?>
			<div class=" large-3 medium-6 small-6  text-center  columns _lleva_circulos_generales end ">
				<figure class=" text-center "><img src="img/circulo_detalle_item_3.png"></figure>
				<p class=" poppi-sb ">Razonamiento lógico </br> matemático</p>
			</div>
		<?php }  ?>	

			<div class=" large-3 medium-6 small-6  text-center  columns _lleva_circulos_generales end ">
				<figure class=" text-center "><img src="img/circulo_detalle_item_4.png"></figure>
				<p class=" poppi-sb ">Curso según </br> especialidad</p>
			</div>
		</div>
	<?php } ?>	

		<h3 class="poppi-b text-left _espe ">  Especialidades   </h3>
		<div class=" large-12  _contiene_cajas_silabos columns nothing ">
<?php 
	$sql_silabos = "SELECT cv.*,e.nombre AS estado , esp.titulo as especialidad , pp.titulo as profesor 
	FROM silabos cv
	LEFT JOIN profesores pp ON cv.id_profesor = pp.id_profesor   
	INNER JOIN especialidades esp ON cv.id_especialidad = esp.id_especialidad  
	INNER JOIN estado e ON cv.estado_idestado=e.idestado  
	WHERE  cv.id_curso=".$curso[0]['id_curso']." and cv.estado_idestado=1 order by cv.orden desc ";
	$silabos = executesql($sql_silabos);
	$z=1;
	if(!empty( $silabos )){
		foreach($silabos as $_data_silabos ){
			if( $z ==4 ){ $z=1; }
	?>
				<div class=" _listado_silabos _fonso_silabo_<?php echo $z; ?> text-left blanco ">
					<div class=" text-center lleva_3_puntos ">
						<img src="img/iconos/3_puntos_blanco_<?php echo $z; ?>.png">
					</div>
					<div class=" lleva_dato_intro ">
						<h2 class=" poppi-sb "> <?php echo $_data_silabos["titulo"]; ?></h2>
						<p class=" poppi "> <?php echo $_data_silabos["profesor"]; ?></p>
					</div>
					<div class=" _btn_ver_temario text-right ">				
						<a id="id-<?php echo $_data_silabos["id_silabo"]; ?>"class=" poppi-b btn mostrar_temario "> VER <span>TEMARIO</span> »</a>
					</div>
				</div>
				<!-- ventana flota -->
				<div class=" listado_temario   temario_<?php echo $_data_silabos["id_silabo"]; ?>  hide " >
					<div class=" _contenido_silabo_flotante  " >
						<div class=" large-12 columns text-center nothing " >
							<figure class=" text-right _cerrar_mostrar_temario "><img src="img/iconos/cerrar_silabo.png"></figure>
							<blockquote class=" poppi color1 text-left _subtitulo"> <img src="img/iconos/icon_flota_silabo.png"><?php echo $curso[0]["titulo"]; ?> / <b> <?php echo $_data_silabos["especialidad"]; ?></b></blockquote>
							<figure class=" text-right _logo_auge_silabo "><img src="img/logo_silabo.png"></figure>
						</div>
						<div class=" large-10 large-centered medium-11 medium-centered columns text-justify " >
							<h2 class=" poppi-b color1 text-center "><?php echo $_data_silabos["titulo"]; ?></h2>
							<div class=" _subrayado_center "></div>
							<div class=" _contiene_des_temario  ">
								<?php echo $_data_silabos["descripcion"]; ?>
								<?php if( !empty($_data_silabos["imagen"]) ){ ?>
									<figure><img src="tw7control/files/images/silabos/<?php echo $_data_silabos["imagen"]; ?>"></figure>
								<?php } ?>
							</div>
							<blockquote class=" poppi color1 text-right _lleva_name_docente " > <img src="img/iconos/ico_docente_silabo.png" style="padding-right:7px;"><b>DOCENTE:</b> <?php echo $_data_silabos["profesor"]; ?></blockquote>
						</div>	
						<div class=" large-12 columns text-right " >
							<img src="img/iconos/icon_flota_silabo.png">
						</div>			
					</div>
				</div>
<?php 
			$z++;
		} // for silabo
	} // if temarios ?>
		</div>	<!-- end contien_cajas-->

		<!-- slidder docentes -->
		<h3 class="poppi-b colo1 text-left "> <?php echo ($_GET['rewrite'] !="libros" )? 'Docentes:' : 'Autores' ; ?> </h3>
		<?php  $portada = executesql("SELECT * FROM portada where id=1 ");   ?>
		<!-- <p class="poppi " style="padding-bottom:40px;"> <?php echo $portada[0]["detalle_titulo_docentes"]; ?>  </p> -->
		<div class="contiene_slider docentes rel "> 				
			<div class=" contiene_sesiones_listado  "> 
<?php 
	if( !empty($profe)){    // multiples profes .. 
		echo '<ul class="carousel-docente-curso no-bullet" >';
		foreach($profe as $dataprofes){ 
?>
				<li>
					<div class="large-5 medium-5 columns ">
						<img src="<?php echo "tw7control/files/images/profesores/".$dataprofes['imagen']; ?>">
					</div>
					<div class=" large-7 medium-7 columns text-left ">
						<h4 class="poppi-b color1 ">
							<img src="img/iconos/icon_docente_slider_detalle_curso.png">
							<?php echo $dataprofes['titulo'] ?>
						</h4>
						<?php echo !empty($dataprofes['descripcion']) ? '<div class="data_finder" >'.$dataprofes['descripcion'].'</div>' : '' ?>
					</div>
				</li>
<?php
			}
			echo '</ul>';
		} // if temarios
?>
			</div>
		</div>	
		<!-- end docentes slider -->

		<?php  if( $_GET["rewrite"] != "libros" ){ ?>
		<div class=" section_certificacion">
			<h3 class="poppi-b colo1 text-center "> Certificación</h3>
			<div class="large-4 medium-5 columns text-center ">
				<img src="img/img_certificacion.png">
			</div>
			<div class=" large-8 medium-7 columns text-justify _detalle_certificacion ">
				<p>	<?php echo $curso[0]['certificacion'];?>  </p>
			</div>
		</div>
		<?php } ?> 

	</div> <!-- end l8 -->	
</div></div>	
<?php } // end info sino es pack ?>



<?php 
if( $_GET["rewrite"] != "libros" ){

 $exitos=executesql(" select * from casos_de_exitos where estado_idestado=1 order by orden desc ");
// $exitos=executesql("SELECT * FROM testimonios WHERE estado_idestado = 1 and tipo=1 and link !=''   ORDER BY orden DESC limit 0,8  ");
if( !empty($exitos)){  ?>
<div class="callout callout-14 poppi "><div class="row"><div class=" large-8 columns ">
	<div class=" casos_exito text-center " >
		<h3 class="poppi-b blanco text-center "> TESTIMONIOS</h3>
		<div class=" _subrayado_center "></div>
		<div class=" _contenedor_listado_testi rel  "> 
			<div class="clientes text-center ">
				<div class="lSAction"><a class="lSPrev" title="regresar"></a><a class="lSNext" title="avanzar"></a></div>
			</div>
			<div class=" contiene_listado_testimonios  "> 
				<ul class=" carousel_1_detalle_curso_tetsimonio  no-bullet ">
<?php foreach( $exitos as $row ){		 
		if( !empty($row["imagen"])){ ?>
					<div class=" _contiene_testimonio" >
						<figure  CLASS="rel">
							<img src="tw7control/files/images/casos_de_exitos/<?php echo $row['imagen'] ?>" class="imagen_1" style="width:100%;">
								<?php if(!empty($row["link"]) ){ ?>
							<a class="abs mpopup-02" href="<?php echo $row['link'] ?>"><img src="img/iconos/ico_play_detalle_curso_2024_abril.png" class="verticalalignmiddle"></a>
								<?php }?>

						</figure>
						<div class="lleva_name_testi text-left ">
							<p class="poppi-b texto ">	
								<span class="poppi-sb ">DOCENTE</span>
								<?php echo $row['titulo']; ?> 
							</p>
						</div>
					</div>
<?php	} /* si registor un img  */ 
	} /*for exitos */?>
				</ul>				
			
			</div>
		</div>
	</div>
</div> </div></div>	<!-- end tetsimonios -->
<?php } ?>
<?php }  // en validarion lidro ?>


<?PHP /*
<div class="callout callout-12 "><div class="row">																						
	<?php   $pestañas=executesql("select * from pestanhas where estado_idestado=1 and id_curso='".$curso[0]['id_curso']."' order by orden asc ");
				if( !empty($pestañas) ){
				foreach($pestañas as $detalle_pestana){
?>
				<hr>
				<h4 class="poppi-b azul "><?php echo $detalle_pestana['titulo']; ?></h4>
				<?php echo !empty($detalle_pestana['descripcion']) ? '<div class="poppi texto rel">'.$detalle_pestana['descripcion'].'</div>' : '' ?>
				<p class="poppi-b mos texto"></p>
				
				<?php  } }// for ?>
</div></div>				
*/ ?>			


	<div class="callout callout-15 _callout_formas_de_pago_offline "><div class="row">	<div class="large-8 columns ">
		<?php  include("inc/inc_formas_de_pago.php"); ?>
						
	</div></div></div> <!-- L8 forma de pago -->	
		