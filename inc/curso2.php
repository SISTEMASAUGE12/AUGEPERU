<?php 
/* imagen a mostrar :: ahora mini: imagen */
$imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen'];  /* mostramos la img pequeña */
// $imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen2'];  /* mostramos la img grande */


$si_finalizado = executesql("SELECT * FROM suscritos_x_cursos WHERE estado_idestado = 1 AND id_curso = '".$detalles['id_curso']."' and  id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."'  "); 
 
$tipo = executesql("SELECT titulo FROM tipo_cursos WHERE id_tipo = '".$detalles['id_tipo']."' ");
$profe = executesql("SELECT titulo,titulo_rewrite,imagen FROM profesores WHERE id_profesor = '".$detalles['id_pro']."'");

$fecha_actual = fecha_hora(1);
$mostrar="si";

// si tiene una fecha limite de validez ..
if(!empty($si_finalizado[0]['validez_meses']) && $si_finalizado[0]['validez_meses'] > 0){  /* si no asigna dato de vence en cursos, se asigna un periodo de 1 año .*/
// fecha limite de acceso : vencimiento
	$fecha_compra = $si_finalizado[0]['fecha_registro'];
	$meses_disponibles = $si_finalizado[0]['validez_meses'];
	//sumo  meses de plazo 
	$fecha_limite= date("Y-m-d",strtotime($fecha_compra."+ ".$meses_disponibles." month")); 
	
	// echo $fecha_actual.' > '.$fecha_limite ; 
	
	if($detalles["id_tipo"]==2 || $detalles["id_tipo"]==3){ 
		$mostrar="si";		

	}else if( $fecha_actual > $fecha_limite ){
		/* actualizamos estado de la asignacaion como vencido plazo:  */ 
		$mostrar="no";
		// echo "SI";
		
		// /* actualizamos la condicion del curso a 2 --> plazo_vencido */
		$_POST['condicion']=2;
		$campos=array('condicion');
		$bd=new BD;
		$bd->actualiza_(armaupdate('suscritos_x_cursos',$campos," ide='".$si_finalizado[0]["ide"]."'",'POST'));/*actualizo*/

	}
}

// si  mostramos o no el curso
if($mostrar == "si"){ 
?>
<div class="curso-list rel">
<?php if(!empty( $detalles['imagen2'])){  /* video trailer */ ?>
    <figure class="rel ">
			<img src="<?php echo $imgproduct ?>" class="principal ">
		<?php if($detalles["id_tipo"]!=2 && $detalles["id_tipo"]!=3){ ?>
			<?php if(!empty($meses_disponibles) && $meses_disponibles > 0){  $existe_fecha='si'; ?>
			<figcaption>Hasta: <?php echo $fecha_limite;?></figcaption>
			<?php } ?>
		<?php } ?>
		<figcaption style="<?php echo (isset($existe_fecha) && $existe_fecha=='si')?'top:30px;':'';?>"><?php echo strtoupper($tipo[0]['titulo']) ?></figcaption>
			
	<?php if(!empty( $detalles['link_video'])){  /* video trailer */ ?>
			<a class="abs mpopup-02 " href="<?php echo $detalles['link_video'] ?>"><img src="img/iconos/ico-play-small.png" class="verticalalignmiddle"></a>
	<?php }  ?>
	
<?php if( $detalles['en_vivo']==1){ /* valido si esta activo el boton */
				if(!empty($detalles['enlace_en_vivo']) && !empty($detalles['hora_en_vivo']) ){ ?>
			<a href="<?php echo $detalles['enlace_en_vivo'];?>" target="_blank">
				<figcaption class="en_vivo text-center">
						<b class="float-left" style="padding-right:20px;">En vivo</b> <?php echo $detalles['hora_en_vivo'];?>
				</figcaption>
			</a> 
			<?php }
			}
		?>
		</figure>
		
<?php }elseif( !empty( $detalles['link_video']) ){ ?>
		<div class="rel lleva_vimeo_listado">
				<iframe src="	<?php echo $detalles['link_video']; ?>"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
				<?php if(!empty($meses_disponibles) && $meses_disponibles > 0){ ?>
				<figcaption>Hasta: <?php echo $fecha_limite;?></figcaption>
				<?php } ?>
				
	<?php 
		 if( $detalles['en_vivo']==1){ /* valido si etsa cativo */
				if(!empty($detalles['enlace_en_vivo']) && !empty($detalles['hora_en_vivo']) ){ ?>
				<a href="<?php echo $detalles['enlace_en_vivo'];?>" target="_blank">
					<figcaption class="en_vivo text-center">
							<b class="float-left" style="padding-right:20px;">En vivo</b> <?php echo $detalles['hora_en_vivo'];?>
					</figcaption>
				</a> 
	<?php }
		} ?>
		</div>

<?php }  ?>

		
<?php 
// y=(AB*100)/x  --> formula  
// => x = total de clases
// => y =porcentaje
// AB= clases finalizadas. 

$porcentaje='';
// marcamos el curso como finalizado
if($si_finalizado[0]['finalizado']!=1){
	// calculo total de clases 
	$sql_total_clase="SELECT count(*) as total_clases FROM avance_de_cursos_clases WHERE id_curso = '".$detalles['id_curso']."' and id_suscrito='".$_SESSION['suscritos']['id_suscrito']."' "; 
	$total_n_clases = executesql($sql_total_clase);
	
	// clases finalizadas 
	$finalizadas = executesql("SELECT count(*) as total_finalizadas FROM avance_de_cursos_clases WHERE id_curso = '".$detalles['id_curso']."' and id_suscrito='".$_SESSION['suscritos']['id_suscrito']."'  and estado_fin=1 ");
	
	if( !empty($total_n_clases) && $total_n_clases[0]['total_clases'] > 0 ){ // total de clases > 0
		// echo 'xxx'.$finalizadas[0]['total_finalizadas'];
		
		if( !empty($finalizadas) ){
							$porcentaje= round( ($finalizadas[0]['total_finalizadas']*100)/$total_n_clases[0]['total_clases']);
							if($porcentaje =='100'){
								// marcamoscurso como finalizado el curso ..
									$bd=new BD;
									$_POST['finalizado']=1;
									$campos=array('finalizado');
									$bd->actualiza_(armaupdate('suscritos_x_cursos',$campos," ide='".$si_finalizado[0]["ide"]."'",'POST'));/*actualizo*/
							}
		}
	}else{
		// cero clases tiene el curso al moemnto de comparlo
		$porcentaje='';
	}
	
	
	
}else{
	// si esta finalizado = 100%
	$porcentaje='100';
}

?>
    <div class="deta">
		<!-- 
        <span class="color2 poppi-sb"><?php echo strtoupper($tipo[0]['titulo']) ?></span>
				-->
        <h2 class="color1 poppi"><small><?php echo $detalles['codigo']; ?></small></br><?php echo short_name($titulo,60); ?></h2>
<!-- Ocultamos docente ..       
        <p class="texto poppi-l"><?php echo short_name($detalles['breve_detalle'],145) ?></p>
			 <ol class="no-bullet poppi-l"> <a href="docente/<?php echo $profe[0]['titulo_rewrite']; ?>">
            <li class="texto"><img class="rb50" src="<?php echo !empty($profe[0]['imagen']) ? 'tw7control/files/images/profesores/'.$profe[0]['imagen'] : 'img/docente.jpg' ?>"> <?php echo $profe[0]['titulo'] ?></li>
        </a></ol>
				-->
				
        <div class="botones">
				<?php if($data_asignacion['estado']==1 && $data_asignacion['estado_idestado']==1 ){ 
										// echo $porcentaje; 
									if( ($porcentaje!='' && $porcentaje!='..') && $porcentaje>='0' ){ 
				?>
						<a href="<?php echo $link ?>" class="boton poppi-sb"> INGRESAR</a>
				<?php 
									}else{
							// echo '		<a  class="boton poppi-sb" style="background:gray;cursor:no-drop;" title="Comunícate con el área de soporte  o vía Whatsapp. Envíanos una captura de pantalla.">No presenta clases</a>';
							
							//porcentaje 0 . //si no tiene curso asignado 
										if($detalles["id_tipo"]==1){
											echo '<a href="'.$link.'" class="boton poppi-sb"> INGRESAR</a>';
										}elseif($detalles["id_tipo"]==2){
											echo '<a href="'.$link.'" class="boton poppi-sb"> VER DETALLE</a>';											
										}elseif($detalles["id_tipo"]==3){
											echo '<a href="'.$link.'" class="boton poppi-sb"> VER DETALLE</a>';											
										}
										
									}
									?>
	<?php if(  is_numeric($porcentaje)  && $porcentaje >= 0 ){ ?>	<div class="bot poppi-sb color1"><?php echo $porcentaje; ?>%</div> <?php } ?>
					 
					
		<?php		}elseif($data_asignacion['estado']==2 && $data_asignacion['estado_idestado']==1 ){  ?>
						<a  class="boton poppi-sb" style="background:gray;cursor:no-drop;">Por aprobar</a>
			<?php }else if($data_asignacion['estado']==3 && $data_asignacion['estado_idestado']==1 ){  ?>
						<a  class="boton poppi-sb" style="background:#383535;cursor:no-drop;">Pago Rechazado</a>
			<?php }else if( $data_asignacion['estado_idestado']==2 ){  ?>
						<a  class="boton poppi-sb" style="background:black;cursor:no-drop;">Asignación deshabilitada</a>

				<?php } ?>
						
        </div>
    </div>
</div>
<?php  
} // end si mostramos o no  el curso ..
?>