
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

	/* Registrar asistencia de cliente a Clase */				
		include('inc/proceso_registrar_asistencia_del_cliente_a_clase.php');								
?>
		<div class="encabezado "><h3 class="color1 poppi titu ">
			<?php echo $detal['titulo'] ?>
			<?php echo $detal['descripcion'] ?>

		</h3>

	</div>
		
		
<?php  
        // TABLA DE HORARIOS 
        /*
		$detalles= executesql("select * from cursos where id_curso='".$curs[0]["id_curso"]."' ",0);
		include('inc/horarios_del_curso_en_detalle_clases.php');	
        */									
		// END  TABLA DE HORARIOS 

	if( isset($_GET["rewrite5"]) && !empty($_GET["rewrite5"]) ){

		$recur = executesql("SELECT * FROM archivos_detalle_sesion_virtuals WHERE estado_idestado = 1 AND id_detalle = '".$detal['id_detalle']."' and idimagen ='".$_GET["rewrite5"]."' ");
		if(!empty($recur)){ 
			$ruta_archivo = 'tw7control/files/files/'.$detal['id_detalle'].'/'.$recur[0]['archivo'].'';
			echo '
			<p style="padding:30px 20px ;">* Tu archivo ha sido descargado. En caso no puedas vizualizar el archivo,  <b>verifica tu carpeta de descargas</b>.</p>	
			<object data="'.$ruta_archivo.'" type="application/pdf" width="100%" height="800px"> 
				<p style="padding:30px 20px ;"> Tu navegador no permite vizualizar el PDF , descargalo aquí: 
					<a href="'.$ruta_archivo.'" target="_blank" class="boton poppi-sb wow pulse " style="margin-top:20px;"> Descargar archivo Aquí </a> 
				</p>  
		  	</object>
			';
		}else{
			echo "<h3>	No se encontro este archivo </h3>";
		}

		
	}else{  // para video contenido
        /* intro */
		if( $detal["lleva_video"] == 2){
			echo "<div class=' rel _contiene_texto_introduccion ' >";
			echo " <img src='img/marca_de_agua_clase.png' class=' marca_de_agua_clase '>";
			echo !empty($detal['descripcion_intro']) ?'<div class="detalle" style="padding:0 15px 10px;">'.$detal['descripcion_intro'].'</div>' : '';
			echo "</div>";
		}


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
					echo ' 
						<div class=" large-12 columns text-center  _contiene_link_clase_externo end  " style="margin-bottom:30px;"> 
							<div class=" medium-6 columns  " >
								<img src="img/buho_clase_link_externo.png">
							</div>
							<div class=" medium-6 columns  medium-text-left text-center " style="padding-top:60px;" >
								<a href="'.$detal["externo"].'" class=" poppi-sb ">
									<p class=" _nube_link  wow pulse ">Ingresa a tu clase  </br> EN VIVO  </br> ¡CLICK AQUÍ!</p>
								</a> 
							</div>					
						</div>';
				
				}else if( ($curs[0]['modalidad']==2 || $curs[0]['en_vivo']==1) && $detal['lleva_video']=='1' ){ 						
						// clase_en_vivo 
						echo '<div class="cuadro-virtual text-center" style="margin-bottom:30px;">
						<span class="poppi-bi">Esta clase se realizará en VIVO a través de la plataforma ZOOM.<br>Unicamente tiene que ingresar a esta sección para participar de la sesión</span> </br> <p class="poppi-sb color1 text-center rel" style="color: #fff!important; background: #333; display: inline-block; padding: 3px 7px;"> '.date('d\/m\/Y ',strtotime($curs[0]['fecha_inicio'])).' a las '.date("g:i a",strtotime($curs[0]['hora_inicio'])) .' </p> '.(!empty($curs[0]["enlace_en_vivo"]) ? '<a href="'.$curs[0]["enlace_en_vivo"].'" target="_blank" class="boton poppi-sb">Ingresar Aquí</a>' : '').'
						</div>';							
				}
				
		}
	} //  end si no existe rewrire 5 : es de materiales 
				
		// echo !empty($detal['descripcion']) ? '<div class="detalle">'.$detal['descripcion'].'</div>' : ' '; // despues del video 
?>

<!-- * controles -->
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
				echo '<div class="text-center"> <a class="boton poppi-sb marcar_completado "  style="border: none;cursor: no-drop;">Clase finalizada</a></div>';
			} // end estado clase por laumno
		} // si cuando compro curso este curso tenia cero clases .. 		
?>				
		</div> <!-- L8 -->