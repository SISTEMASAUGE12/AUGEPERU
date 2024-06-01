<?php include('auten.php');
$sql="select * from pedidos where estado_idestado=1 and id_suscrito='".$ide_suscrito."' order by fecha_registro desc, codigo desc";

$custom = array();
$custom['sql'] = $sql;
$custom['div'] = 'listado_pedidos';
$custom['params'] = isset($_POST) ?array_keys($_POST) : array();
$custom['pages']  = 10;

$paging = configurar_paginador($custom);

if($paging->numTotalRegistros>0){
?>
<div class="row mispedidos">
<?php while ($detalles = $paging->fetchResultado()):      
      $enlace='perfil/mis-pedidos/'.$detalles['id_pedido']; 
			// $img= 'intranet/files/images/publicaciones/'.$detalles['imagen'];
      
$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
$fecha= strtr(date('\<\s\p\a\n\>d\<\/\s\p\a\n\> M Y',strtotime($detalles['fecha_registro'])),$meses);

 ?>    
      <div class="large-12 columns monset minh-pro poppi 	end">
				<figure class="regalo"><img src="img/regalo.png"></figure> 
				<div class="data">
					<blockquote class="color-4 bold">Nº pedido: <?php echo $detalles["codigo"];?> <span>|</span> Comprado el  <?php echo $detalles["fecha_registro"];?> <span>|</span> Total: S/  <?php echo $detalles["total"];?></blockquote>
					<p class=""> Método de pago:  
								<?php 
								if($detalles['tipo_pago'] == '2'){
									echo 'Pago Online  <span style="padding:0 7px;"></span> cod. referencia: '.$detalles['codreferencia'];
								}else if($detalles['tipo_pago'] == '1'){
									echo 'Pago Offline Deposito <span style="padding:0 7px;"></span> cod. referencia: '.$detalles['codigo_ope_off'];																		
								}else if($detalles['tipo_pago'] == '3'){
									echo 'Pago Efectivo  <span style="padding:0 7px;"></span> Codigo cip: '.$detalles['codreferencia'];																		
								}else if($detalles['tipo_pago'] == '4'){
									echo 'Venta Manual  <span style="padding:0 7px;"></span> Codigo cip: '.$detalles['codigo_ope_off'];																		
								}else{
									echo ' error_ cosultar a sistemas ';																		
								} 
								?>
					</p>
						<p class="estado<?php echo $detalles["estado_pago"];?> "> Estado:  <?php 
						if($detalles["estado_pago"]==2){ 
								echo "Por validar pago";
						}elseif($detalles["estado_pago"]==3){ 
								echo "Compra rechazada";
						}elseif($detalles["estado_pago"]==1){ 
								echo "Aprobado";
						
						} ?>
					</p>
					<a  href="<?php echo $enlace; ?>" class="btn botones">Ver pedido</a>	
					<!-- <figure><img src="img/pro.jpg"></figure> -->
				</div> 
			</div> 

<?php endwhile; ?>
</div>
<div class="pagination" role="navigation" arial-label="Pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<?php
}else{ 
	echo '<div class="text-center monset cero-registro"><p class="texto em ">Aún no registras pedidos con nosotros .. </p> <!-- <a class="color-4" href="<?php echo $url;?>">Ellos ya confian en nosotros..  ♥</a> --></div>';
}
?>