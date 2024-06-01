<?php 
$si_finalizado = executesql("SELECT * FROM suscritos_x_cursos WHERE estado_idestado = 1 AND id_tipo = 2 AND id_curso = '".$detalles['id_curso']."' and  id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."'"); 
 
$estado_pago=!empty($si_finalizado[0]['estado'])?$si_finalizado[0]['estado']:'';

$pedido = executesql("SELECT * FROM pedidos WHERE id_pedido = '".$si_finalizado[0]['id_pedido']."'");

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
		}
?>
		<figcaption style="background:<?php echo $color_noti ?>;"><?php echo $condicion_depago ?></figcaption>
	</figure>
		
<?php 
// y=(AB*100)/x  --> formula  
// => x = total de clases
// => y =porcentaje
// AB= clases finalizadas. 

$porcentaje='100';

?>
    <div class="deta certificado ">
        <h2 class="color1 poppi">
			<small style="color:#666;">	COD: <?php echo $detalles['codigo']; ?></small>
			</br><?php echo short_name($titulo,47); ?>
			<!--</br><b><a href="perfil/mis-cursos/<?php echo $detalles["rewrite"]; ?>"><?php echo $detalles["codigo"].': '.short_name($detalles["titulo"],47); ?></a></b>-->
		</h2>
		<blockquote class="poppi-b color2">
<?php 
		if($estado_pago==1){ 
			echo "<span class='poppi texto' >Costo de venta: s/ ".$pedido[0]['total']." </br> Pagadao el: ".$si_finalizado[0]['fecha_registro']."</span>" ;
		}else if($estado_pago==2){ 
			echo "<span class='poppi texto' >Costo de venta: s/ ".$pedido[0]['total']." </br> Esperando confirmación</span>" ;
		}else if($estado_pago==3){ 
			echo "<span class='poppi texto' >Costo de venta: s/ ".$pedido[0]['total']." </br> <b class='red'>Pago rechazado</b></span>" ;
		}else{ /* si aun no comprra el certificado .. */
			if($detalles['costo_promo']>0){
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
		if($estado_pago==1){ 
			if($porcentaje =='100'){ 
				$mostrar_porcentaje="no"; /* en este nivel ya no mostrar el % de avance */
				/* valido mientras aun no exista una solicitud de certificado, pueda enviar una: */
				/* Válido si ya se envio una solicitud por este certificado, para no generar varias ordenes.. */
				$sql_validate="select * from solicitudes_libros where estado_idestado=1 and id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."' ";
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
						echo '<p class="poppi"> <b class="blue">Enviado</b> el '.$existe_solicitud[0]['fecha_envio'].' </br> Agencia: '.$existe_solicitud[0]['empresa_envio'].'</p>';
					}
 				}else{ /* si aun no existe una solicitud por el certificado, le permitimos enviar una  */ ?> 
					<a href="mis-libros/<?php echo $detalles["titulo_rewrite"]; ?>" class="boton poppi-sb"> SOLICITAR ENTREGA </a>
<?php			} /* END validacion de solicutd */
			}
		/* Si pago fue rechazado o esta en espera */
		}else if( $estado_pago ==2 ){ /* Si pago fue rechazado o esta en espera */
			echo '<p class="poppi "></p>';
		}
		// echo $mostrar_porcentaje;	
		/* muestro % avance del curso .. */
		if( $mostrar_marcar_entregados=="si" ){ /* si el certificado ya estsa enviado, dar la opcion de marcar como recibido/entregado  */ 
		?>	
			<input type="hidden" name="nombre_dliente" id="nombre_dliente" value="<?php echo $detalles['titulo']; ?>" >
			<input type="hidden" name="name_libro" id="name_libro" value="<?php echo $detalles['titulo']; ?>" >
			<input type="hidden" name="ide_suscrito_x_cursos" id="ide_suscrito_x_cursos" value="<?php echo $si_finalizado[0]['ide']; ?>" >
			<input type="hidden" name="id_solicitud" id="id_solicitud" value="<?php echo $existe_solicitud[0]['ide']; ?>" >
			<div class=" poppi-sb color1 libro_marcar_como_recibido">
				<span>Marcar como recibido
				<small> <img src="img/iconos/check.png" alt="Marcar como recibido"></small>
				</span>
			</div> 
<?php
		} ?>						
        </div>
    </div>
</div>