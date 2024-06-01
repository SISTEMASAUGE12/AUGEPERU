<?php include('auten.php');

$sql = "SELECT * FROM preguntas WHERE id_examen='".$_POST['id_examen']."'";

$custom = array();
$custom['sql'] = $sql;
$custom['div'] = 'listado_preguntas_examenes';
$custom['params'] = isset($_POST) ?array_keys($_POST) : array();
$custom['pages']  = 10;
$paging = configurar_paginador($custom);
if($paging->numTotalRegistros>0){ ?>
    <table class="table table-bordered table-striped">
      	<thead><tr role="row">
            <th width="30">Item</th> 
		<th class="unafbe cnone">Preguntas</th>
		<th class="unafbe cnone">Tu&nbsp;marcaste</th>
		<th class="unafbe cnone">Resp.&nbsp;correcta</th>
		<th class="unafbe cnone">Puntos</th>
		<th class="unafbe cnone">Solución</th>
    	</tr></thead>
  		<tbody id="sort">
<?php 

		while ($detalles = $paging->fetchResultado()): 
			
			$sql_rpta_correcto="SELECT * FROM respuestas WHERE id_pregunta=".$detalles['id_pregunta']." AND estado_rpta = 1"; 
			// echo $sql_rpta_correcto;

			$sql_listado_rpta_marcadas="SELECT * FROM suscritos_x_examenes_rptas WHERE id_sxe = ".$_POST['id_sxe']." AND id_suscrito=".$_SESSION["suscritos"]["id_suscrito"]." AND id_examen=".$_POST['id_examen']." AND id_pregunta=".$detalles['id_pregunta']." order by orden desc limit 0,1 ";

			 // echo $sql_rpta_marcada;


			$rpta_correcta = executesql($sql_rpta_correcto);
			$rpta_marcada = executesql($sql_listado_rpta_marcadas); /* solo consulto el ultimo intento registrado */
			
			if(!empty($rpta_marcada)){
				if(!empty($rpta_correcta)){
					if($rpta_marcada[0]['id_rpta'] == $rpta_correcta[0]['id_rpta']) {
						$rpta_tit = '<i class="fa fa-check" style="color:rgb(12,124,3);"></i> '.$rpta_correcta[0]['titulo'];
						$puntos = '<i class="fa fa-check" style="color:rgb(12,124,3);"></i> '.$detalles['puntos'];
					
					}else{  // si pregunta esta errada., saco la verdadera respuesta para mostrrñe al cliente 

						if( !empty($rpta_marcada[0]['id_rpta']) ){
							$sql_rpta_marcada_x ="SELECT * FROM respuestas WHERE id_rpta=".$rpta_marcada[0]['id_rpta'];
							//echo $sql_rpta_marcada_x;
							$rpta_incorrec = executesql($sql_rpta_marcada_x);  /* sao la rpta marcada */
							if( !empty($rpta_incorrec) ){
								$rpta_tit = '<i class="fa fa-times" style="color:#E10F0F;"></i> '.$rpta_incorrec[0]['titulo'];
								$puntos = '<i class="fa fa-times" style="color:#E10F0F;"></i> 0.00';					
							}

						}else{
							$rpta_tit = '<i class="fa fa-times" style="color:#E10F0F;"></i> [ no marco una respuesta ]';
							$puntos = '<i class="fa fa-times" style="color:#E10F0F;"></i> 0.00';
						} // END  mostrar respueta lciente al lciemte si e que no marco una opcion en desarrolllo de examen 						
						
					}
				}else{
					$rpta_tit = '<i class="fa fa-times" style="color:#E10F0F;"></i> [ no marco una respuesta y  no_definida_rpta_para_pregunta]';
					$puntos = '<i class="fa fa-times" style="color:#E10F0F;"></i> 0.00';
				}

			}else{
				$rpta_tit = '<i class="fa fa-times" style="color:#E10F0F;">  [ no marco una respuesta ] </i>';
				$puntos = '<i class="fa fa-times" style="color:#E10F0F;"></i> 0.00';
			}
?>
    		<tr>
      			<td><?php echo $detalles["id_pregunta"]; ?></td>
      			<td style="text-align:justify;"><?php echo $detalles["titulo"]; ?></td>
				<td><?php echo $rpta_tit ?></td>
				<td><i class="fa fa-check" style="color:rgb(12,124,3);"></i> <?php echo !empty($rpta_correcta)? $rpta_correcta[0]['titulo']:' [no_definida_rpta] '; ?></td>
				<td><?php echo $puntos ?></td>
				<td>
				
				<?php if($detalles["solucion_es_video"]==1){  ?> 
							<div class="rel lleva_vimeo_listado lleva_video_solucion_examen ">
								<iframe src="<?php echo $detalles['solucion']; ?>"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
							</div>
				<?php 
				}else{ 
						echo $detalles["solucion"]; 
				}
				?>
				
				</td>
    		</tr>
<?php	  endwhile; ?>
        </tbody>
    </table>
    <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>

<?php
}else echo '<p class="text-center osans color1" style="padding:110px 0;">No se encontro '.$ruta.'</p>'; ?>