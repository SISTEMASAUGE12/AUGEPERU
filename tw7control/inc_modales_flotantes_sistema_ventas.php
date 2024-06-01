<!-- Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_recordatorio" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>RECORDATORIOS DEL DÍA HOY <?php echo fecha_hora(1); ?></b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	<?php 
	// echo $sql_recordatorio; 
	if( !empty($recordatorio) ){
	?>
					<table id="example1" class="table table-bordered table-striped">
						<tbody id="sort">	
							<tr role="row">
								<th width="30">HORA</th>
								<th class="sort cnone">CLIENTE</th>
								<th class="sort cnone">DNI</th>
								<th class="sort ">CEL</th>
								<th class="sort cnone ">NIVEL</th>
								<th class="sort cnone">DETALLE</th>
								<th class="sort ">RECORDATORIO</th>                                    
								<th class="sort  unafbe">VER</th>                                      
							</tr>
		<?php foreach($recordatorio as $recorda){ ?>			
							<tr>
								<td><?php echo $recorda["hora_recordatorio"];?></td>				       
								<td class="cnone"><?php echo $recorda["suscrito"];?></td>
								<td class="cnone"><?php echo $recorda["dni"];?> </td>
								<td><?php echo $recorda["telefono"];?></td>
								<td class="cnone"><?php echo $recorda["nivel"];?></td>
								<td class="cnone"><?php echo $recorda["descripcion"];?></td>
								<td><?php echo $recorda["recordatorio"];?></td>                    
								<td>
									<a target="_blank" href="index.php?page=kardex_clientes&amp;task=edit&amp;&amp;id_kar_cli=<?php echo $recorda["id_kar_cli"];?>&amp;module=&amp;parenttab=" style="background:blue;padding:6px;color:#fff;border-radius:8px;" title="editar"><span> ver</span>
									</a> 
								</td>  
							</tr>
		<?php } /* end for */ ?>
						</tbody>
					</table>
	<?php 
	}else{
		echo "<h3 class='text-center '>No tienes recordatorios el dia de hoy.</h3>";
	} /* end si existe recordatorio */
	?>
							
				
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
				<!--
        <button type="button" class="btn btn-primary">Save changes</button>
				-->
      </div>
    </div>
  </div>
</div>
<!-- END modal recordatorio -->



<!--  MODAL FELIZ CUMPLEAÑOS CUMPLEAÑOS -->
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_cumple_ventas" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>¡FELIZ CUMPLEAÑOS! TE DESEA EDUCAAUGE.COM  </b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	<?php 
	// echo $sql_recordatorio; 
	// if( !empty($recordatorio) ){
	?>
        <div class=" lleva_cumple ">
          <figure><img src="<?php echo $imagen_cumple; ?>"></figure>
					<div class=" detalle_cumpleano ">
            <?php  echo $detalle_cumple; ?>
					</div>
        </div>
	<?php
  /* 
	}
   /* end si existe recordatorio 
  */
	?>
							
				
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
				<!--
        <button type="button" class="btn btn-primary">Save changes</button>
				-->
      </div>
    </div>
  </div>
</div>
<!-- END modal cumpleaños  -->

	
