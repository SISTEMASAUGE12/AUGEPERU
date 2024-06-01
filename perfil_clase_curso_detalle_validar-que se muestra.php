
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
		
?>		


<?php 
	/* Registrar asistencia de cliente a Clase */				
		include('inc/proceso_registrar_asistencia_del_cliente_a_clase.php');								
?>
		<div class="encabezado"><h3 class="color1 poppi titu ">
			<?php echo $detal['titulo'] ?>		
		</h3></div>
		
		
<?php  
        // TABLA DE HORARIOS 
        /*
		$detalles= executesql("select * from cursos where id_curso='".$curs[0]["id_curso"]."' ",0);
		include('inc/horarios_del_curso_en_detalle_clases.php');	
        */									
		// END  TABLA DE HORARIOS 


        /* intro */
		// echo !empty($detal['descripcion_intro']) ?'<div class="detalle" style="padding:0 15px 10px;">'.$detal['descripcion_intro'].'</div>' : '';

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
?>				

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