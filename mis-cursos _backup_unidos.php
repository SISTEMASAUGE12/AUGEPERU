<?php 
$pagina='perfil_home';
include('auten.php');
if(!isset($_SESSION["suscritos"]["id_suscrito"])){ header('Location: '.$url); }
$meta = array(
    'title' => ' Mis cursos | Educa Auge',
    'description' => ''
);
include ('inc/header.php');

echo '=>'.$_SESSION['suscritos']['id_suscrito']; 

$suscri = executesql("SELECT s.*, e.titulo FROM suscritos s INNER JOIN especialidades e ON s.id_especialidad = e.id_especialidad WHERE s.id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."' ");
?>

<main id="perfil" class="margin_interno ">
<!-- Si ven el curso detalle en el perfil -->
<?php if(isset($_GET["task"]) && $_GET["task"]=="gracias" ){ /* ventana emergente de gracias por compra */ 
	include("inc/modal_gracias_por_compra.php");
}
 ?>

<!-- 
<div class="success callout" data-closable="slide-out-right">
  <p>You can close me too, and I close using a Motion UI animation.</p>
  <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
    <span aria-hidden="true">&times;</span>
  </button>
</div>
-->
	<div class="callout callout-inicio "><div class="row "><div class="large-12 medium-12 columns content_perfil ">
<?php
 $sql_x1="SELECT sc.*, c.orden  FROM suscritos_x_cursos sc INNER JOIN cursos c ON sc.id_curso=c.id_curso WHERE sc.estado_idestado=1 and sc.condicion=1 and sc.estado=1 and sc.id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."'  Order by c.orden asc  ";
$suscur = executesql($sql_x1);
            if(!empty($suscur)){ ?>
		<blockquote class="color1 poppi-sb text-center"><small>Bienvenido <?php echo $perfil[0]["nombre"]; ?> </small>
		</br>Empecemos a aprender </blockquote>			
		<h4 class="color1 poppi-sb">Mis cursos adquiridos  </h4>

		<ul class="tabs" data-tabs id="example-tabs">
			<li class="tabs-title is-active bold "><a href="#panel1" aria-selected="true"> CURSOS GENERALES </a></li>
			<li class="tabs-title bold "><a data-tabs-target="panel2" href="#panel2"> CURSOS DE ESPECIALIDADES </a></li>
		</ul>
		<div class="tabs-content" data-tabs-content="example-tabs">
			<div class="tabs-panel is-active" id="panel1">
				<p>Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus.</p>
			</div>
			<div class="tabs-panel" id="panel2">
				<p>Suspendisse dictum feugiat nisl ut dapibus.  Vivamus hendrerit arcu sed erat molestie vehicula. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor.  Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor.</p>
			</div>
		</div>



							<?php
								foreach ($suscur as $data_asignacion){
									$sql_x="SELECT * FROM cursos WHERE (id_tipo=1 or id_tipo=4) and  id_curso = '".$data_asignacion['id_curso']."' ";
									
									$data_curso = executesql($sql_x);
									if(!empty($data_curso)){ 
										foreach($data_curso as $detalles){

											if( empty($detalles['cursos_dependientes']) ){  /* si no es el pack mostramos el curso al cliente, */
														
														$titulo=$detalles['titulo'];
														$link='perfil/mis-cursos/'.$detalles['titulo_rewrite'];
														// $imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen'];
														$imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen2'];
														
														$si_fina = executesql("SELECT * FROM suscritos_x_cursos WHERE estado_idestado = 1 AND id_curso = '".$detalles['id_curso']."' and  id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."'  "); 
														$porc='';
														if($si_fina[0]['finalizado']!=1){
															$sql_tot_cla="SELECT count(*) as total_clases FROM avance_de_cursos_clases WHERE id_curso = '".$detalles['id_curso']."' and id_suscrito='".$_SESSION['suscritos']['id_suscrito']."' "; 
															$tot_n_cla = executesql($sql_tot_cla);
				
															$final = executesql("SELECT count(*) as total_finalizadas FROM avance_de_cursos_clases WHERE id_curso = '".$detalles['id_curso']."' and id_suscrito='".$_SESSION['suscritos']['id_suscrito']."'  and estado_fin=1 ");
															if(!empty($tot_n_cla) && $tot_n_cla[0]['total_clases']>0){
																if(!empty($final)){
																	$porc = round(($final[0]['total_finalizadas']*100)/$tot_n_cla[0]['total_clases']);
																	if($porc =='100'){
																		$bd=new BD;
																		$_POST['finalizado']=1;
																		$campos=array('finalizado');
																		$bd->actualiza_(armaupdate('suscritos_x_cursos',$campos," ide='".$si_fina[0]["ide"]."'",'POST'));/*actualizo*/
																	}
																}
															}else{
																$porc='0';
															}
														}else{
															$porc='100';
														}

														//echo '<div class="large-3 float-left medium-6 columns rel  end mis_cursos ">';
														//	include('inc/curso2.php');
														//echo '</div>';
														?>
														<div class="large-12 columns"><div class="curso_land">
															<div class="ima poppi-b "><img src="<?php echo $imgproduct; ?>" alt="<?php echo $detalles['titulo']; ?>"><b><?php echo $detalles['codigo']; ?></b></div>
															<div class="titu"><div class="contiene_ ">
													<?php
															if( $detalles['en_vivo']==1){ /* valido si esta activo el boton */ ?> 
																	<!-- 
																	<div class="medium-12 columns ">
																		<div class="medium-4 columns "><p>Fecha de inicio<?php echo $detalles['horario_inicio']; ?></p></div>
																		<div class="medium-4 columns "><p class="color1">HORARIO EN VIVO</p></div>
																		<div class="medium-4 columns "><p>Fecha final<?php echo $detalles['horario_final']; ?></p></div>
																	</div>
																	-->
																	
																	<div class="table-scroll ">
																		<table class="unstriped "> 
																			<thead>
																				<tr class="cabezera_tabla ">
																					<th colspan="3">Fecha de inicio: <?php echo $detalles['horario_inicio']; ?></th>
																					<th colspan="2" class="color2 ">HORARIO EN VIVO</th>
																					<th colspan="3">Fecha fin: <?php echo $detalles['horario_final']; ?></th>
																				</tr>
																				<tr>
																					<th >HORA</th>
																				<?php if(!empty($detalles['horario_lunes']) ){ ?> 
																						<th>LUNES</th>
																					<?php } ?>

																				<?php if(!empty($detalles['horario_martes'])) { ?> 
																						<th >MARTES</th>
																					<?php } ?>

																				<?php if(!empty($detalles['horario_miercoles']) ){ ?> 
																						<th >MIERCOLES</th>
																					<?php } ?>

																				<?php if(!empty($detalles['horario_jueves']) ){ ?> 
																						<th >JUEVES</th>
																					<?php } ?>

																				<?php if(!empty($detalles['horario_viernes']) ){ ?> 
																						<th >VIERNES</th>
																					<?php } ?>

																				<?php if(!empty($detalles['horario_sabado']) ){ ?> 
																						<th >SABADO</th>
																					<?php } ?>

																				<?php if(!empty($detalles['horario_domingo']) ){ ?> 
																						<th >DOMINGO</th>
																					<?php } ?>
																				</tr>
																			</thead>
																			<tbody>
																				<tr>
																					<td><?php echo $detalles['horario_hora']; ?> </td>
																					
																			<?php if(!empty($detalles['horario_lunes']) ){ ?> 
																					<td><?php echo $detalles['horario_lunes']; ?> </td>
																				<?php } ?>

																			<?php if(!empty($detalles['horario_martes']) ){ ?> 
																					<td><?php echo $detalles['horario_martes']; ?> </td>
																				<?php } ?>

																			<?php if(!empty($detalles['horario_miercoles']) ){ ?> 
																					<td><?php echo $detalles['horario_miercoles']; ?> </td>
																				<?php } ?>

																			<?php if(!empty($detalles['horario_jueves']) ){ ?> 
																					<td><?php echo $detalles['horario_jueves']; ?> </td>
																				<?php } ?>
																				
																			<?php if(!empty($detalles['horario_viernes']) ){ ?> 
																					<td><?php echo $detalles['horario_viernes']; ?> </td>
																				<?php } ?>

																			<?php if( !empty($detalles['horario_sabado']) ){ ?> 
																					<td><?php echo $detalles['horario_sabado']; ?> </td>
																				<?php } ?>

																			<?php if( !empty($detalles['horario_domingo']) ){ ?> 
																					<td><?php echo $detalles['horario_domingo']; ?> </td>
																				<?php } ?>
																					
																				</tr>
																			</tbody>
																		</table>
																	</div>
																		<h2 class="poppi-b text-center "><?php echo $titulo;?></h2>
																	
											<?php }else{ /* si es grabado */  ?> 
																	<h2 class="poppi-b ptoppp"><?php echo  $detalles['codigo'].' </br> '.$titulo;?></h2>
											<?php } ?> 
															</div></div>
															<div class="progresar">
																<p class="poppi">Progreso: <b class="poppi-b"><?php echo $porc; ?>%</b></p>
																<div class="tar"><div style="width:<?php echo $porc.'%';?>"></div></div>					
																<?php
																	if( $detalles['en_vivo']==1){ /* valido si esta activo el boton */
																				if(!empty($detalles['enlace_en_vivo']) && !empty($detalles['hora_en_vivo']) ){ ?>
																		<div class="lleva_boton_en_vivo ">
																			<a href="<?php echo $detalles['enlace_en_vivo'];?>" target="_blank">
																				<figcaption class="en_vivo text-center animated infinite pulse delay-2s  ">
																						<img src="img/iconos/click_aqui.png">
																						<b class="float-left" style="padding-right:20px;"><span>Transmisión en vivo </span> </b> <?php echo $detalles['hora_en_vivo'];?>
																				</figcaption>
																			</a> 
																		</div>

																	<?php }
																	}
																?>
																
															</div>
															<!-- 
															<div class="bota"><a href="<?php echo $link;?>" class="boton poppi-sb"> INGRESAR</a></div>
															
																-->
																<div class="bota"><a href="<?php echo $link;?>" class="boton poppi-sb"><img src="img/iconos/icon-mis-cursos.png"> SESIONES</a></div>
														</div></div>
														
										<?php
											}/* end si no es pack:: mostramos el curso :: los pack, estan ocultos xq salen sin contenido */
											
										} /* end for data curso */
									}  /* end if curso */
							
							} /* end for suscritoz_x_cursos */
							
						}else{
									// echo '<div class="text-center" style="padding:40px 15px;">Aún no has comprado cursos .. </div>';
?>
								<div class=" aun_sin_compra ">
									<div class="text-center" ><img src="img/cliente_sin_compras.png" alt="compra cursos en educauage" class="text-center" style="width:60px;"></div>
									<blockquote class="color1 poppi-sb text-center" style="padding-bottom:20px;"><small>Aún no has comprado ningún curso en EducaAuge</small>
									</br><a href="https://www.educaauge.com/curso/todos" title="compra cursos aqui">Comienza a aprender </a></blockquote>
								</div>
								<div class=" mensaje_aun_sin_compra ">
									<p>Si has comprado un curso y no aparece aquí, asegurate de que tu compra ya fue aprobada. <a href="https://www.educaauge.com/perfil/mis-pedidos" title="ver mis ocmpras">Visita el listado de tus compras aquí</a></p>
								</div>
<?php
						}
?>
		
		
		<?php /* 
		<!-- LIBROS COMPRADOS -->
	<div class="large-12 columns nothing ">
<?php$suscur = executesql("SELECT * FROM suscritos_x_cursos WHERE estado_idestado=1 and condicion=1 and estado=1 and id_tipo=2 and id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."' ");
            if(!empty($suscur)){ ?>
			<h4 class="color1 poppi-sb">Mis libros adquiridos </h4>
			<?php
				foreach ($suscur as $data_asignacion){
					$sql_x="SELECT c.*, ca.titulo_rewrite AS catrewri, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c
								INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso
								INNER JOIN categorias ca ON csc.id_cat = ca.id_cat
								INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub
								INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo
								WHERE  c.id_tipo=2 and c.id_curso = '".$data_asignacion['id_curso']."' ";
										
// echo $sql_x;										
												
									$data_curso = executesql($sql_x);
									if(!empty($data_curso)){ 
										foreach($data_curso as $detalles){ 
											$titulo=$detalles['titulo'];
											$link='curso/'.$detalles['tiprewri'].'/'.$detalles['catrewri'].'/'.$detalles['subrewri'].'/'.$detalles['titulo_rewrite'];
											$imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen'];

											echo '<div class="large-3 float-left medium-6 columns rel  end mis_cursos ">';
												include('inc/curso2.php');
											echo '</div>';
										}
									}
							
							} 
						}else{
									// echo '<div class="text-center" style="padding:40px 15px;">Aún no has comprado libros .. </div>';
						}
?>		
	</div>	
	<!-- 	END LIBROS COMPRADOS -->
	
	<!-- LIBROS CO AUTORES COAUTORES -->
	<div class="large-12 columns nothing ">
<?php$suscur = executesql("SELECT * FROM suscritos_x_cursos WHERE estado_idestado=1 and condicion=1 and estado=1 and id_tipo=3 and id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."' ");
            if(!empty($suscur)){ ?>
			<h4 class="color1 poppi-sb">Mis libros Coautores adquiridos </h4>
			<?php
				foreach ($suscur as $data_asignacion){
					$sql_x="SELECT c.*, ca.titulo_rewrite AS catrewri, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c
								INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso
								INNER JOIN categorias ca ON csc.id_cat = ca.id_cat
								INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub
								INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo
								WHERE  c.id_tipo=3 and c.id_curso = '".$data_asignacion['id_curso']."' ";
										
// echo $sql_x;										
												
									$data_curso = executesql($sql_x);
									if(!empty($data_curso)){ 
										foreach($data_curso as $detalles){ 
											$titulo=$detalles['titulo'];
											$link='curso/'.$detalles['tiprewri'].'/'.$detalles['catrewri'].'/'.$detalles['subrewri'].'/'.$detalles['titulo_rewrite'];
											$imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen'];

											echo '<div class="large-3 float-left medium-6 columns rel  end mis_cursos ">';
												include('inc/curso2.php');
											echo '</div>';
										}
									}
							
							} 
						}else{
									// echo '<div class="text-center" style="padding:40px 15px;">Aún no has comprado libros .. </div>';
						}
?>
		
	</div>
	<?php*/ ?>
	
	</div></div></div>

	<div class="callout callout-inicio-2 "><div class="row "><div class="large-12 medium-12 columns content_perfil ">
		<h3 class="color1 poppi-sb text-center">Qué más deseas aprender con nosotros</h3>
		<p class="poppi text-center maxi ">Aprovecha que ya cuentas con tu registro en Auge y estás a un click de aprender más   </p>
				
		<h4 class=" poppi-sb text-center">Te recomendamos estos cursos  </h4>
		<div class="large-12 columns"><div class="rel cursos_portada ">
				<!--
				<ul id="carousel-para-4" class="no-bullet">
				-->
<?php
		// $deta = executesql("SELECT c.*, ca.titulo_rewrite AS catrewri, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso INNER JOIN categorias ca ON csc.id_cat = ca.id_cat INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo WHERE c.estado_idestado = 1 and c.tipo=1 and c.id_tipo=1 and c.precio > 0  and  c.id_curso NOT IN ( select id_curso from suscritos_x_cursos where id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."')   GROUP BY c.id_curso  ORDER BY c.orden_destacado DESC  limit 0,8");
		
		

		$sql_cc="SELECT c.*, ca.titulo_rewrite AS catrewri, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso INNER JOIN categorias ca ON csc.id_cat = ca.id_cat INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo WHERE c.estado_idestado = 1 and c.tipo=1 and c.id_tipo=1 and c.precio > 0  and  c.id_curso NOT IN ( select id_curso from suscritos_x_cursos where id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."')   ORDER BY c.orden_destacado DESC  limit 0,8";


		// echo $sql_cc;

		$deta = executesql($sql_cc);
		if(!empty($deta)){ foreach($deta as $detalles){
			$titulo=$detalles['titulo'];
    		$link='curso/'.$detalles['tiprewri'].'/'.$detalles['catrewri'].'/'.$detalles['subrewri'].'/'.$detalles['titulo_rewrite'];
    		// $imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen'];
    		$imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen2'];
?>
    		<!-- 
				<li><?php // include("inc/curso.php") ?></li>
				-->
    		<div class="large-3 medium-4 columns end "><?php include("inc/curso.php") ?></div>			 	
<?php
		} }
?>
		<!-- 
    	</ul>
			-->
				<div class="large-12 columns end text-center" >
					<a href="curso/todos" class="btn_2 botones " title="ver todos los cursos">VER TODOS LOS CURSOS</a>
				</div>
			</div></div>
	</div></div></div>
	
	
	<div class="callout callout-inicio-3"><div class="row text-center "><div class="large-12 medium-12 columns content_perfil ">
		<img src="img/logo-rojo.png">
		<h3 class="color1 poppi-sb text-center">Construyendo el camino a la Revolución Educativa</h3>
			
	</div></div></div>

</main>
<?php include ('inc/footer.php'); ?>