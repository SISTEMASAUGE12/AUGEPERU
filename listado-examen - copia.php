<main id="certi" style="margin-top:0;margin-left:-15px;">
	<div class="callout callout-2" style="padding-top:0"><div class="row">
		<div class="large-12 columns">
			<h1 class="poppi-b color1 rel" style="padding:50px 0;">Exámenes<a href="perfil/examenes/historial_examenes" class="poppi bota">Exámenes Resueltos</a></h1>
		</div>
		<!-- <div class="large-12 columns nothing" style="background:#FDF7F7;min-height:500px;">
			<div class="tableta">
				<div class="cuadro cuadro1"><p class="color1 poppi-sb">Exámen</p></div>
				<div class="cuadro cuadro2"><p class="color1 poppi-sb">Fecha de Cierre</p></div>
				<div class="cuadro cuadro2"><p class="color1 poppi-sb">Estado</p></div>
				<div class="cuadro cuadro2"><p class="color1 poppi-sb">Ultima Nota</p></div>
				<div class="cuadro cuadro2"><p class="color1 poppi-sb">Resolver</p></div>
			</div> -->
<?php
			/*$list = executesql("SELECT * FROM examenes e INNER JOIN examenes_curso ec ON e.id_examen = ec.id_examen INNER JOIN suscritos_x_cursos sxc ON ec.id_curso = sxc.id_curso WHERE ec.estado_idestado = 1 AND sxc.id_tipo = 1 AND sxc.id_suscrito = ".$_SESSION["suscritos"]["id_suscrito"]." ORDER BY e.fecha_registro ASC");
            if(!empty($list)){ foreach($list as $lista){
            $nota = executesql("SELECT nota FROM suscritos_x_examenes WHERE id_suscrito=".$_SESSION["suscritos"]["id_suscrito"]." AND id_examen=".$lista['id_examen']."");
            echo '
            <div class="tableta tableta1">
				<div class="cuadro cuadro1"><p class="color1 poppi">'.$lista['titulo'].'</p></div>
				<div class="cuadro cuadro2"><p class="color1 poppi">'.date('d/m/Y ',strtotime($lista['fecha_registro'])).'</p></div>
				<div class="cuadro cuadro2"><p class="color1 poppi">'.(($lista['estado_examen']==1) ? '<span class="color-blanco">Abierto</span>' : '<span class="ul">Cerrado</span>').'</p></div>
				<div class="cuadro cuadro2"><p class="color1 poppi">'.(!empty($nota) ? $nota[0]['nota'] : '').'</p></div>
				<div class="cuadro cuadro2"><p class="color1 poppi"><a href="perfil/examenes/'.$lista['titulo_rewrite'].'" class="bto">Resolver</a></p></div>
			</div>';
            } }*/
?><!-- 
		</div> -->
		<div class="large-12 columns ">
		<div class="table-scroll tabli" style="background-color:#FFFFFF"><table style="width:100%;">
    		<thead><tr>
        		<th bgcolor="#F0F0F0" width="35">#</th>
        		<th bgcolor="#F0F0F0">Examen</th>
        		<th bgcolor="#F0F0F0" width="150">Privacidad <i class="fas fa-calendar-alt" style="color:green;"></i></th>
        		<th bgcolor="#F0F0F0" width="150">Fecha Activa <i class="fas fa-calendar-alt" style="color:green;"></i></th>
				<th bgcolor="#F0F0F0" width="150">Fecha Vence <i class="fas fa-calendar-alt" style="color:red;"></i></th>
				<th bgcolor="#F0F0F0">Cant.&nbsp;Intentos/Efectuados</th>
				<th bgcolor="#F0F0F0" width="100">Estado</th>
				<th bgcolor="#F0F0F0" width="100">Ir</th>
		    </tr></thead>
    		<tbody>
<?php
			
			if( !empty($especialidad_del_cliente) ){  /* listado examen publicos según especilidad */
				$sql_listados_publicos=" select * from examenes where estado_idestado=1 and  privacidad=2 and id_especialidad='".$especialidad_del_cliente."' "; 
				
			}
			
			$sql_listado_examen_privados="SELECT e.* 
													FROM examenes e 
													INNER JOIN examenes_curso ec ON e.id_examen = ec.id_examen 
													INNER JOIN suscritos_x_cursos sxc ON ec.id_curso = sxc.id_curso 
													WHERE ec.estado_idestado = 1 AND sxc.estado=1 and sxc.estado_idestado=1 AND sxc.id_suscrito = ".$_SESSION["suscritos"]["id_suscrito"]." 
													 ";
													 // and sxc.id_tipo=1  // supuestamente solo cursos . pero esta linea la comento apra dehjar ´pasar algunos tipo NULKL de cursos dependientes en caso de pack, etc 
													// ORDER BY e.fecha_registro ASC";
			
			// echo $listado= $sql_listados_publicos.' UNION '.$sql_listado_examen_privados; /* publicos + privados */
			// echo "====";
			
			$listado= $sql_listado_examen_privados.' UNION '.$sql_listados_publicos; /* publicos + privados */
			
			
			// echo $listado; 
			$list = executesql($listado);
			$conteo = 1;
            if(!empty($list)){ foreach($list as $lista){
            	$cante = executesql("SELECT * FROM suscritos_x_examenes WHERE id_examen = ".$lista['id_examen']." AND id_suscrito = ".$_SESSION["suscritos"]["id_suscrito"]." ORDER BY orden ASC");
            	$totalintento = count($cante);
							$lista['cant_intentos']=($lista['cant_intentos'] >0)?$lista['cant_intentos']:0;
?>
    			<tr>
    				<td bgcolor="#DB271C"><font color="#FFFFFF">&nbsp;<b><?php echo $conteo ?></b></font></td>
    				<td><?php echo 'cod: '.$lista['id_examen'].' - '.$lista['titulo'] ?></td>
    				<td><?php echo ( $lista['privacidad']==1 )?'Privado':'Público'; ?></td>
    				<td><?php echo $lista['fecha_registro']; ?></td>
    				<td><?php echo $lista['fecha_cierre'] ?></td>
    				<td align="center"><?php echo $totalintento.' / '.$lista['cant_intentos']; ?></td>
    				<td><a class="button success"><b> <?php echo ($totalintento > 0 && $lista['cant_intentos']==$totalintento) ? 'Rendido' : 'Activo' ?></b></a></td>
    				<td>
						<?php if( $lista['cant_intentos'] > 0 ){ ?>
							<a <?php echo ($lista['cant_intentos']==$totalintento) ? 'onClick="examen_completo()"' : 'href="perfil/examenes/'.$lista['titulo_rewrite'].'"' ?> class="button <?php echo ($lista['cant_intentos']==$totalintento) ? 'primary' : 'alert' ?>"><b>Resolver</b></a>
						<?php }else{ 
										echo "-";
									}
						?>
						</td>
    			</tr>
<?php
			$conteo++;
			} }
?>
    		</tbody>
  		</table></div></div>
	</div></div>
</main>