<?php include('auten.php');
$sql = "SELECT c.* from  testimonios c  WHERE c.estado_idestado = 1  ORDER BY c.orden DESC";
$custom = array();
$custom['sql'] = $sql;
$custom['div'] = 'listado_testimonios';
$custom['params'] = isset($_POST) ?array_keys($_POST) : array();
$custom['pages']  = 12;
$paging = configurar_paginador($custom);
if($paging->numTotalRegistros>0){ 
	while ($testi = $paging->fetchResultado()): 
?>     
    <div class=" large-12 columns end "><div class="testimonio"><?php include("inc/testimonios.php") ?></div></div>		
<?php
	endwhile;
	?>
	<script type="text/javascript">
		$(document).ready(function(){
		$('.mpopup-02').magnificPopup({ type : 'iframe' });
		});
	</script>
<?php
	echo '<div class="large-12 columns"><div class="pagination text-center " role="navigation" arial-label="Pagination">'.$paging->fetchNavegacion().'</div></div>';
}else echo '<p class="text-center osans color1" style="padding:110px 0;">No se encontro testimonios ..</p>'; ?>