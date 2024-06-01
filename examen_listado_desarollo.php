<?php 

if(isset($_GET['task3']) && ($_GET['task3']=='resultado')){   // solucion del examen 
	
	 $sql_examen_desarrollado="
	 		SELECT sxe.ide,  sxe.minutos as minutos , e.*,ce.titulo as cate_exa 
			FROM suscritos_x_examenes sxe 
			INNER JOIN examenes e  ON e.id_examen=sxe.id_examen LEFT JOIN categoria_examenes ce ON e.id_cate = ce.id_cate 
			WHERE e.estado_idestado=1 and sxe.estado_idestado=1 and e.titulo_rewrite='".$_GET['task2']."'  and sxe.id_suscrito=".$_SESSION["suscritos"]["id_suscrito"]."  and sxe.ide=".$_GET["task4"]."    
			ORDER BY sxe.ide desc 
			LIMIT 0,1	"; 
	 $sql_examen_desarrollado; 
	$exa = executesql($sql_examen_desarrollado);
	// $_GET["task4"] ==> aca e vio le iddel examen desarrollado 


?>
<main id="examen">
<?php   
	$sql_marco_cliente="SELECT COUNT(r.id_rpta) as total, SUM(e.puntos) as punto 
		FROM respuestas r 
		INNER JOIN preguntas e ON r.id_pregunta = e.id_pregunta 
		INNER JOIN suscritos_x_examenes_rptas ser ON r.id_rpta = ser.id_rpta 
		WHERE r.estado_idestado=1 and ser.id_suscrito=".$_SESSION["suscritos"]["id_suscrito"]." 
		AND ser.id_sxe=".$exa[0]['ide']." AND r.estado_rpta = 1  
		 ORDER BY ser.id_rpta desc LIMIT 0,1
		";
	
	// echo $sql_marco_cliente; 

	
	$rpta_c = executesql($sql_marco_cliente);
	
	$rpta_t = executesql("SELECT COUNT(e.id_examen) as total_preguntas_registradas, SUM(e.puntos) as punto FROM preguntas e  WHERE  e.estado_idestado=1 and e.id_examen=".$exa[0]['id_examen']);

	// $min_exa = executesql("SELECT minutos FROM suscritos_x_examenes WHERE estado_idestado=1 and id_suscrito=".$_SESSION["suscritos"]["id_suscrito"]." AND id_examen=".$exa[0]['id_examen']."  Order BY  ide desc limit 0,1 ");
	
	$porcentaje = round(($rpta_c[0]['total']*100)/$exa[0]['total_preguntas'],2);
	
?>
	<div class="callout callout-2"><div class="row">
    	<div class="large-12 columns">
    		<h3 class="poppi-b rel"><small><?php echo $exa[0]['cate_exa'] ?></small><?php echo $exa[0]['titulo'] ?><a href="perfil/examenes" class="osansb"><< Retornar</a></h3>
    	</div>
    	<div class="large-12 columns"><div class="detalle_resultado">
    		<div class="hea-prin">
    			Detalle del Exámen Resuelto
    			<a onclick="resumen_examen('<?php echo $exa[0]['titulo'] ?>',<?php echo $rpta_t[0]['total_preguntas_registradas'] ?>,<?php echo $rpta_c[0]['total'] ?>, '<?php echo $porcentaje; ?>', <?php echo !empty($rpta_c[0]['punto']) ? $rpta_c[0]['punto'] : '0' ?>,<?php echo $rpta_t[0]['punto'] ?>,'<?php echo $exa[0]['minutos'] ?>')">Ver Resumen</a>
    		</div>
    		<?php 
    		$sql_respuestas_correctas="SELECT COUNT(r.id_rpta) as total, SUM(e.puntos) as punto 
			FROM respuestas r  
			INNER JOIN preguntas e ON r.id_pregunta = e.id_pregunta 
			INNER JOIN suscritos_x_examenes_rptas ser ON r.id_rpta = ser.id_rpta 
			WHERE r.estado_idestado=1 and ser.id_suscrito=".$_SESSION["suscritos"]["id_suscrito"]." 
			AND ser.id_sxe=".$exa[0]['ide']." AND r.estado_rpta = 1  
			ORDER BY ser.id_rpta desc LIMIT 0,1"; 

			$rpta_c = executesql($sql_respuestas_correctas);

			// echo $sql_respuestas_correctas; 
			

    		$rpta_t = executesql("SELECT COUNT(e.id_examen) as total_preguntas_registradas, SUM(e.puntos) as punto FROM preguntas e  WHERE  e.estado_idestado=1 and e.id_examen=".$exa[0]['id_examen']);

    		// $exa = executesql("SELECT minutos FROM suscritos_x_examenes WHERE id_suscrito=".$_SESSION["suscritos"]["id_suscrito"]." AND id_examen=".$exa[0]['id_examen']);
    		$porcentaje = round(($rpta_c[0]['total']*100)/$exa[0]['total_preguntas'],2);
    		?>
    <script src="js/sweetalert.min.js"></script>
    		<script type="text/javascript">
				function resumen_examen(titulo,total_preguntas_registradas,resp_total,porcentaje,puntos_obtenidos,puntos_totales,minutos){
					swal({
					title: titulo,
					html: "<p align='left' style='font-size:16px;line-height:21px'><br><b style='text-align:center;display:block'>Resumen del exámen resuelto</b>" +
					"<span style='display:block;font-size:15px;line-height:20px'>Cantidad de Preguntas: <b>"+total_preguntas_registradas+"</b></span>"+
					"<span style='display:block;font-size:15px;line-height:20px'>Preguntas Correctas: <b>"+resp_total+"</b></span>"+
					"<span style='display:block;font-size:15px;line-height:20px'>Preguntas Incorrectas: <b>"+(total_preguntas_registradas - resp_total)+"</b></span>"+
					"<span style='display:block;font-size:15px;line-height:20px'>Puntos Obtenido: <b>"+puntos_obtenidos+"</b> de un total de: <b>"+puntos_totales+"</b> , representa un: <b>"+porcentaje+"%</b> al <b>100%</b> </span>"+
					"<span style='display:block;font-size:15px;line-height:20px'>Minutos en el examen: "+minutos+"</span></p>",
					width: '600px',
					button: "Cerrar",
					});
				}
					
				window.onload = resumen_examen('<?php echo $exa[0]['titulo'] ?>',<?php echo $rpta_t[0]['total_preguntas_registradas'] ?>,<?php echo $rpta_c[0]['total'] ?>, '<?php echo $porcentaje ?>', <?php echo !empty($rpta_c[0]['punto']) ? $rpta_c[0]['punto'] : '0' ?>,<?php echo $rpta_t[0]['punto'] ?>, '<?php echo $exa[0]['minutos'] ?>');
			</script>
    		<div class="deta-prin">
        		<form name="frm_listado" style="display:none;" id="frm_listado" enctype="multipart/form-data">
<?php
            		echo (isset($exa[0]['ide']) && !empty($exa[0]['ide'])) ? '<input type="hidden" name="id_sxe" value="'.$exa[0]['ide'].'">' : '';
            		echo (isset($exa[0]['id_examen']) && !empty($exa[0]['id_examen'])) ? '<input type="hidden" name="id_examen" value="'.$exa[0]['id_examen'].'">' : '';
?>
        		</form>
    			<div id="listado_preguntas_examenes" class="load-content"><p class="text-center" style="padding:110px 0;">Espere mientras listado se va cargando...</p></div>
    		</div>
    	</div></div>
    </div></div>
</main>



<?php
}elseif(isset($_GET['task2']) && ($_GET['task2']=='historial_examenes')){  /* Historial de exámenes  */
	include("examen_historial.php");

}else{    
	// desarrollo del examen 
$examen = executesql("SELECT * FROM examenes WHERE titulo_rewrite = '".$_GET['task2']."' AND estado_idestado=1");
$pregunta = executesql("SELECT * FROM preguntas WHERE id_examen = '".$examen[0]['id_examen']."' ORDER BY id_pregunta ASC");
$nota = executesql("SELECT nota FROM suscritos_x_examenes WHERE id_suscrito=".$_SESSION["suscritos"]["id_suscrito"]." AND id_examen=".$examen[0]['id_examen'].""); 
$puntaje_total = executesql("SELECT SUM(puntos) as suma_total FROM preguntas WHERE id_examen = '".$examen[0]['id_examen']."'");
?>


<div class=" _pantalla_cargando_inicio_al_examen  hide  ">
	<div class=" _contiene_pantalla_cargando text-center  ">
		<img src="img/gif_cargando.gif">
		<p class=" color1 poppi-sb "> Espere estamos revisando el desarrollo de tu examen ..</p>
	</div>
</div>


<main id="examen"  class=" <?php if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){ echo "logeado"; }?> ">
	<div class="callout callout-1"><div class="row">
    	<div class="large-12 columns">
    		<form id="form-finalizar" method="post" enctype="multipart/form-data">
    		<h1 class="poppi-sb color1 rel anticon">
				<em>Evaluación Exámen Online:</em></br>
				<?php echo $examen[0]['titulo'] ?><a href="perfil/examenes" class="osansb"><< Retornar</a>
			</h1>
			<hr>
			<p class="texto conside">CONSIDERACIONES<br>El tiempo de duración del examen es de <b><?php echo conversorSegundosHoras($examen[0]['minutos']) ?></b> y comenzo a correr !!<br>Cantidad de Preguntas <b><?php echo $examen[0]['total_preguntas'] ?></b> │ Total Puntaje <b><?php echo $puntaje_total[0]['suma_total'] ?></b> │ Cantidad veces para resolver el examen es de <b>1 intento(s)</b>.</p>
			<hr>
			<div id="countdown" class="conteo"></div>
            <input type="hidden" name="link_espe" value="<?php echo $url.'perfil/examenes/'.$_GET['task2'] ?>">
            <input type="hidden" name="suscrito" value="<?php echo $_SESSION["suscritos"]["id_suscrito"] ?>">
            <input type="hidden" name="minuto2" value="<?php echo $examen[0]['minutos'] ?>">
            <input type="hidden" name="examen" value="<?php echo $examen[0]['id_examen'] ?>">
            <input type="hidden" name="total_preguntas" value="<?php echo $examen[0]['total_preguntas'] ?>">
<?php
// Arracan preguntas
            if(!empty($pregunta)){ 
				$contador_numero_de_pregunta = 1;
				foreach($pregunta as $preguntas){

					if($contador_numero_de_pregunta == $examen[0]['total_preguntas']){
					// funcion  finalizar .. 
					echo "<script>
					function sigue".$contador_numero_de_pregunta."(){
						if($('input:radio[name=preg".$contador_numero_de_pregunta."]:checked').val()===undefined){
							alert('Seleccionar Respuesta');
						}else{
							$('#pregunta".$contador_numero_de_pregunta."').css('display', 'none');
							$('#finalizar').css('display', 'block');
							$('#countdown').attr('id','pausa');
						}
					}
					function ante".$contador_numero_de_pregunta."(){
						$('#pregunta".($contador_numero_de_pregunta-1)."').css('display', 'block');
						$('#pregunta".$contador_numero_de_pregunta."').css('display', 'none');
					}
					</script>";
					}else{
					// creamos funciones sigueintes
					// Creamos las funciones Js para las preguntas:  atras . // aca ya nos llega el contador_numero_de_pregunta +1 ;
					echo "<script>
					function sigue".$contador_numero_de_pregunta."(){
						if($contador_numero_de_pregunta==1){
						if($('input:radio[name=preg".$contador_numero_de_pregunta."]:checked').val()===undefined){
							alert('Seleccionar Respuesta');
						}else{
							$('#pregunta".$contador_numero_de_pregunta."').css('display', 'none');
							$('#pregunta".($contador_numero_de_pregunta +1 )."').css('display', 'block');
						}
						}else{
							$('#pregunta".$contador_numero_de_pregunta."').css('display', 'none');
							$('#pregunta".($contador_numero_de_pregunta +1 )."').css('display', 'block');
						}
					}

					function ante".$contador_numero_de_pregunta."(){
						$('#pregunta".($contador_numero_de_pregunta-1)."').css('display', 'block');
						$('#pregunta".$contador_numero_de_pregunta."').css('display', 'none');
					}
					</script>";  
					}								
?>
					<input type="hidden" name="pregunta<?php echo $contador_numero_de_pregunta; ?>" value="<?php echo $preguntas['id_pregunta'] ?>">
    				<div class="preguntas" id="pregunta<?php echo $contador_numero_de_pregunta; ?>" style="display:none">
    					<h2 class="color1 preg poppi-b">Pregunta: <?php echo $contador_numero_de_pregunta; ?> / <?php echo $examen[0]['total_preguntas']; ?></h2>
    					<h3 class="color1 poppi"></br>
						Pregunta <?php echo $contador_numero_de_pregunta; ?>, <?php echo $preguntas['titulo'] ?>
						</h3>
    					<?php 
						if(!empty($preguntas['descripcion'])){  ?>
						<div class="color1 poppi-sb" style="padding:10px 0 10px;"> <?php echo $preguntas['descripcion']; ?></div> 
						<?php } ?>
						
						
						<?php if(!empty($preguntas['imagen'])){ ?>
							<!-- 
						<img src="tw7control/files/images/examenes/<?php echo $preguntas['id_examen'].'/'.$preguntas['imagen'] ?>" style="padding:0 0 30px;">
									-->						
						<img src="tw7control/files/images/imagenes/<?php echo $preguntas['imagen'] ?>" style="padding:0 0 20px;"> 
						<?php } ?>

						<?php if(!empty($preguntas['imagen_pre_2'])){ ?>		
						<img src="tw7control/files/images/imagenes/<?php echo $preguntas['imagen_pre_2'] ?>" style="padding:0 0 30px;"> 
						<?php } ?>
					
					
						<span class="alte poppi-b"><em>Seleccione una alternativa para la respuesta correcta</em></span>
<?php
						// $respuesta = executesql("SELECT * FROM respuestas WHERE id_examen = '".$examen[0]['id_examen']."' AND id_pregunta = '".$preguntas['id_pregunta']."' ORDER BY orden ASC");
						
						$sql_repsuestas="SELECT * FROM respuestas WHERE id_pregunta = '".$preguntas['id_pregunta']."' ORDER BY id_rpta ASC";
						
						// echo $sql_repsuestas;
						
						$respuesta = executesql($sql_repsuestas);
                		if(!empty($respuesta)){ foreach($respuesta as $respuestas){
							/* listado de perguntas */
							if( !empty($respuestas['titulo']) && $respuestas['titulo']!=' ' ){ /* que se diferente a un esoacio en blanco */			
							// echo strlen($respuestas['titulo']).' => '.$respuestas['titulo'];
?>
    					<fieldset><label class="color1 poppi">
								<input type="radio" value="<?php echo $respuestas['id_rpta'] ?>" name="preg<?php echo $contador_numero_de_pregunta; ?>"> <?php echo $respuestas['titulo'] ?>
								<span class="checkmark"></span>
								<?php if( !empty($respuestas['imagen']) ){  /* imagen respuestas */
														$img_rpta="tw7control/files/images/imagenes/".$respuestas['imagen'];
								?>
										<figure class="rel " style="padding-top:12px;"><img src="<?php echo $img_rpta; ?>"></figure>
								<?php } ?>
								
							</label></fieldset>
    					<hr>
<?php										}  /* solo preguntas con texto, sin texto no salen */
                		} }
?>
                		<fieldset style="padding-top:40px;">
<?php
                		
                		if($contador_numero_de_pregunta!=1){
?>
                		<a class="boton poppi" onclick="ante<?php echo $contador_numero_de_pregunta; ?>();">Anterior</a>
<?php
						}
                		if($contador_numero_de_pregunta!=$examen[0]['total_preguntas']){
?>
                		<a class="boton poppi" onclick="sigue<?php echo $contador_numero_de_pregunta; ?>();">Siguiente</a>
<?php
						}
?>
                		</fieldset>
    				</div>
<?php
					$contador_numero_de_pregunta++;	
				}  // for preguntas 	
			} // fin de listado de preguntas ..
?>
            <div class="preguntas" id="finalizar">
                <fieldset style="text-align:center;"><a class="boton poppi" style="background:#444E4F" onclick="finalizar('<?php echo $examen[0]['total_preguntas']; ?>');">TERMINAR EXAMEN</a></fieldset>
            </div>
            <?php 
            $mifecha= date('Y-m-d H:i:s'); 
			$NuevaFecha = strtotime('+'.$examen[0]['minutos'].' minute',strtotime($mifecha));
			$NuevaFecha = date('Y-m-d\TH:i:s',$NuevaFecha);
            ?>
            <script>
    		document.getElementById("pregunta1").style.display = "block";
			var end = new Date('<?php echo $NuevaFecha; ?>');
    		var _second = 1000;
    		var _minute = _second * 60;
    		var _hour = _minute * 60;
    		var _day = _hour * 24;
    		var timer;

    		function showRemaining() {
        		var now = new Date();
		        var distance = end - now;
		        if (distance < 0) {
		            clearInterval(timer);
		            document.getElementById('countdown').innerHTML = 'EXPIRED!';
		            return;
		        }
		        var days = Math.floor(distance / _day);
		        var hours = Math.floor((distance % _day) / _hour);
		        var minutes = Math.floor((distance % _hour) / _minute);
		        var seconds = Math.floor((distance % _minute) / _second);

		        document.getElementById('countdown').innerHTML = '<input type="hidden" name="minuto" value="' + hours + ':' + minutes + ':' + seconds + '">Tiempo: ' + hours + ':';
		        document.getElementById('countdown').innerHTML += minutes + ':';
		        document.getElementById('countdown').innerHTML += seconds;
    		}

    		timer = setInterval(showRemaining, 1000);

            </script>
      		</form>
    	</div>
    </div></div>
</main>
<?php
}
?>