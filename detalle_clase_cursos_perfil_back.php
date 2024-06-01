<?php // validamos si el curso le pertenece al alumno logeado.
$sql_cc="SELECT c.*, sc.estado_idestado as estado_asignacion,  sc.estado as condicion_curso , sc.condicion 
	FROM suscritos_x_cursos sc 
	INNER JOIN cursos c ON sc.id_curso=c.id_curso
	WHERE  sc.estado=1   and c.titulo_rewrite = '".$_GET['task2']."' and sc.id_suscrito='".$_SESSION['suscritos']['id_suscrito']."' 
	ORDER BY  sc.orden desc limit 0,1 ";
					
// si el curso se encuentra deshabilitado en el futuro esto no afecta a los ya comprados, igual se visualiza el contenido y clases	

// echo $sql_cc; 

$curs = executesql($sql_cc);
?>
<div class="callout callout-2 detalle_de_curso_comprado "><div class="row row3 row-docen">
<?php 
if(!empty($curs)){   // si le pertenece el curso 

	if($curs[0]["condicion"]=="2" ){	
?>
	<div class="large-12 columns rptas_error "><h4 class="color1 poppi-b">Plazo de acceso vencido para acceder a este curso. </br> Recuerda que el tiempo de acceso válido es un plazo de 6 meses desde la fecha de compra.</h4></div>

<?php 
	}else if($curs[0]["condicion_curso"]=="2" ){	
?>		
	<div class="large-12 columns rptas_error "><h4 class="color1 poppi-b">Aún esta pendiente la aprobación del pago.</h4></div>
<?php 
	}elseif($curs[0]["condicion_curso"]=="3" ){ 
?>
	<div class="large-12 columns rptas_error"><h4 class="color1 poppi-b">El pago fue rechazado, comunícate con nosotros por WhatsApp.  </h4></div>
<?php 
	}elseif($curs[0]["estado_asignacion"]=="2"){
?>
	<div class="large-12 columns rptas_error"><h4 class="color1 poppi-b">Esta asignación ha sido deshabilitada!  </h4></div>
<?php 
	}elseif($curs[0]["estado_asignacion"]=="1" && $curs[0]["condicion_curso"]=="1"){
	// si asignacion esta vigente y el pago fue aprobado mueestro contenido curso .
	// y=(AB*100)/x  --> formula  
	// => x = total de clases
	// => y =porcentaje
	// AB= clases finalizadas. 
	// marcamos el curso como finalizado
	$si_finalizado = executesql("SELECT ide,finalizado FROM suscritos_x_cursos WHERE estado_idestado = 1 AND id_curso = '".$curs[0]['id_curso']."' and  id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."'  ");
	if($si_finalizado[0]['finalizado']!=1){
		// calculo total de clases 
		// ... calculo total de clases 
		$total_n_clases = executesql("SELECT count(*) as total_clases FROM avance_de_cursos_clases WHERE id_curso = '".$curs[0]['id_curso']."' and id_suscrito='".$_SESSION['suscritos']['id_suscrito']."' ");
		if(!empty($total_n_clases) && $total_n_clases[0]['total_clases'] > 0 ){
			// clases finalizadas 
			$finalizadas = executesql("SELECT count(*) as total_finalizadas FROM avance_de_cursos_clases WHERE id_curso = '".$curs[0]['id_curso']."' and id_suscrito='".$_SESSION['suscritos']['id_suscrito']."'  and estado_fin=1 ");
			$porcentaje= round( ($finalizadas[0]['total_finalizadas']*100)/$total_n_clases[0]['total_clases']);
			if($porcentaje =='100'){
				// marcamoscurso como finalizado el curso ..
				$bd=new BD;
				$_POST['finalizado']=1;
				$campos=array('finalizado');
				$bd->actualiza_(armaupdate('suscritos_x_cursos',$campos," ide='".$si_finalizado[0]["ide"]."'",'POST'));/*actualizo*/
					// }else{
					// $porcentaje ='0';
			}
		}else{
			// lo compro cuando no tenia clase registradas ..
			$porcentaje ='';
		}
	}else{
		// si esta finalizado = 100%
		$porcentaje='100';
	}
?>			
    <div class="large-3 medium-4 nothing columns new_menu menu_del_clases ">
    	<div class="titu-gene"><h3 class="poppi-b"><?php echo '<small style="padding-right:9px;">'.$curs[0]['codigo'].'</small>'.$curs[0]['titulo'] ?></h3></div>
<?php
    $ses = executesql("SELECT * FROM sesiones WHERE estado_idestado = 1 AND id_curso = ".$curs[0]['id_curso']." ORDER BY ORDEN ASC");
    $z=1;
    $general=1;
    $loe=1;
    if(!empty($ses)){
        echo '<div class="calco"><ul class="accordion" style="margin-bottom:25px !important" data-accordion data-allow-all-closed="true"  >';
        foreach($ses as $sesi){

						if($z == 1){
							$primera_sesion=$sesi["id_sesion"];  /* util para listar la primera clase, por defecto */
						}
						$estado_clases_modulos="completas";
						// validamos las clases finalizadas .. 
						$modulo_completo=executesql("SELECT estado_fin FROM avance_de_cursos_clases WHERE id_curso = '".$curs[0]['id_curso']."' and id_sesion = '".$sesi['id_sesion']."' and id_suscrito='".$_SESSION['suscritos']['id_suscrito']."' ");
						if(!empty($modulo_completo)){ 
							foreach($modulo_completo as $recorro_clase_vista){
								if($recorro_clase_vista['estado_fin']=='2'){
									// si encuentro una clase que aun no esta finalizada ya no muestro el check verde. 
									$estado_clases_modulos="falta";
								}
							}	
						}else{
							$estado_clases_modulos="falta";
							// echo "<small>error val() modulos completos</small>";
							echo "<script>console.log('error val() modulos completos sin clase al momento de la compra .. '); </script>";
						}
			// validamos las clases finalizadas .. 
?>
            <li class="accordion-item is-active <?php echo ( isset($_GET['task3']) && $_GET['task3']==$sesi['titulo_rewrite']) ? 'is-active' : '' ?>" data-accordion-item>
                <a href="#" class="accordion-title <?php //echo ($estado_clases_modulos=="completas")?'comprobado':'';?>  poppi-b"><i class="fa fa-arrow-right"></i><?php echo $sesi['titulo'] ?></a>
                <div class="accordion-content" data-tab-content>
<?php
                $det = executesql("SELECT * FROM detalle_sesiones WHERE estado_idestado = 1 AND id_sesion = ".$sesi['id_sesion']." ORDER BY orden asc ");
                if(!empty($det)){ echo '<div class="lista">';
									 foreach($det as $deta){
                			$edc2=executesql("SELECT estado_fin FROM avance_de_cursos_clases WHERE id_curso = '".$curs[0]['id_curso']."' and id_detalle = '".$deta['id_detalle']."' and id_sesion='".$sesi['id_sesion']."' and id_suscrito='".$_SESSION['suscritos']['id_suscrito']."' ");
?>
                   	<a id="llama<?php echo $loe; ?>" href="<?php echo 'perfil/'.$_GET['task'].'/'.$_GET['task2'].'/'.$sesi['titulo_rewrite'].'/'.$deta['titulo_rewrite'] ?>">
											<p class="poppi texto rel <?php echo (isset($_GET['task4']) && $deta['titulo_rewrite']==$_GET['task4']) ? 'acti' : '' ?>">
													<?php echo (isset($_GET['task4']) && $deta['titulo_rewrite']==$_GET['task4']) ?
																			 '<i class="fas fa-check"></i>' 
																			 : '<i class="fa'.((empty($edc2) || ($edc2[0]['estado_fin']==2)) ?
																			 			 'r' 
																						 : 's').' fa-circle"></i>' ?>
																	<?php echo $deta['titulo'] ?>
											</p>
										</a>
<?php
					if(isset($_GET['task4']) && $deta['titulo_rewrite']==$_GET['task4']){
						$general = $loe;				
					}
					$loe++;
                    $z++;
                } // end for clases 
							echo '</div>'; }
?>
                </div>
            </li>
<?php
        } /* END for sesiones */
        echo '</ul></div>';
    } // end listado de modulos
?>
    </div>

    <div class="large-9 medium-8 columns   detalle_clase_aula ">
<?php
// DETALLE DE CLASES 

		if(isset($_GET['task4']) && !empty($_GET['task4'])){
			$sql_complemento=" AND titulo_rewrite = '".$_GET['task4']."' ";
		}else{
			$sql_complemento=" AND id_sesion = '".$primera_sesion."' order by orden asc ";
		}	
		$sql_clase="SELECT * FROM detalle_sesiones WHERE estado_idestado = 1 ".$sql_complemento;
		// echo $sql_clase;
		$detal = executesql($sql_clase,0);
	

		// TABLA DE HORARIOS 
		$detalles= executesql("select * from cursos where id_curso='".$curs[0]["id_curso"]."' ",0);
		include('inc/horarios_del_curso_en_detalle_clases.php');										
		// END  TABLA DE HORARIOS 
		

	/* Registrar asistencia de cliente a Clase */
		/* sistencias */
		
		include('inc/proceso_registrar_asistencia_del_cliente_a_clase.php');								
?>
		<div class="encabezado"><h3 class="color1 poppi-b titu ">
			<?php echo $detal['titulo'] ?>
			<?php //if(is_numeric($porcentaje) && $porcentaje >= 0){ ?> 
			<!--<span><?php// echo $porcentaje; ?>%</span>-->
			<?php //} ?> 
		</h3></div>
		
		
<?php  /* intro */
		echo !empty($detal['descripcion_intro']) ?'<div class="detalle" style="padding:0 15px 10px;">'.$detal['descripcion_intro'].'</div>' : '';


		// if($curs[0]['modalidad']==2){ 
			// echo '<p class="poppi-sb color1 text-center rel">'.date('d\/m\/Y ',strtotime($curs[0]['fecha_inicio'])).' '.date("g:i a",strtotime($curs[0]['hora_inicio'])).'<img class="float-right" style="position:absolute;right:0;top:-20px;" src="img/iconos/live.png"></p>';
		// }
        if(!empty($detal["link"])){
?>
		<div class="rel ifra">
			<iframe src="<?php echo $detal['link']; ?>" class="" id="video1" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
			<a class="alpa" onclick="playpause()"></a>
		</div>
		<form id="form-vista-video" style="display:none;">
			<input type="hidden" name="action" value="registro">
			<input type="hidden" name="id_curso" value="<?php echo $curs[0]['id_curso'] ?>">
			<input type="hidden" name="id_detalle" value="<?php echo $detal['id_detalle'] ?>">
			<input type="hidden" name="id_sesion" value="<?php echo $detal['id_sesion'] ?>">
			<input type="hidden" name="id_suscrito" value="<?php echo $_SESSION['suscritos']['id_suscrito'] ?>">
		</form>
		<script>
    	function playpause(){
    	   	jQuery('#video1').attr('src', '<?php echo $detal['link']; ?>?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=1;');
			$('iframe')[0].src += "&amp;autoplay=1";
			$(".alpa").css("display", "none");
			var options = { frm:$('#form-vista-video').serialize(), url:'process_cart/insert_vista_videos.php'};
    		$.ajax({
        		url:options.url,
        		cache:false,
        		type:'post',
        		data:options.frm,
        		success:function(data){
                }
    		});
    	};
  		</script>

<?php
		}else{
				
							
				if( !empty($detal["externo"]) ){  
					echo ' <div class=" text-center" style="margin-bottom:30px;"> <a href="'.$detal["externo"].'" class=" "><img src="img/webinar_externo_1.jpg"></a> </div>';
				
				}else if( ($curs[0]['modalidad']==2 || $curs[0]['en_vivo']==1) && $curs[0]['lleva_video']=='1' ){ 
							// echo '<div class="cuadro-virtual text-center">
							// <span class="poppi-bi">Esta clase se realizará en VIVO a través de la plataforma ZOOM.<br>Unicamente tiene que ingresar a esta sección para participar de la sesión</span> </br> <p class="poppi-sb color1 text-center rel"> '.date('d\/m\/Y ',strtotime($curs[0]['fecha_inicio'])).' a las '.date("g:i a",strtotime($curs[0]['hora_inicio'])) .' </p> '.(!empty($curs[0]["enlace_en_vivo"]) ? '<a href="'.$curs[0]["enlace_en_vivo"].'" class="boton poppi-sb">Ingresar Aquí</a>' : '').'
							// </div>';

							echo '<div class="cuadro-virtual text-center" style="margin-bottom:30px;">
							<span class="poppi-bi">Esta clase se realizará en VIVO a través de la plataforma ZOOM.<br>Unicamente tiene que ingresar a esta sección para participar de la sesión</span> </br> <p class="poppi-sb color1 text-center rel" style="color: #fff!important; background: #333; display: inline-block; padding: 3px 7px;"> '.date('d\/m\/Y ',strtotime($curs[0]['fecha_inicio'])).' a las '.date("g:i a",strtotime($curs[0]['hora_inicio'])) .' </p> '.(!empty($curs[0]["enlace_en_vivo"]) ? '<a href="'.$curs[0]["enlace_en_vivo"].'" target="_blank" class="boton poppi-sb">Ingresar Aquí</a>' : '').'
							</div>';
							
				}
				
		}
				
		echo !empty($detal['descripcion']) ? '<div class="detalle">'.$detal['descripcion'].'</div>' : '';
?>
		<div class="atrasigue">
<?php
			if($general==1){
			}else{
?>
			<a onclick="mandalink('llama<?php echo $general-1 ?>')" class="float-left boton poppi-sb"> &#60; Anterior clase</a>
<?php
			}
			if($general==($loe-1)){
			}else{
?>
			<a onclick="mandalink('llama<?php echo $general+1 ?>')" class="float-right boton poppi-sb">Siguiente clase > </a>
<?php
			}
?>
			<script type="text/javascript">
				function mandalink(insa){
					document.location.href = $('#'+insa).attr('href');
				}
			</script>
		</div>
<?php
		// consultamos  estado_fin de la clase por alumno
		$estado_de_clase=executesql("SELECT estado_fin FROM avance_de_cursos_clases WHERE id_detalle = '".$detal['id_detalle']."' and id_suscrito='".$_SESSION['suscritos']['id_suscrito']."' ");
		if(!empty($estado_de_clase)){ // si tiene clases por curso asignadas ..
			if($estado_de_clase[0]['estado_fin']==2){
?>
			<div class="text-center"> <a  href="javascript: fn_estado_clase('<?php echo $detal["id_detalle"]; ?>')"  class="boton poppi-sb marcar_completado ">Marcar como completado</a></div>
<!-- Recursos -->
<?php
			}else{
				echo '<div class="text-center"> <a class="boton poppi-sb marcar_completado "  style="background: #666;border: none;cursor: no-drop;">Clase finalizada</a></div>';
			} // end estado clase por laumno
		} // si cuando compro curso este curso tenia cero clases .. 		
		
		
// recursos listado				
		$recur = executesql("SELECT * FROM archivos_detalle_sesion_virtuals WHERE estado_idestado = 1 AND id_detalle = '".$detal['id_detalle']."'");
		if(!empty($recur)){ 
			echo '<h4 class="poppi-b color1 recur">Recursos</h4> <ul class="accordion" style="margin-top:25px" data-accordion   data-multi-expand="true" >';
			foreach ($recur as $recurso){
?>
				<li class="accordion-item   is-active " data-accordion-item >
					<a href="#" class="accordion-title titu-rec poppi-b"><?php echo $recurso['titulo'] ?></a>
					<div class="accordion-content" data-tab-content>
<?php
						echo !empty($recurso['descripcion']) ?'<div class="detalle">'.$recurso['descripcion'].'</div>' : '';
						echo !empty($recurso['archivo']) ? '<span class="poppi color1 arch">Archivo: <a target="_blank" href="tw7control/files/files/'.$detal['id_detalle'].'/'.$recurso['archivo'].'"><img src="tw7control/dist/img/icons/archivo.jpg"></a></span>' : '';
?>
					</div>
				</li>
<?php
			} // for recursos
			echo '</ul>'; 
		}// if_recursos 
			
		// }else{ //  si task_4 si existe rewrite de clase	
			// /* Por defecto mostar la 1° clase */
			// echo "Aquí mostrar por decto la 1° clase .. ";
			
		// } //  END si task_4 si existe rewrite de clase			
?>				
		<form id="form-comen" class="form-comentario">
			<input type="hidden" name="id_curso" value="<?php echo $curs[0]['id_curso'] ?>">
			<input type="hidden" name="id_detalle" value="<?php echo $detal['id_detalle'] ?>">
			<input type="hidden" name="id_sesion" value="<?php echo $detal['id_sesion'] ?>">
			<input type="hidden" name="id_suscrito" value="<?php echo $_SESSION['suscritos']['id_suscrito'] ?>">
			<label class="poppi-b" style="margin-top:30px;">Agregue un comentario:</label>
			<div class="div rel"><textarea name="comen"></textarea></div>
			<div>
				<button class="poppi-b">Enviar comentario</button>
			  	<div class="callout primary hide" id="comenInfo">Procesando datos...</div>
                <div class="callout alert hide" id="comenError">El comentario no pudo enviarse<br>intentelo más tarde.</div>
                <div class="callout success hide" id="comenSuccess">Comentario enviado correctamente</div>
            </div>
		</form>
<?php 
		$sql_coments="SELECT c.*,CONCAT(s.ap_pa, ' ', s.ap_ma, ' ', s.nombre) as suscrito, s.email as email, s.telefono as telefono, cu.titulo as curso, se.titulo as sesion, ds.titulo as detalle, e.nombre AS estado 
		FROM comentario c 
		INNER JOIN estado e ON c.estado_idestado=e.idestado 
		INNER JOIN suscritos s ON c.id_suscrito=s.id_suscrito 
		INNER JOIN cursos cu ON c.id_curso=cu.id_curso 
		INNER JOIN sesiones se ON c.id_sesion=se.id_sesion  
		INNER JOIN detalle_sesiones ds ON c.id_detalle=ds.id_detalle 
		WHERE c.id_curso = ".$curs[0]['id_curso']." AND c.id_sesion = ".$detal['id_sesion']." AND c.id_detalle = ".$detal['id_detalle']." and c.estado_idestado=1 
		ORDER BY c.fecha_registro DESC";
		
		// $sql_coments="SELECT c.*,CONCAT(s.ap_pa, ' ', s.ap_ma, ' ', s.nombre) as suscrito, s.email as email, s.telefono as telefono, cu.titulo as curso, se.titulo as sesion, ds.titulo as detalle, e.nombre AS estado 
		// FROM comentario c 
		// INNER JOIN estado e ON c.estado_idestado=e.idestado 
		// INNER JOIN suscritos s ON c.id_suscrito=s.id_suscrito 
		// WHERE c.id_curso = ".$curs[0]['id_curso']." AND c.id_sesion = ".$detal['id_sesion']." AND c.id_detalle = ".$detal['id_detalle']." and c.estado_idestado=1 
		// ORDER BY c.fecha_registro DESC";
		
		$com = executesql($sql_coments);
		if(!empty($com)){
			echo '<div><h3 class="poppi-b titcomen">Comentarios:</h3></div>'; 
			
			foreach($com as $comen){
					echo '<div class="comenta">
						<p class="poppi-b til">'.$comen['suscrito'].'<small class="poppi float-right">'.$comen['fecha_registro'].'</small></p>
						<p>'.nl2br($comen['comen']).'</p>
					</div>';

		}}
?>
		</div> <!-- L8 -->
<?php 				
		}// si curso ya esta pago aprobado, estado OK

	}else{ // Si no le compro el curso .. rpta al chistoso  ?>	
	<div class="large-12 columns text-center" style="padding:110px 0;">
		<h4 class="color1 poppi-b">No tienes acceso a este curso, compralo aquí <a href='curso/todos'>[ ver cursos] </a> </h4>
    </div>		
<?php } //enf valiacion si curso es del alumno logeado  ?>				
</div></div>
		
		