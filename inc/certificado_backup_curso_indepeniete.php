<?php 
$si_finalizado = executesql("SELECT * FROM suscritos_x_cursos WHERE estado_idestado = 1 AND id_curso = '".$detalles['id_curso']."' and  id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."'  "); 

$sql_x1="SELECT * FROM suscritos_x_certificados WHERE estado_idestado = 1 AND id_certificado = '".$detalles['id_certificado']."' and  id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."'  Order by ide desc ";
// echo $sql_x1;
$si_pago_certificado = executesql($sql_x1); 
$estado_pago=!empty($si_pago_certificado[0]['estado'])?$si_pago_certificado[0]['estado']:'';

$mostrar_porcentaje="si";
$mostrar_marcar_entregados="no";
?>
<div class="curso-list rel">
    <figure class="rel ">
			<img src="<?php echo $imgproduct ?>" class="principal ">
			<?php 
						if($estado_pago == ''){  /* si aun no paga el certificado */
								$condicion_depago="Compralo ahora!";$color_noti="#999";
						}else if($estado_pago == 1){   /* pago aprobado */
								$condicion_depago="Pagado";$color_noti="green";
						}else if($estado_pago == 2){  /* pago pendiente de aprobacion */
								$condicion_depago="Pago en revisión";$color_noti="#555";
						}else if($estado_pago == 3){  /* pago rechazado  de aprobacion */
								$condicion_depago="Pago rechazado";$color_noti="red";
						}else{
								$condicion_depago="Error_".$estado_pago; $color_noti="black";
						} ?>
			<figcaption style="background:<?php echo $color_noti ?>;"><?php echo $condicion_depago ?></figcaption>
		</figure>
		
<?php 
// y=(AB*100)/x  --> formula  
// => x = total de clases
// => y =porcentaje
// AB= clases finalizadas. 

$porcentaje='';

/* Chequeadmo el nivel de avance del curso del usuario .. */
if($si_finalizado[0]['finalizado']!=1){
	// calculo total de clases 
	$sql_total_clase="SELECT count(*) as total_clases FROM avance_de_cursos_clases WHERE id_curso = '".$detalles['id_curso']."' and id_suscrito='".$_SESSION['suscritos']['id_suscrito']."' "; 
	$total_n_clases = executesql($sql_total_clase);
	
	// clases finalizadas 
	$finalizadas = executesql("SELECT count(*) as total_finalizadas FROM avance_de_cursos_clases WHERE id_curso = '".$detalles['id_curso']."' and id_suscrito='".$_SESSION['suscritos']['id_suscrito']."'  and estado_fin=1 ");
	
	if( !empty($total_n_clases) && $total_n_clases[0]['total_clases'] > 0 ){ // total de clases > 0		
		if( !empty($finalizadas) ){
			$porcentaje= round( ($finalizadas[0]['total_finalizadas']*100)/$total_n_clases[0]['total_clases']);							
			if($porcentaje =='100'){
				/* Por si se puede hacer de valor aquí .. */					
			}
		}
	}else{ /* cero clases tiene el curso al moemnto de comparlo */ 
		$porcentaje='en_vivo'; /* seuguro compro un curso en_vivo; o un grabado sin clases registradas previamente */
		
		/* cuendo este curso, se marque como en_vivo_finalizado ==1 ; ya debe permisirse el boton de solicitar certificado al docente. */
		/* consulto por este atributo: en_vivo_finalizado */
		
		$sql_c="select id_curso, en_vivo_finalizado from cursos WHERE id_curso='".$detalles["id_curso"]."' ";
		// echo $sql_c;
		$consultando_curso_en_vivo= executesql($sql_c);
		if(!empty($consultando_curso_en_vivo)){
				// echo "see".$consultando_curso_en_vivo[0]['en_vivo_finalizado'];
			if( $consultando_curso_en_vivo[0]['en_vivo_finalizado'] == 1){ /* Si el curso en_vivo; ya se marco como finalizado. */
					$porcentaje ='100'; /* ya se les puede habilitar para solicitar certificado */
			}else{
					$porcentaje ='El curso aun no finaliza';
			}
			
		}else{
			$porcentaje='Curso ya no esta disponible'; /* curso ya no existe? */			
		}
		
	}
	
}else{
	// si esta finalizado = 100%
	$porcentaje='100';
}

?>
    <div class="deta certificado ">
        <h2 class="color1 poppi">
					<small style="color:#666;">	COD: <?php echo $detalles['id_certificado']; ?></small>
					</br><?php echo short_name($titulo,47); ?>
					</br><b><a href="perfil/mis-cursos/<?php echo $detalles["curso_rew"]; ?>"><?php echo $detalles["cod_curso"].': '.short_name($detalles["curso"],47); ?></a></b>
				</h2>
				 <blockquote class="poppi-b color2">
				<?php 
						if( $estado_pago ==1 ){ 
							echo "<span class='poppi texto' >Costo de venta: s/ ".$si_pago_certificado[0]['precio']." </br> Pagadao el: ".$si_pago_certificado[0]['fecha_registro']."</span>" ;
						}else if( $estado_pago ==2 ){ 
							echo "<span class='poppi texto' >Costo de venta: s/ ".$si_pago_certificado[0]['precio']." </br> Esperando confirmación</span>" ;
						}else if( $estado_pago ==3 ){ 
							echo "<span class='poppi texto' >Costo de venta: s/ ".$si_pago_certificado[0]['precio']." </br> <b class='red'>Pago rechazado</b></span>" ;
						
						}else{ /* si aun no comprra el certificado .. */
								if( $detalles['costo_promo']>0 ){
										$precio=$detalles['costo_promo'];
                    echo ($detalles['costo_promo']>0) ? 'S/ '.$detalles['costo_promo'].' <small class="poppi rojo"> S/ '.$detalles['precio'].'</small>' : 'S/ '.$detalles['precio'];
                }else{
										$precio=$detalles['precio'];
                    echo 'S/ '.$detalles['precio'];
                }
						}	
					?>
				</blockquote>
        <div class="botones">
		<?php		
				// if($data_asignacion['estado']==1 && $data_asignacion['estado_idestado']==1 ){  /* Si la compra del curso fue pagada con exito: */
						
						/* Si ya esta pagado .. el certificdao */
						if( $estado_pago ==1 ){ 
								if( ($porcentaje!='' && $porcentaje!='..') && $porcentaje =='100' ){ 
										$mostrar_porcentaje="no"; /* en este nivel ya no mostrar el % de avance */
										/* valido mientras aun no exista una solicitud de certificado, pueda enviar una: */
										/* Válido si ya se envio una solicitud por este certificado, para no generar varias ordenes.. */
										$sql_validate="select * from solicitudes where estado_idestado=1 and  id_certificado='".$detalles['id_certificado']."' and id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."' ";
										// echo $sql_validate;
										$existe_solicitud=executesql($sql_validate);
										
										if(!empty($existe_solicitud)){ /* si ya apgo y ya envio/ tiene una solicitud enviada, blqoueamos el formulario*/ 
											/* MOstramos mensjae de alerta, de espera, */
												if($existe_solicitud[0]['estado']=='1'){
													echo '<p class="poppi ">  <b class="blue">Entregado</b> el '.$existe_solicitud[0]['fecha_entrega'].'  </p>';
												}else if($existe_solicitud[0]['estado']=='2'){
													echo '<p class="poppi ">Estado de envio: Pendiente</p>';
												}else if($existe_solicitud[0]['estado']=='3'){
													echo '<p class="poppi red ">Pago: Rechazado</p>';
												}else if($existe_solicitud[0]['estado']=='4'){
													echo '<p class="poppi ">Estado de envio: En proceso</p>';
												}else if($existe_solicitud[0]['estado']=='5'){
													$mostrar_marcar_entregados="si";
													echo '<p class="poppi  "> <b class="blue">Enviado</b> el '.$existe_solicitud[0]['fecha_envio'].' </br> Agencia: '.$existe_solicitud[0]['empresa_envio'].'</p>';
												}
									
		?>
					<?php 		}else{ /* si aun no existe una solicitud por el certificado, le permitimos enviar una  */ ?> 
									<a href="certificados/<?php echo $detalles["titulo_rewrite"]; ?>" class="boton poppi-sb"> SOLICITAR ENTREGA </a>											
					<?php			} /* END validacion de solicutd */
										
										
								}else{ //porcentaje  . // desactivado boton solicitar, tiene que culminar de ver el curso 
										echo '<a  class="boton poppi-sb" style="cursor:no-drop;background:#777;" title="Debes Completar el curso al 100%"> SOLICITAR ENTREGA '.$porcentaje.'</a>';
								}	
								
						/* Si pago fue rechazado o esta en espera */			
						}else if( $estado_pago ==2 ){ /* Si pago fue rechazado o esta en espera */
								echo '<p class="poppi "></p>';
						
						/* Si aun no paga el certificado... */
						}else if( $estado_pago !=2   ){ /* Si aun no existe un registro de certificao_x_suscirto */
				?>
						<!-- <a href="" class="boton poppi-sb"> PAGAR </a> -->
						<form id ="ruta-<?php echo $detalles["id_certificado"]; ?>" class="add mostrar_texto_comprar " method="POST" action="process_cart/insert.php" accept-charset="UTF-8">
									<input type="hidden" name="id"  value="<?php echo $detalles["id_certificado"] ?>">
									<input type="hidden" name="id_tipo"  value="9999">  <!-- *9999:: certificados -->
									<input type="hidden" name="validez_meses"  value="<?php echo $detalles["id_curso"] ?>">  <!-- *usare esta variable para enviar id_curso, para venta de certificad-->
									<input type="hidden" name="cursos_dependientes"  value="">
									<input type="hidden" name="cursos_dependientes_data"  value="">
									<input type="hidden" name="cursos_especialidades"  value="">
									<input type="hidden" name="cursos_especiales_data"  value="">
									<input type="hidden" name="rewrite"  value="certificados_disponibles">
									<input type="hidden" name="imagen"  value="<?php echo $imgproduct ; ?>">
									<input type="hidden" name="cantidad"  value="1">
									<input type="hidden" name="profe"  value="" >
									<input type="hidden" name="nombre"  value="<?php echo $detalles["titulo"]; ?>" id="nombre">
									<input type="hidden" name="precio"  value="<?php echo $precio; ?>" id="precio">
									<input type="hidden" name="precio_online"  value="<?php echo $precio; ?>" id="precio_online">
									<div style="">
										<button class="roboto boton  hola  estoy_detalle_curso compra_directa">PAGAR</button>
									</div><!-- l **12 prod-->
								</form>
				
				<?php 
						}
						
					// echo $mostrar_porcentaje;	
					/* muestro % avance del curso .. */
					if(  is_numeric($porcentaje)  && $porcentaje >= 0   && $mostrar_porcentaje=="si" ){ ?>	
						<div class="bot poppi-sb color1"><?php echo $porcentaje; ?>%</div> 
		<?php  }elseif( $mostrar_marcar_entregados=="si" ){ /* si el certificado ya estsa enviado, dar la opcion de marcar como recibido/entregado  */ 

		?>	
						<input type="hidden" name="nombre_dliente" id="nombre_dliente" value="<?php echo $detalles['titulo']; ?>" >
						<input type="hidden" name="name_certificado" id="name_certificado" value="<?php echo $detalles['titulo']; ?>" >
						<input type="hidden" name="ide_suscrito_x_certificados" id="ide_suscrito_x_certificados" value="<?php echo $si_pago_certificado[0]['ide']; ?>" >
						<input type="hidden" name="id_solicitud" id="id_solicitud" value="<?php echo $existe_solicitud[0]['ide']; ?>" >
						<div class=" poppi-sb color1 certificado_marcar_como_recibido">
							<span>Marcar como recibido
							<small> <img src="img/iconos/check.png" alt="Marcar como recibido"></small>
							</span>
						</div> 
						<!-- 
						-->
		
		<?php } ?>
					 				
<?php	 /* 
			}elseif($data_asignacion['estado']==2 && $data_asignacion['estado_idestado']==1 ){  ?>
					<a  class="boton poppi-sb" style="background:gray;cursor:no-drop;">Por aprobar</a>
<?php  }else if($data_asignacion['estado']==3 && $data_asignacion['estado_idestado']==1 ){  ?>
					<a  class="boton poppi-sb" style="background:#383535;cursor:no-drop;">Pago Rechazado</a>
<?php  }else if( $data_asignacion['estado_idestado']==2 ){  ?>
					<a  class="boton poppi-sb" style="background:black;cursor:no-drop;">Asignación deshabilitada</a>
<?php } 
*/?>
						
        </div>
    </div>
</div>