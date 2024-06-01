<?php 
$mensajillo='';
$mensajillo_comprados_finalizados=''; /* comprados finalizados */
$mensajillo_comprados_pen=''; /* comprados, pendientes x finalizar*/


$habilitado_para_solicitar_envio=1;  /* si acabo todos los cursos e la canastilla relacionado a este certificado, peude solicitar la entrega del certificado */

//include('inc/certificado_valdiacion_si_acabo_curso.php');

$sql_x1="SELECT * FROM suscritos_x_certificados WHERE estado_idestado = 1 AND id_certificado = '".$detalles['id_certificado']."' and  id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."'  Order by ide desc ";
// echo $sql_x1;

$suscritos_x_certificados = executesql($sql_x1); 
$estado_pago=!empty($suscritos_x_certificados[0]['estado'])?$suscritos_x_certificados[0]['estado']:'';

$mostrar_marcar_entregados="no";
?>
<div class="curso-list rel">
	<div class=" large-2 medium-3 columns ">
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
	</div>
<?php 
/*  cuerpo del certificado   */ 
?>
	<div class=" large-4 medium-5 columns ">
    <div class="deta certificado ">
        <h2 class="color1 poppi">
					<small style="color:#666;">	COD: <?php echo $detalles['id_certificado']; ?></small>
					</br><?php echo short_name($titulo,47); ?>
					</br><b><a href="perfil/mis-cursos/<?php echo $detalles["curso_rew"]; ?>"><?php echo $detalles["cod_curso"].': '.short_name($detalles["curso"],47); ?></a></b>
				</h2>
				 <blockquote class="poppi-b color2">
				<?php 
						if( $estado_pago ==1 ){ 
							echo "<span class='poppi texto' >Costo de venta: s/ ".$suscritos_x_certificados[0]['precio']." </br> Pagadao el: ".$suscritos_x_certificados[0]['fecha_registro']."</span>" ;
						}else if( $estado_pago ==2 ){ 
							echo "<span class='poppi texto' >Costo de venta: s/ ".$suscritos_x_certificados[0]['precio']." </br> Esperando confirmación</span>" ;
						}else if( $estado_pago ==3 ){ 
							echo "<span class='poppi texto' >Costo de venta: s/ ".$suscritos_x_certificados[0]['precio']." </br> <b class='red'>Pago rechazado</b></span>" ;
						
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
			</div>
		</div>
		
		<div class=" large-6 medium-5 columns ">
			<div class="deta certificado ">	
        <div class="botones">
		<?php		
		/*
						echo "<h3 class=' poppi-sb color1 ' > Detalle: </h3>";
						echo '<p>'.$mensajillo_comprados_finalizados.' </br> '.
										( (!empty($mensajillo_comprados_pen) )?' *Te recomendamos completar los siguientes módulos para solicitar tu certificado: </br> <b style="padding-top:7px;">'.$mensajillo_comprados_pen.' </b> </br> ':'').
										( (!empty($mensajillo) )?' *Te recomendamos comprar los siguientes módulos para solicitar tu certificado: </br> <b style="padding-top:7px;">'.$mensajillo.' </b>':'').' </p>';
						*/
		
						
						/* Válido si ya se envio una solicitud por este certificado, para no generar varias ordenes.. */
						$sql_validate="select * from solicitudes where estado_idestado=1 and  id_certificado='".$detalles['id_certificado']."' and id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."'  and estado !=3  ORDER BY ide desc  ";
						// echo $sql_validate;
						$existe_solicitud=executesql($sql_validate);
										
										
						/* si forzo el boton solicitar y aun on ha enviado una solicitud  */
						if( ( isset($suscritos_x_certificados[0]["habilitar_solicitar_directo"]) && $suscritos_x_certificados[0]["habilitar_solicitar_directo"] == 1)   &&  empty($existe_solicitud) ){ 
								if($estado_pago == 1){   /* pago aprobado */
					?>
										<a href="certificados/<?php echo $detalles["titulo_rewrite"]; ?>" class="boton poppi-sb">- SOLICITAR ENTREGA</a>											
<?php 
								} // end si ya pago se fuerza elsolcitirar 

								
						/* Si ya esta pagado .. el certificdao o esta forzado el pase directo:: [esto permite que asi no marcaron que pago, ingrese aquí ]  */
						}else if( $estado_pago ==1  || ( isset($suscritos_x_certificados[0]["habilitar_solicitar_directo"]) && $suscritos_x_certificados[0]["habilitar_solicitar_directo"] == 1)  ){ 
								/* si acabo - finalizado todos los modulos/cursos, se le permite pagar */
									
								/* ACA VALIDAR SI COMPLETO / FINALIZO , TODOS LOS CURSOS DE LA CANASTILLA  */			
								if( $habilitado_para_solicitar_envio!='' && $habilitado_para_solicitar_envio =='1'  || $suscritos_x_certificados[0]["habilitar_solicitar_directo"] == 1  ){ /* si acabo todos los cursos */
										
										/* AQUI ya pago y se muestra flujo de envio, procesamiento .. */
										/* si se forzo o fue venta manual directa ::: no espera q acabe de ver las clases   */

										if(!empty($existe_solicitud)){ /* si ya apgo y ya envio/ tiene una solicitud enviada, blqoueamos el formulario*/ 
											/* MOstramos mensjae de alerta, de espera, */
												if($existe_solicitud[0]['estado']=='1'){
													echo '<p class="poppi rpta_estado_envio ">  <b class="blue">Entregado</b> el '.$existe_solicitud[0]['fecha_entrega'].'  </p>';
												}else if($existe_solicitud[0]['estado']=='2'){
													echo '<p class="poppi rpta_estado_envio ">Estado de envio: Pendiente</p>';
												}else if($existe_solicitud[0]['estado']=='3'){
													echo '<p class="poppi red  rpta_estado_envio ">Pago: Rechazado </p>';
												}else if($existe_solicitud[0]['estado']=='4'){
													echo '<p class="poppi rpta_estado_envio ">Estado de envio: En proceso</p>';
												}else if($existe_solicitud[0]['estado']=='5'){
													$mostrar_marcar_entregados="si";
													echo '<p class="poppi  rpta_estado_envio "> <b class="blue">* Enviado</b> el '.$existe_solicitud[0]['fecha_envio'].' </br> Agencia: '.$existe_solicitud[0]['empresa_envio'].'</p>';
												}
												
												/* si ya existe una solicitud, muestro el boton PDF para descargue directamente  :: si es que ya aprobo sus datos. */
												if($existe_solicitud[0]['estado_api'] ==1 ){
													echo '<a class="poppi  btn_descarga_certificado " href="tw7control/pdf/certificado/'.$existe_solicitud[0]['ide'].'" target="_blank"> Descarga tu certificado aquí </a>';
												}

		?>
					<?php 				}else{ /* si aun no existe una solicitud por el certificado, le permitimos enviar una  */ ?> 
											<a href="certificados/<?php echo $detalles["titulo_rewrite"]; ?>" class="boton poppi-sb"> SOLICITAR ENTREGA .</a>											
					<?php				} /* END validacion de solicutd */
										
					
								}
									
								
						/* Si pago fue rechazado o esta en espera */			
						}else if( $estado_pago ==2 ){ /* Si pago fue rechazado o esta en espera */
								echo '<p class="poppi rpta_estado_envio ">Pago en espera de aprobación</p>';
								
						}else if( $estado_pago ==3 ){ /* Si pago fue rechazado o esta en espera */
								echo '<p class="poppi rpta_estado_envio  ">Pago rechazado</p>';
						
						/* Si aun no paga el certificado... */
						}else if( $estado_pago !=2  && $habilitado_para_solicitar_envio =='1' ){ /* Si aun no existe un registro de certificao_x_suscirto */ 
									
				?>
						<!-- <a href="" class="boton poppi-sb"> PAGAR </a> -->
						<form id ="ruta-<?php echo $detalles["id_certificado"]; ?>" class="add mostrar_texto_comprar " method="POST" action="process_cart/insert.php" accept-charset="UTF-8">
									<input type="hidden" name="id"  value="<?php echo $detalles["id_certificado"] ?>">
									<input type="hidden" name="id_tipo"  value="9999">  <!-- *9999:: certificados -->
									<input type="hidden" name="validez_meses"  value="<?php echo $detalles["id_curso"] ?>">  <!-- *usare esta variable para enviar id_curso, para venta de certificad-->
									<!-- 
									<input type="hidden" name="tag"  value="<?php echo $detalles["tag"]; ?>" id="tag">
						-->
									<input type="hidden" name="tag"  value="2100" id="tag">  <!-- tag que indica que compro un certificado -->
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
										<button class="roboto boton  hola  estoy_detalle_curso compra_directa">PAGAR -<?php echo $estado_pago; ?></button>
									</div><!-- l **12 prod-->
								</form>
				
				<?php 
						}else{
										// echo '<p>'.( (!empty($mensajillo) )?' *Te recomendamos completar los siguientes módulos para solicitar tu certificado: </br> <b>'.$mensajillo.' </b>':'').' </p>';
						}  /** end condiciones  */
						
	

				// echo '===>'.$mostrar_marcar_entregados;

				if( $mostrar_marcar_entregados=="si" ){ /* si el certificado ya estsa enviado, dar la opcion de marcar como recibido/entregado  */ 
		?>	
						<input type="hidden" name="nombre_dliente" id="nombre_dliente" value="<?php echo $detalles['titulo']; ?>" >
						<input type="hidden" name="name_certificado" id="name_certificado" value="<?php echo $detalles['titulo']; ?>" >
						<input type="hidden" name="ide_suscrito_x_certificados" id="ide_suscrito_x_certificados" value="<?php echo $suscritos_x_certificados[0]['ide']; ?>" >
						<input type="hidden" name="id_solicitud" id="id_solicitud" value="<?php echo $existe_solicitud[0]['ide']; ?>" >
						<div class=" poppi-sb color1 certificado_marcar_como_recibido">
							<span>Marcar como recibido
							<small> <img src="img/iconos/check.png" alt="Marcar como recibido"></small>
							</span>
						</div> 
						<!-- 
						-->
		
		<?php } // end maecar como recibido   ?>
					 				
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
	</div>  <!-- lg 10 -->
</div>