<?php 
$curso = executesql(" SELECT c.*, ca.titulo as categoria, ca.titulo_rewrite AS catrewri, sc.titulo as subcategoria, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso INNER JOIN categorias ca ON csc.id_cat = ca.id_cat INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo WHERE c.estado_idestado = 1  and c.titulo_rewrite = '".$_GET['rewrite4']."' ORDER BY c.orden DESC ");

// data puntual
$alumn = executesql("SELECT * FROM suscritos_x_cursos WHERE estado_idestado = 1 AND id_curso = '".$curso[0]['id_curso']."'");

if( !empty($curso[0]['id_pro']) ){
$profe = executesql("SELECT * FROM profesores WHERE id_profesor IN (".$curso[0]['id_pro'].") ");
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
				
				<blockquote class="cabezera_menu"><?php  echo '<a href="'.$ruta.$curso[0]['catrewri'].'">'.$curso[0]['categoria'].' </a> / <a href="'.$ruta.$curso[0]['subrewri'].'">'.$curso[0]['subcategoria'].'</a>'?></blockquote>

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
						<figcaption>COD: <?php echo $curso[0]['codigo'] ?></figcaption>
						<img src="<?php echo $imgproduct ?>" class="principal ">
					</figure>
					
					<?php 						
					}					
					?>
					
				
				<?php 	
				if( empty($curso[0]['cursos_dependientes']) ){  /* si tiene cusos dependientes es un PACKs: Aqui mostramos packs */ 	// Dependientes  ?>
				
					<?php 
						if(!empty( $curso[0]['link_video']) && empty($curso[0]['imagen_4']) ){  /* video trailer */ ?>
							<div class="rel lleva_vimeo_listado">
								<iframe src="	<?php echo $curso[0]['link_video']; ?>"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
							</div>
					<?php }else{  //  imagen  
						
							if( !empty($curso[0]['imagen_4']) ){ // nueva imagen para detalle
								$imgproduct= 'tw7control/files/images/capa/'.$curso[0]['imagen_4'];
							}else if( !empty($curso[0]['imagen2']) ){ 
								$imgproduct= 'tw7control/files/images/capa/'.$curso[0]['imagen2'];
							}else{
								$imgproduct= 'img/not_img_curso.jpg';
							}
						
					?>
							<figure class="rel lleva_img_principal ">
								<figcaption>COD: <?php echo $curso[0]['codigo'] ?></figcaption>
								<img src="<?php echo $imgproduct ?>" class="principal ">
						<?php if(!empty( $curso[0]['link_video'])){  /* video trailer */ ?>
								<!-- 
								<a class="abs mpopup-02" href="<?php echo $curso[0]['link_video'] ?>"><img src="img/iconos/ico-play.png" class="verticalalignmiddle"></a>
								-->
								<a class="abs mpopup-03 " href="trailers/<?php echo $curso[0]['id_curso'] ?>"><img src="img/iconos/ico-play.png" class="verticalalignmiddle"></a>
						<?php }  ?>
							</figure> 				

					<?php }  // end validation imagenes  ?>



						<!-- 
							<div class="unete_wasap text-center ">
								<a href="https://api.whatsapp.com/send?phone=5117075755&text=Hola%20quiero%20informaci%C3%B3n%20sobre%20los%20cursos%20del%20Grupo%20AUGE" target="_blank">
									<img src="img/iconos/unete_wasap.png">
								</a>
							</div>
							-->
				
					<div id="compi" >
						<ul class="no-bullet poppi  color1">
								<li class="poppi float-left ">
									<em style="display:inline-block;padding-right:10px;">Compartir: </em> 
									<a title="Twitter" href="javascript: void(0);" onclick="window.open('https://twitter.com/intent/tweet?text=&url='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/twitter-b.png"></a>
									<a title="Facebook" href="javascript: void(0);" onclick="window.open('http://www.facebook.com/sharer.php?u='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/face-b.png"></a>
									<a title="Telegram" href="javascript: void(0);" onclick="window.open('https://telegram.me/share/url?url='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/telegram-b.png"></a> 
									<a href="https://api.whatsapp.com/send/?phone&text=<?php echo 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" target="_blank"><img src="img/iconos/wsp-b.png" style="margin-top:;"></a>
								</li>
								<?php if(!empty($curso[0]['link_grupo_wasap']) ){ ?>
								<li class="float-right ">
									<a href="<?php echo $curso[0]['link_grupo_wasap']; ?>"  class="unete_wsp" target="_blank">
										<img src="img/iconos/unete_wasap.png">
									</a>
								</li>
								<?php } ?>
						</ul>
					</div>
				<?php } /* end si no tiene depemientes */ ?>
			</div>
						
			<div class="large-4 medium-5  columns"><div class="contiene_datos_compra ">
				<?php
					if(!isset($_SESSION["suscritos"]["id_suscrito"])){
							//  include("inc/formulario_registro_banner.php"); 
					}
				?>
				
				<h1 class="poppi azul ">
					<?php echo (( !empty($curso[0]['cursos_dependientes']) )?'<b>Pack:</b> ':'').$curso[0]['titulo'] ?>
					<!--
					<small class="color1 poppi"> <?php echo $curso[0]['codigo']; ?></small>
					-->
				</h1>
				<?php 
					include("formulario_de_compra.php"); 
				?>
			</div></div>
    </div></div>
		

    <div class="callout callout-11 <?php echo  (!empty($curso[0]['cursos_dependientes'])) ?' css_si_pack ':'';?> "    style=" <?php echo (!isset($_SESSION["suscritos"]["id_suscrito"]))?'/* margin-top: -450px; */ ':''; ?> "  >   
			<div class="row">
        <div class="large-8 medium-7 columns">
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
						<h4 class="poppi azul " style="padding-bottom:40px; 	<?php echo (!isset($_SESSION["suscritos"]["id_suscrito"]))?' /*margin-top: -380px; */ ':''; ?>  "> <small class="azul ">Este pack incluye los siguientes cursos: </small></h4>
					


							<?php foreach($cur as $detalles){
							$titulo=$detalles['titulo'];
							$link='curso/'.$detalles['catrewri'].'/'.$detalles['catrewri'].'/'.$detalles['subrewri'].'/'.$detalles['titulo_rewrite'];
							$imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen2'];
			?>
            <div class="large-4  medium-6   columns end cursio listado_cursos_del_pack " style="padding:5px;">
            <?php include("inc/curso.php") ?>
            </div>
		<?php
								} }
			/* end  if si tiene dependietnes */
		?>
			
		<?php 	}else{  /*Muestro el detalle del curso, de los cursos que NORMALES, que no tienen cursos Dependientes */  ?>
				
				
				<!--
				<ol class="no-bullet">
						<li><p class="texto poppi-b"><img src="img/iconos/corazon.png">Me gusta</p></li>
						<li><p class="texto poppi-b"><img src="img/iconos/regalo.png">Regalar</p></li>
						<li class="rel"><p class="texto poppi-b"><a onclick="compi();" style="color:#7a7a7a"><img src="img/iconos/compa.png">Compartir</a></p>
								<div id="compi" style="display:none;position: absolute;width: 196px; top: -62px;">
								<ul class="no-bullet color1">
									<li class="poppi"><a title="Twitter" href="javascript: void(0);" onclick="window.open('https://twitter.com/intent/tweet?text=&url='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/twitter-b.png"></a> <a title="Facebook" href="javascript: void(0);" onclick="window.open('http://www.facebook.com/sharer.php?u='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/face-b.png"></a> <a title="Telegram" href="javascript: void(0);" onclick="window.open('https://telegram.me/share/url?url='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/telegram-b.png"></a> <a href="https://api.whatsapp.com/send/?phone&text=<?php echo 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" target="_blank"><img src="img/iconos/wsp-b.png" style="margin-top:10px;"></a></li>
								</ul></div>
						</li>
				</ol>
						-->
				<?php if( !empty($curso[0]['descripcion']) ){  ?> 
					<h4 class="poppi-b azul " style="padding-top:30px;">Presentación</h4>
					<div class="poppi texto rel"><?php echo $curso[0]['descripcion']; ?></div>
					<p class="poppi-b mos texto"></p>
				<?php  } ?>				
				

				<div class="parte-medio text-center " style="margin-top:10px;">
					<a href="<?php echo $link_grupo_wasap; ?>" title="  canal_wsp_flota" target="_blank" class=" canal_wsp_flota  poppi  "  >
						<img src="img/iconos/ws.png" alt="Únete a nuestro  canal de whatsApp "> Únete al canal de whatsApp <span>de Grupo Auge  </span>
					</a>
				</div>


				<?php /*
				<div class=" datos_anexos_en_vivo blanco text-center ">
						<?php // frecuencia y clases  
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
						<?php } ?>
						<?php // frecuencia y clases  
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
				*/ ?>
				
				
				<?php if( !empty($curso[0]['inicio']) ){ ?>
				<hr>
				<h4 class="poppi-b azul ">Inicio:</h4>
				<div class="poppi texto rel"><?php echo $curso[0]['inicio']; ?></div>
				<p class="poppi-b mos texto"></p>
				<?php  } ?>				

				<?php if( !empty($curso[0]['frecuencia']) ){ ?>
				<hr>
				<h4 class="poppi-b azul ">Frecuencia:</h4>
				<div class="poppi texto rel"><?php echo $curso[0]['frecuencia'];?></div>
				<p class="poppi-b mos texto"></p>
				<?php  } ?>				
				
				<?php if( !empty($curso[0]['horario']) ){ ?>
				<hr>
				<h4 class="poppi-b azul ">Horario:</h4>
				<div class="poppi texto rel"><?php echo $curso[0]['horario'] ;?></div>
				<p class="poppi-b mos texto"></p>
				<?php  } ?>				
				
				<?php if( !empty($curso[0]['modalidad_texto']) ){ ?>
					<hr>
				<h4 class="poppi-b azul ">Modalidad:</h4>
				<div class="poppi texto rel"><?php echo $curso[0]['modalidad_texto']; ?></div>
				<p class="poppi-b mos texto"></p>
				<?php  } ?>				
				
				<?php if( !empty($curso[0]['duracion']) ){  ?>
				<hr>
				<h4 class="poppi-b azul ">Duración:</h4>
				<div class="poppi texto rel"><?php echo $curso[0]['duracion']; ?></div>
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
				
				
				
				<?php if( !empty($curso[0]['breve_detalle']) ){ ?>
				<hr>
				<h4 class="poppi-b azul ">Dirigido a:</h4>
				<div class="poppi texto rel"><?php echo $curso[0]['breve_detalle'];?> </div>
				<p class="poppi-b mos texto"></p>
				<?php  } ?>				
				
				
<!-- 
                    <div class="cuadro">
                        <p class="poppi texto rel"><img src="img/iconos/check.png">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed est magna. Donec rhoncus diam nec velit posuere tempor. </p>
                    </div>
-->
				
<?php 
				$ses = executesql("SELECT * FROM silabos WHERE estado_idestado = 1 AND id_curso = ".$curso[0]['id_curso']." ORDER BY ORDEN ASC");
				$z=1;
				if(!empty($ses)){
?>
				<hr>
				<h4 class="poppi-b azul ">Lecciones de curso: </h4>
				<div class="contiene_slider rel "> 
					<div class="clientes text-center ">
						<div class="lSAction"><a class="lSPrev"></a><a class="lSNext"></a></div>
					</div>
					<div class=" contiene_sesiones_listado  "> 
						<ul class="carousel-one no-bullet" >
<?php 					
					foreach($ses as $sesi){
?>
							<li>
								<h3 class="poppi-b azul"><?php echo $sesi['titulo'] ?></h3>
							<?php echo !empty($sesi['descripcion']) ? '<div class="data_finder" style="padding:15px 0 25px">'.$sesi['descripcion'].'</div>' : '' ?>
<?php
              // $det = executesql("SELECT * FROM detalle_sesiones WHERE estado_idestado = 1 AND id_sesion = ".$sesi['id_sesion']." ORDER BY orden asc ");
							// if(!empty($det)){ echo '<div class="lista">'; foreach($det as $deta){
?>
								<!--
								<p class="poppi texto clase rel"><img src="img/iconos/vi.png"><?php /* echo $z.'. '.$deta['titulo'] */ ?></p>
								-->
						
<?php
								// $z++;
							// } echo '</div>'; }
?>                        
							</li>
<?php
					} /* for */
?>
					 </ul>
					</div>
				</div>
				<hr>
<?php   } // if temarios
?>
				
<?php   $pestañas=executesql("select * from pestanhas where estado_idestado=1 and id_curso='".$curso[0]['id_curso']."' order by orden asc ");
				if( !empty($pestañas) ){
				foreach($pestañas as $detalle_pestana){
?>
				<hr>
				<h4 class="poppi-b azul "><?php echo $detalle_pestana['titulo']; ?></h4>
				<?php echo !empty($detalle_pestana['descripcion']) ? '<div class="poppi texto rel">'.$detalle_pestana['descripcion'].'</div>' : '' ?>
				<p class="poppi-b mos texto"></p>

<?php  } }// for ?>
				
				<hr>
			
				<h4 class="poppi-b azul "> 
					<?php echo ($_GET['rewrite'] !="libros" )? 'Plana Docente:' : 'Autores' ; ?> 
				</h4>
				<?php 
					$portada = executesql("SELECT * FROM portada where id=1 "); 		
				?>
				<p class="poppi " style="padding-bottom:40px;"> <?php echo $portada[0]["detalle_titulo_docentes"]; ?>  </p>


				<div class="contiene_slider docentes rel "> 
					<div class="clientes text-center ">
						<div class="lSAction"><a class="lSPrev"></a><a class="lSNext"></a></div>
					</div>
					<div class=" contiene_sesiones_listado  "> 
<?php 
			if( !empty($profe)){    // multiples profes .. 
				echo '<ul class="carousel-docente-curso no-bullet" >';
				foreach($profe as $dataprofes){ 
?>
						<li>
							<div class="large-4 medium-5 columns ">
								<img src="<?php echo "tw7control/files/images/profesores/".$dataprofes['imagen']; ?>">
							</div>
							<div class=" large-8 medium-7 columns ">
								<h3 class="poppi-b azul"><?php echo $dataprofes['titulo'] ?></h3>
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
				<hr>


<?php include("inc/inc_formas_de_pago.php"); ?>


				<div class=" propuestas  row text-center " >
					<h4 class="poppi-b azul text-center ">Propuesta de valor: </h4>
					<div class="large-3 medoum-4 small-6 columns end " >
						<img src="img/iconos/propuesta-1.jpg">
						<p class="poppi texto ">Aprende </br>a tu ritmo</p>
					</div>
					<div class="large-3 medoum-4 small-6 columns end " >
						<img src="img/iconos/propuesta-2.jpg">
						<p class="poppi texto ">De la mano del </br>profesor</p>
					</div>
					<div class="large-3 medoum-4 small-6 columns end " >
						<img src="img/iconos/propuesta-3.jpg">
						<p class="poppi texto ">Profesores </br> expertos</p>
					</div>
					<div class="large-3 medoum-4 small-6 columns end " >
						<img src="img/iconos/propuesta-4.jpg">
						<p class="poppi texto ">Certificado </br> por curso</p>
					</div>
					<div class="large-3 medoum-4 small-6 columns end " >
						<img src="img/iconos/propuesta-5.jpg">
						<p class="poppi texto ">En primera </br> fila</p>
					</div>
					<div class="large-3 medoum-4 small-6 columns end " >
						<img src="img/iconos/propuesta-6.jpg">
						<p class="poppi texto ">Comparte </br> conocimiento </p>
					</div>
					<div class="large-3 medoum-4 small-6 columns end " >
						<img src="img/iconos/propuesta-7.jpg">
						<p class="poppi texto ">Comunidad </br> creativa</p>
					</div>
					<div class="large-3 medoum-4 small-6 columns end " >
						<img src="img/iconos/propuesta-8.jpg">
						<p class="poppi texto ">Cursos producidos </br> profesionalmente</p>
					</div>
				</div>
				
				<hr>			
				
				<?php $exitos=executesql(" select * from casos_de_exitos where estado_idestado=1 and link !='' order by orden desc ");
					if( !empty($exitos)){		
				?>
				<div class=" casos_exito text-center " >
					<h4 class="poppi-b blanco text-center "> <img src="img/iconos/ico-exito.png" style="padding-right:10px;"> Casos de éxito </h4>
				
					<?php foreach( $exitos as $row ){		 ?>
						<?php if( !empty($row["imagen"])){ ?>
					<div class="medium-6 columns end " >
						<figure  CLASS="rel">
							<img src="tw7control/files/images/casos_de_exitos/<?php echo $row['imagen'] ?>" class="imagen_1" style="width:100%;">
								<?php if(!empty($row["link"]) ){ ?>
							<a class="abs mpopup-02" href="<?php echo $row['link'] ?>"><img src="img/iconos/ico-play.png" class="verticalalignmiddle"></a>
								<?php }?>

						</figure>
						<div class="lleva_name_testi"><p class="poppi texto ">	<?php echo $row['titulo']; ?> </p></div>
					</div>
						<?php } /* si registor un img  */ ?>
				<?php } /*for exitos */?>
					
				</div>
				<?php } ?>
				
		<?php } /* END CURSO NORMAL */ ?>

		</div> <!-- L8 detalle -->	
		
		<div class="large-4 meium-5 columns lleva_relacionados "> <!-- L4 dependientes  -->	
				<!-- se mostraban relacionados ; pero se separaron en seccion packs  -->
		</div> <!-- L4 detalle Dependientes -->	
		
</div></div> <!-- calloiut -#11 -->