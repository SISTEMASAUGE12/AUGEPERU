<?php include('auten.php');
$ruta="examen";

$sql = " SELECT c.*, c.titulo_rewrite as catrewri  FROM categoria_examenes c WHERE   c.estado_idestado = 1  and c.mostrar_en_la_web =1  ORDER BY c.orden DESC ";

 // echo $sql; 

$custom = array();
$custom['sql'] = $sql;
$custom['div'] = 'listado_categoria_examenes';
$custom['params'] = isset($_POST) ?array_keys($_POST) : array();
$custom['pages']  = 100;
$paging = configurar_paginador($custom);
if($paging->numTotalRegistros>0){ while ($detalles = $paging->fetchResultado()):
    $titulo=$detalles['titulo'];
    //$link=$ruta.'/'.$detalles['tiprewri'].'/'.$detalles['catrewri'];
    $link='examen/todos/'.$detalles['catrewri'];
    $imgproduct= !empty($detalles['imagen']) ?'tw7control/files/images/categoria_examenes/'.$detalles['imagen'] : 'img/no_imagen.jpg'; ?>
		
    <div class="large-4 medium-4 columns nothing   list_examenes_categorias "><?php include("inc/categoria_examen.php") ?></div>
<?php
	endwhile;
	?>
		<script >
			    // Magnific Popup
			if($('.mpopup-01').length){ $('.mpopup-01').magnificPopup({ type : 'image', delegate : 'a', gallery : { enabled:true } }); }
			if($('.mpopup-02').length){ $('.mpopup-02').magnificPopup({ type : 'iframe' }); } /* efecto ventana emergente ara video*/
			$('.mpopup-03').magnificPopup({ type : 'ajax' });//emergente
		</script>
		<script src="js/carrito.js"></script>

<?php
	echo '<div class="large-12 columns"><div class="pagination text-right" role="navigation" arial-label="Pagination">'.$paging->fetchNavegacion().'</div></div>';
}else echo '<p class="text-center osans color1" style="padding:110px 0;">No se encontro '.$ruta.'</p>'; ?>